<?php
/* @var $this BaseManageController */
/* @var $model Books */
/* @var $icon array */
/* @var $tax string */
/* @var $commission string */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>Yii::app()->createUrl('/manageBooks/base/admin')),
);
?>

<h1>افزودن کتاب جدید</h1>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#info">عمومی</a></li>
    <li class="disabled"><a>نوبت چاپ</a></li>
    <li class="disabled"><a >تصاویر</a></li>
</ul>

<div class="tab-content">
    <div id="info" class="tab-pane fade in active">
        <?php $this->renderPartial('_form', array(
            'model'=>$model,'icon'=>$icon,
            'tax'=>$tax,
            'commission'=>$commission,
        )); ?>
    </div>
</div>