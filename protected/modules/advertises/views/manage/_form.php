<?php
/* @var $this ManageController */
/* @var $model Advertises */
/* @var $form CActiveForm */
/* @var $cover [] */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertises-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
$books = array();
if($model->isNewRecord) {
	// get valid books for advertising
	$criteria = Books::model()->getValidBooks();
	$criteria->with[] = 'advertise';
	$criteria->addCondition('advertise.book_id IS NULL');
	$books = Books::model()->findAll($criteria);
	//
}
if(!$model->isNewRecord || $books) {
	?>

	<div class="row">
		<?php echo $form->labelEx($model, 'book_id'); ?>
		<?
		if(!$model->isNewRecord)
			echo CHtml::textField('',$model->book->title,array('disabled'=>true));
		else
			echo $form->dropDownList($model, 'book_id', CHtml::listData($books, 'id', 'title'));
		?>
		<?php echo $form->error($model, 'book_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'cover'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
				'id' => 'uploaderAd',
				'model' => $model,
				'name' => 'cover',
				'maxFiles' => 1,
				'maxFileSize' => 0.4, //MB
				'url' => Yii::app()->createUrl('/advertises/manage/upload'),
				'deleteUrl' => Yii::app()->createUrl('/advertises/manage/deleteUpload'),
				'acceptedFiles' => 'image/png',
				'serverFiles' => $cover,
				'onSuccess' => '
                var responseObj = JSON.parse(res);
                if(responseObj.state == "ok")
                {
                    {serverName} = responseObj.fileName;
                }else if(responseObj.state == "error"){
                    alert(responseObj.msg);
                    this.removeFile(file);
                }
            ',
		));
		?>
		<?php echo $form->error($model, 'cover'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'fade_color'); ?>
		<?php echo $form->textField($model, 'fade_color', array('size' => 6, 'maxlength' => 6)); ?>
		<?php echo $form->error($model, 'fade_color'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', $model->statusLabels); ?>
		<?php echo $form->error($model, 'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>
<?
}else
	echo '<h4>کتاب ای برای تبلیغ وجود ندارد.</h4>';
?>
</div><!-- form -->
