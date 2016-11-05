<?php
/* @var $model Users */
/* @var $form CActiveForm */
?>
<h4 class="welcome-text">خوش آمدید<small> ، لطفا وارد شوید.</small></h4>
<div class="login-form">
    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success fade in">
            <?php echo Yii::app()->user->getFlash('success');?>
        </div>
    <?php elseif(Yii::app()->user->hasFlash('failed')):?>
        <div class="alert alert-danger fade in">
            <?php echo Yii::app()->user->getFlash('failed');?>
        </div>
    <?php endif;?>
    <a href="<?= $this->createUrl('/googleLogin') ?>" class="btn-red"><i class="google-icon"></i>ورود با گوگل</a>
    <div class="text-center or-text">یا</div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'beforeValidate' => "js:function(form) {
                $('.loading-container').fadeIn();
                return true;
            }",
            'afterValidate' => "js:function(form,data,hasError) {
                $('.loading-container').stop().hide();
                $(\"#login-btn\").val(\"در حال انتقال ...\");
                return true;
            }",
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                if(data.UserLoginForm_authenticate_field != undefined)
                    $("#validate-message").text(data.UserLoginForm_authenticate_field[0]).removeClass("hidden");
                else
                    $("#validate-message").addClass("hidden");
            }',
        ),
    )); ?>

    <div class="alert alert-danger<?php if(!$model->hasErrors()):?> hidden<?php endif;?>" id="validate-message">
        <?php echo $form->error($model,'authenticate_field'); ?>
    </div>

    <div class="form-row">
        <?php echo $form->textField($model,'email',array('class'=>'form-control','placeholder'=>'پست الکترونیکی')); ?>
        <?php echo $form->error($model,'email'); ?>
        <span class="transition icon-envelope"></span>
    </div>
    <div class="form-row">
        <?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'کلمه عبور')); ?>
        <?php echo $form->error($model,'password'); ?>
        <span class="transition icon-key"></span>
    </div>
    <div class="form-group">
        <?= $form->checkBox($model,'rememberMe',array('id'=>'remember-me')); ?>
        <?= CHtml::label('مرا به خاطر بسپار','remember-me') ?>
    </div>
    <div class="form-row">
        <input id="login-btn" class="btn btn-success" type="submit" value="ورود">
    </div>
    <?php $this->endWidget(); ?>
    <p><a href="<?= Yii::app()->createUrl('/users/public/forgetPassword') ?>" class="forget-link">کلمه عبور خود را فراموش کرده اید؟</a></p>
    <p>تازه وارد هستید؟ <a href="<?= Yii::app()->createUrl('/register') ?>" class="register-link">ثبت نام کنید</a></p>
</div>