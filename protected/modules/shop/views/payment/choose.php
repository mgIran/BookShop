<?php
Shop::register('css/shop.css');
$this->renderPartial('/order/_steps', array('point' => 3));

if(!isset($customer))
	$customer = new Customer;

	if(!isset($billingAddress))
		if(isset($customer->billingAddress))
			$billingAddress = $customer->billingAddress;
		else
			$billingAddress = new ShopAddresses;

if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Order'),
			Shop::t('Payment method'));
			
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'action' => array('//shop/order/create'),
			'enableAjaxValidation'=>false,
			)); 
?>

<h2><?php echo Shop::t('Payment method'); ?></h2>
<h3><?php echo Shop::t('Billing address'); ?></h3>
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
//echo CHtml::checkBox('toggle_billing',
//			$customer->billingAddress !== NULL, array(
//				'style' => 'float: left'));
//	echo CHtml::label(Shop::t('alternative billing address'), 'toggle_billing', array(
//				'style' => 'cursor:pointer'));
?>
<div class="form">
	<fieldset id="billing_information" style="display: none;" >
        <div class="payment_address">
        
        	<h3> <?php echo Shop::t('new payment address'); ?> </h3>
            <p><?php echo Shop::t('Shipping new address'); ?></p>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'transferee'); ?>
				<?php echo $form->textField($billingAddress,'transferee',array('size'=>50,'maxlength'=>255)); ?>
				<?php echo $form->error($billingAddress,'transferee'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'emergency_tel'); ?>
				<?php echo $form->telField($billingAddress,'emergency_tel',array('size'=>50,'maxlength'=>11,'minlength'=>11)); ?>
				<?php echo $form->error($billingAddress,'emergency_tel'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'landline_tel'); ?>
				<?php echo $form->telField($billingAddress,'landline_tel',array('size'=>50,'maxlength'=>15)); ?>
				<?php echo $form->error($billingAddress,'landline_tel'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'town_id'); ?>

				<?php echo $form->error($billingAddress,'town_id'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'place_id'); ?>

				<?php echo $form->error($billingAddress,'place_id'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'district'); ?>
				<?php echo $form->textField($billingAddress,'district',array('size'=>50,'maxlength'=>45)); ?>
				<?php echo $form->error($billingAddress,'district'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'postal_code'); ?>
				<?php echo $form->numberField($billingAddress,'postal_code',array('size'=>50,'maxlength'=>10)); ?>
				<?php echo $form->error($billingAddress,'postal_code'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($billingAddress,'postal_address'); ?>
				<?php echo $form->textArea($billingAddress,'postal_address',array('rows'=>5,'cols'=>20)); ?>
				<?php echo $form->error($billingAddress,'postal_address'); ?>
			</div>
		</div>
     </fieldset>
<br />
<hr />  
<h3> <?php echo Shop::t('Payment method'); ?> </h3>
<p> <?php echo Shop::t('Choose your Payment method'); ?> </p>


<?php
$i = 0;
foreach(ShopPaymentMethod::model()->findAll() as $method) {
	echo '<div class="row">';
	echo CHtml::radioButton("PaymentMethod", $i == 0, array(
				'value' => $method->id));
	echo '<div class="float-left">';
	echo CHtml::label($method->title, 'PaymentMethod');
	echo CHtml::tag('p', array(), $method->description);
	echo '</div>';
	echo '</div>';
	echo '<div class="clear"></div>';
	$i++;
}
	?>


<div class="row buttons">
<?php
echo CHtml::submitButton(Shop::t('Continue'),array('id'=>'next'));
?>
</div>

<?php
echo '</div>';
$this->endWidget(); 
?>

<?php
Yii::app()->clientScript->registerScript('toggle', "
	if($('#toggle_billing').attr('checked'))
		$('#billing_information').show();

	$('#toggle_billing').click(function() { 
		$('#billing_information').toggle(500);
	});
"); 