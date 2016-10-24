<?php
/* @var $this ImagesManageController */
/* @var $model BookImages */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن BookImages</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>