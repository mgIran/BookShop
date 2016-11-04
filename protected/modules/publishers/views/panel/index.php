<?php
/* @var $this PanelController */
/* @var $booksDataProvider CActiveDataProvider */
?>
<div class="transparent-form">
    <h3>کتاب ها</h3>
    <p class="description">لیست کتاب هایی که منتشر کرده اید.</p>

    <?php $this->renderPartial('//partial-views/_flashMessage', array('prefix'=>'images-'));?>

    <div class="buttons">
        <a class="btn btn-success" href="<?php echo $this->createUrl('/publishers/books/create');?>">افزودن کتاب جدید</a>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>عنوان کتاب</th>
            <th>وضعیت</th>
            <th>قیمت</th>
            <th class="hidden-xs">قیمت نسخه چاپی</th>
            <th class="hidden-xs">تعداد نصب شده</th>
            <th>عملیات</th>
            <th>تاییدیه</th>
        </tr>
        </thead>
        <?php if(!$booksDataProvider->totalItemCount):?>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center">نتیجه ای یافت نشد.</td>
                </tr>
            </tbody>
        <?php else:?>
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$booksDataProvider,
                'itemView'=>'_book_list',
                'itemsTagName'=>'tbody',
                'template'=>'{items}'
            ));?>
        <?php endif;?>
    </table>
</div>