<?php
/* @var $this NewsManageController */
/* @var $model News */

$this->breadcrumbs=array(
	'نمایش لیست اخبار'=>array('index'),
	'مدیریت',
);

$this->menu=array(
	array('label'=>'لیست اخبار', 'url'=>array('index')),
	array('label'=>'لیست دسته بندی اخبار', 'url'=>array('/news/category/admin')),
	array('label'=>'افزودن خبر', 'url'=>array('create')),
	array('label'=>'افزودن دسته بندی', 'url'=>array('/news/category/create')),
);
?>

<h1>مدیریت اخبار</h1>
<? $this->renderPartial('//layouts/_flashMessage'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table',
	'columns'=>array(
		'title',
		array(
			'name' => 'category_id',
			'value' => '$data->category->fullTitle',
			'filter' => CHtml::listData(NewsCategories::model()->findAll(),'id','fullTitle')
		),
		array(
			'name' => 'status',
			'value' => '$data->statusLabel'
		),
		array(
			'name' => 'create_date',
			'value' => 'JalaliDate::date("Y/m/d - H:i",$data->create_date)',
            'filter'=>false
		),
		array(
			'name' => 'publish_date',
			'value' => '$data->publish_date?JalaliDate::date("Y/m/d - H:i",$data->publish_date):"-"',
            'filter'=>false
		),
		'seen',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
