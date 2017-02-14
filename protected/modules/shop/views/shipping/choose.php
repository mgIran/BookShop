<?php
/* @var $this ShopOrderController */
/* @var $form CActiveForm */
/* @var $user Users */
/* @var $shippingMethods ShopShippingMethod[] */
?>

    <div class="page">
        <div class="page-heading">
            <div class="container">
                <h1>اطلاعات ارسال سفارش</h1>
            </div>
        </div>
        <div class="container page-content">
            <div class="white-box cart">
                <?php $this->renderPartial('/order/_steps', array('point' => 1));?>
                <div class="select-address">
                    <h5 class="pull-right">انتخاب آدرس</h5>
                    <a href="#" data-toggle="modal" data-target="#add-address-modal" class="btn-green pull-left">افزودن آدرس جدید</a>
                    <div class="clearfix"></div>
                    <div id="addresses-list-container">
                        <?php $this->renderPartial("/shipping/_addresses_list", array("addresses"=>$user->addresses));?>
                    </div>
                    <?php $this->renderPartial("/shipping/_add_address_modal");?>
                    <div class="shipping-method">
                        <h5>شیوه ارسال</h5>
                        <div class="shipping-methods-list">
                            <div class="shipping-method-item">
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
                                    <div class="radio-control">
                                        <input name="r" id="r2" type="radio">
                                        <label for="r2"></label>
                                    </div>
                                </div>
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
                                    <div class="pull-right">
                                        <h5 class="name">تحویل اکسپرس کتابیک</h5>
                                        <div class="desc">زمان تحويل سفارش ثبت شده تا ساعت 12: روز بعد (به‌جز روزهاي تعطيل)</div>
                                    </div>
                                    <div class="pull-left">
                                        <span>هزینه ارسال</span>
                                        <div class="price">8.000<small> تومان</small></div>
                                    </div>
                                </div>
                            </div>
                            <div class="shipping-method-item">
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
                                    <div class="radio-control">
                                        <input name="r" id="r2" type="radio">
                                        <label for="r2"></label>
                                    </div>
                                </div>
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
                                    <div class="pull-right">
                                        <h5 class="name">تحویل اکسپرس کتابیک</h5>
                                        <div class="desc">زمان تحويل سفارش ثبت شده تا ساعت 12: روز بعد (به‌جز روزهاي تعطيل)</div>
                                    </div>
                                    <div class="pull-left">
                                        <span>هزینه ارسال</span>
                                        <div class="price">8.000<small> تومان</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                        <input type="submit" class="btn-black pull-right" value="بازگشت به سبد خرید">
                        <input type="submit" class="btn-blue pull-left" value="بازبینی سفارش">
                    </div>
                </div>
            </div>
        </div>
    </div>
