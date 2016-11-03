<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <title><?= $this->siteName.(!empty($this->pageTitle)?' - '.$this->pageTitle:'') ?></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
    $cs->registerCssFile($baseUrl.'/css/owl.theme.default.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-panel-theme.css');
    $cs->registerCssFile($baseUrl.'/css/responsive-panel-theme.css');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/panel.script.js', CClientScript::POS_END);
    ?>
</head>
<body>
<div class="overlay fade"></div>
<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed">
            <span class="sr-only">نمایش / پنهان کردن منو</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="pin"></div>
        <a class="navbar-brand" href="<?php echo Yii::app()->createUrl('site'); ?>"><img src="<?php echo Yii::app()->theme->baseUrl.'/svg/logo-white.svg'?>" alt="<?php echo Yii::app()->name;?>"><h1>کتـــــابیـــــک</h1></a>
    </div>

    <div class="navbar-custom" id="mobile-menu">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'id' => 'header-serach-form',
            'action' => array('/books/search'),
            'method' => 'get',
            'htmlOptions' => array(
                'class' => 'navbar-form navbar-center'
            )
        )); ?>
            <div class="input-group">
                <?php echo CHtml::textField('term',isset($_GET['term'])?trim($_GET['term']):'',array('placeholder' => 'جستجو کنید ...', 'class'=>'form-control')); ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"></button>
                </span>
            </div>
        <?php $this->endWidget(); ?>
        <ul class="navbar-buttons navbar-left">
            <li><a href="<?= $this->createUrl('/tickets/manage/');?>"><i class="messages-icon"></i></a></li>
            <li><a href="<?php echo $this->createUrl('/users/public/notifications');?>"><i class="notification-icon"></i><?php if(count($this->userNotifications)!=0):?><span class="badge"><?php echo count($this->userNotifications);?></span><?php endif;?></a></li>
            <li><a href="<?php echo $this->createUrl('/logout');?>"><i class="logout-icon"></i></a></li>
        </ul>
    </div>
</nav>
<div class="page-container">
    <div class="sidebar">
        <div class="profile">
            <div class="profile-image">
                <img src="<?php echo (Yii::app()->user->avatar=='')?Yii::app()->theme->baseUrl.'/images/default-user.svg':Yii::app()->baseUrl.'/uploads/users/avatar/'.Yii::app()->user->avatar;?>" alt="<?= $this->userDetails->getShowName(); ?>">
                <div class="profile-badges">
                    <a href="<?php echo Yii::app()->createUrl('users/public/bookmarked');?>" class="profile-badges-left"><i class="bookmark-icon"></i><span><?php echo Controller::parseNumbers(number_format(count($this->userDetails->user->bookmarkedBooks), 0, '.', '.'));?></span>نشان شده</a>
                    <a href="<?php echo Yii::app()->createUrl('/users/credit/buy');?>" class="profile-badges-right"><i class="credit-icon"></i><span><?php echo Controller::parseNumbers(number_format($this->userDetails->credit, 0, '.', '.'));?></span>تومان</a>
                </div>
            </div>
            <div class="profile-info">
                <h4><?= $this->userDetails->getShowName(); ?></h4>
                <span><?= $this->userDetails->roleLabels[Yii::app()->user->roles] ?></span>
            </div>
        </div>

        <?php if(Yii::app()->user->roles!='publisher'):?>
            <a href="<?php echo Yii::app()->createUrl('publishers/panel/signup/step/agreement');?>" class="signup-link"><i class="books-icon"></i>آیا ناشر هستید؟</a>
        <?php endif;?>

        <div class="list-group">
            <h5>کاربری</h5>
            <a href="<?php echo Yii::app()->createUrl('users/public/dashboard');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='users/public/dashboard')?' active':'';?>"><i class="dashboard-icon"></i><span class="text">داشبورد</span></a>
            <a href="<?php echo Yii::app()->createUrl('users/public/library');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='users/public/library')?' active':'';?>"><i class="my-library-icon"></i><span class="text">کتابخانه من</span></a>
            <a href="<?php echo Yii::app()->createUrl('users/public/transactions');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='users/public/transactions')?' active':'';?>"><i class="transaction-icon"></i><span class="text">تراکنش ها</span></a>
            <a href="<?php echo Yii::app()->createUrl('users/public/downloaded');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='users/public/downloaded')?' active':'';?>"><i class="downloaded-icon"></i><span class="text">دانلود شده ها</span></a>
            <a href="<?php echo Yii::app()->createUrl('tickets/manage');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='tickets/manage')?' active':'';?>"><i class="support-icon"></i><span class="text">پشتیبانی</span><span class="badge">3</span></a>
        </div>
        <?php if(Yii::app()->user->roles=='publisher'):?>
            <div class="list-group">
                <h5>ناشرین</h5>
                <a href="<?php echo Yii::app()->createUrl('publishers/panel');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='publishers/panel')?' active':'';?>"><i class="my-library-icon"></i><span class="text">کتاب ها</span></a>
                <a href="<?php echo Yii::app()->createUrl('publishers/panel/discount');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='publishers/panel/discount')?' active':'';?>"><i class="discount-icon"></i><span class="text">تخفیفات</span></a>
                <a href="<?php echo Yii::app()->createUrl('publishers/panel/account');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='publishers/panel/account')?' active':'';?>"><i class="user-icon"></i><span class="text">پروفایل ناشر</span></a>
                <a href="<?php echo Yii::app()->createUrl('publishers/panel/sales');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='publishers/panel/sales')?' active':'';?>"><i class="chart-icon"></i><span class="text">گزارش فروش</span></a>
                <a href="<?php echo Yii::app()->createUrl('publishers/panel/settlement');?>" class="list-group-item<?php echo (Yii::app()->request->pathInfo=='publishers/panel/settlement')?' active':'';?>"><i class="payment-icon"></i><span class="text">تسویه حساب</span></a>
            </div>
        <?php endif;?>
    </div>
    <div class="content">
        <?php echo $content;?>
    </div>
    <div class="footer">
        <div class="pull-right">
            <a href="<?php echo Yii::app()->createUrl('logout');?>"><i class="logout-icon"></i></a>
            <a href="<?php echo Yii::app()->createUrl('users/public/setting');?>"><i class="setting-icon"></i></a>
        </div>
        <div class="pull-left copyright">
            © 2016 Ketabic
        </div>
    </div>
</div>

</body>
</html>