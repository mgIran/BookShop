<?php
/* @var $this NewsCategoriesManageController */
/* @var $model NewsCategories */

$this->breadcrumbs=array(
	'مدیریت دسته بندی اخبار'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت دسته بندی اخبار', 'url'=>array('admin')),
);
?>

<h1>افزودن دسته بندی خبر</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>