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
		'id',
		'user_id',
		'delivery_address_id',
		'billing_address_id',
		'ordering_date',
		'update_date',
		/*
		'payment_method',
		'shipping_method',
		'comment',
		'amount',
		*/
		array(
			'name' => 'status',
			'value' => '$data->statusLabel',
			'filter' => false
		),
		array(
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
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
