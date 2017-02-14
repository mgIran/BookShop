<?php
class Shop
{
	public static $qtyList = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10);

	public static function mailNotification($order)
	{
		$email = Shop::module()->notifyAdminEmail;
		if($email !== null){
			$appTitle = Yii::app()->name;
//			$headers = "From: {$title}\r\nReply-To: {do@not-reply.org}";

			mail($email,
				Shop::t('Order #{order_id} has been made in your Webshop', array(
					'{order_id}' => $order->id)),
				CHtml::link(Shop::t('direct link'), array(
					'//shop/order/view', 'id' => $order->id)));
		}
	}

	public static function getPaymentMethod()
	{
		if($payment_method = Yii::app()->user->getState('payment_method'))
			return ShopPaymentMethod::model()->findByPk($payment_method);
	}

	public static function getShippingMethod()
	{
		if($shipping_method = Yii::app()->user->getState('shipping_method'))
			return ShopShippingMethod::model()->findByPk($shipping_method);
	}

	public static function getDeliveryAddress()
	{
		if($delivery_address = Yii::app()->user->getState('delivery_address'))
			return ShopAddresses::model()->findByPk($delivery_address);
	}


	public static function getCartContent()
    {
        if(is_string(Yii::app()->user->getState('cart')))
            return json_decode(Yii::app()->user->getState('cart'), true);
        else
            return Yii::app()->user->getState('cart');
    }

	public static function setCartContent($cart)
	{
		return Yii::app()->user->setState('cart', json_encode($cart));
	}

	public static function getCartCount()
	{
		$cart = self::getCartContent();
		$count = 0;
		if(!is_null($cart))
			foreach ($cart as $item)
				$count += $item['qty'];
		return $count;
	}

	public static function getPriceTotal()
	{
		$response = [];
		$price_total = 0;
		$discount_total = 0;
		$payment_total = 0;
		$payment_price = 0;
		$shipping_price = 0;
		$discountCodeAmount = 0;
		foreach(Shop::getCartContent() as $book){
			$model = Books::model()->findByPk($book['book_id']);
			$price = (double)($model->getPrinted_price() * $book['qty']);
			$price_total += $price;
			// calculate tax
			$discount_price = (double)($model->getOff_printed_price() * $book['qty']);
			$discount_total += ($price - $discount_price);
			$payment_total += $discount_price;
		}

		$response['cartPrice'] = $payment_total;

		if($discount_codes = Users::model()->getDiscountCodes()){
			$discountObj = DiscountCodes::model()->findByAttributes(['code' => $discount_codes]);
			$discountCodeAmount = (double)$discountObj->getAmount($payment_total);
			DiscountCodes::calculateDiscountCodes($payment_total);
		}

		if($shipping_method = Shop::getShippingMethod()){
			$shipping_price = (double)$shipping_method->price;
			$payment_total += $shipping_price;
		}

		if($payment_method = Shop::getPaymentMethod()){
			$payment_price = (double)$payment_method->price;
			$payment_total += $payment_price;
		}

		$response['paymentPrice'] = $payment_price;
		$response['shippingPrice'] = $shipping_price;
		$response['discountCodeAmount'] = $discountCodeAmount;
		$response['totalPrice'] = $price_total;
		$response['totalDiscount'] = $discount_total;
		$response['totalPayment'] = $payment_total;
		return $response;
	}

	public static function register($file)
	{
//		$url = Yii::app()->getAssetManager()->publish(
//			Yii::getPathOfAlias('application.modules.shop.assets'));
//
//		$path = $url . '/' . $file;
//		if(strpos($file, 'js') !== false)
//			return Yii::app()->clientScript->registerScriptFile($path);
//		else if(strpos($file, 'css') !== false)
//			return Yii::app()->clientScript->registerCssFile($path);
//
//		return $path;
	}

    /**
     * Return User
     * @return Users
     */
	public static function getCustomer()
    {
        if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user')
            if($customer = Users::model()->findByPk(Yii::app()->user->getId()))
                return $customer;

        if($customer_id = Yii::app()->user->getState('customer_id'))
            return Users::model()->findByPk($customer_id);
    }

	public static function t($string, $params = array())
	{
		Yii::import('application.modules.shop.ShopModule');

		return Yii::t('ShopModule.shop', $string, $params);
	}

	/* set a flash message to display after the request is done */
	public static function setFlash($message)
	{
		Yii::app()->user->setFlash('yiishop', Shop::t($message));
	}

	public static function hasFlash()
	{
		return Yii::app()->user->hasFlash('yiishop');
	}

	/* retrieve the flash message again */
	public static function getFlash()
	{
		if(Yii::app()->user->hasFlash('yiishop')){
			return Yii::app()->user->getFlash('yiishop');
		}
	}

	public static function renderFlash()
	{
		if(Yii::app()->user->hasFlash('yiishop')){
			echo '<div class="info">';
			echo Shop::getFlash();
			echo '</div>';
			Yii::app()->clientScript->registerScript('fade', "
					setTimeout(function() { $('.info').fadeOut('slow'); }, 5000);	
					");
		}
	}
}