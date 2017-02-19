<?php
/* @var $this ShopOrderController */
/* @var $model ShopOrder */

$this->breadcrumbs=array(
	'مدیریت',
);

?>

<h1>مدیریت سفارشات</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shop-order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table',
	'columns'=>array(
        array(
            'name' => 'id',
            'value' => '$data->getOrderId()',
            'htmlOptions' => array('style' => 'width:80px')
        ),
		array(
			'header' => 'کاربر',
			'value' => function($data){
				return $data->user && $data->user->userDetails?$data->user->userDetails->getShowName():'';
			},
            'htmlOptions' => array('style' => 'width:80px')
		),
		array(
			'name' => 'ordering_date',
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i', $data->ordering_date);
			},
            'filter' => false,
            'htmlOptions' => array('style' => 'width:80px')
		),
		array(
            'name' => 'update_date',
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i', $data->update_date);
			},
            'filter' => false,
            'htmlOptions' => array('style' => 'width:80px')
		),
		array(
            'name' => 'payment_method',
            'value' => '$data->paymentMethod->title',
            'filter' => CHtml::listData(ShopPaymentMethod::model()->findAll(),'id', 'title'),
		),
		array(
            'name' => 'shipping_method',
            'value' => '$data->shippingMethod->title',
            'filter' => CHtml::listData(ShopShippingMethod::model()->findAll(array('order'=>'t.order')),'id', 'title'),
            'htmlOptions' => array('style' => 'width:80px')
		),
//		array(
//			'name' => 'payment_status',
//			'value' => '$data->paymentStatusLabel',
//			'htmlOptionsExperissions' => array(
//                
//            ),
//			'filter' => $model->paymentStatusLabels,
//		),
		array(
			'name' => 'status',
			'value' => '$data->statusLabel',
			'filter' => false
		),
		array(
			'header'=>'تغییر وضعیت',
			'value'=>function($data){
				$form=CHtml::dropDownList("stauts", $data->status, $data->statusLabels, array("class"=>"change-order-status", "data-id"=>$data->id));
				$form.=CHtml::button("ثبت", array("class"=>"btn btn-success order-change-status", 'style'=>'margin-right:5px;'));
				return $form;
			},
			'type'=>'raw'
		),
		array(
			'class'=>'CButtonColumn',
            'template' => '{view} {delete}',
            'header'=>$this->getPageSizeDropDownTag(),
		),
	),
));

Yii::app()->clientScript->registerScript('changeFinanceStatus', "
	$('body').on('click', '.order-change-status', function(){
	    var el = $(this),
            tr = el.parents('tr');
		$.ajax({
			url:'".$this->createUrl('/shop/order/changeStatus')."',
			type:'POST',
			dataType:'JSON',
			data:{id:tr.find('.change-order-status').data('id'), value:tr.find('.change-order-status').val()},
			success:function(data){
				if(data.status)
					$.fn.yiiGridView.update('shop-order-grid');
				else
					alert(data.msg);
			}
		});
	});
");
