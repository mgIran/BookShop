<?php
/* @var $this DiscountCodesManageController */
/* @var $model DiscountCodes */

$this->breadcrumbs=array(
	'کدهای تخفیف'=>array('admin'),
	'ایجاد',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن کد تخفیف</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>