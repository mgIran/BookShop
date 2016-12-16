<?php
/* @var $this UsersPublicController */
/* @var $login UserLoginForm */
/* @var $register Users */
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="text-center or-text">
        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 float-none">
            <a href="<?= $this->createUrl('/googleLogin') ?>" class="btn-red"><i class="google-icon"></i>ورود یا ثبت نام با گوگل</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php
$this->renderPartial('login', array(
    'model' => $login
));
$this->renderPartial('register', array(
    'model' => $register
));
?>