<?php
/* @var $this ManageController */
/* @var $model Advertises */

$this->breadcrumbs=array(
	'لیست تبلیغات'=>array('admin'),
	'افزودن تبلیغات',
);

$this->menu=array(
	array('label'=>'لیست تبلیغات', 'url'=>array('admin')),
);
?>

<h1>افزودن تبلیغات</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'cover' => $cover)); ?>