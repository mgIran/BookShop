<?php
/* @var $this PublicController */
/* @var $model Users */
$tab ='credit-tab';
if(isset($_GET['tab']))
    $tab = $_GET['tab'];
?>
<div class="container dashboard-container">
    <ul class="nav nav-tabs">
        <li <?= ($tab && $tab=="credit-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#credit-tab">اعتبار</a>
        </li>
        <li <?= ($tab && $tab=="transactions-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#transactions-tab">تراکنش ها</a>
        </li>
        <li <?= ($tab && $tab=="buys-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#buys-tab">خریدها</a>
        </li>
        <li <?= ($tab && $tab=="bookmarks-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#bookmarks-tab">نشان شده ها</a>
        </li>
        <li>
            <a href="<?= $this->createUrl('/tickets/manage/') ?>">پشتیبانی</a>
        </li>
        <li <?= ($tab && $tab=="setting-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#setting-tab">تنظیمات</a>
        </li>
    </ul>
    <?php if(Yii::app()->user->roles!='publisher'):?>
        <a class="btn btn-danger publisher-signup-link" href="<?php echo Yii::app()->createUrl('/publishers/panel/signup/step/agreement')?>">ناشر شوید</a>
    <?php elseif(Yii::app()->user->roles=='publisher'):?>
        <a class="btn btn-success publisher-signup-link" href="<?php echo Yii::app()->createUrl('/publishers/panel')?>">پنل ناشران</a>
    <?php endif;?>

    <div class="tab-content">
        <div id="credit-tab" class="tab-pane fade <?= ($tab && $tab=="credit-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_credit',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="transactions-tab" class="tab-pane fade <?= ($tab && $tab=="transactions-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_transactions',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="buys-tab" class="tab-pane fade <?= ($tab && $tab=="buys-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_buys_list',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="setting-tab" class="tab-pane fade <?= ($tab && $tab=="setting-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_setting',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="bookmarks-tab" class="tab-pane fade <?= ($tab && $tab=="bookmarks-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_bookmarks',array(
                'model'=>$model,
            ));?>
        </div>
    </div>
</div>