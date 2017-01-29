<?php
/* @var $this FestivalsManageController */
/* @var $model Festivals */
/* @var $form CActiveForm */
$ranges = SiteSetting::model()->findByAttributes(array('name' => 'buy_credit_options'))->value;
$ranges = CJSON::decode($ranges);
foreach($ranges as $key => $range)
{
    $fes = Festivals::model()->find('type = :type AND t.range = :range',array(
        ':type' => Festivals::FESTIVAL_TYPE_CREDIT,
        ':range' => (double)$range
    ));
    unset($ranges[$key]);
    if($fes === null)
        $ranges[$range] = $range;

}
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
    ));
    $model->type = Festivals::FESTIVAL_TYPE_CREDIT;
    $model->gift_type = Festivals::FESTIVAL_GIFT_TYPE_AMOUNT;
    ?>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'title'); ?>
<!--		--><?php //echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
<!--		--><?php //echo $form->error($model,'title'); ?>
<!--	</div>-->

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
		<?php echo $form->textField($model,'limit_times',array('size'=>10,'maxlength'=>10)); ?>کاربر
		<?php echo $form->error($model,'limit_times'); ?>
	</div>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'type'); ?>
		<?php echo $form->hiddenField($model,'type'); ?>
<!--		--><?php //echo $form->error($model,'type'); ?>
<!--	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'range'); ?>
		<?php echo $form->dropDownList($model,'range',$ranges); ?>تومان
		<?php echo $form->error($model,'range'); ?>
	</div>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'gift_type'); ?>
<!--		--><?php //echo $form->dropDownList($model,'gift_type', $model->giftTypeLabels); ?>
		<?php echo $form->hiddenField($model,'gift_type'); ?>
<!--		--><?php //echo $form->error($model,'gift_type'); ?>
<!--	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'gift_amount'); ?>
		<?php echo $form->textField($model,'gift_amount',array('size'=>10,'maxlength'=>10)); ?>تومان
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