<?php
/* @var $this DiscountCodesManageController */
/* @var $model DiscountCodes */

$this->breadcrumbs=array(
	'کدهای تخفیف'=>array('admin'),
	'نمایش',
);

$this->menu=array(
	array('label'=>'افزودن کد تخفیف', 'url'=>array('create')),
);
?>

<h1>مدیریت کد تخفیف</h1>
<?php $this->renderPartial('//layouts/_flashMessage') ?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discount-codes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>20,
    'itemsCssClass'=>'table',
	'columns'=>array(
		'title',
		'code',
		array(
			'name' => 'start_date',
            'filter'=>false,
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i', $data->start_date);
			}
		),
		array(
			'name' => 'expire_date',
            'filter'=>false,
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i', $data->expire_date);
			}
		),
		array(
			'name' => 'limit_times',
            'filter'=>false,
			'value' => function($data){
				return $data->limit_times?Controller::parseNumbers(number_format($data->limit_times)).' بار':'ندارد';
			}
		),
		array(
			'header' => 'میزان تخفیف',
            'filter'=>false,
			'value' => function($data){
				if($data->off_type == DiscountCodes::DISCOUNT_TYPE_PERCENT)
					return Controller::parseNumbers($data->percent).' درصد';
				elseif($data->off_type == DiscountCodes::DISCOUNT_TYPE_AMOUNT)
					return Controller::parseNumbers(number_format($data->amount)).' تومان';
				return '-';
			}
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}'
		),
	),
));
