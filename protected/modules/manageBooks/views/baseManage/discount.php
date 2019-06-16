<?php
/* @var $this ManageBooksBaseManageController */
/* @var $model BookDiscounts */

$this->breadcrumbs=array(
    'مدیریت',
);
$this->menu=array(
    array('label'=>'افزودن تخفیف کتاب', 'url'=>array('createDiscount')),
    array('label'=>'افزودن تخفیف به گروهی از کتاب ها', 'url'=>array('groupDiscount')),
);
?>

<h1>مدیریت کتاب ها</h1>
<? $this->renderPartial('//layouts/_flashMessage',array('prefix' => 'discount-')); ?>
<?php
echo CHtml::beginForm('','post',array('id'=>'grid-delete'));
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'books-grid',
    'dataProvider'=>$model->searchDiscount(),
    'itemsCssClass'=>'table',
    'selectableRows'=>isset($_GET['pageSize'])?$_GET['pageSize']:30,
    'columns'=>array(
        'book.title',
        array(
            'name' => 'book.lastPrintedPackage.printed_price',
            'header' => 'قیمت اصلی',
            'value' => 'Controller::parseNumbers(number_format($data->book->lastPrintedPackage->printed_price))." تومان"'
        ),
        array(
            'header' => 'قیمت الکترونیک با تخفیف',
            'value' => 'Controller::parseNumbers(number_format($data->book->offPrice))." تومان"'
        ),
        array(
            'name' => 'book.lastPrintedPackage.printed_price',
            'header' => 'قیمت آخرین نسخه چاپی',
            'value' => 'Controller::parseNumbers(number_format($data->book->lastPrintedPackage->printed_price))." تومان"'
        ),
        array(
            'header' => 'قیمت چاپی با تخفیف',
            'value' => 'Controller::parseNumbers(number_format($data->book->lastPrintedPackage->getOffPrice()))." تومان"'
        ),
        array(
            'id'=>'selectedItems',
            'class'=>'CCheckBoxColumn',
        ),
        array(
            'class'=>'CButtonColumn',
            'header' => $this->getPageSizeDropDownTag(),
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/manageBooks/baseManage/updateDiscount", array("id"=>$data->id))'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/manageBooks/baseManage/deleteDiscount", array("id"=>$data->id))'
                ),
            )
        ),
    ),
));
echo CHtml::ajaxButton('حذف انتخاب ها',
    $this->createUrl('deleteSelectedDiscount'),array(
        'type'=>'POST',
        'data' => 'js:$("#grid-delete").serialize()',
        'success'=>'js:function(){
            $("#books-grid").yiiGridView("update")
        }',
    ),array('class' => 'btn btn-success'));
echo CHtml::endForm(); ?>