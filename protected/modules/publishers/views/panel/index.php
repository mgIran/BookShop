<?php
/* @var $this PanelController */
/* @var $booksDataProvider CActiveDataProvider */
?>
<div class="container dashboard-container">

    <? $this->renderPartial('_tab_links',array('active' => $this->action->id)); ?>

    <a class="btn btn-success publisher-signup-link" href="<?php echo Yii::app()->createUrl('/dashboard')?>">پنل کاربری</a>
    <div class="tab-content card-container">
        <?php $this->renderPartial('//layouts/_flashMessage', array('prefix'=>'images-'));?>
        <div class="tab-pane active">
            <a class="btn btn-success" href="<?php echo $this->createUrl('/publishers/books/create');?>"><i class="icon icon-plus"></i> افزودن برنامه جدید</a>
        </div>
        <div class="table text-center">
            <div class="thead">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">عنوان برنامه</div>
                <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">وضعیت</div>
                <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">قیمت</div>
                <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">تعداد نصب شده</div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">عملیات</div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">تاییدیه</div>
            </div>
            <div class="tbody">
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$booksDataProvider,
                    'itemView'=>'_app_list',
                    'template'=>'{items}'
                ));?>
            </div>
        </div>
    </div>
</div>