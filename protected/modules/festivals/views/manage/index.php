<?php
/* @var $this FestivalsManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Festivals',
);

$this->menu=array(
	array('label'=>'افزودن ', 'url'=>array('create')),
	array('label'=>'مدیریت ', 'url'=>array('admin')),
);
?>

<h1>Festivals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
