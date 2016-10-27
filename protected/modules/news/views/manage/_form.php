<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $form CActiveForm */
/* @var $image [] */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?= $this->renderPartial("//layouts/_loading");?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',NewsCategories::model()->adminSortList()); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $model,
			'name' => 'image',
			'maxFiles' => 1,
			'maxFileSize' => 2, //MB
			'url' => $this->createUrl('/news/manage/upload'),
			'deleteUrl' => $this->createUrl('/news/manage/deleteUpload'),
			'acceptedFiles' => '.jpeg, .jpg, .png, .gif',
			'serverFiles' => $image,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.state == "ok")
				{
					{serverName} = responseObj.fileName;
				}else if(responseObj.state == "error"){
					console.log(responseObj.msg);
				}
		',
		));
		?>
		<?php echo $form->error($model,'image'); ?>
	</div>
	<div class='row'>
		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($model, 'title',array('class'=> 'span7 pull-right','maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php echo EMHelper::megaOgogo($model,'summary',array('rows'=>6,'style'=>'width:100%','maxlength'=>2000),'textArea'); ?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php
		$this->widget("ext.ckeditor.CKEditor",array(
			'model' => $model,
			'attribute' => 'body',
			'multiLanguage' => true
		));
		?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->statusLabels); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'formTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formTags',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/courses/tags/list'),
			'data' => $model->formTags
		));
		?>
		<button data-toggle="modal" data-target="#modal" class="btn btn-success btn-round btn-inverse btn-sm">
			<i class="icon-plus icon-1x"></i>
			&nbsp;&nbsp;
			افزودن برچسب دلخواه
		</button>
		<?php echo $form->error($model,'formTags'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="modal fade" role="dialog" id="modal">
	<div class="modal-dialog modal-sm	">
		<div class="modal-content">
			<div class="modal-body">
				<?
				$this->renderPartial('_tagForm',array(
					'model' => new Tags()
				)); ?>
			</div>
		</div>
	</div>
</div>