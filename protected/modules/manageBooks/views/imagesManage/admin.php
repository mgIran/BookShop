<?php
/* @var $this ImagesManageController */
/* @var $model BookImages */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن BookImages', 'url'=>array('create')),
);
?>

<h1>مدیریت Book Images</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'book-images-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'book_id',
		'image',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
