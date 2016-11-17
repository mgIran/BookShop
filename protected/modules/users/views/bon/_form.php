<?php
/* @var $this UserBonsManageController */
/* @var $model UserBons */
/* @var $form CActiveForm */
?>

<div class="form">
	<?php
	$this->renderPartial('//layouts/_flashMessage');
	?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-bons-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<p class="note">فیلد های دارای <span class="required">*</span> الزامی هستند.</p>
	<?php
	if($model->isNewRecord):
	?>
		<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo CHtml::label("<strong>{$model->code}</strong>",''); ?>
			<?php echo $form->hiddenField($model,'code'); ?>
		</div>
	<?php
	else:
	?>
		<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo CHtml::label("<strong>{$model->code}</strong>",''); ?>
		</div>
	<?php
	endif;
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('style'=>'width:100px','maxlength'=>12)); ?>تومان
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
			'id'=>'start_date',
			'model' => $model,
			'attribute' => 'start_date',
			'options'=>array(
				'format'=>'DD MMMM YYYY'
			)
		));?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
			'id'=>'end_date',
			'model' => $model,
			'attribute' => 'end_date',
			'options'=>array(
				'format'=>'DD MMMM YYYY'
			)
		));?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_limit'); ?>
		<?php echo $form->textField($model,'user_limit',array('style'=>'width:100px')); ?>نفر
		<?php echo $form->error($model,'user_limit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->statusLabels); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->