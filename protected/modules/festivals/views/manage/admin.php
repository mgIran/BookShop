<?php
/* @var $this FestivalsManageController */
/* @var $model Festivals */

$this->breadcrumbs=array(
	'مدیریت طرح خا',
);

$this->menu=array(
	array('label'=>'افزودن طرح جدید', 'url'=>array('create')),
);
?>
<h1>مدیریت طرح ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'festivals-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table',
	'columns'=>array(
		array(
			'name' => 'start_date',
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i',$data->start_date);
			}
		),
		array(
			'name' => 'end_date',
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i',$data->end_date);
			}
		),
		array(
			'name' => 'range',
			'value' => function($data){
				return Controller::parseNumbers(number_format($data->range)).' تومان';
			}
		),
		array(
			'name' => 'limit_times',
			'value' => function($data){
				return $data->limit_times?Controller::parseNumbers(number_format($data->limit_times)).' کاربر':'-';
			}
		),
		array(
			'name' => 'gift_amount',
			'value' => function($data){
				if($data->gift_type == Festivals::FESTIVAL_GIFT_TYPE_AMOUNT)
					return Controller::parseNumbers(number_format($data->gift_amount)).' تومان';
				else
					return Controller::parseNumbers(number_format($data->gift_amount)).' درصد';

			}
		),
		array(
			'name' => 'disposable',
			'value' => function($data){
				return $data->disposable?"بله":"خیر";
			}
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update} {delete}'
		),
	),
)); ?>
