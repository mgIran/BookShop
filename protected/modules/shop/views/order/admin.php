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
            'header'=>$this->getPageSizeDropDownTag(),
		),
	),
)); ?>
