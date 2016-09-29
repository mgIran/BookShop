<?php
/* @var $this ManageController */
/* @var $data Advertises */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->book_id), array('view', 'id'=>$data->book_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cover')); ?>:</b>
	<?php echo CHtml::encode($data->cover); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fade_color')); ?>:</b>
	<?php echo CHtml::encode($data->fade_color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />


</div>