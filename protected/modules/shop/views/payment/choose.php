<?php
/* @var $this ShopOrderController */
/* @var $form CActiveForm */
/* @var $user Users */
/* @var $paymentMethods ShopPaymentMethod[] */
/* @var $discountObj DiscountCodes */

$discountCodesInSession = Users::model()->getDiscountCodes();
$discountObj = DiscountCodes::model()->findByAttributes(['code' => $discountCodesInSession]);
$cartStatistics = Shop::getPriceTotal();
?>
<div class="page">
    <div class="page-heading">
        <div class="container">
            <h1>اطلاعات پرداخت</h1>
        </div>
    </div>
    <div class="container page-content">
        <div class="white-box cart">
            <?php $this->renderPartial('/order/_steps', array('point' => 2));?>
            <?php $this->renderPartial("//partial-views/_flashMessage");?>
            <?php if($discountCodesInSession):?>
                <div class="used-discount-code">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"><?php echo CHtml::encode($discountObj->title);?><a href="<?php echo $this->createUrl("/shop/order/removeDiscount", array("code"=>$discountObj->code));?>" class="remove">حذف</a></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics['discountCodeAmount']))?><small> تومان</small></div>
                </div>
            <?php else:?>
                <div class="discount-code">
                    <div class="checkbox-container">
                        <input type="checkbox" id="has-discount" data-toggle="collapse" data-target="#discount-code-form">
                        <label for="has-discount">کد تخفیف کتابیک دارم</label>
                    </div>
                    <div id="discount-code-form" class="collapse">
                        <div class="pull-right">لطفا کد تخفیف خود را وارد کنید.</div>
                        <div class="pull-left">
                            <?php echo CHtml::beginForm(array("/shop/order/addDiscount"));?>
                                <?php echo CHtml::textField("DiscountCodes[code]", "", array("class"=>"text-field sm pull-right", "placeholder"=>"کد تخفیف"));?>
                                <?php echo CHtml::submitButton("ثبت", array("class"=>"btn-blue btn-sm pull-left"));?>
                            <?php echo CHtml::endForm();?>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <div class="bill">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل خرید</div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php //echo ?><small> تومان</small></div>
                    </li>
                    <li class="list-group-item red-item">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">تخفیف کتاب + کد تخفیف نوروزی</div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center">1.000<small> تومان</small></div>
                    </li>
                    <li class="list-group-item green-item">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">مبلغ قابل پرداخت</div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center">17.000<small> تومان</small></div>
                    </li>
                </ul>
            </div>
            <div class="payment-method">
                <h5>شیوه پرداخت</h5>
                <div class="payment-methods-list">
                    <div class="payment-method-item">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
                            <div class="radio-control">
                                <input name="r" id="r2" type="radio">
                                <label for="r2"></label>
                            </div>
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
                            <h5 class="name">پرداخت اینترنتی توسط درگاه پرداخت زرین پال </h5>
                        </div>
                    </div>
                    <div class="payment-method-item">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
                            <div class="radio-control">
                                <input name="r" id="r1" type="radio">
                                <label for="r1"></label>
                            </div>
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
                            <h5 class="name">پرداخت در محل</h5>
                        </div>
                    </div>
                    <div class="payment-method-item">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
                            <div class="radio-control">
                                <input name="r" id="r1" type="radio">
                                <label for="r1"></label>
                            </div>
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
                            <h5 class="name">پرداخت حضوری</h5>
                        </div>
                    </div>
                </div>
                <small class="note">با انتخاب دکمه (پرداخت و ثبت سفارش) موافقت خود را با <a href="#">شرایط و قوانین</a> مربوط به ثبت سفارش کتابیک، اعلام نموده‌اید. </small>
            </div>
            <div class="buttons">
                <a href="<?= $this->createUrl('/shop/cart/view') ?>" class="btn-black pull-right">بازگشت به سبد خرید</a>
                <input type="submit" class="btn-blue pull-left" value="بازبینی سفارش">
            </div>
        </div>
    </div>
</div>