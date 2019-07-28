<?php
/* @var $this PublishersPanelController */
/* @var $model ShopOrder */
?>
<div class="white-form">
    <?php $this->renderPartial('//partial-views/_flashMessage');?>
    <h3>جزئیات سفارش</h3>
    <p class="description">جزئیات سفارش ثبت شده</p>

    <h4>جزییات اقلام سفارش</h4>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>شرح محصول</th>
            <th class="text-center">تعداد</th>
            <th class="text-center hidden-xs">قیمت پایه واحد</th>
            <th class="text-center hidden-xs">قیمت واحد<small>(همراه با تخفیف)</small></th>
            <th class="text-center">قیمت کل<small>(همراه با تخفیف)</small></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($model->items as $item):?>
            <tr>
                <td>
                    <h5><a href="<?php echo $this->createUrl("/book/".$item->model->id."/".urlencode($item->model->title));?>"><?php echo CHtml::encode($item->model->title);?></a></h5>
                    <span class="item hidden-xs">نویسنده: <span class="value"><?php echo $item->model->getPersonsTags("نویسنده", "fullName", true, "span");?></span></span>
                    <span class="item hidden-xs">ناشر: <span class="value"><?php echo $item->model->getPublisherName();?></span></span>
                </td>
                <td class="text-center">
                    <?php echo CHtml::encode(Controller::parseNumbers($item->qty));?> عدد
                </td>
                <td class="text-center hidden-xs">
                    <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->base_price)));?> تومان
                </td>
                <td class="text-center hidden-xs">
                    <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->payment)));?> تومان
                </td>
                <td class="text-center">
                    <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->payment * $item->qty)));?>تومان
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        <tr>
            <td>

            </td>
            <td class="text-center">
                <?php echo CHtml::encode(Controller::parseNumbers($item->qty));?> عدد
            </td>
            <td class="text-center">
                <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->base_price)));?> تومان
            </td>
            <td class="text-center">
                <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->payment)));?> تومان
            </td>
            <td class="text-center">
                <?php echo CHtml::encode(Controller::parseNumbers(number_format($item->payment * $item->qty)));?>تومان
            </td>
        </tr>
        </tfoot>
    </table>
    <h4 style="margin-top: 80px;">اطلاعات سفارش</h4>
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'detail-view table table-striped','style' => 'margin-top:30px'),
        'attributes'=>array(
            array(
                'label' => $model->getAttributeLabel('id'),
                'name' => 'orderID',
            ),
            array(
                'label' => 'کاربر',
                'value' => function($data){
                    return $data->user && $data->user->userDetails?$data->user->userDetails->getShowName():'';
                }
            ),
            array(
                'name' => 'ordering_date',
                'value' => JalaliDate::date('Y/m/d - H:i', $model->ordering_date)
            ),
            array(
                'name' => 'update_date',
                'value' => JalaliDate::date('Y/m/d - H:i', $model->update_date)
            ),
            array(
                'name' => 'status',
                'value' => $model->getStatusLabel()
            ),
        ),
    )); ?>
    <h4 style="margin-top: 80px;">اطلاعات مالی سفارش</h4>
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'detail-view table table-striped','style' => 'margin-top:30px'),
        'attributes'=>array(
            array(
                'name' => 'payment_method',
                'value' => $model->paymentMethod->title
            ),
            array(
                'name' => 'payment_status',
                'value' => $model->getPaymentStatusLabel()
            ),
            array(
                'label' => 'کد رهگیری تراکنش',
                'value' => $model->transaction?$model->transaction->token:'',
                'cssClass' => 'token-text text-lg'
            ),
            array(
                'name' => 'price_amount',
                'value' => function($data){
                    return Controller::parseNumbers(number_format($data->price_amount)).' تومان';
                }
            ),
            array(
                'name' => 'discount_amount',
                'value' => function($data){
                    return Controller::parseNumbers(number_format($data->discount_amount)).' تومان';
                }
            ),
            array(
                'name' => 'payment_amount',
                'value' => function($data){
                    return Controller::parseNumbers(number_format($data->payment_amount)).' تومان';
                },
                'cssClass' => 'green-text text-lg'
            ),
        ),
    )); ?>
    <h4 style="margin-top: 80px;">اطلاعات ارسال سفارش</h4>
    <?php if($model->status == ShopOrder::STATUS_SENDING):?>
        <div class="alert alert-info" style="margin-top: 30px;">
            <label>ثبت کد مرسوله</label>
            <div class="form">
                <?php
                $model->scenario='export-code';
                $form = $this->beginWidget('CActiveForm',array(
                    'id' =>'export-code-form',
                    'action' => array('exportCode','id' => $model->id),
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate' => 'js: function(form, data, hasError){
                                if(!hasError)
                                    return true;
                                return false;
                            }'
                    )));
                ?>
                <div class="form-group" style='width:200px'>
                    <?php
                    echo $form->textField($model, 'export_code',array('placeholder' => 'کد مرسوله *', 'maxLength'=>100, 'class' => 'form-control'));
                    echo $form->error($model, 'export_code');
                    ?>
                </div>
                <div class="buttons">
                    <?php
                    echo CHtml::submitButton($model->export_code?'ویرایش کد مرسوله':'ثبت کد مرسوله',array('class' => 'btn btn-success'));
                    ?>
                </div>
                <?php
                $this->endWidget();
                ?>
            </div>
        </div>
    <?php endif;?>
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'detail-view table table-striped','style' => 'margin-top:30px'),
        'attributes'=>array(
            array(
                'name' => 'shipping_method',
                'value' => $model->shippingMethod->title.'<small> (هزینه ارسال '.Controller::parseNumbers(number_format($model->shippingMethod->price)).' تومان)</small>',
                'type' => 'raw'
            ),
            array(
                'name' => 'export_code',
                'value' => $model->export_code,
                'cssClass' => 'token-text text-lg',
            ),
            array(
                'name' => 'deliveryAddress.transferee',
                'value' => $model->deliveryAddress->transferee,
            ),
            array(
                'label' => 'استان',
                'value' => $model->deliveryAddress->town->name,
            ),
            array(
                'label' => 'شهرستان',
                'value' => $model->deliveryAddress->place->name,
            ),
            array(
                'name' => 'deliveryAddress.district',
                'value' => $model->deliveryAddress->district,
            ),
            array(
                'name' => 'deliveryAddress.landline_tel',
                'value' => $model->deliveryAddress->landline_tel,
            ),
            array(
                'name' => 'deliveryAddress.emergency_tel',
                'value' => $model->deliveryAddress->emergency_tel,
            ),
            array(
                'name' => 'deliveryAddress.postal_address',
                'value' => $model->deliveryAddress->postal_address,
            ),
            array(
                'name' => 'deliveryAddress.postal_code',
                'value' => $model->deliveryAddress->postal_code,
                'cssClass' => 'token-text text-lg',
            ),
        ),
    )); ?>
    <?php if($model->transactions): ?>
        <h4 style="margin-top: 80px;">جزییات پرداخت های این سفارش</h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ردیف</th>
                <th>نوع پرداخت</th>
                <th>درگاه پرداخت</th>
                <th>کد رهگیری</th>
                <th>تاریخ</th>
                <th>مبلغ</th>
                <th>وضعیت</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($model->transactions as $key => $transaction):
                ?>

                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= CHtml::encode($model->paymentMethod->title) ?></td>
                    <td><?= CHtml::encode($transaction->gateway_name) ?></td>
                    <td><?= $transaction->token?CHtml::encode($transaction->token):"-" ?></td>
                    <td><?= CHtml::encode(JalaliDate::date('d F Y',$transaction->date)) ?></td>
                    <td><span class="price"><?= Controller::parseNumbers(number_format($transaction->amount)) ?><small> تومان</small></span></td>
                    <td<?= $transaction->status == UserTransactions::TRANSACTION_STATUS_UNPAID?' class="red-text"':' class="green-text"' ?>><?= $transaction->statusLabels[$transaction->status] ?></td>
                </tr>
                <?php
            endforeach;
            ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php Yii::app()->clientScript->registerCss('inline-overflow', '.list-group-item{overflow:hidden;padding:20px 0;}');?>
    <h4 style="margin-top: 80px;">خلاصه صورتحساب</h4>
    <ul class="list-group">
        <li class="list-group-item">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل خرید</div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($model->price_amount))?><small> تومان</small></div>
        </li>
        <li class="list-group-item">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">هزینه ارسال</div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php
                if(!$model->shipping_price || $model->shipping_price == 0):
                    echo 'رایگان';
                else:
                    ?>
                    <?= Controller::parseNumbers(number_format($model->shipping_price)) ?><small> تومان</small>
                    <?
                endif;
                ?>
            </div>
        </li>
        <li class="list-group-item">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">شیوه پرداخت</div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo ShopPaymentMethod::getMethodName($model->payment_method); ?></div>
        </li>
        <li class="list-group-item red-item">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل تخفیف</div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($model->discount_amount))?><small> تومان</small></div>
        </li>
        <li class="list-group-item green-item">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">جمع کل قابل پرداخت</div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($model->payment_amount))?><small> تومان</small></div>
        </li>
    </ul>
</div>