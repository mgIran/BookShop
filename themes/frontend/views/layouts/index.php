<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="fa_ir">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    $cs->registerCssFile($baseUrl.'/css/animate.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css?3.1');
    $cs->registerCssFile($baseUrl.'/css/responsive-theme.css?3.1');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/parallax.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.nicescroll.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.js?3.1', CClientScript::POS_END);
    $cs->registerScript('scroll-mode', '
    if($(window).scrollTop() > 85)
            $(".navbar.navbar-default").addClass(\'scroll-mode\');
    ', CClientScript::POS_READY);
    ?>
</head>
<body class="overflow-hidden">
<?php $this->renderPartial('//partial-views/_page_loading');?>
<?php $this->renderPartial('//partial-views/navbar');?>
<?php echo $content;?>
<?php $this->renderPartial('//partial-views/footer');?>
</body>
</html>