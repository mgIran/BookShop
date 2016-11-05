<?php

class UsersCreditController extends Controller
{
    public $layout = '//layouts/panel';

    private $merchantID ='012d3926-9824-11e6-a86b-005056a205be';

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'buy',
                'bill',
                'verify'
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess', // perform access control for CRUD operations
        );
    }

    /**
     * Buy Credit
     */
    public function actionBuy()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/panel';
        $model = Users::model()->findByPk(Yii::app()->user->getId());
        Yii::import('application.modules.setting.models.*');
        $buyCreditOptions = SiteSetting::model()->findByAttributes(array('name' => 'buy_credit_options'));
        $amounts = array();
        foreach (CJSON::decode($buyCreditOptions->value) as $amount)
            $amounts[$amount] = Controller::parseNumbers(number_format($amount, 0)) . ' تومان';

        $this->render('buy', array(
            'model' => $model,
            'amounts' => $amounts,
        ));
    }

    /**
     * Show bill
     */
    public function actionBill()
    {
        if (isset($_POST['pay'])) {
            // Save payment
            $model = UserTransactions::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'status' => 'unpaid'));
            if (!$model)
                $model = new UserTransactions();
            $model->user_id = Yii::app()->user->getId();
            $model->amount = $_POST['amount'];
            $model->date = time();
            if ($model->save()) {
                // Redirect to payment gateway
                $MerchantID = $this->merchantID;  //Required
                $Amount = intval($_POST['amount']); //Amount will be based on Toman  - Required
                $Description = 'افزایش اعتبار در ' . Yii::app()->name;  // Required
                $Email = Yii::app()->user->email; // Optional
                $Mobile = '0'; // Optional

                $CallbackURL = Yii::app()->getBaseUrl(true) . '/users/credit/verify';  // Required

                include("lib/nusoap.php");
                $client = new NuSOAP_Client('https://ir.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
                $client->soap_defencoding = 'UTF-8';
                $result = $client->call('PaymentRequest', array(
                    array(
                        'MerchantID' => $MerchantID,
                        'Amount' => $Amount,
                        'Description' => $Description,
                        'Email' => $Email,
                        'Mobile' => $Mobile,
                        'CallbackURL' => $CallbackURL
                    )
                ));

                //Redirect to URL You can do it also by creating a form
                if ($result['Status'] == 100)
                    $this->redirect('https://www.zarinpal.com/pg/StartPay/' . $result['Authority']);
                else
                    echo 'ERR: ' . $result['Status'];
            }
        } elseif (isset($_POST['amount'])) {
            Yii::app()->theme = 'frontend';
            $amount = CHtml::encode($_POST['amount']);
            $model = Users::model()->findByPk(Yii::app()->user->getId());
            $this->render('bill', array(
                'model' => $model,
                'amount' => CHtml::encode($amount),
            ));
        } else
            $this->redirect($this->createUrl('/users/credit/buy'));
    }

    public function actionVerify()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/panel';
        $model = UserTransactions::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'status' => 'unpaid'));
        $userDetails = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
        $MerchantID = $this->merchantID;
        $Amount = $model->amount; //Amount will be based on Toman
        $Authority = $_GET['Authority'];

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
                $model->description = 'خرید اعتبار از طریق درگاه زرین پال';
                $model->save();
                // Increase credit
                $userDetails->setScenario('update-credit');
                $userDetails->credit = $userDetails->credit + $model->amount;
                $userDetails->save();
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
                Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
                Yii::app()->user->setFlash('transactionFailed', isset($errors[$result['Status']]) ? $errors[$result['Status']] : 'در انجام عملیات پرداخت خطایی رخ داده است.');
            }
        } else
            Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بوده یا توسط کاربر لغو شده است.');

        $this->render('verify', array(
            'model' => $model,
            'userDetails' => $userDetails,
        ));
    }
}