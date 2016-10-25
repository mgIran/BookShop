<?php
/* @var $this BaseManageController */
/* @var $model Books */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'books-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    )
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderIcon',
			'model' => $model,
			'name' => 'icon',
			'maxFiles' => 1,
			'maxFileSize' => 0.5, //MB
			'url' => Yii::app()->createUrl('/manageBooks/base/upload'),
			'deleteUrl' => Yii::app()->createUrl('/manageBooks/base/deleteUpload'),
			'acceptedFiles' => 'image/png',
			'serverFiles' => $icon,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-message").html("");
				}
				else{
					$(".uploader-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
		));
		?>
		<?php echo $form->error($model,'icon'); ?>
		<div class="uploader-message error"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'publisher_name'); ?>
		<?php echo $form->textField($model,'publisher_name',array('size'=>50,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'publisher_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',BookCategories::model()->sortList());
        ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',array(
				'enable' => 'فعال',
				'disable' => 'غیر فعال'
		));
        ?>
		<?php echo $form->error($model,'status'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php
		$this->widget('ext.ckeditor.CKEditor',array(
			'model' => $model,
			'attribute' => 'description'
		));
		?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'change_log'); ?>
		<span class="clearfix"></span>
		<span class="description">این فیلد برای زمانی است که کتاب در نوبت چاپ جدید تغییراتی داشته باشد، پر کردن آن الزامی نیست.</span>
		<?php
		$this->widget('ext.ckeditor.CKEditor',array(
			'model' => $model,
			'attribute' => 'change_log'
		));
		?>
		<?php echo $form->error($model,'change_log'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش' ,array('class' => 'btn btn-success')); ?>
	</div>

<?php  $this->endWidget(); ?>

</div><!-- form -->