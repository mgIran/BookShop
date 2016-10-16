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
        // Has bookmarked this books by user
        $bookmarked = false;
        if (!Yii::app()->user->isGuest) {
            $hasRecord = UserBookBookmark::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'book_id' => $id));
            if ($hasRecord)
                $bookmarked = true;
        }
        // Get similar books
        $criteria = Books::model()->getValidBooks(array($model->category_id));
        $criteria->addCondition('id!=:id');
        $criteria->params[':id'] = $model->id;
        $similar = new CActiveDataProvider('Books', array('criteria' => $criteria));
        $this->render('view', array(
            'model' => $model,
            'similar' => $similar,
            'bookmarked' => $bookmarked,
        ));
    }

    /**
     * Buy book
     */
    public function actionBuy($id, $title)
    {
        Yii::app()->theme = 'market';
        $this->layout = 'panel';

        $model = $this->loadModel($id);
        $price = $model->hasDiscount()?$model->offPrice:$model->price;
        $buy = BookBuys::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'book_id' => $id));
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

            $buy = new BookBuys();
            $buy->book_id = $model->id;
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
     * Download book
     */
    public function actionDownload($id, $title)
    {
        $model = $this->loadModel($id);
        if ($model->price == 0) {
            $model->download += 1;
            $model->setScenario('update-download');
            $model->save();
            $this->download($model->lastPackage->file_name, Yii::getPathOfAlias("webroot") . '/uploads/books/files');
        } else {
            $buy = BookBuys::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'book_id' => $id));
            if ($buy) {
                $model->download += 1;
                $model->setScenario('update-download');
                $model->save();
                $this->download($model->lastPackage->file_name, Yii::getPathOfAlias("webroot") . '/uploads/books/files');
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
        $criteria = Books::model()->getValidBooks();
        if (isset($_GET['t']) and $_GET['t'] == 1) {
            $criteria->addCondition('publisher_name=:publisher');
            $publisher_id = $title;
        } else {
            $criteria->addCondition('publisher_id=:publisher');
            $publisher_id = $id;
        }
        $criteria->params[':dev'] = $publisher_id;
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
        $categoryIds = BookCategories::model()->getCategoryChildes($id);
        $criteria = Books::model()->getValidBooks($categoryIds);
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
     * Bookmark book
     */
    public function actionBookmark()
    {
        Yii::app()->getModule('users');
        $model = UserBookBookmark::model()->find('user_id=:user_id AND book_id=:book_id', array(':user_id' => Yii::app()->user->getId(), ':book_id' => $_POST['bookId']));
        if (!$model) {
            $model = new UserBookBookmark();
            $model->book_id = $_POST['bookId'];
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
            if (UserBookBookmark::model()->deleteAllByAttributes(array('user_id' => Yii::app()->user->getId(), 'book_id' => $_POST['bookId'])))
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
            $report = BookBuys::model()->findAll($criteria);
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
            $report = BookBuys::model()->findAll($criteria);
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
            $criteria->addCondition('book_id=:book_id');
            $criteria->params = array(
                ':from_date' => $_POST['from_date_altField'],
                ':to_date' => $_POST['to_date_altField'],
                ':book_id' => $_POST['book_id'],
            );
            $report = BookBuys::model()->findAll($criteria);
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
            $criteria->addInCondition('book_id', CHtml::listData(Books::model()->findAllByAttributes(array('publisher_id' => $_POST['publisher'])), 'id', 'id'));
            $criteria->params[':from_date'] = $_POST['from_date_publisher_altField'];
            $criteria->params[':to_date'] = $_POST['to_date_publisher_altField'];
            $report = BookBuys::model()->findAll($criteria);
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
            $report = BookBuys::model()->findAll($criteria);
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
                        $amount = $model->book->price;
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
        $criteria->addCondition('status=:status AND confirm=:confirm AND deleted=:deleted AND (SELECT COUNT(book_images.id) FROM ym_book_images book_images WHERE book_images.book_id=t.id) != 0');
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
        $criteria->with[] = 'book';
        $criteria->addCondition('book.confirm=:confirm');
        $criteria->addCondition('book.deleted=:deleted');
        $criteria->addCondition('book.status=:status');
        $criteria->addCondition('(SELECT COUNT(book_images.id) FROM ym_book_images book_images WHERE book_images.book_id=book.id) != 0');
        $criteria->addCondition('(SELECT COUNT(book_packages.id) FROM ym_book_packages book_packages WHERE book_packages.book_id=book.id) != 0');
        $criteria->addCondition('start_date < :now AND end_date > :now');
        $criteria->addCondition('(SELECT COUNT(book_packages.id) FROM ym_book_packages book_packages WHERE book_packages.book_id=book.id) != 0');
        $criteria->params = array(
            ':confirm' => 'accepted',
            ':deleted' => 0,
            ':status' => 'enable',
            ':now' => time()
        );
        $criteria->order='book.id DESC';
        $dataProvider = new CActiveDataProvider('BookDiscounts', array(
            'criteria' => $criteria,
        ));

        $this->render('books_discounts_list', array(
            'dataProvider' => $dataProvider,
            'pageTitle' => 'تخفیفات'
        ));
    }

    /**
     * @param $book_id
     * @param $rate
     * @throws CException
     * @throws CHttpException
     */
    public function actionRate($book_id ,$rate)
    {
        $model = $this->loadModel($book_id);
        if($model) {
            $rateModel = new BookRatings();
            $rateModel->rate = (int)$rate;
            $rateModel->book_id = $model->id;
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