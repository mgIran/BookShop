<?php
/* @var $this SiteController */
/* @var $model UserTransactions */
?>

<h1>تراکنش ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transactions-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'itemsCssClass'=>'table',
    'columns'=>array(
        array(
            'name'=>'user_name',
            'header'=>'کاربر',
            'value'=> function($data){
                return $data->user && $data->user->userDetails?(empty($data->user->userDetails->fa_name)?$data->user->email:$data->user->userDetails->fa_name):'کاربر حذف شده';
            }
        ),
        array(
            'name'=>'amount',
            'value'=>'number_format($data->amount, 0)." تومان"',
        ),
        array(
            'name'=>'date',
            'value'=>'JalaliDate::date("d F Y - H:i", $data->date)',
            'filter'=>false
        ),
        'token',
        'gateway_name',
        array(
            'name'=>'type',
            'value'=>'$data->typeLabels[$data->type]',
            'filter'=>CHtml::activeDropDownList($model,'type',$model->typeLabels,array('prompt' => 'همه'))
        ),
        array(
            'name'=>'status',
            'value'=>function($data){
                return '<span class="label label-'.(($data->status=='paid')?'success':'danger').'">'.$data->statusLabels[$data->status].'</span>';
            },
            'type'=>'raw',
            'filter'=>CHtml::activeDropDownList($model,'status',$model->statusLabels,array('prompt' => 'همه'))
        ),
        'description',
    ),
)); ?>