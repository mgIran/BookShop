<?php
/* @var $this BookCategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Book Categories',
);

$this->menu=array(
	array('label'=>'Create BookCategories', 'url'=>array('create')),
	array('label'=>'Manage BookCategories', 'url'=>array('admin')),
);
?>

<h1>Book Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
