<?php
/* @var $this FestivalsManageController */
/* @var $model Festivals */
/* @var $form CActiveForm */
?>

<div class="form">
	<?php $this->renderPartial('//layouts/_flashMessage') ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'festivals-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php $this->widget('ext.PDatePicker.PDatePicker', array(
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
		<?php $this->widget('ext.PDatePicker.PDatePicker', array(
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
		<?php echo $form->labelEx($model,'limit_times'); ?>
		<?php echo $form->textField($model,'limit_times',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'limit_times'); ?>
	</div>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'type'); ?>
<!--		--><?php //echo $form->textField($model,'type',array('size'=>1,'maxlength'=>1)); ?>
<!--		--><?php //echo $form->error($model,'type'); ?>
<!--	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'range'); ?>
		<?php echo $form->textField($model,'range',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'range'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gift_type'); ?>
		<?php echo $form->dropDownList($model,'gift_type', $model->giftTypeLabels); ?>
		<?php echo $form->error($model,'gift_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gift_amount'); ?>
		<?php echo $form->textField($model,'gift_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'gift_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'disposable'); ?>
		<?php echo $form->checkBox($model,'disposable',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'disposable'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش', array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->