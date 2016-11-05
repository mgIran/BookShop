<?php /* @var $model Books */?>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'book-images-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'action' => array('/manageBooks/baseManage/images?id='.$model->id),
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true
        )
    ));
    ?>
    <?= $this->renderPartial('//layouts/_flashMessage' ,array('prefix' => 'images-')); ?>
    <div class="row">
        <?php if(empty($model->images)):?>
            <div class="alert alert-warning submit-image-warning">لطفا تصاویر کتاب را ثبت کنید. کتاب های بدون تصویر نمایش داده نمی شوند.</div>
        <?php endif;?>
        <?= CHtml::label('تصاویر' ,'uploaderImages' ,array('class' => 'control-label')); ?>
        <?php
        $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderImages',
            'name' => 'image',
            'maxFiles' => 15,
            'maxFileSize' => 2, //MB
            'url' => $this->createUrl('/manageBooks/imagesManage/upload'),
            'deleteUrl' => $this->createUrl('/manageBooks/imagesManage/deleteUploaded'),
            'acceptedFiles' => 'image/jpeg , image/png',
            'serverFiles' => $images,
            'data' => array('book_id'=>$model->id),
            'onSuccess' => '
                var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".submit-image-warning").addClass("hidden");
				}
				else{
				    console.log(responseObj.msg);
                    this.removeFile(file);
                }
            ',
        ));
        ?>
        <?php echo $form->error($model,'image'); ?>
    </div>
    <div class="form-group">
        <div class="input-group buttons">
            <?php echo CHtml::submitButton('تایید نهایی',array('class'=>'btn btn-success')); ?>
        </div>
    </div>
    <? $this->endWidget();?>
</div>