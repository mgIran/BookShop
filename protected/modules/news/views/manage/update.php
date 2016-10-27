<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $image [] */

$this->breadcrumbs=array(
	'مدیریت اخبار'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);


$this->menu=array(
	array('label'=>'لیست اخبار', 'url'=>array('index')),
	array('label'=>'مدیریت اخبار', 'url'=>array('admin')),
	array('label'=>'افزودن خبر', 'url'=>array('create')),
	array('label'=>'نمایش این خبر', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>ویرایش خبر #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>