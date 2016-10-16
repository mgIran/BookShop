<?php
/* @var $this BookCategoriesController */
/* @var $model BookCategories */

$this->breadcrumbs=array(
	'دسته بندی های برنامه',
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت دسته بندی ها', 'url'=>array('admin')),
);
?>

<h1>افزودن دسته بندی</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>