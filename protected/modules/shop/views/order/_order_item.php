<?php
/* @var $this ShopOrderController */
/* @var $model ShopOrder */
/* @var $item ShopOrderItems */
?>

<div class="order-info">
    <table class="table">
        <thead>
            <tr>
                <th>شرح محصول</th>
                <th class="text-center">تعداد</th>
                <th class="text-center hidden-xs">قیمت واحد<small>(همراه با تخفیف)</small></th>
                <th class="text-center hidden-xs">قیمت کل</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model->items as $item):?>
                <tr>
                    <td>
                        <h5><a href="<?php echo $this->createUrl("/book/".$item->model->id."/".urlencode($item->model->title));?>"><?php echo CHtml::encode($item->model->title);?></a></h5>
                        <span class="item hidden-xs">نویسنده: <span class="value"><?php echo $item->model->getPersonsTags("نویسنده", "fullName", true, "span");?></span></span>
                    </td>
                    <td class="text-center">
                        <?php echo CHtml::encode(Controller::parseNumbers($item->qty));?> عدد
                    </td>
                    <td class="text-center hidden-xs">
                        <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->fee)));?>تومان
                    </td>
                    <td class="text-center hidden-xs">
                        <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->fee*$item->qty)));?>تومان
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <div class="order-status">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4>اطلاعات مالی سفارش</h4>
                <div class="rows">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">مبلغ کل</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php echo CHtml::encode(Controller::parseNumbers(number_format($model->price_amount)));?> تومان</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">تخفیفات</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php echo CHtml::encode(Controller::parseNumbers(number_format($model->discount_amount)));?> تومان</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">روش ارسال</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php echo CHtml::encode($model->shippingMethod->title)?><?php
                            if($model->shipping_price == 0):
                                echo '<small>(ارسال رایگان)</small>';
                            else:
                                ?>
                                <small> (هزینه ارسال <?php echo Controller::parseNumbers(number_format($model->shipping_price));?> تومان)</small>
                                <?
                            endif;
                            ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">مبلغ قابل پرداخت</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php echo CHtml::encode(Controller::parseNumbers(number_format($model->payment_amount)));?> تومان</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4>اطلاعات ارسالی سفارش</h4>
                <div class="rows">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">تحویل گیرنده</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php echo CHtml::encode($model->deliveryAddress->transferee);?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">آدرس تحویل</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php echo CHtml::encode($model->deliveryAddress->postal_address);?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">شماره تماس</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php echo CHtml::encode($model->deliveryAddress->emergency_tel." - ".$model->deliveryAddress->landline_tel);?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">کد مرسوله</div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">-<?php echo CHtml::encode($model->export_code);?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
