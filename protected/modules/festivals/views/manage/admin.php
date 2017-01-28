<?php
/* @var $this FestivalsManageController */
/* @var $model Festivals */

$this->breadcrumbs=array(
	'مدیریت طرح خا',
);

$this->menu=array(
	array('label'=>'افزودن Festivals', 'url'=>array('create')),
);
?>

<h1>مدیریت طرح ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'festivals-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table',
	'columns'=>array(
		'title',
		'start_date',
		'end_date',
		'range',
		'limit_times',
		/*
		'gift_type',
		'gift_amount',
		'disposable',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
