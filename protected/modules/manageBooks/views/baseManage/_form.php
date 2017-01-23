<?php
/* @var $this ManageBooksBaseManageController */
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
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderIcon',
			'model' => $model,
			'name' => 'icon',
			'maxFiles' => 1,
			'maxFileSize' => 0.5, //MB
			'url' => Yii::app()->createUrl('/manageBooks/baseManage/upload'),
			'deleteUrl' => Yii::app()->createUrl('/manageBooks/baseManage/deleteUpload'),
			'acceptedFiles' => '.jpg, .jpeg, .png',
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
		)); ?>
		<?php echo $form->error($model,'icon'); ?>
		<div class="uploader-message error"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'preview_file'); ?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderPreview',
			'model' => $model,
			'name' => 'preview_file',
			'maxFiles' => 1,
			'maxFileSize' => 5, //MB
			'url' => Yii::app()->createUrl('/manageBooks/baseManage/uploadPreview'),
			'deleteUrl' => Yii::app()->createUrl('/manageBooks/baseManage/deleteUploadedPreview'),
			'acceptedFiles' => '.pdf, .epub',
			'serverFiles' => $previewFile,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-preview-message").html("");
				}
				else{
					$(".uploader-preview-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
		));
		?>
		<?php echo $form->error($model,'preview_file'); ?>
		<div class="uploader-preview-message error"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'publisher_id'); ?>
		<?php echo $form->dropDownList($model, 'publisher_id', CHtml::listData(Users::model()->getPublishers()->getData(), 'id', 'userDetails.fa_name'),array(
			'class' => 'selectpicker',
			'data-live-search' => true,
		)); ?>
		<?php echo $form->error($model,'publisher_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language'); ?>
		<?php echo $form->textField($model,'language',array('size'=>50,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'language'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formAuthor'); ?>
		<?php $this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formAuthor',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/bookPersons/list'),
			'data' => $model->formAuthor
		)); ?>
		<?php echo $form->error($model,'formAuthor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formTranslator'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formTranslator',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/bookPersons/list'),
			'data' => $model->formTranslator
		));
		?>
		<?php echo $form->error($model,'formTranslator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_of_pages'); ?>
		<?php echo $form->textField($model,'number_of_pages',array('size'=>10,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'number_of_pages'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',BookCategories::model()->adminSortList(null,false),array(
			'class' => 'selectpicker',
			'data-live-search' => true,
		));
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
		<?php echo $form->labelEx($model,'publisher_commission'); ?>
		<?php echo $form->textField($model,'publisher_commission',array('size'=>50,'maxlength'=>3,'disabled'=>is_null($model->publisher_commission)?true:false)); ?>درصد
		<div>
			<label></label>
			<?php echo CHtml::checkBox('default_commission', (is_null($model->publisher_commission)?true:false), array('style'=>'margin-top:15px;'));?>
			<?php echo CHtml::label('کمیسیون پیش فرض در نظر گرفته شود.', 'default_commission');?>
		</div>
		<?php echo $form->error($model,'publisher_commission'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'formTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formTags',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/tags/list'),
			'data' => $model->formTags
		));
		?>
		<?php echo $form->error($model,'formTags'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'formSeoTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formSeoTags',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/tags/list'),
			'data' => $model->formSeoTags
		));
		?>
		<?php echo $form->error($model,'formSeoTags'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش' ,array('class' => 'btn btn-success')); ?>
	</div>

<?php  $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScript('inline-script', "
$('body').on('change', '#default_commission', function(){
	$('#Books_publisher_commission').prop('disabled', function(i, v) { return !v; }).val('');
});
");?>