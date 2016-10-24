<?php
/* @var $this ImagesManageController */
/* @var $model BookImages */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'لیست BookImages', 'url'=>array('index')),
	array('label'=>'افزودن BookImages', 'url'=>array('create')),
	array('label'=>'ویرایش BookImages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف BookImages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت BookImages', 'url'=>array('admin')),
);
?>

<h1>نمایش BookImages #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'book_id',
		'image',
	),
)); ?>
