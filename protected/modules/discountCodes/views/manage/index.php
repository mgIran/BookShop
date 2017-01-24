<?php
/* @var $this DiscountCodesManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Discount Codes',
);

$this->menu=array(
	array('label'=>'ایجاد DiscountCodes', 'url'=>array('create')),
	array('label'=>'نمایش DiscountCodes', 'url'=>array('admin')),
);
?>

<h1>کد تخفیف</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
