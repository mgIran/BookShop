<?php
/* @var $this ShopOrderController */
/* @var $form CActiveForm */
/* @var $user Users */
/* @var $paymentMethods ShopPaymentMethod[] */
Shop::getPriceTotal();
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
				<h5>خلاصه صورتحساب شما</h5>
				<ul class="list-group">
					<li class="list-group-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل خرید شما</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center">10.000<small> تومان</small></div>
					</li>
					<li class="list-group-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">هزینه ارسال</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center">8.000<small> تومان</small></div>
					</li>
					<li class="list-group-item red-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل تخفیف</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center">0<small> تومان</small></div>
					</li>
					<li class="list-group-item green-item">
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل قابل پرداخت</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center">18.000<small> تومان</small></div>
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