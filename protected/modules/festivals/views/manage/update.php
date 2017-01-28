<?php
/* @var $this FestivalsManageController */
/* @var $model Festivals */

$this->breadcrumbs=array(
	'مدیریت طرح ها'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>array('create')),
    array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>ویرایش طرح "<?php echo $model->title; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>