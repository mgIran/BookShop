<?php
/* @var $this FestivalsManageController */
/* @var $model Festivals */

$this->breadcrumbs=array(
	'مدیریت طرح ها'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن طرح جدید</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>