<?php
/* @var $this ShopOrderController */
/* @var $form CActiveForm */
/* @var $user Users */
/* @var $shippingMethods ShopShippingMethod[] */

if(!isset($customer))
	$customer = new Users();

if(!isset($deliveryAddress))
	if(isset($customer->deliveryAddress))
		$deliveryAddress = $customer->deliveryAddress;
	else
		$deliveryAddress = new ShopAddresses();

if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Order'),
			Shop::t('Shipping method'));
			
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'action' => array('//shop/order/create'),
			'enableAjaxValidation'=>false,
			)); 
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
                    <input type="button" class="btn-green pull-left" value="افزودن آدرس جدید">
                    <div class="clearfix"></div>
                    <div class="address-list">
                        <div class="address-item">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
                                <div class="radio-control">
                                    <input name="r" id="r1" type="radio">
                                    <label for="r1"></label>
                                </div>
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
                                <div class="pull-right">
                                    <h5 class="name">مسعود قراگوزلو</h5>
                                    <div class="address">
                                        <span>استان: قم</span>
                                        <span>شهر: قم</span>
                                        <div>بلوار سوم خرداد خ شهید شوندی ک 12 پ 5 - کدپستی: 1234</div>
                                    </div>
                                    <div class="phone">
                                        <div><span>شماره موبایل:</span>09373252746</div>
                                        <div><span>شماره تماس ثابت:</span>38846821</div>
                                    </div>
                                </div>
                                <div class="links pull-left">
                                    <a href="#" class="edit-link"></a>
                                    <a href="#" class="remove-link"></a>
                                </div>
                            </div>
                        </div>
                        <div class="address-item">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
                                <div class="radio-control">
                                    <input name="r" id="r1" type="radio">
                                    <label for="r1"></label>
                                </div>
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
                                <div class="pull-right">
                                    <h5 class="name">مسعود قراگوزلو</h5>
                                    <div class="address">
                                        <span>استان: قم</span>
                                        <span>شهر: قم</span>
                                        <div>بلوار سوم خرداد خ شهید شوندی ک 12 پ 5 - کدپستی: 1234</div>
                                    </div>
                                    <div class="phone">
                                        <div><span>شماره موبایل:</span>09373252746</div>
                                        <div><span>شماره تماس ثابت:</span>38846821</div>
                                    </div>
                                </div>
                                <div class="links pull-left">
                                    <a href="#" class="edit-link"></a>
                                    <a href="#" class="remove-link"></a>
                                </div>
                            </div>
                        </div>
                    </div>
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






<h2> <?php echo Shop::t('Shipping options'); ?> </h2>

<h3> <?php echo Shop::t('Shipping address'); ?></h3>

<div class="current_address">
	<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$customer->addresses,
    'htmlOptions' => array('class' => 'detail-view'),
    'attributes'=>array(
        'transferee',
        'town.title',
        'place.title',
        'postal_code'
        ),
    )); ?>
</div>
<br/>
<?php
//echo CHtml::checkBox('toggle_delivery',
//			$customer->deliveryAddress !== NULL, array(
//				'style' => 'float: left'));
//	echo CHtml::label(Shop::t('alternative delivery address'), 'toggle_delivery', array(
//				'style' => 'cursor:pointer'));
	
?>

<div class="form">
	<fieldset id="delivery_information" style="display: none;">
		<div class="payment_address">

			<h3> <?php echo Shop::t('new shipping address'); ?> </h3>
            <p><?php echo Shop::t('Shipping new address'); ?></p>
            
            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'transferee'); ?>
                <?php echo $form->textField($deliveryAddress,'transferee',array('size'=>50,'maxlength'=>255)); ?>
                <?php echo $form->error($deliveryAddress,'transferee'); ?>
            </div>
        
            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'emergency_tel'); ?>
                <?php echo $form->telField($deliveryAddress,'emergency_tel',array('size'=>50,'maxlength'=>11,'minlength'=>11)); ?>
                <?php echo $form->error($deliveryAddress,'emergency_tel'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'landline_tel'); ?>
                <?php echo $form->telField($deliveryAddress,'landline_tel',array('size'=>50,'maxlength'=>15)); ?>
                <?php echo $form->error($deliveryAddress,'landline_tel'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'town_id'); ?>

                <?php echo $form->error($deliveryAddress,'town_id'); ?>
            </div>
            
            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'place_id'); ?>

                <?php echo $form->error($deliveryAddress,'place_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'district'); ?>
                <?php echo $form->textField($deliveryAddress,'district',array('size'=>50,'maxlength'=>45)); ?>
                <?php echo $form->error($deliveryAddress,'district'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'postal_code'); ?>
                <?php echo $form->numberField($deliveryAddress,'postal_code',array('size'=>50,'maxlength'=>10)); ?>
                <?php echo $form->error($deliveryAddress,'postal_code'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($deliveryAddress,'postal_address'); ?>
                <?php echo $form->textArea($deliveryAddress,'postal_address',array('rows'=>5,'cols'=>20)); ?>
                <?php echo $form->error($deliveryAddress,'postal_address'); ?>
            </div>
		</div>
	</fieldset>
<br />
<hr />  
<h3> <?php echo Shop::t('Shipping Method'); ?> </h3>
<p> <?php echo Shop::t('Choose your Shipping method'); ?> </p>

<?php
$i = 0;

foreach(ShopShippingMethod::model()->findAll('status <> 0') as $method) {
	echo '<div class="row">';
	echo CHtml::radioButton("ShippingMethod", $i == 0, array(
				'value' => $method->id));
	echo '<div class="float-left">';
	echo CHtml::label($method->title, 'ShippingMethod');
	echo CHtml::tag('p', array(), $method->description);
	echo CHtml::tag('p', array(), Shop::t('Price: ') . $method->price);
	echo '</div>';
	echo '</div>';
	echo '<div class="clear"></div>';
	$i++;
}
	?>

	

<?php
 Yii::app()->clientScript->registerScript('toggle', "
	if($('#toggle_delivery').attr('checked'))
		$('#delivery_information').show();
	$('#toggle_delivery').click(function() { 
		$('#delivery_information').toggle(500);
	});
");
?>

    <div class="row buttons">
		<?php
        	echo CHtml::submitButton(Shop::t('Continue'),array('id'=>'next'));
        ?>
	</div>
</div>
<?php $this->endWidget(); ?>





                </div>
            </div>
        </div>
    </div>
