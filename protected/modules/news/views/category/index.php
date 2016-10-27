<?php
/* @var $this NewsCategoriesManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'News Categories',
);

$this->menu=array(
	array('label'=>'Create NewsCategories', 'url'=>array('create')),
	array('label'=>'Manage NewsCategories', 'url'=>array('admin')),
);
?>

<h1>News Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
