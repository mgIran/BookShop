<?php
/* @var $this ImagesManageController */
/* @var $model BookImages */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>array('create')),
    array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>ویرایش BookImages <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>