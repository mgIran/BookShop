<?php
/* @var $this SellersPanelController */
/* @var $dataProvider CActiveDataProvider */
?>
<div class="white-form">
    <h3>سفارشات ثبت شده</h3>
    <p class="description">لیست کتاب های شما که توسط کاربران سفارش داده شده است.</p>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'shop-order-grid',
        'dataProvider' => $dataProvider,
        'template' => '{pager} {items} {pager}',
        'ajaxUpdate' => true,
        'afterAjaxUpdate' => "function(id, data){
            $('html, body').animate({
                scrollTop: ($('#'+id).offset().top-130)
            },1000);
        }",
        'pager' => array(
            'header' => '',
            'firstPageLabel' => '<<',
            'lastPageLabel' => '>>',
            'prevPageLabel' => '<',
            'nextPageLabel' => '>',
            'cssFile' => false,
            'htmlOptions' => array(
                'class' => 'pagination pagination-sm',
            ),
        ),
        'pagerCssClass' => 'blank',
        'itemsCssClass' => 'table',
        'columns' => array(
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
                'htmlOptions' => array('style' => 'width:200px')
            ),
            array(
                'name' => 'ordering_date',
                'value' => function($data){
                    return JalaliDate::date('Y/m/d - H:i', $data->ordering_date);
                },
                'filter' => false,
                'htmlOptions' => array('style' => 'width:130px')
            ),
            array(
                'name' => 'update_date',
                'value' => function($data){
                    return JalaliDate::date('Y/m/d - H:i', $data->update_date);
                },
                'filter' => false,
                'htmlOptions' => array('style' => 'width:130px')
            ),
            array(
                'name' => 'payment_method',
                'value' => '$data->paymentMethod->title',
                'filter' => CHtml::listData(ShopPaymentMethod::model()->findAll(),'id', 'title'),
                'htmlOptions' => array('style' => 'width:100px')
            ),
            array(
                'name' => 'shipping_method',
                'value' => '$data->shippingMethod->title',
                'filter' => CHtml::listData(ShopShippingMethod::model()->findAll(array('order'=>'t.order')),'id', 'title'),
                'htmlOptions' => array('style' => 'width:100px')
            ),
            array(
                'name' => 'status',
                'value' => '$data->statusLabel',
                'filter' => false
            ),
            array(
                'header'=>'تغییر وضعیت',
                'value'=>function($data){
                    if($data->status == ShopOrder::STATUS_PAID) {
                        $form = CHtml::dropDownList("status", in_array($data->status, [ShopOrder::STATUS_STOCK_PROCESS, ShopOrder::STATUS_SENDING]) ? $data->status : null, [ShopOrder::STATUS_STOCK_PROCESS => 'پردازش انبار', ShopOrder::STATUS_SENDING => 'ارسال شده'], array("class" => "change-order-status", "data-id" => $data->id, 'prompt' => 'لطفا انتخاب کنید', 'style' => 'width: 110px;height: 30px;'));
                        $form .= CHtml::button("ثبت", array("class" => "btn btn-success btn-sm order-change-status", 'style' => 'margin-right:5px;width: 70px;min-width: 70px;'));
                        return $form;
                    } return '';
                },
                'htmlOptions' => array('style' => 'width:210px'),
                'type'=>'raw'
            ),
            array(
                'class'=>'CButtonColumn',
                'template' => '{view}',
                'header'=>$this->getPageSizeDropDownTag(),
                'buttons'=>array(
                    'view'=>array(
                        'url'=>'Yii::app()->createUrl("/sellers/panel/viewOrder", array("id"=>$data->id))',
                    ),
                ),
            ),
        )
    ));?>
</div>
<?php Yii::app()->clientScript->registerScript('changeOrderStatus', "
	$('body').on('click', '.order-change-status', function(){
	    var el = $(this),
            tr = el.parents('tr');
		$.ajax({
			url:'".$this->createUrl('/sellers/panel/changeOrderStatus')."',
			type:'POST',
			dataType:'JSON',
			data:{
			    id: tr.find('.change-order-status').data('id'),
			    value: tr.find('.change-order-status').val()
            },
			success:function(data){
				if(data.status)
					$.fn.yiiGridView.update('shop-order-grid');
				else
					alert(data.msg);
			}
		});
	});
");?>