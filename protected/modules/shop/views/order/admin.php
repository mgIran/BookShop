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
			}
		),
		array(
			'name' => 'ordering_date',
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i', $data->ordering_date);
			},
            'filter' => false
		),
		array(
            'name' => 'update_date',
			'value' => function($data){
				return JalaliDate::date('Y/m/d - H:i', $data->update_date);
			},
            'filter' => false
		),
		array(
            'name' => 'payment_method',
            'value' => '$data->paymentMethod->title',
            'filter' => CHtml::listData(ShopPaymentMethod::model()->findAll(),'id', 'title')
		),
		array(
            'name' => 'shipping_method',
            'value' => '$data->shippingMethod->title',
            'filter' => CHtml::listData(ShopShippingMethod::model()->findAll(array('order'=>'t.order')),'id', 'title')
		),
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
/*		array(
			'header' => 'تغییر وضعیت',
			'class'=>'CButtonColumn',
			'template' => '{active} {deactive}',
			'buttons' => array(
				'active' => array(
					'label'=>'فعال',
					'url'=>'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->primaryKey))',
					'options'=>array('class' => 'btn btn-success btn-sm'),
					'click' => new CJavaScriptExpression('function() {
                        if(confirm("آیا از انجام این عمل اطمینان دارید؟")){
                            var th = this;
                            jQuery("#shop-payment-method-grid").yiiGridView(\'update\', {
                                type: \'POST\',
                                url: jQuery(this).attr(\'href\'),
                                success: function(data) {
                                    jQuery(\'#shop-payment-method-grid\').yiiGridView(\'update\');
                                }
                            });
                        }
                        return false;
                    }'),
					'visible'=>'!$data->status',
				),
				'deactive' => array(
					'label'=>'غیر فعال',
					'url'=>'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->primaryKey))',
					'options'=>array('class' => 'btn btn-danger btn-sm'),
					'click' => new CJavaScriptExpression('function() {
                        if(confirm("آیا از انجام این عمل اطمینان دارید؟")){
                            var th = this;
                            jQuery("#shop-payment-method-grid").yiiGridView(\'update\', {
                                type: \'POST\',
                                url: jQuery(this).attr(\'href\'),
                                success: function(data) {
                                    jQuery(\'#shop-payment-method-grid\').yiiGridView(\'update\');
                                }
                            });
                        }
                        return false;
                    }'),
					'visible'=>'$data->status',
				)
			)
        ),*/
		array(
			'class'=>'CButtonColumn',
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
