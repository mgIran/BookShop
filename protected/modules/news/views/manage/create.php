<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $image [] */

$this->breadcrumbs=array(
	'مدیریت اخبار'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت اخبار', 'url'=>array('admin')),
);
?>

<h1>افزودن خبر</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>