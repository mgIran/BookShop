<?php
/* @var $this PanelController */
/* @var $booksDataProvider CActiveDataProvider */
?>
<?php $this->renderPartial('//partial-views/_flashMessage', array('prefix'=>'images-'));?>
<a class="btn btn-success" href="<?php echo $this->createUrl('/publishers/books/create');?>"><i class="icon icon-plus"></i> افزودن کتاب جدید</a>
<?php if($booksDataProvider->totalItemCount):?>
<table class="table text-center">
    <thead>
        <tr>
            <td>عنوان کتاب</td>
            <td>وضعیت</td>
            <td>قیمت</td>
            <td>قیمت نسخه چاپی</td>
            <td>تعداد نصب شده</td>
            <td>عملیات</td>
            <td>تاییدیه</td>
        </tr>
    </thead>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$booksDataProvider,
        'itemView'=>'_book_list',
        'itemsTagName'=>'tbody',
        'template'=>'{items}'
    ));?>
</table>
<?php else:?>
    <div class="table">نتیجه ای یافت نشد.</div>
<?php endif;?>




<!--<div class="container dashboard-container">-->
<!---->
<!--    <a class="btn btn-success publisher-signup-link" href="--><?php //echo Yii::app()->createUrl('/dashboard')?><!--">پنل کاربری</a>-->
<!--    <div class="tab-content card-container">-->
<!---->
<!--        <div class="tab-pane active">-->
<!--            <a class="btn btn-success" href="--><?php //echo $this->createUrl('/publishers/books/create');?><!--"><i class="icon icon-plus"></i> افزودن کتاب جدید</a>-->
<!--        </div>-->
<!--        <div class="table text-center">-->
<!--            <div class="thead">-->
<!--                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-5">عنوان کتاب</div>-->
<!--                <div class="col-lg-2 col-md-1 col-sm-1 hidden-xs">وضعیت</div>-->
<!--                <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs">قیمت اینترنتی</div>-->
<!--                <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs">قیمت چاپی</div>-->
<!--                <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs">تعداد نصب شده</div>-->
<!--                <div class="col-lg-2 col-md-1 col-sm-1 col-xs-3">عملیات</div>-->
<!--                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">تاییدیه</div>-->
<!--            </div>-->
<!--            <div class="tbody">-->
<!--                --><?php //$this->widget('zii.widgets.CListView', array(
//                    'dataProvider'=>$booksDataProvider,
//                    'itemView'=>'_book_list',
//                    'template'=>'{items}'
//                ));?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->