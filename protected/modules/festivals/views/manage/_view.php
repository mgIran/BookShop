<?php
/* @var $this FestivalsManageController */
/* @var $data Festivals */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit_times')); ?>:</b>
	<?php echo CHtml::encode($data->limit_times); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range')); ?>:</b>
	<?php echo CHtml::encode($data->range); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gift_type')); ?>:</b>
	<?php echo CHtml::encode($data->gift_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('gift_amount')); ?>:</b>
	<?php echo CHtml::encode($data->gift_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disposable')); ?>:</b>
	<?php echo CHtml::encode($data->disposable); ?>
	<br />

	*/ ?>

</div>