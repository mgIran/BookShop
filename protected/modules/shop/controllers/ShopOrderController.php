<?php

class ShopOrderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/public';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'frontend' => array('create'),
			'backend' => array('admin', 'index', 'view', 'delete', 'update', 'changeStatus')
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - create',
			'postOnly + delete',
			'ajaxOnly + changeStatus',
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    /**
     * Creation of a new Order
     * Before we create a new order, we need to gather Customer information.
     * If the user is logged in, we check if we already have customer information.
     * If so, we go directly to the Order confirmation page with the data passed
     * over. Otherwise we need the user to enter his data, and depending on
     * whether he is logged in into the system it is saved with his user
     * account or once just for this order.
     *
     * @param null $customer
     * @param null $payment_method
     * @param null $shipping_method
     */
    public function actionCreate($customer = null, $payment_method = null, $shipping_method = null) {
		Yii::app()->theme="frontend";
        $this->layout="//layouts/index";
		$cart = Shop::getCartContent();
		if(!$cart)
			$this->redirect(array('/shop/cart/view'));
        if(isset($_POST['ShippingMethod']))
            Yii::app()->user->setState('shipping_method', $_POST['ShippingMethod']);

        if(isset($_POST['PaymentMethod']))
            Yii::app()->user->setState('payment_method', $_POST['PaymentMethod']);


        if(isset($_POST['ShopAddresses']) && $_POST['ShopAddresses'] === true) {
            if(ShopAddresses::isEmpty($_POST['ShopAddresses'])) {
                Shop::setFlash(Shop::t('Delivery address is not complete! Please fill in all fields to set the Delivery address'));
            } else {
                $deliveryAddress = new ShopAddresses();
                $deliveryAddress->attributes = $_POST['ShopAddresses'];
                $deliveryAddress->user_id = Shop::getCustomer()->id;
                if($deliveryAddress->save()) {
                }
            }
        }

        if(!$customer && !Yii::app()->user->isGuest && Yii::app()->user->type == 'user')
            $customer = Yii::app()->user->getId();
        if(!Yii::app()->user->isGuest && !$customer)
            $customer = Users::model()->findByPk(Yii::app()->user->id);
        if(!$payment_method)
            $payment_method = Yii::app()->user->getState('payment_method');
        if(!$shipping_method)
            $shipping_method = Yii::app()->user->getState('shipping_method');
        if(!$customer) {
			Yii::app()->user->returnUrl = '/'.$this->route;
			$this->render('login');
            Yii::app()->end();
        }
		if(!$shipping_method) {
			$this->render('/shipping/choose', array(
                'user' => Shop::getCustomer(),
                'shipping_methods' => ShopShippingMethod::model()->findAll('status <> :deactive',array(':deactive' => ShopShippingMethod::STATUS_DEACTIVE)),
			));
			Yii::app()->end();
        }
        if(!$payment_method) {
			$shipping_object = ShopShippingMethod::model()->findByPk($shipping_method);
            $this->render('/payment/choose', array(
				'user' => Shop::getCustomer(),
				'payment_methods' => $shipping_object->getPaymentMethodObjects()
			));
            Yii::app()->end();
        }


        if($customer && $payment_method && $shipping_method)   {
            if(is_numeric($customer))
                $customer = Customer::model()->findByPk($customer);
            if(is_numeric($shipping_method))
                $shipping_method = ShopShippingMethod::model()->findByPk($shipping_method);
            if(is_numeric($payment_method))
                $payment_method = ShopPaymentMethod::model()->findByPk($payment_method);

            $this->render('/order/create', array(
                'customer' => $customer,
                'shippingMethod' => $shipping_method,
                'paymentMethod' => $payment_method,
            ));
        }
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopOrder']))
		{
			$model->attributes=$_POST['ShopOrder'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ShopOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopOrder']))
			$model->attributes=$_GET['ShopOrder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopOrder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopOrder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Change Status action
	 * @throws CHttpException
	 */
	public function actionChangeStatus(){
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$id = (int)$_GET['id'];
			$model = $this->loadModel($id);
			if($model->changeStatus()->save())
				echo CJSON::encode(['status' => true]);
			else
				echo CJSON::encode(['status' => false, 'msg' => 'در تغییر وضعیت این آیتم مشکلی بوجود آمده است! لطفا مجددا بررسی کنید.']);
		}
	}
}
