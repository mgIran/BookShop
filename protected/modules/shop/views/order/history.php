<?php
/* @var $this ShopOrderController */
/* @var $model ShopOrder */
?>
<div class="transparent-form">
<h3>سفارشات من</h3>
<p class="description">لیست سفارشات که تا کنون ثبت کرده اید.</p>
<?php $this->renderPartial('//partial-views/_flashMessage') ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'orders-grid',
    'dataProvider'=>$model->search(),
    'itemsCssClass'=>'table',
    'columns'=>array(
        array(
            'name'=>'id',
            'value'=>'$data->getOrderID()',
        )
    )
)); ?>