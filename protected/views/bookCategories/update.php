<?php
/* @var $this BookCategoriesController */
/* @var $model BookCategories */

$this->breadcrumbs=array(
		'دسته بندی های کتاب',
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'مدیریت دسته بندی ها', 'url'=>array('admin')),
);
?>

<h1>ویرایش دسته بندی <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>