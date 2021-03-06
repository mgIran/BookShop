<?php
/* @var $model Users */
/* @var $form CActiveForm */
?>
<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 box">
    <h4 class="title"><strong>ایجاد حساب کاربری</strong></h4>
    <h4 class="welcome-text">کاربر گرامی<small> ، لطفا فرم زیر را پر کنید.</small></h4>
    <div class="login-form signup">
        <?php $this->renderPartial('//partial-views/_flashMessage', array('prefix' => 'register-')); ?>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'register-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'beforeValidate' => "js:function(form) {
                    $('.loading-container').fadeIn();
                    return true;
                }",
                'afterValidate' => "js:function(form) {
                    $('.loading-container').stop().hide();
                    return true;
                }",
            ),
        )); ?>
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
        <div class="form-row register-button">
            <input class="btn btn-danger" type="submit" value="ثبت نام">
        </div>
        <?php $this->endWidget(); ?>
<!--        <div class="loading-container">-->
<!--            <div class="overly"></div>-->
<!--            <div class="spinner">-->
<!--                <div class="bounce1"></div>-->
<!--                <div class="bounce2"></div>-->
<!--                <div class="bounce3"></div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>