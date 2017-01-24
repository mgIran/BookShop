<?php
/* @var $this DiscountCodesManageController */
/* @var $model DiscountCodes */

$this->breadcrumbs=array(
	'کدهای تخفیف'=>array('admin'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'نمایش کدهای تخفیف', 'url'=>array('admin')),
	array('label'=>'افزودن کد تخفیف', 'url'=>array('create')),
);
?>

<h1>ویرایش کد تخفیف #<?php echo $model->code; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>