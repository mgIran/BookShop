<?php
/* @var $this DiscountCodesManageController */
/* @var $model DiscountCodes */
/* @var $form CActiveForm */
$url = CHtml::normalizeUrl(array('/discountCodes/manage/codeGenerator'));
Yii::app()->clientScript->registerScript('gen','
	$("body").on("click", ".code-generator", function(){
		$.ajax({
			url: "'.$url.'",
			type: "POST",
			dataType: "JSON",
			beforeSend: function(){
			    
			},
			success: function(data){
				if(data.status)
					$("#DiscountCodes_code").val(data.code);
				else
					alert(data.msg);
			}
		});
	});
	
	if($("#DiscountCodes_off_type").val() == 1)
	    $("#percent").removeClass("hidden").addClass("in");
    else if($("#DiscountCodes_off_type").val() == 2)
	    $("#amount").removeClass("hidden").addClass("in");
	
	$("body").on("change", "#DiscountCodes_off_type", function(){
	    if($("#DiscountCodes_off_type").val() == 1){
	        $("#amount").addClass("hidden").removeClass("in");
	        $("#percent").removeClass("hidden").addClass("in");
        }
        else if($("#DiscountCodes_off_type").val() == 2){
	        $("#percent").addClass("hidden").removeClass("in");
	        $("#amount").removeClass("hidden").addClass("in");
        }
	});    
', CClientScript::POS_READY);
Yii::app()->clientScript->registerCss('gen','
	.code-generator{
	    margin-top:0 !important;
        padding: 4px 15px !important;
        vertical-align: top !important;
    }
    .fade input{
        width: 100px;
    }
');
?>

<div class="form">
	<?php $this->renderPartial('//layouts/_flashMessage') ?>


<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'discount-codes-form',
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
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>50,'maxlength'=>50)); ?>
		<?
		echo CHtml::button('تولید کد تصادفی', array(
			'class'=>'code-generator btn btn-info btn-sm',
		))
		?>
        <div class="clearfix"></div>
        <span class="description">کد تخفیف بدون فاصله وارد شود.</span>
		<?php echo $form->error($model,'code'); ?>
        
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'start_date'); ?>
        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
            'id'=>'start_date',
            'model' => $model,
            'attribute' => 'start_date',
            'options'=>array(
                'format'=>'YYYY/MM/DD'
            )
        ));?>
        <?php echo $form->error($model,'start_date'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'expire_date'); ?>
        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
            'id'=>'expire_date',
            'model' => $model,
            'attribute' => 'expire_date',
            'options'=>array(
                'format'=>'YYYY/MM/DD'
            )
        ));?>
        <?php echo $form->error($model,'expire_date'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'limit_times'); ?>
		<?php echo $form->textField($model,'limit_times',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'limit_times'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'off_type'); ?>
		<?php echo $form->dropDownList($model,'off_type', $model->offTypeLabels); ?>
		<?php echo $form->error($model,'off_type'); ?>
	</div>

	<div class="row fade hidden" id="percent">
		<?php echo $form->labelEx($model,'percent'); ?>
		<?php echo $form->textField($model,'percent',array('size'=>2,'maxlength'=>2)); ?>درصد
		<?php echo $form->error($model,'percent'); ?>
	</div>

	<div class="row fade hidden" id="amount">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('size'=>10,'maxlength'=>10)); ?>تومان
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->