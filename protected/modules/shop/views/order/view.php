<?php
/* @var $this ShopOrderController */
/* @var $model ShopOrder */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'لیست ShopOrder', 'url'=>array('index')),
	array('label'=>'افزودن ShopOrder', 'url'=>array('create')),
	array('label'=>'ویرایش ShopOrder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف ShopOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت ShopOrder', 'url'=>array('admin')),
);
?>

<h1>نمایش ShopOrder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'delivery_address_id',
		'billing_address_id',
		'ordering_date',
		'update_date',
		'status',
		'payment_method',
		'shipping_method',
		'comment',
		'amount',
	),
)); ?>
