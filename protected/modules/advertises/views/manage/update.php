<?php
/* @var $this ManageController */
/* @var $model Advertises */

$this->breadcrumbs=array(
		'لیست تبلیغات'=>array('admin'),
		'ویرایش',
);

$this->menu=array(
		array('label'=>'لیست تبلیغات', 'url'=>array('admin')),
		array('label'=>'افزودن تبلیغات', 'url'=>array('create')),
);
?>

<h1>ویرایش تبلیغ <?php echo $model->book->title ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'cover' => $cover)); ?>