<?php
/* @var $this BaseManageController */
/* @var $model Books */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست Books', 'url'=>array('index')),
	array('label'=>'افزودن Books', 'url'=>array('create')),
	array('label'=>'ویرایش Books', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Books', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Books', 'url'=>array('admin')),
);
?>

<h1>نمایش Books #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'publisher_id',
		'category_id',
		'status',
		'price',
		'file_name',
		'icon',
		'description',
		'change_log',
		'permissions',
		'size',
		'version',
		'confirm',
	),
)); ?>
