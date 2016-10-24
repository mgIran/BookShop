<?php
/* @var $this ImagesManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Book Images',
);

$this->menu=array(
	array('label'=>'افزودن ', 'url'=>array('create')),
	array('label'=>'مدیریت ', 'url'=>array('admin')),
);
?>

<h1>Book Images</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
