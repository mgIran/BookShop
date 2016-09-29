<?php
/* @var $this BookCategoriesController */
/* @var $model BookCategories */

$this->breadcrumbs=array(
	'دسته بندی های برنامه',
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>array('create')),
);

?>

<h1>مدیریت دسته بندی ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'app-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'والد',
			'name' => 'parent.title',
			//'filter' => CHtml::activeTextField($model,'parentFilter')
			'filter' => CHtml::activeDropDownList($model,'parentFilter',CHtml::listData(BookCategories::model()->findAll('parent_id IS NULL'),'title','title'))
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
