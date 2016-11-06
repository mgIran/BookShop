<?php
/* @var $this NewsCategoriesManageController */
/* @var $model NewsCategories */

$this->breadcrumbs=array(
	'دسته بندی اخبار'=>array('index'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'مدیریت دسته بندی اخبار', 'url'=>array('admin')),
);
?>

<h1>ویرایش دسته بندی خبر #<?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>