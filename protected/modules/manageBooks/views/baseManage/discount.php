<?php
/* @var $this ManageBooksBaseManageController */
/* @var $model BookDiscounts */

$this->breadcrumbs=array(
    'مدیریت',
);
$this->menu=array(
    array('label'=>'افزودن تخفیف کتاب', 'url'=>array('createDiscount')),
);
?>

<h1>مدیریت کتاب ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'books-grid',
    'dataProvider'=>$model->searchDiscount(),
    'itemsCssClass'=>'table',
    'columns'=>array(
        'book.title',
        array(
            'name' => 'book.lastPackage.price',
            'header' => 'قیمت آخرین نسخه دیجیتال',
            'value' => 'Controller::parseNumbers(number_format($data->book->lastPackage->price))." تومان"'
        ),
        array(
            'header' => 'قیمت دیجیتال با تخفیف',
            'value' => 'Controller::parseNumbers(number_format($data->book->offPrice))." تومان"'
        ),
        array(
            'name' => 'book.lastPackage.printed_price',
            'header' => 'قیمت آخرین نسخه چاپی',
            'value' => 'Controller::parseNumbers(number_format($data->book->lastPackage->printed_price))." تومان"'
        ),
        array(
            'header' => 'قیمت چاپی با تخفیف',
            'value' => 'Controller::parseNumbers(number_format($data->book->off_printed_price))." تومان"'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/manageBooks/baseManage/updateDiscount", array("id"=>$data->id))'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/manageBooks/baseManage/deleteDiscount", array("id"=>$data->id))'
                ),
//                'view' => array(
//                    'url'=>'Yii::app()->createUrl("/book/".$data->id."/".urlencode($data->title))',
//                    'options'=>array(
//                        'target'=>'_blank'
//                    ),
//                )
            )
        ),
    ),
)); ?>