<?php
/* @var $this FestivalsManageController */
/* @var $model Festivals */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'لیست Festivals', 'url'=>array('index')),
	array('label'=>'افزودن Festivals', 'url'=>array('create')),
	array('label'=>'ویرایش Festivals', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Festivals', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Festivals', 'url'=>array('admin')),
);
?>

<h1>نمایش Festivals #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'start_date',
		'end_date',
		'limit_times',
		'type',
		'range',
		'gift_type',
		'gift_amount',
		'disposable',
	),
)); ?>
