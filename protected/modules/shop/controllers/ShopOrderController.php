<?php

class ShopOrderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/public';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'frontend' => array('create', 'addDiscount', 'removeDiscount', 'back', 'confirm', 'history', 'getInfo'),
			'backend' => array('admin', 'index', 'view', 'delete', 'update', 'changeStatus')
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - create, addDiscount, removeDiscount, back, confirm',
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
		$this->render('view', array(
			'model' => $this->loadModel($id),
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
	 * @param null $delivery_address
	 */
	public function actionCreate($customer = null, $payment_method = null, $shipping_method = null, $delivery_address = null)
	{
		Yii::app()->theme = "frontend";
		$this->layout = "//layouts/index";
		Yii::app()->getModule('users');
		Yii::app()->getModule('discountCodes');

		if(!Yii::app()->user->hasState('basket-position'))
			Yii::app()->user->setState('basket-position', 1);
		$cart = Shop::getCartContent();
		if(!$cart)
			$this->redirect(array('/shop/cart/view'));
		if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'){
			$customer = Yii::app()->user->getId();
			Yii::app()->user->setState('customer_id', $customer);
			if(Yii::app()->user->getState('basket-position') < 2)
				Yii::app()->user->setState('basket-position', 2);
		}
		if(isset($_POST['DeliveryAddress']))
			Yii::app()->user->setState('delivery_address', $_POST['DeliveryAddress']);
		if(isset($_POST['ShippingMethod'])){
			Yii::app()->user->setState('shipping_method', $_POST['ShippingMethod']);
			if(Yii::app()->user->hasState('delivery_address'))
				Yii::app()->user->setState('basket-position', 3);
		}
		if(isset($_POST['PaymentMethod'])){
			Yii::app()->user->setState('payment_method', $_POST['PaymentMethod']);
			Yii::app()->user->setState('basket-position', 4);
		}
		if(!$shipping_method)
			$shipping_method = (int)Yii::app()->user->getState('shipping_method');
		if(!$delivery_address)
			$delivery_address = (int)Yii::app()->user->getState('delivery_address');
		if(!$payment_method)
			$payment_method = (int)Yii::app()->user->getState('payment_method');
		if(Yii::app()->user->getState('basket-position') == 1){
			$this->render('login');
			Yii::app()->end();
		}
		if(Yii::app()->user->getState('basket-position') == 2){
			Yii::app()->getModule('places');
			if(isset($_POST['form']) && $_POST['form'] == 'shipping-form'){
				if(!$shipping_method && !$delivery_address)
					Yii::app()->user->setFlash('warning', 'لطفا آدرس تحویل و شیوه ارسال را انتخاب کنید.');
				elseif(!$shipping_method)
					Yii::app()->user->setFlash('warning', 'لطفا شیوه ارسال را انتخاب کنید.');
				elseif(!$delivery_address)
					Yii::app()->user->setFlash('warning', 'لطفا آدرس تحویل را انتخاب کنید.');
			}
			$this->render('/shipping/choose', array(
				'user' => Shop::getCustomer(),
				'shippingMethods' => ShopShippingMethod::model()->findAll(array(
					'condition' => 'status <> :deactive',
					'order' => 't.order',
					'params' => array(':deactive' => ShopShippingMethod::STATUS_DEACTIVE)
				)),
			));
			Yii::app()->end();
		}
		if(Yii::app()->user->getState('basket-position') == 3){
			if(isset($_POST['form']) && $_POST['form'] == 'payment-form'){
				if(!$payment_method)
					Yii::app()->user->setFlash('warning', 'لطفا شیوه پرداخت را انتخاب کنید.');
			}
			$shipping_object = ShopShippingMethod::model()->findByPk($shipping_method);
			$this->render('/payment/choose', array(
				'user' => Shop::getCustomer(),
				'paymentMethods' => $shipping_object->getPaymentMethodObjects()
			));
			Yii::app()->end();
		}

		if(Yii::app()->user->getState('basket-position') == 4){
			if(is_numeric($customer))
				$customer = Users::model()->findByPk($customer);
			if(is_numeric($shipping_method))
				$shipping_method = ShopShippingMethod::model()->findByPk($shipping_method);
			if(is_numeric($delivery_address))
				$delivery_address = ShopAddresses::model()->findByPk($delivery_address);
			if(is_numeric($payment_method))
				$payment_method = ShopPaymentMethod::model()->findByPk($payment_method);

			$this->render('/order/create', array(
				'user' => $customer,
				'shippingMethod' => $shipping_method,
				'deliveryAddress' => $delivery_address,
				'paymentMethod' => $payment_method
			));
		}
	}

	public function actionBack()
	{
		$position = Yii::app()->user->getState('basket-position');
		if($position > 2)
			$position--;
		elseif($position == 2)
			$this->redirect(array('/shop/cart/view'));
		Yii::app()->user->setState('basket-position', $position);
		$this->redirect(array('/shop/order/create'));
	}

	public function actionConfirm($customer = null)
	{
		Yii::app()->theme = "frontend";
		$this->layout = "//layouts/index";
		Yii::app()->getModule('users');
		Yii::app()->getModule('discountCodes');
		// check cart content and statistics
		$cartStatistics = Shop::getPriceTotal();
		$cart = Shop::getCartContent();
		if(!$cart || Shop::isEmpty($cartStatistics))
			$this->redirect(array('/shop/cart/view'));

		// check order fields that is correct to be send
		if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user')
			$customer = Yii::app()->user->getId();
		elseif(Yii::app()->user->hasState('customer_id'))
			$customer = Yii::app()->user->getState('customer_id');

		$shipping_method = Yii::app()->user->getState('shipping_method');
		$delivery_address = Yii::app()->user->getState('delivery_address');
		$payment_method = Yii::app()->user->getState('payment_method');
		if(!$customer || !$shipping_method || !$delivery_address || !$payment_method)
			$this->redirect(array('/shop/order/create'));
		// order save in db
		$order = new ShopOrder();
		$order->user_id = $customer;
		$order->shipping_method = $shipping_method;
		$order->payment_method = $payment_method;
		$order->delivery_address_id = $delivery_address;
		$order->ordering_date = time();
		$order->update_date = time();
		$order->status = ShopOrder::STATUS_ACCEPTED;
		$order->payment_amount = (double)$cartStatistics['totalPayment'];
		$order->price_amount = (double)$cartStatistics['totalPrice'];
		$order->discount_amount = (double)$cartStatistics['totalDiscount'] + (double)$cartStatistics['discountCodeAmount'];
		$order->shipping_price = (double)$cartStatistics['shippingPrice'];
		$order->payment_price = (double)$cartStatistics['paymentPrice'];
		if($order->save()){
			// order items save in db
			$flag = true;
			foreach($cart as $id => $array){
				$id = $array['book_id'];
				$qty = $array['qty'];
				$model = Books::model()->findByPk($id);
				$orderItem = new ShopOrderItems();
				$orderItem->order_id = $order->id;
				$orderItem->model_name = get_class($model);
				$orderItem->model_id = $id;
				$orderItem->fee = $model->printed_price;
				$orderItem->qty = $qty;
				$flag = @$orderItem->save();
				if(!$flag)
					break;
			}
			if(!$flag){
				$order->delete();
				Yii::app()->user->setFlash('failed', 'متاسفانه در ثبت سفارش مشکلی پیش آمده است! لطفا موارد را بررسی کرده و مجدد تلاش فرمایید.');
				Yii::app()->user->setState('basket-position', 4);
				$this->redirect(array('create'));
			}

			// clear cart content and all order states
			Shop::clearCartContent();
			Shop::clearOrderStates();

			// @todo payment order redirects


			if($order->payment_amount !== 0){
				if($order->paymentMethod->name == ShopPaymentMethod::METHOD_CASH){
					DiscountCodes::InsertCodes($order->user); // insert used discount code in db
					$order->setStatus(ShopOrder::STATUS_STOCK_PROCESS)->save();
					Yii::app()->user->setFlash('success', 'خرید شما با موفقیت انجام شد.');
				}else if($order->paymentMethod->name == ShopPaymentMethod::METHOD_CREDIT){
					if($order->user->userDetails->credit < $order->payment_amount){
						Yii::app()->user->setFlash('credit-failed', 'اعتبار فعلی شما کافی نیست!');
						$this->refresh();
					}
					$userDetails = UserDetails::model()->findByAttributes(array('user_id' => $order->user_id));
					$userDetails->setScenario('update-credit');
					$userDetails->credit = $userDetails->credit - $order->payment_amount;
					if($userDetails->save()){
						DiscountCodes::InsertCodes($order->user); // insert used discount code in db
						$order->setStatus(ShopOrder::STATUS_PAID)->save();
						Yii::app()->user->setFlash('success', 'خرید شما با موفقیت انجام شد.');
					}else
						Yii::app()->user->setFlash('failed', 'در انجام عملیات خرید خطایی رخ داده است. لطفا مجددا تلاش کنید.');
				}else if($order->paymentMethod->name == ShopPaymentMethod::METHOD_GATEWAY){
					// Save transaction
					$transaction = new UserTransactions();
					$transaction->user_id = $order->user_id;
					$transaction->amount = $order->payment_amount;
					$transaction->date = time();
					$transaction->gateway_name = 'زرین پال';
					$transaction->type = UserTransactions::TRANSACTION_TYPE_SHOP;

					if($transaction->save()){
						$gateway = new ZarinPal();
						$gateway->callback_url = Yii::app()->getBaseUrl(true) . '/shop/order/verify/' . $order->id;
						$siteName = Yii::app()->name;
						$description = "پرداخت فاکتور {$order->getOrderID()} در وبسایت {$siteName} از طریق درگاه {$gateway->getGatewayName()}";
						$result = $gateway->request(doubleval($transaction->amount), $description, Yii::app()->user->email, $this->userDetails && $this->userDetails->phone?$this->userDetails->phone:'0');
						$transaction->scenario = 'set-authority';
						$transaction->description = $description;
						$transaction->authority = $result->getAuthority();
						$transaction->save();
						//Redirect to URL You can do it also by creating a form
						if($result->getStatus() == 100)
							$this->redirect($gateway->getRedirectUrl());
						else
							throw new CHttpException(404, 'خطای بانکی: ' . $result->getError());
					}
				}
			}else{
				DiscountCodes::InsertCodes($order->user); // insert used discount code in db
				Yii::app()->user->setFlash('success', 'خرید شما با موفقیت انجام شد.');
			}
		}else{
			Yii::app()->user->setFlash('failed', 'متاسفانه در ثبت سفارش مشکلی پیش آمده است! لطفا موارد را بررسی کرده و مجدد تلاش فرمایید.');
			Yii::app()->user->setState('basket-position', 4);
			$this->redirect(array('create'));
		}
	}

	public function actionPayment($id)
	{
		Yii::app()->theme = "frontend";
		$this->layout = "//layouts/index";
		Yii::app()->getModule('users');
		Yii::app()->getModule('discountCodes');
		$order = $this->loadModel($id);
		// @todo payment order redirects

		$this->render('confirm', array(
			'order' => $order,
		));
	}

	public function actionVerify()
	{
		Yii::app()->theme = "frontend";
		$this->layout = "//layouts/index";

		// @todo payment order redirects

		$this->render('confirm', array(
			'order' => $order,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopOrder'])){
			$model->attributes = $_POST['ShopOrder'];
			if($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'model' => $model,
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
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ShopOrder');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = '//layouts/column1';
		$model = new ShopOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopOrder']))
			$model->attributes = $_GET['ShopOrder'];

		$this->render('admin', array(
			'model' => $model,
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
		$model = ShopOrder::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopOrder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'shop-order-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Change Status action
	 * @throws CHttpException
	 */
	public function actionChangeStatus()
	{
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$id = (int)$_GET['id'];
			$model = $this->loadModel($id);
			if($model->changeStatus()->save())
				echo CJSON::encode(['status' => true]);
			else
				echo CJSON::encode(['status' => false, 'msg' => 'در تغییر وضعیت این آیتم مشکلی بوجود آمده است! لطفا مجددا بررسی کنید.']);
		}
	}

	/**
	 * Add discount code to order invoice
	 */
	public function actionAddDiscount()
	{
		Yii::app()->user->setState('basket-position', 3);
		Yii::app()->getModule('discountCodes');
		// use Discount codes
		if(isset($_POST['DiscountCodes'])){
			$code = $_POST['DiscountCodes']['code'];
			$criteria = DiscountCodes::ValidCodes();
			$criteria->compare('code', $code);
			$discount = DiscountCodes::model()->find($criteria);
			/* @var $discount DiscountCodes */
			if($discount === NULL){
				Yii::app()->user->setFlash('failed', 'کد تخفیف مورد نظر موجود نیست.');
				$this->redirect(array('/shop/order/create'));
			}
			if($discount->limit_times && $discount->usedCount() >= $discount->limit_times){
				Yii::app()->user->setFlash('failed', 'محدودیت تعداد استفاده از کد تخفیف مورد نظر به اتمام رسیده است.');
				$this->redirect(array('/shop/order/create'));
			}
			if(!Yii::app()->user->isGuest && $discount->user_id && $discount->user_id != Yii::app()->user->getId()){
				Yii::app()->user->setFlash('failed', 'کد تخفیف مورد نظر نامعتبر است.');
				$this->redirect(array('/shop/order/create'));
			}
			$used = $discount->codeUsed(array(
					'condition' => 'user_id = :user_id',
					'params' => array(':user_id' => Yii::app()->user->getId()),
				)
			);
			/* @var $used DiscountUsed */
			if($used){
				$u_date = JalaliDate::date('Y/m/d - H:i', $used->date);
				Yii::app()->user->setFlash('failed', "کد تخفیف مورد نظر قبلا در تاریخ {$u_date} استفاده شده است.");
				$this->redirect(array('/shop/order/create'));
			}
			if(DiscountCodes::addDiscountCodes($discount))
				Yii::app()->user->setFlash('success', 'کد تخفیف با موفقیت اعمال شد.');
			else
				Yii::app()->user->setFlash('failed', 'کد تخفیف در حال حاضر اعمال شده است.');
			$this->redirect(array('/shop/order/create'));
		}
	}

	/**
	 * Remove added discount code to order invoice
	 */
	public function actionRemoveDiscount()
	{
		Yii::app()->user->setState('basket-position', 3);
		Yii::app()->getModule('discountCodes');
		// use Discount codes
		if(isset($_GET['code'])){
			$code = $_GET['code'];
			if(Yii::app()->user->hasState('discount-codes')){
				$discountCodesInSession = Yii::app()->user->getState('discount-codes');
				$discountCodesInSession = CJSON::decode(base64_decode($discountCodesInSession));
				if(is_array($discountCodesInSession) && in_array($code, $discountCodesInSession)){
					$key = array_search($code, $discountCodesInSession);
					unset($discountCodesInSession[$key]);
				}else if(!is_array($discountCodesInSession) && $code == $discountCodesInSession)
					$discountCodesInSession = null;
				if($discountCodesInSession)
					Yii::app()->user->setState('discount-codes', base64_encode(CJSON::encode($discountCodesInSession)));
				else
					Yii::app()->user->setState('discount-codes', null);
			}
		}
		$this->redirect(array('/shop/order/create'));
	}

	public function actionHistory()
    {
        Yii::app()->theme = "frontend";
        $this->layout = "//layouts/panel";

        $model = new ShopOrder("search");

        $this->render("history", array(
            "model" => $model,
        ));
    }

	public function actionGetInfo($id)
    {
        $model = $this->loadModel($id);

        if ($model) {
            $this->beginClip("order-item");
            $this->renderPartial("_order_item", array(
                "model" => $model,
            ));
            $this->endClip();

            echo CJSON::encode(array(
                "status" => true,
                "content" => $this->clips["order-item"]
            ));
        } else
            echo CJSON::encode(array(
                "status" => false,
            ));
    }
}