<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $detailsModel UserDetails */
/* @var $form CActiveForm */
/* @var $avatarImage array */
/* @var $registrationCertificateImage array */
?>

<div class="white-form">
    <h3>اطلاعات کاربری</h3>
    <p class="description">جهت تغییر اطلاعات کاربری خود فرم زیر را پر کنید.</p>

    <?php $this->renderPartial('//partial-views/_flashMessage', array(' prefix'=>'profile-'));?>

    <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'update-profile-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            )
        )); ?>

        <?php echo $form->errorSummary($detailsModel); ?>

        <div class="row" style="margin-bottom: 15px">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->textField($detailsModel,'fa_name',array('placeholder'=>$detailsModel->getAttributeLabel('fa_name').' *','maxlength'=>50,'class'=>'form-control')); ?>
                <?php echo $form->error($detailsModel,'fa_name'); ?>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->textField($detailsModel,'national_code',array('placeholder'=>$detailsModel->getAttributeLabel('national_code').' *','maxlength'=>10,'class'=>'form-control')); ?>
                <?php echo $form->error($detailsModel,'national_code'); ?>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->textField($detailsModel,'phone',array('placeholder'=>$detailsModel->getAttributeLabel('phone').' *','maxlength'=>11,'class'=>'form-control')); ?>
                <?php echo $form->error($detailsModel,'phone'); ?>
            </div>
        </div>
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->textField($detailsModel,'zip_code',array('placeholder'=>$detailsModel->getAttributeLabel('zip_code').' *','maxlength'=>10,'class'=>'form-control')); ?>
                <?php echo $form->error($detailsModel,'zip_code'); ?>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <?php echo $form->textField($detailsModel,'address',array('placeholder'=>$detailsModel->getAttributeLabel('address').' *','maxlength'=>1000,'class'=>'form-control')); ?>
                <?php echo $form->error($detailsModel,'address'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                    'id' => 'national-card-uploader',
                    'model' => $detailsModel,
                    'name' => 'avatar',
                    'dictDefaultMessage'=>$detailsModel->getAttributeLabel('avatar').' را به اینجا بکشید',
                    'maxFiles' => 1,
                    'maxFileSize' => 0.5, //MB
                    'data'=>array('user_id'=>$detailsModel->user_id),
                    'url' => $this->createUrl('/users/public/uploadAvatarImage'),
                    'acceptedFiles' => 'image/jpeg , image/png',
                    'serverFiles' => $avatarImage,
                    'onSuccess' => '
                    var responseObj = JSON.parse(res);
                    if(responseObj.state == "ok")
                    {
                        {serverName} = responseObj.fileName;
                    }else if(responseObj.state == "error"){
                        console.log(responseObj.msg);
                    }
                ',
                ));?>
            </div>
        </div>

        <div class="buttons">
            <?php echo CHtml::submitButton('ثبت',array('class'=>'btn btn-success')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>

</div>

<div class="white-form">
    <h3>تغییر کلمه عبور</h3>
    <p class="description">جهت تغییر کلمه عبور خود فرم زیر را پر کنید.</p>

    <?php $this->renderPartial('//partial-views/_flashMessage');?>

    <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'users-form',
            'action' => Yii::app()->createUrl('/users/public/setting'),
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>true,
        )); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->passwordField($model,'oldPassword',array('placeholder'=>$model->getAttributeLabel('oldPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                <?php echo $form->error($model,'oldPassword'); ?>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->passwordField($model,'newPassword',array('placeholder'=>$model->getAttributeLabel('newPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                <?php echo $form->error($model,'newPassword'); ?>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->passwordField($model,'repeatPassword',array('placeholder'=>$model->getAttributeLabel('repeatPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                <?php echo $form->error($model,'repeatPassword'); ?>
            </div>

        </div>

        <div class="buttons">
            <?php echo CHtml::submitButton('تغییر کلمه عبور',array('class'=>'btn btn-success')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>

</div>
