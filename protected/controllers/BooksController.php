<?php

class BooksController extends Controller
{
    public $layout = '//layouts/inner';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + bookmark',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('reportSales', 'reportIncome'),
                'roles' => array('admin'),
            ),
            array('allow',
                'actions' => array('discount','search','view', 'download', 'programs', 'games', 'educations', 'publisher'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('buy', 'bookmark','rate'),
                'users' => array('@'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        Yii::import('users.models.*');
        Yii::app()->theme = "market";
        $model = $this->loadModel($id);
        $model->seen = $model->seen + 1;
        $model->save();
        $this->saveInCookie($model->category_id);
        $this->platform = $model->platform_id;
        // Has bookmarked this books by user
        $bookmarked = false;
        if (!Yii::app()->user->isGuest) {
            $hasRecord = UserAppBookmark::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'app_id' => $id));
            if ($hasRecord)
                $bookmarked = true;
        }
        // Get similar books
        $criteria = new CDbCriteria();
        $criteria->addCondition('id!=:id');
        $criteria->addCondition('category_id=:cat_id');
        $criteria->addCondition('platform_id=:platform_id');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->addCondition('(SELECT COUNT(app_images.id) FROM ym_app_images app_images WHERE app_images.app_id=t.id) != 0');
        $criteria->addCondition('(SELECT COUNT(app_packages.id) FROM ym_app_packages app_packages WHERE app_packages.app_id=t.id) != 0');
        $criteria->order = 'install DESC, seen DESC';
        $criteria->params[':id'] = $model->id;
        $criteria->params[':cat_id'] = $model->category_id;
        $criteria->params[':platform_id'] = $model->platform_id;
        $criteria->params[':status'] = 'enable';
        $criteria->params[':confirm'] = 'accepted';
        $criteria->params[':deleted'] = 0;
        $criteria->limit = 20;
        $criteria->order='id DESC';
        $similar = new CActiveDataProvider('Books', array('criteria' => $criteria));
        $this->render('view', array(
            'model' => $model,
            'similar' => $similar,
            'bookmarked' => $bookmarked,
        ));
    }

    /**
     * Buy app
     */
    public function actionBuy($id, $title)
    {
        Yii::app()->theme = 'market';
        $this->layout = 'panel';

        $model = $this->loadModel($id);
        $price = $model->hasDiscount()?$model->offPrice:$model->price;
        $buy = AppBuys::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'app_id' => $id));
        if ($buy)
            $this->redirect(array('/books/download/' . CHtml::encode($model->id) . '/' . CHtml::encode($model->title)));

        Yii::app()->getModule('users');
        $user = Users::model()->findByPk(Yii::app()->user->getId());

        if (isset($_POST['buy'])) {
            if ($user->userDetails->credit < $model->price) {
                Yii::app()->user->setFlash('failed', 'اعتبار فعلی شما کافی نیست!');
                Yii::app()->user->setFlash('failReason', 'min_credit');
                $this->refresh();
            }

            $buy = new AppBuys();
            $buy->app_id = $model->id;
            $buy->user_id = $user->id;
            if ($buy->save()) {
                $userDetails = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
                $userDetails->setScenario('update-credit');
                $userDetails->credit = $userDetails->credit - $price;
                $userDetails->score = $userDetails->score + 1;
                if ($model->publisher)
                    $model->publisher->userDetails->credit = $model->publisher->userDetails->credit + $model->getPublisherPortion();
                $model->publisher->userDetails->save();
                if ($userDetails->save()) {
                    $message =
                        '<p style="text-align: right;">با سلام<br>کاربر گرامی، جزئیات خرید شما به شرح ذیل می باشد:</p>
                        <div style="width: 100%;height: 1px;background: #ccc;margin-bottom: 15px;"></div>
                        <table style="font-size: 9pt;text-align: right;">
                            <tr>
                                <td style="font-weight: bold;width: 120px;">عنوان برنامه</td>
                                <td>' . CHtml::encode($model->title) . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">قیمت</td>
                                <td>' . Controller::parseNumbers(number_format($price, 0)) . ' تومان</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">تاریخ</td>
                                <td>' . JalaliDate::date('d F Y - H:i', $buy->date) . '</td>
                            </tr>
                        </table>';
                    Mailer::mail($user->email, 'اطلاعات خرید برنامه', $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP']);

                    $this->redirect(array('/books/download/' . CHtml::encode($model->id) . '/' . CHtml::encode($model->title)));
                }
            }
        }

        $this->render('buy', array(
            'model' => $model,
            'price' => $price,
            'user' => $user,
            'bought' => ($buy) ? true : false,
        ));
    }

    /**
     * Download app
     */
    public function actionDownload($id, $title)
    {
        $model = $this->loadModel($id);
        $platformFolder = '';
        switch (pathinfo($model->lastPackage->file_name, PATHINFO_EXTENSION)) {
            case 'apk':
                $platformFolder = 'android';
                break;

            case 'ipa':
                $platformFolder = 'ios';
                break;

            case 'xap':
                $platformFolder = 'windowsphone';
                break;
        }
        if ($model->price == 0) {
            $model->install += 1;
            $model->setScenario('update-install');
            $model->save();
            $this->download($model->lastPackage->file_name, Yii::getPathOfAlias("webroot") . '/uploads/books/files/' . $platformFolder);
        } else {
            $buy = AppBuys::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'app_id' => $id));
            if ($buy) {
                $model->install += 1;
                $model->setScenario('update-install');
                $model->save();
                $this->download($model->lastPackage->file_name, Yii::getPathOfAlias("webroot") . '/uploads/books/files/' . $platformFolder);
            } else
                $this->redirect(array('/books/buy/' . CHtml::encode($model->id) . '/' . CHtml::encode($model->title)));
        }
    }

    protected function download($fileName, $filePath)
    {
        $fakeFileName = $fileName;
        $realFileName = $fileName;

        $file = $filePath . DIRECTORY_SEPARATOR . $realFileName;
        $fp = fopen($file, 'rb');

        $mimeType = '';
        switch (pathinfo($fileName, PATHINFO_EXTENSION)) {
            case 'apk':
                $mimeType = 'application/vnd.android.package-archive';
                break;

            case 'xap':
                $mimeType = 'application/x-silverlight-app';
                break;

            case 'ipa':
                $mimeType = 'application/octet-stream';
                break;
        }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename=' . $fakeFileName);

        echo stream_get_contents($fp);
    }

    /**
     * Show programs list
     */
    public function actionPrograms($id = null, $title = null)
    {
        if (is_null($id))
            $id = 1;
        $this->showCategory($id, $title, 'برنامه ها');
    }

    /**
     * Show games list
     */
    public function actionGames($id = null, $title = null)
    {
        if (is_null($id))
            $id = 2;
        $this->showCategory($id, $title, 'بازی ها');
    }

    /**
     * Show educations list
     */
    public function actionEducations($id = null, $title = null)
    {
        if (is_null($id))
            $id = 3;
        $this->showCategory($id, $title, 'آموزش ها');
    }

    /**
     * Show programs list
     */
    public function actionPublisher($title, $id = null)
    {
        Yii::app()->theme = 'market';
        $this->layout = 'public';
        $criteria = new CDbCriteria();
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('platform_id=:platform');
        if (isset($_GET['t']) and $_GET['t'] == 1) {
            $criteria->addCondition('publisher_name=:dev');
            $publisher_id = $title;
        } else {
            $criteria->addCondition('publisher_id=:dev');
            $publisher_id = $id;
        }
        $criteria->params = array(
            ':confirm' => 'accepted',
            ':deleted' => 0,
            ':status' => 'enable',
            ':platform' => $this->platform,
            ':dev' => $publisher_id,
        );
        $criteria->addCondition('(SELECT COUNT(app_images.id) FROM ym_app_images app_images WHERE app_images.app_id=t.id) != 0');
        $criteria->addCondition('(SELECT COUNT(app_packages.id) FROM ym_app_packages app_packages WHERE app_packages.app_id=t.id) != 0');
        $criteria->order='id DESC';
        $dataProvider = new CActiveDataProvider('Books', array(
            'criteria' => $criteria,
        ));

        $pageTitle = UserDetails::model()->findByAttributes(array('user_id' => $id));

        $this->render('books_list', array(
            'dataProvider' => $dataProvider,
            'title' => $pageTitle->nickname,
            'pageTitle' => 'برنامه ها'
        ));
    }

    /**
     * Show books list of category
     */
    public function showCategory($id, $title, $pageTitle)
    {
        Yii::app()->theme = 'market';
        $this->layout = 'public';
        $criteria = new CDbCriteria();
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('platform_id=:platform');
        $criteria->addCondition('(SELECT COUNT(app_images.id) FROM ym_app_images app_images WHERE app_images.app_id=t.id) != 0');
        $criteria->addCondition('(SELECT COUNT(app_packages.id) FROM ym_app_packages app_packages WHERE app_packages.app_id=t.id) != 0');
        $criteria->params = array(
            ':confirm' => 'accepted',
            ':deleted' => 0,
            ':status' => 'enable',
            ':platform' => $this->platform,
        );

        $categories = BookCategories::model()->getCategoryChildes($id);
        $criteria->addInCondition('category_id', $categories);
        $criteria->order='id DESC';
        $dataProvider = new CActiveDataProvider('Books', array(
            'criteria' => $criteria,
        ));

        $this->render('books_list', array(
            'dataProvider' => $dataProvider,
            'title' => (!is_null($title)) ? $title : null,
            'pageTitle' => $pageTitle
        ));
    }

    /**
     * Bookmark app
     */
    public function actionBookmark()
    {
        Yii::app()->getModule('users');
        $model = UserAppBookmark::model()->find('user_id=:user_id AND app_id=:app_id', array(':user_id' => Yii::app()->user->getId(), ':app_id' => $_POST['appId']));
        if (!$model) {
            $model = new UserAppBookmark();
            $model->app_id = $_POST['appId'];
            $model->user_id = Yii::app()->user->getId();
            if ($model->save())
                echo CJSON::encode(array(
                    'status' => true
                ));
            else
                echo CJSON::encode(array(
                    'status' => false
                ));
        } else {
            if (UserAppBookmark::model()->deleteAllByAttributes(array('user_id' => Yii::app()->user->getId(), 'app_id' => $_POST['appId'])))
                echo CJSON::encode(array(
                    'status' => true
                ));
            else
                echo CJSON::encode(array(
                    'status' => false
                ));
        }
    }

    /**
     * Report sales
     */
    public function actionReportSales()
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/column2';

        $labels = $values = array();
        $showChart = false;
        $activeTab = 'monthly';
        if (isset($_POST['show-chart-monthly'])) {
            $activeTab = 'monthly';
            $startDate = JalaliDate::toGregorian(JalaliDate::date('Y', $_POST['month_altField'], false), JalaliDate::date('m', $_POST['month_altField'], false), 1);
            $startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
            $endTime = '';
            if (JalaliDate::date('m', $_POST['month_altField'], false) <= 6)
                $endTime = $startTime + (60 * 60 * 24 * 31);
            else
                $endTime = $startTime + (60 * 60 * 24 * 30);
            $showChart = true;
            $criteria = new CDbCriteria();
            $criteria->addCondition('date >= :start_date');
            $criteria->addCondition('date <= :end_date');
            $criteria->params = array(
                ':start_date' => $startTime,
                ':end_date' => $endTime,
            );
            $report = AppBuys::model()->findAll($criteria);
            // show daily report
            $daysCount = (JalaliDate::date('m', $_POST['month_altField'], false) <= 6) ? 31 : 30;
            for ($i = 0; $i < $daysCount; $i++) {
                $labels[] = JalaliDate::date('d F Y', $startTime + (60 * 60 * (24 * $i)));
                $count = 0;
                foreach ($report as $model) {
                    if ($model->date >= $startTime + (60 * 60 * (24 * $i)) and $model->date < $startTime + (60 * 60 * (24 * ($i + 1))))
                        $count++;
                }
                $values[] = $count;
            }
        } elseif (isset($_POST['show-chart-yearly'])) {
            $activeTab = 'yearly';
            $startDate = JalaliDate::toGregorian(JalaliDate::date('Y', $_POST['year_altField'], false), 1, 1);
            $startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
            $endTime = $startTime + (60 * 60 * 24 * 365);
            $showChart = true;
            $criteria = new CDbCriteria();
            $criteria->addCondition('date >= :start_date');
            $criteria->addCondition('date <= :end_date');
            $criteria->params = array(
                ':start_date' => $startTime,
                ':end_date' => $endTime,
            );
            $report = AppBuys::model()->findAll($criteria);
            // show monthly report
            $tempDate = $startTime;
            for ($i = 0; $i < 12; $i++) {
                if ($i < 6)
                    $monthDaysCount = 31;
                else
                    $monthDaysCount = 30;
                $labels[] = JalaliDate::date('F', $tempDate);
                $tempDate = $tempDate + (60 * 60 * 24 * ($monthDaysCount));
                $count = 0;
                foreach ($report as $model) {
                    if ($model->date >= $startTime + (60 * 60 * 24 * ($monthDaysCount * $i)) and $model->date < $startTime + (60 * 60 * 24 * ($monthDaysCount * ($i + 1))))
                        $count++;
                }
                $values[] = $count;
            }
        } elseif (isset($_POST['show-chart-by-program'])) {
            $activeTab = 'by-program';
            $showChart = true;
            $criteria = new CDbCriteria();
            $criteria->addCondition('date > :from_date');
            $criteria->addCondition('date < :to_date');
            $criteria->addCondition('app_id=:app_id');
            $criteria->params = array(
                ':from_date' => $_POST['from_date_altField'],
                ':to_date' => $_POST['to_date_altField'],
                ':app_id' => $_POST['app_id'],
            );
            $report = AppBuys::model()->findAll($criteria);
            if ($_POST['to_date_altField'] - $_POST['from_date_altField'] < (60 * 60 * 24 * 30)) {
                // show daily report
                $datesDiff = $_POST['to_date_altField'] - $_POST['from_date_altField'];
                $daysCount = ($datesDiff / (60 * 60 * 24));
                for ($i = 0; $i < $daysCount; $i++) {
                    $labels[] = JalaliDate::date('d F Y', $_POST['from_date_altField'] + (60 * 60 * (24 * $i)));
                    $count = 0;
                    foreach ($report as $model) {
                        if ($model->date >= $_POST['from_date_altField'] + (60 * 60 * (24 * $i)) and $model->date < $_POST['from_date_altField'] + (60 * 60 * (24 * ($i + 1))))
                            $count++;
                    }
                    $values[] = $count;
                }
            } else {
                // show monthly report
                $datesDiff = $_POST['to_date_altField'] - $_POST['from_date_altField'];
                $monthCount = ceil($datesDiff / (60 * 60 * 24 * 30));
                for ($i = 0; $i < $monthCount; $i++) {
                    $labels[] = JalaliDate::date('d F', $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * $i))) . ' الی ' . JalaliDate::date('d F', $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * ($i + 1))));
                    $count = 0;
                    foreach ($report as $model) {
                        if ($model->date >= $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * $i)) and $model->date < $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * ($i + 1))))
                            $count++;
                    }
                    $values[] = $count;
                }
            }
        } elseif (isset($_POST['show-chart-by-publisher'])) {
            $activeTab = 'by-publisher';
            $showChart = true;
            $criteria = new CDbCriteria();
            $criteria->addCondition('date > :from_date');
            $criteria->addCondition('date < :to_date');
            $criteria->addInCondition('app_id', CHtml::listData(Books::model()->findAllByAttributes(array('publisher_id' => $_POST['publisher'])), 'id', 'id'));
            $criteria->params[':from_date'] = $_POST['from_date_publisher_altField'];
            $criteria->params[':to_date'] = $_POST['to_date_publisher_altField'];
            $report = AppBuys::model()->findAll($criteria);
            if ($_POST['to_date_publisher_altField'] - $_POST['from_date_publisher_altField'] < (60 * 60 * 24 * 30)) {
                // show daily report
                $datesDiff = $_POST['to_date_publisher_altField'] - $_POST['from_date_publisher_altField'];
                $daysCount = ($datesDiff / (60 * 60 * 24));
                for ($i = 0; $i < $daysCount; $i++) {
                    $labels[] = JalaliDate::date('d F Y', $_POST['from_date_publisher_altField'] + (60 * 60 * (24 * $i)));
                    $count = 0;
                    foreach ($report as $model) {
                        if ($model->date >= $_POST['from_date_publisher_altField'] + (60 * 60 * (24 * $i)) and $model->date < $_POST['from_date_publisher_altField'] + (60 * 60 * (24 * ($i + 1))))
                            $count++;
                    }
                    $values[] = $count;
                }
            } else {
                // show monthly report
                $datesDiff = $_POST['to_date_publisher_altField'] - $_POST['from_date_publisher_altField'];
                $monthCount = ceil($datesDiff / (60 * 60 * 24 * 30));
                for ($i = 0; $i < $monthCount; $i++) {
                    $labels[] = JalaliDate::date('d F', $_POST['from_date_publisher_altField'] + (60 * 60 * 24 * (30 * $i))) . ' الی ' . JalaliDate::date('d F', $_POST['from_date_publisher_altField'] + (60 * 60 * 24 * (30 * ($i + 1))));
                    $count = 0;
                    foreach ($report as $model) {
                        if ($model->date >= $_POST['from_date_publisher_altField'] + (60 * 60 * 24 * (30 * $i)) and $model->date < $_POST['from_date_publisher_altField'] + (60 * 60 * 24 * (30 * ($i + 1))))
                            $count++;
                    }
                    $values[] = $count;
                }
            }
        }

        $this->render('report_sales', array(
            'labels' => $labels,
            'values' => $values,
            'showChart' => $showChart,
            'activeTab' => $activeTab,
        ));
    }

    /**
     * Report income
     */
    public function actionReportIncome()
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/column2';

        $labels = $values = array();
        $sumIncome = $sumCredit = 0;
        $showChart = false;
        $sumCredit = UserDetails::model()->find(array('select' => 'SUM(credit) AS credit'));
        $sumCredit = $sumCredit->credit;
        if (isset($_POST['show-chart-monthly'])) {
            $startDate = JalaliDate::toGregorian(JalaliDate::date('Y', $_POST['month_altField'], false), JalaliDate::date('m', $_POST['month_altField'], false), 1);
            $startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
            $endTime = '';
            if (JalaliDate::date('m', $_POST['month_altField'], false) <= 6)
                $endTime = $startTime + (60 * 60 * 24 * 31);
            else
                $endTime = $startTime + (60 * 60 * 24 * 30);
            $showChart = true;
            $criteria = new CDbCriteria();
            $criteria->addCondition('date >= :start_date');
            $criteria->addCondition('date <= :end_date');
            $criteria->params = array(
                ':start_date' => $startTime,
                ':end_date' => $endTime,
            );
            $report = AppBuys::model()->findAll($criteria);
            Yii::app()->getModule('setting');
            $commission = SiteSetting::model()->findByAttributes(array('name' => 'commission'));
            $commission = $commission->value;
            // show daily report
            $daysCount = (JalaliDate::date('m', $_POST['month_altField'], false) <= 6) ? 31 : 30;
            for ($i = 0; $i < $daysCount; $i++) {
                $labels[] = JalaliDate::date('d F Y', $startTime + (60 * 60 * (24 * $i)));
                $amount = 0;
                foreach ($report as $model) {
                    if ($model->date >= $startTime + (60 * 60 * (24 * $i)) and $model->date < $startTime + (60 * 60 * (24 * ($i + 1))))
                        $amount = $model->app->price;
                }
                $values[] = ($amount * $commission) / 100;
                $sumIncome += ($amount * $commission) / 100;
            }
        }

        $this->render('report_income', array(
            'labels' => $labels,
            'values' => $values,
            'showChart' => $showChart,
            'sumIncome' => $sumIncome,
            'sumCredit' => $sumCredit,
        ));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionSearch()
    {
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';
        $criteria = new CDbCriteria();
        $criteria->addCondition('platform_id=:platform_id AND status=:status AND confirm=:confirm AND deleted=:deleted AND (SELECT COUNT(app_images.id) FROM ym_app_images app_images WHERE app_images.app_id=t.id) != 0');
        $criteria->params[':platform_id'] = $this->platform;
        $criteria->params[':status'] = 'enable';
        $criteria->params[':confirm'] = 'accepted';
        $criteria->params[':deleted'] = 0;
        $criteria->limit = 20;
        $criteria->order='t.id DESC';
        if(isset($_GET['term']) && !empty($term = $_GET['term'])) {
            $terms = explode(' ', urldecode($term));
            $sql = null;
            foreach($terms as $key => $term)
                if($term) {
                    if(!$sql)
                        $sql = "(";
                    else
                        $sql .= " OR (";
                    $sql .= "t.title regexp :term$key OR t.description regexp :term$key OR category.title regexp :term$key)";
                    $criteria->params[":term$key"] = $term;
                }
            $criteria->with[] = 'category';
            $criteria->addCondition($sql);

        }
        $dataProvider = new CActiveDataProvider('Books', array('criteria' => $criteria));

        $this->render('search', array(
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Show books list of category
     */
    public function actionDiscount()
    {
        Yii::app()->theme = 'market';
        $this->layout = 'public';
        $criteria = new CDbCriteria();
        $criteria->with[] = 'app';
        $criteria->addCondition('app.confirm=:confirm');
        $criteria->addCondition('app.deleted=:deleted');
        $criteria->addCondition('app.status=:status');
        $criteria->addCondition('app.platform_id=:platform');
        $criteria->addCondition('(SELECT COUNT(app_images.id) FROM ym_app_images app_images WHERE app_images.app_id=app.id) != 0');
        $criteria->addCondition('(SELECT COUNT(app_packages.id) FROM ym_app_packages app_packages WHERE app_packages.app_id=app.id) != 0');
        $criteria->addCondition('start_date < :now AND end_date > :now');
        $criteria->addCondition('(SELECT COUNT(app_packages.id) FROM ym_app_packages app_packages WHERE app_packages.app_id=app.id) != 0');
        $criteria->params = array(
            ':confirm' => 'accepted',
            ':deleted' => 0,
            ':status' => 'enable',
            ':platform' => $this->platform,
            ':now' => time()
        );
        $criteria->order='app.id DESC';
        $dataProvider = new CActiveDataProvider('AppDiscounts', array(
            'criteria' => $criteria,
        ));

        $this->render('books_discounts_list', array(
            'dataProvider' => $dataProvider,
            'pageTitle' => 'تخفیفات'
        ));
    }

    /**
     * @param $app_id
     * @param $rate
     * @throws CException
     * @throws CHttpException
     */
    public function actionRate($app_id ,$rate)
    {
        $model = $this->loadModel($app_id);
        if($model) {
            $rateModel = new AppRatings();
            $rateModel->rate = (int)$rate;
            $rateModel->app_id = $model->id;
            $rateModel->user_id = Yii::app()->user->getId();
            if($rateModel->save()) {
                $this->beginClip('rate-view');
                $this->renderPartial('_rating', array(
                    'model' => $model
                ));
                $this->endClip();
                if(isset($_GET['ajax'])) {
                    echo CJSON::encode(array('status' => true,'rate'=> $rateModel->rate , 'rate_wrapper' => $this->clips['rate-view']));
                    Yii::app()->end();
                }
            } else {
                if(isset($_GET['ajax'])) {
                    echo CJSON::encode(array('status' => false, 'msg' => 'متاسفانه عملیات با خطا مواجه است! لطفا مجددا سعی فرمایید.'));
                    Yii::app()->end();
                }
            }
        }else {
            if(isset($_GET['ajax'])) {
                echo CJSON::encode(array('status' => false, 'msg' => 'مقادیر ارسالی صحیح نیست.'));
                Yii::app()->end();
            }
        }
    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Books the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Books::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}