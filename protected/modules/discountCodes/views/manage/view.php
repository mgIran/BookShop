<?php
/* @var $this DiscountCodesManageController */
/* @var $model DiscountCodes */

$this->breadcrumbs=array(
	'Discount Codes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'ایجاد DiscountCodes', 'url'=>array('create')),
	array('label'=>'ویرایش DiscountCodes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف DiscountCodes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'نمایش DiscountCodes', 'url'=>array('admin')),
);
?>

<h1>نمایش کد تخفیف #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'code',
		'start_date',
		'expire_date',
		'limit_times',
		'off_type',
		'percent',
		'amount',
		'user_id',
		'expire',
	),
)); ?>
