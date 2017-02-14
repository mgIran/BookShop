<?php
$this->renderPartial('/order/_steps', array('point' => 4));

$this->breadcrumbs=array(
		Shop::t('Order')=>array('index'),
		Shop::t('New Order'),
		);
?>

<?php 
Shop::renderFlash();
echo CHtml::beginForm(array('//shop/order/confirm'));
echo '<h2>'.Shop::t('Confirmation').'</h2>';


if(Shop::getCartContent() == array())
	return false;

	// If the customer is not passed over to the view, we assume the user is 
	// logged in and we fetch the customer data from the customer table
if(!isset($customer))
	$customer = Shop::getCustomer();
	$this->renderPartial('application.modules.shop.views.customer.view', array(
				'model' => $customer,
				'hideAddress' => true,
				'hideEmail' => true));
echo '<br />';
echo '<hr />';
				
				
echo '<p>';
	$shipping = ShopShippingMethod::model()->findByPk(Yii::app()->user->getState('shipping_method'));
	echo '<strong>'.Shop::t('Shipping Method').': </strong>'.' '.$shipping->title.' ('.$shipping->description.')';
	echo '<br />';
	echo CHtml::link(Shop::t('Edit shipping method'), array(
			'//shop/shippingMethod/choose', 'order' => true));
			echo '</p>';


echo '<p>';
	$payment = 	ShopPaymentMethod::model()->findByPk(Yii::app()->user->getState('payment_method'));
	echo '<strong>'.Shop::t('Payment method').': </strong>'.' '.$payment->title.' ('.$payment->description.')';	
	echo '<br />';
	echo CHtml::link(Shop::t('Edit payment method'), array(
			'//shop/paymentMethod/choose', 'order' => true));
echo '</p>';

echo '<hr />';

//$this->renderPartial('application.modules.shop.views.shoppingCart.view');


echo '<h3>'.Shop::t('Please add additional comments to the order here').'</h3>'; 

echo CHtml::textArea('Order[Comment]',
		@Yii::app()->user->getState('order_comment'), array('style'=>'width:600px; height:100px;padding:10px;'));
		
echo '<br /><br />';

echo '<hr />';
//$this->renderPartial(Shop::module()->termsView);

?>

<div class="row buttons">
	<?php echo CHtml::submitButton(Shop::t('Confirm Order'),array ('id'=>'next'), array(
                '//shop/order/confirm')); ?>
</div>
<?php echo CHtml::endForm(); ?>











<?php
/* @var $this ShopOrderController */
/* @var $form CActiveForm */
/* @var $user Users */
/* @var $paymentMethods ShopPaymentMethod[] */
?>
<div class="page">
	<div class="page-heading">
		<div class="container">
			<h1>بازبینی سفارش</h1>
		</div>
	</div>
	<div class="container page-content relative">
		<?php $this->renderPartial('shop.views.shipping._loading', array('id' => 'basket-loading')) ?>
		<div class="white-box cart">
			<?php $this->renderPartial('/order/_steps', array('point' => 2));?>
			<?php $this->renderPartial('/payment/_basket_table', array('books' => Shop::getCartContent()));?>
			<div class="bill">
				<?php $cartStatistics=Shop::getPriceTotal(); ?>
				<h5>خلاصه صورتحساب شما</h5>
				<ul class="list-group">
					<li class="list-group-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل خرید شما</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalPrice"]))?><small> تومان</small></div>
					</li>
					<li class="list-group-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">هزینه ارسال</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["shippingPrice"]))?><small> تومان</small></div>
					</li>
					<li class="list-group-item red-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل تخفیف</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalDiscount"]))?><small> تومان</small></div>
					</li>
					<li class="list-group-item green-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل قابل پرداخت</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalPayment"]))?><small> تومان</small></div>
					</li>
				</ul>
			</div>
			<div class="address-info">
				<h5>اطلاعات ارسال سفارش</h5>
				<ul class="list-group">
					<li class="list-group-item">این سفارش به <span class="green-label">مسعود قراگوزلو</span> به آدرس <span class="green-label">بلوار سوم خرداد</span> و شماره تماس <span class="green-label">09373252746</span> تحویل می گردد.</li>
					<li class="list-group-item">این سفارش از طریق <span class="green-label">تحویل اکسپرس کتابیک</span> با هزینه <span class="green-label">8.000</span> تومان به شما تحویل داده خواهد شد.</li>
				</ul>
			</div>
			<div class="buttons">
				<input type="submit" class="btn-black pull-right" value="بازگشت">
				<input type="submit" class="btn-blue pull-left" value="تایید و انتخاب شیوه پرداخت">
			</div>
		</div>
	</div>
</div>