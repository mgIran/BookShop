<?php
/* @var $this SellersPanelController */
/* @var $books CActiveDataProvider */
/* @var $labels array */
/* @var $values array */
?>
<div class="white-form report-sale">
    <h3>گزارش فروش</h3>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'books-list',
        'dataProvider' => $order->reportByUser(),
        'template' => '{items} {pager}',
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
                'htmlOptions' => array('style' => 'width:60px')
            ),
            array(
                'header' => 'کتاب ها',
                'value' => function($data){
                    $html = '';
                    foreach($data->items as $item){
                        $html.=CHtml::tag('div',array('class' => 'nested-row text-nowrap'),$item->model->title.'<small>('.Controller::parseNumbers(number_format($item->qty)).'عدد)</small>');
                        $html.=CHtml::closeTag('div');
                    }
                    return $html;
                },
                'type' => 'raw'
            ),
            array(
                'header' => 'کاربر',
                'value' => function($data){
                    return $data->user && $data->user->userDetails?$data->user->userDetails->getShowName():'';
                },
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
                'name' => 'status',
                'value' => '$data->statusLabel',
                'filter' => false,
                'htmlOptions' => array('style' => 'width:80px')
            ),
            array(
                'name' => 'payment_method',
                'value' => function($data){
                    $p = '';
                    if($data->payment_price)
                        $p = '<br><small>('.Controller::parseNumbers(number_format($data->payment_price)).' تومان)</small>';
                    return $data->paymentMethod->title.$p;
                },
                'type' => 'raw',
                'htmlOptions' => array('style' => 'width:80px'),
                'filter' => CHtml::listData(ShopPaymentMethod::model()->findAll(),'id', 'title'),
            ),
            array(
                'name' => 'shipping_method',
                'value' => function($data){
                    $p = '<br><small>(رایگان)</small>';
                    if($data->shipping_price)
                        $p = '<br><small>('.Controller::parseNumbers(number_format($data->shipping_price)).' تومان)</small>';
                    return $data->shippingMethod->title.$p;
                },
                'filter' => CHtml::listData(ShopShippingMethod::model()->findAll(array('order'=>'t.order')),'id', 'title'),
                'type' => 'raw'
            ),
            array(
                'header' => 'مبلغ پایه',
                'value' => function($data){
                    $html = '';
                    foreach($data->items as $item){
                        $html.=CHtml::tag('div',array('class' => 'nested-row'),Controller::parseNumbers(number_format($item->base_price*$item->qty)).' تومان');
                        $html.=CHtml::closeTag('div');
                    }
                    return $html;
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'تخفیف',
                'value' => function($data){
                    return Controller::parseNumbers(number_format($data->discount_amount)).' تومان';
                },
            ),
            array(
                'header' => 'جمع پرداختی',
                'value' =>function($data){
                    return Controller::parseNumbers(number_format($data->payment_amount)) . ' تومان';
                },
            ),
        )
    ));?>
    <hr style="margin: 50px 0;">
    <p class="description">کتاب مورد نظر را انتخاب کنید:</p>
    <?php $this->renderPartial('//partial-views/_flashMessage');?>
    <?php echo CHtml::beginForm('', 'POST', array(
        'class'=>'form'
    ));?>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$books,
                    'itemView'=>'_report_sale_book_list',
                    'template'=>'{items}'
                ));?>
            </div>
        </div>
        <div class="row" style="margin-bottom: 50px;">
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-md-12">
                <?php echo CHtml::label('از تاریخ', 'from_date');?>
                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                    'id'=>'from_date',
                    'options'=>array(
                        'format'=>'DD MMMM YYYY'
                    ),
                    'htmlOptions'=>array(
                        'class'=>'form-control'
                    ),
                ));?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-md-12">
                <?php echo CHtml::label('تا تاریخ', 'to_date');?>
                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                    'id'=>'to_date',
                    'options'=>array(
                        'format'=>'DD MMMM YYYY'
                    ),
                    'htmlOptions'=>array(
                        'class'=>'form-control'
                    ),
                ));?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-md-12">
                <?php echo CHtml::submitButton('جستجو', array(
                    'class'=>'btn btn-info',
                    'name'=>'show-chart',
                    'id'=>'show-chart',
                ));?>
            </div>
        </div>
        <?php if(isset($_POST['from_date_altField'])):?>
            <div class="panel panel-default chart-container">
                <div class="panel-body">
                    <h4>نمودار گزارش</h4>
                    <?php $this->widget(
                        'chartjs.widgets.ChBars',
                        array(
                            'width' => 700,
                            'height' => 400,
                            'htmlOptions' => array(
                                'class'=>'center-block report-canvas'
                            ),
                            'labels' => $labels,
                            'datasets' => array(
                                array(
                                    "fillColor" => "rgba(54, 162, 235, 0.5)",
                                    "strokeColor" => "rgba(54, 162, 235, 1)",
                                    "data" => $values
                                )
                            ),
                            'options' => array()
                        )
                    );?>
                </div>
            </div>
        <?php else:?>
            <div class="panel panel-default chart-container">
                <div class="panel-body">
                    <h4>فروش امروز</h4>
                    <?php $this->widget(
                        'chartjs.widgets.ChBars',
                        array(
                            'width' => 700,
                            'height' => 400,
                            'htmlOptions' => array(
                                'class'=>'center-block report-canvas'
                            ),
                            'labels' => $labels,
                            'datasets' => array(
                                array(
                                    "fillColor" => "rgba(54, 162, 235, 0.5)",
                                    "strokeColor" => "rgba(54, 162, 235, 1)",
                                    "data" => $values
                                )
                            ),
                            'options' => array()
                        )
                    );?>
                </div>
            </div>
        <?php endif;?>
    <?php echo CHtml::endForm();?>
</div>
<?php Yii::app()->clientScript->registerScript('submitReport', "
    $('#show-chart').click(function(){
        if($('input[name=\"book_id\"]:checked').length==0){
            alert('لطفا کتاب مورد نظر خود را انتخاب کنید.');
            return false;
        }
    });
");?>