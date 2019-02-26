<?php
/* @var $this CategoriesManageController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'لیست دسته بندی اخبار'
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'افزودن خبر', 'url'=>array('manage/create')),
	array('label'=>'مدیریت اخبار', 'url'=>array('/news/manage/admin')),
);
?>
<h1>مدیریت دسته بندی اخبار</h1>
<? $this->renderPartial('//layouts/_flashMessage'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'id'=>'categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'والد',
			'name' => 'parent.fullTitle',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>