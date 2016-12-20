<?php

class BookController extends Controller
{
    public $layout = '//layouts/inner';

    private $merchantID = '012d3926-9824-11e6-a86b-005056a205be';

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'discount',
                'tag',
                'search',
                'view',
                'download',
                'publisher',
                'buy',
                'bookmark',
                'rate',
                'verify'
            ),
            'backend' => array(
                'reportSales',
                'reportIncome'
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess + reportSales, reportIncome, buy, bookmark, rate, verify',
            'postOnly + bookmark',
        );
    }

    public function actionView($id)
    {
        Yii::import('users.models.*');
        Yii::app()->theme = "frontend";
        $this->layout = "//layouts/index";
        $model = $this->loadModel($id);
        $this->keywords = $model->getKeywords();
        $this->description = mb_substr(strip_tags($model->description), 0, 160, 'utf-8');
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
        $criteria->limit = 10;
        $similar = new CActiveDataProvider('Books', array('criteria' => $criteria));

        Yii::import('pages.models.*');
        $about = Pages::model()->findByPk(3);
        $this->render('view', array(
            'model' => $model,
            'similar' => $similar,
            'bookmarked' => $bookmarked,
            'about' => $about
        ));
    }

    /**
     * Buy book
     */
    public function actionBuy($id, $title)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = 'panel';
        $userID = Yii::app()->user->getId();
        $model = $this->loadModel($id);
        $price = $model->hasDiscount() ? $model->offPrice : $model->price;
        $buy = BookBuys::model()->findByAttributes(array('user_id' => $userID ,'book_id' => $id));

        Yii::app()->getModule('users');
        $user = Users::model()->findByPk($userID);
        /* @var $user Users */
        if($model->publisher_id != $userID){
            $buyResult = false;
            if(isset($_POST['Buy'])){
                if(isset($_POST['Buy']['credit'])){
                    if($user->userDetails->credit < $model->price){
                        Yii::app()->user->setFlash('credit-failed' ,'اعتبار فعلی شما کافی نیست!');
                        Yii::app()->user->setFlash('failReason' ,'min_credit');
                        $this->refresh();
                    }

                    $userDetails = UserDetails::model()->findByAttributes(array('user_id' => $userID));
                    $userDetails->setScenario('update-credit');
                    $userDetails->credit = $userDetails->credit - $price;
                    $userDetails->score = $userDetails->score + 1;
                    if($userDetails->save())
                        $buyResult = true;
                }elseif(isset($_POST['Buy']['gateway'])){
                    // Save payment
                    $transaction = new UserTransactions();
                    $transaction->user_id = $userID;
                    $transaction->amount = $price;
                    $transaction->date = time();
                    $transaction->gateway_name = 'زرین پال';
                    $transaction->type = 'book';

                    if($transaction->save()){
                        // Redirect to payment gateway
                        $MerchantID = $this->merchantID;  //Required
                        $Amount = intval($price); //Amount will be based on Toman  - Required
                        $Description = 'خرید کتاب از ' . Yii::app()->name;  // Required
                        $Email = Yii::app()->user->email; // Optional
                        $Mobile = '0'; // Optional

                        $CallbackURL = Yii::app()->getBaseUrl(true) . '/book/verify/' . $id . '/' . urlencode($title);  // Required

                        include("lib/nusoap.php");
                        $client = new NuSOAP_Client('https://ir.zarinpal.com/pg/services/WebGate/wsdl' ,'wsdl');
                        $client->soap_defencoding = 'UTF-8';
                        $result = $client->call('PaymentRequest' ,array(
                            array(
                                'MerchantID' => $MerchantID ,
                                'Amount' => $Amount ,
                                'Description' => $Description ,
                                'Email' => $Email ,
                                'Mobile' => $Mobile ,
                                'CallbackURL' => $CallbackURL
                            )
                        ));

                        //Redirect to URL You can do it also by creating a form
                        if($result['Status'] == 100)
                            $this->redirect('https://www.zarinpal.com/pg/StartPay/' . $result['Authority']);
                        else
                            echo 'ERR: ' . $result['Status'];
                    }
                }

                if($buyResult){
                    $this->saveBuyInfo($model ,$user ,'credit');
                    Yii::app()->user->setFlash('success' ,'خرید شما با موفقیت انجام شد.');
                    $this->refresh();
                }else
                    Yii::app()->user->setFlash('failed' ,'در انجام عملیات خرید خطایی رخ داده است. لطفا مجددا تلاش کنید.');
            }
            $user->refresh();
        }else{
            Yii::app()->user->setFlash('success' ,'شما ناشر این کتاب هستید ');
        }

        $this->render('buy' ,array(
            'model' => $model ,
            'price' => $price ,
            'user' => $user ,
            'bought' => ($buy) ? true : false ,
        ));
    }

    public function actionVerify($id, $title)
    {
        if (!isset($_GET['Authority']))
            $this->redirect(array('/book/buy', 'id' => $id, 'title' => $title));
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/panel';
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id = :user_id');
        $criteria->addCondition('status = :status');
        $criteria->order = 'id DESC';
        $criteria->params = array(':user_id' => Yii::app()->user->getId(), ':status' => 'unpaid');
        $model = UserTransactions::model()->find($criteria);
        $book = Books::model()->findByPk($id);
        $user = Users::model()->findByPk(Yii::app()->user->getId());
        $MerchantID = $this->merchantID;
        $Amount = $model->amount; //Amount will be based on Toman
        $Authority = $_GET['Authority'];

        $transactionResult = false;
        if ($_GET['Status'] == 'OK') {
            include("lib/nusoap.php");
            $client = new NuSOAP_Client('https://ir.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';
            $result = $client->call('PaymentVerification', array(
                    array(
                        'MerchantID' => $MerchantID,
                        'Authority' => $Authority,
                        'Amount' => $Amount
                    )
                )
            );

            if ($result['Status'] == 100) {
                $model->status = 'paid';
                $model->token = $result['RefID'];
                $model->description = 'خرید کتاب "' . CHtml::encode($book->title) . '" از طریق درگاه زرین پال';
                $model->save();

                $transactionResult = true;
                $this->saveBuyInfo($book, $user, 'gateway', $model->id);
                Yii::app()->user->setFlash('success', 'پرداخت شما با موفقیت انجام شد.');
            } else {
                $errors = array(
                    '-1' => 'اطلاعات ارسال شده ناقص است.',
                    '-2' => 'IP یا کد پذیرنده صحیح نیست.',
                    '-3' => 'با توجه به محدودیت ها امکان پرداخت رقم درخواست شده میسر نمی باشد.',
                    '-4' => 'سطح تایید پذیرنده پایین تر از سطح نقره ای است.',
                    '-11' => 'درخواست مورد نظر یافت نشد.',
                    '-12' => 'امکان ویرایش درخواست میسر نمی باشد.',
                    '-21' => 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد.',
                    '-22' => 'تراکنش ناموفق بود.',
                    '-33' => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد.',
                    '-34' => 'سقف تقسیم تراکنش از لحاظ تعداد یا رقم عبور نموده است.',
                    '-40' => 'اجازه دسترسی به متد مربوطه وجود ندارد.',
                    '-41' => 'اطلاعات ارسال شده مربوط به AdditionalData غیر معتبر می باشد.',
                    '-42' => 'مدت زمان معتبر طول عمر شناسه پرداخت باید بین 30 دقیقه تا 45 روز باشد.',
                    '-54' => 'درخواست مورد نظر آرشیو شده است.',
                    '101' => 'عملیات پرداخت موفق بوده و قبلا بررسی تراکنش انجام شده است.',
                );
                Yii::app()->user->setFlash('failed', isset($errors[$result['Status']]) ? $errors[$result['Status']] : 'در انجام عملیات پرداخت خطایی رخ داده است.');
            }
        } else
            Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بوده یا توسط کاربر لغو شده است.');

        $this->render('verify', array(
            'transaction' => $model,
            'book' => $book,
            'user' => $user,
            'price' => $model->amount,
            'transactionResult' => $transactionResult,
        ));
    }

    /**
     * Save buy information
     *
     * @param $book Books
     * @param $user Users
     * @param $method string
     * @param $transactionID string
     */
    private function saveBuyInfo($book, $user, $method, $transactionID = null)
    {
        $price = $book->hasDiscount() ? $book->offPrice : $book->price;

        $book->download += 1;
        $book->setScenario('update-download');
        $book->save();

        $buy = new BookBuys();
        $buy->book_id = $book->id;
        $buy->user_id = $user->id;
        $buy->method = $method;
        $buy->package_id = $book->lastPackage->id;
        $buy->price=$price;
        if ($method == 'gateway')
            $buy->rel_id = $transactionID;
        $buy->save();

        if ($book->publisher) {
            $book->publisher->userDetails->credit = $book->publisher->userDetails->credit + $book->getPublisherPortion();
            $book->publisher->userDetails->save();
        }

        $message =
            '<p style="text-align: right;">با سلام<br>کاربر گرامی، جزئیات خرید شما به شرح ذیل می باشد:</p>
            <div style="width: 100%;height: 1px;background: #ccc;margin-bottom: 15px;"></div>
            <table style="font-size: 9pt;text-align: right;">
                <tr>
                    <td style="font-weight: bold;width: 120px;">عنوان کتاب</td>
                    <td>' . CHtml::encode($book->title) . '</td>
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
        Mailer::mail($user->email, 'اطلاعات خرید کتاب', $message, Yii::app()->params['noReplyEmail']);
    }

    /**
     * Download book
     *
     * public function actionDownload($id, $title)
     * {
     * $model = $this->loadModel($id);
     * if ($model->price == 0) {
     * $model->download += 1;
     * $model->setScenario('update-download');
     * $model->save();
     * $this->download($model->lastPackage->file_name, Yii::getPathOfAlias("webroot") . '/uploads/books/files');
     * } else {
     * $buy = BookBuys::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'book_id' => $id));
     * if ($buy) {
     * $model->download += 1;
     * $model->setScenario('update-download');
     * $model->save();
     * $this->download($model->lastPackage->file_name, Yii::getPathOfAlias("webroot") . '/uploads/books/files');
     * } else
     * $this->redirect(array('/book/buy/' . CHtml::encode($model->id) . '/' . CHtml::encode($model->title)));
     * }
     * }
     *
     * protected function download($fileName, $filePath)
     * {
     * $fakeFileName = $fileName;
     * $realFileName = $fileName;
     *
     * $file = $filePath . DIRECTORY_SEPARATOR . $realFileName;
     * $fp = fopen($file, 'rb');
     *
     * $mimeType = '';
     * switch (pathinfo($fileName, PATHINFO_EXTENSION)) {
     * case 'apk':
     * $mimeType = 'application/vnd.android.package-archive';
     * break;
     *
     * case 'xap':
     * $mimeType = 'application/x-silverlight-app';
     * break;
     *
     * case 'ipa':
     * $mimeType = 'application/octet-stream';
     * break;
     * }
     *
     * header('Pragma: public');
     * header('Expires: 0');
     * header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
     * header('Content-Transfer-Encoding: binary');
     * header('Content-Type: ' . $mimeType);
     * header('Content-Disposition: attachment; filename=' . $fakeFileName);
     *
     * echo stream_get_contents($fp);
     * }*/

    /**
     * Show programs list
     */
    public function actionPublisher($title, $id = null)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = 'index';
        $criteria = Books::model()->getValidBooks();
        if (isset($_GET['t']) and $_GET['t'] == 1) {
            $criteria->addCondition('publisher_name=:publisher');
            $publisher_id = $title;
        } else {
            $criteria->addCondition('publisher_id=:publisher');
            $publisher_id = $id;
        }
        $criteria->params[':publisher'] = $publisher_id;
        $dataProvider = new CActiveDataProvider('Books', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 8)
        ));

        if ($id) {
            $user = UserDetails::model()->findByAttributes(array('user_id' => $id));
            $pageTitle = 'کتاب های ' . ($user->publisher_id ? $user->publisher_id : $user->fa_name);
        } else
            $pageTitle = $title;
        $this->render('books_list', array(
            'dataProvider' => $dataProvider,
            'title' => $pageTitle,
            'pageTitle' => 'کتاب ها'
        ));
    }

    /**
     * show person books list
     */
    public function actionPerson($id, $title = null)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = 'index';
        $person = BookPersons::model()->findByPk((int)$id);
        if (!$person)
            throw new CHttpException(404, 'The requested page does not exist.');
        else
            $pageTitle = 'کتاب های ' . $person->name_family;
        $criteria = Books::model()->getValidBooks();
        $criteria->together = true;
        $criteria->with[] = 'personRel';
        $criteria->addCondition('personRel.person_id =:person_id');
        $criteria->params[':person_id'] = $id;
        $dataProvider = new CActiveDataProvider('Books', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 8)
        ));

        $this->render('books_list', array(
            'dataProvider' => $dataProvider,
            'title' => $pageTitle,
            'pageTitle' => 'کتاب ها'
        ));
    }

    public function actionIndex()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';
        $criteria = Books::model()->getValidBooks();
        $dataProvider = new CActiveDataProvider("Books", array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 8)
        ));
        $this->render('books_list', array(
            'dataProvider' => $dataProvider
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
        $sumSales=0;
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
                    if ($model->date >= $startTime + (60 * 60 * (24 * $i)) and $model->date < $startTime + (60 * 60 * (24 * ($i + 1)))) {
                        $count++;
                        $sumSales+=$model->price;
                    }
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
                    if ($model->date >= $startTime + (60 * 60 * 24 * ($monthDaysCount * $i)) and $model->date < $startTime + (60 * 60 * 24 * ($monthDaysCount * ($i + 1)))) {
                        $count++;
                        $sumSales += $model->price;
                    }
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
                        if ($model->date >= $_POST['from_date_altField'] + (60 * 60 * (24 * $i)) and $model->date < $_POST['from_date_altField'] + (60 * 60 * (24 * ($i + 1)))) {
                            $count++;
                            $sumSales += $model->price;
                        }
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
                        if ($model->date >= $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * $i)) and $model->date < $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * ($i + 1)))) {
                            $count++;
                            $sumSales += $model->price;
                        }
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
                        if ($model->date >= $_POST['from_date_publisher_altField'] + (60 * 60 * (24 * $i)) and $model->date < $_POST['from_date_publisher_altField'] + (60 * 60 * (24 * ($i + 1)))) {
                            $count++;
                            $sumSales += $model->price;
                        }
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
                        if ($model->date >= $_POST['from_date_publisher_altField'] + (60 * 60 * 24 * (30 * $i)) and $model->date < $_POST['from_date_publisher_altField'] + (60 * 60 * 24 * (30 * ($i + 1)))) {
                            $count++;
                            $sumSales += $model->price;
                        }
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
            'sumSales' => $sumSales,
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
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';
        // book criteria
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.status=:status AND t.confirm=:confirm AND t.deleted=:deleted AND (SELECT COUNT(book_packages.id) FROM ym_book_packages book_packages WHERE book_packages.book_id=t.id) != 0');
        $criteria->params[':status'] = 'enable';
        $criteria->params[':confirm'] = 'accepted';
        $criteria->params[':deleted'] = 0;
        $criteria->order = 't.confirm_date DESC';
        if(isset($_GET['term']) && !empty($term = $_GET['term'])){
            $terms = explode(' ' ,urldecode($term));
            $sql = null;
            foreach($terms as $key => $term)
                if($term){
                    if(!$sql)
                        $sql = "(";
                    else
                        $sql .= " OR (";
                    $sql .= "t.title regexp :term$key OR t.description regexp :term$key OR t.publisher_name regexp :term$key OR userDetails.publisher_id regexp :term$key OR userDetails.fa_name regexp :term$key OR category.title regexp :term$key OR persons.name_family regexp :term$key)";
                    // with correction
                    //$sql .= "t.title sounds like :term$key OR t.description sounds like :term$key OR t.publisher_name sounds like :term$key OR userDetails.publisher_id sounds like :term$key OR userDetails.fa_name sounds like :term$key OR category.title sounds like :term$key OR persons.name_family sounds like :term$key)";
                    $criteria->params[":term$key"] = $term;
                }
            $criteria->together = true;
            $criteria->with[] = 'category';
            $criteria->with[] = 'persons';
            $criteria->with[] = 'publisher';
            $criteria->with[] = 'publisher.userDetails';
            $criteria->addCondition($sql);
        }
        $pagination = new CPagination();
        $pagination->pageSize = 8;
        if(Yii::app()->request->isAjaxRequest)
        {
            $criteria->limit=6;
            $pagination->pageSize = 6;
        }
        $dataProvider = new CActiveDataProvider('Books' ,array(
            'criteria' => $criteria,
            'pagination' => $pagination
        ));
        if(Yii::app()->request->isAjaxRequest){
            $this->beginClip('book-list');
            $this->widget('zii.widgets.CListView',array(
                'id' => 'search-book-list',
                'dataProvider' => $dataProvider,
                'itemView' => '//site/_search_book_item',
                'template' => '{items}',
            ));
            $this->endClip();
            $response['html'] = $this->clips['book-list'];
            $response['status'] = true;
            echo CJSON::encode($response);
            Yii::app()->end();
        }else
            $this->render('search' ,array(
                'dataProvider' => $dataProvider
            ));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionTag($id)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';
        $criteria = Books::model()->getValidBooks();
        $criteria->compare('tagsRel.tag_id', $id);
        $criteria->with[] = 'tagsRel';
        $criteria->together = true;
        $dataProvider = new CActiveDataProvider('Books', array('criteria' => $criteria, 'pagination' => array('pageSize' => 8)));
        $this->render('tag', array(
            'model' => Tags::model()->findByPk($id),
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
        $criteria->order = 'book.id DESC';
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
    public function actionRate($book_id, $rate)
    {
        $model = $this->loadModel($book_id);
        if ($model) {
            $rateModel = new BookRatings();
            $rateModel->rate = (int)$rate;
            $rateModel->book_id = $model->id;
            $rateModel->user_id = Yii::app()->user->getId();
            if ($rateModel->save()) {
                $this->beginClip('rate-view');
                $this->renderPartial('_rating', array(
                    'model' => $model
                ));
                $this->endClip();
                if (isset($_GET['ajax'])) {
                    echo CJSON::encode(array('status' => true, 'rate' => $rateModel->rate, 'rate_wrapper' => $this->clips['rate-view']));
                    Yii::app()->end();
                }
            } else {
                if (isset($_GET['ajax'])) {
                    echo CJSON::encode(array('status' => false, 'msg' => 'متاسفانه عملیات با خطا مواجه است! لطفا مجددا سعی فرمایید.'));
                    Yii::app()->end();
                }
            }
        } else {
            if (isset($_GET['ajax'])) {
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