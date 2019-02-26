<?php
/* @var $this BookController */
/* @var $bookDP CActiveDataProvider */
/* @var $personDP CActiveDataProvider */
/* @var $categoryDP CActiveDataProvider */
?>
<div class="page">
    <div class="page-heading">
        <div class="container">
            <h1>جتسجوی عبارت "<?= CHtml::encode($_GET['term']) ?>"</h1>
            <div class="page-info">
                <span>نتایج یافت شده<a><?= $bookDP->totalItemCount ?> نتیجه</a></span>
            </div>
        </div>
    </div>
    <div class="container page-content book-list">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="thumbnail-list">
                        <?php
                        $this->widget('zii.widgets.CListView', array(
                            'id' => 'book-list',
                            'dataProvider' => $bookDP,
                            'itemView' => '/site/_book_item',
                            'template' => '{items} {pager}',
                            'viewData' => array('itemClass' => 'simple'),
                            'ajaxUpdate' => true,
                            'pager' => array(
                                'class' => 'ext.infiniteScroll.IasPager',
                                'rowSelector'=>'.thumbnail-container',
                                'listViewId' => 'book-list',
                                'header' => '',
                                'loaderText'=>'در حال دریافت ...',
                                'options' => array('history' => true, 'triggerPageTreshold' => 2, 'trigger'=>'بارگذاری بیشتر ...'),
                            ),
                            'afterAjaxUpdate'=>"function(id, data) {
								$.ias({
									'history': true,
									'triggerPageTreshold': 2,
									'trigger': 'بارگذاری بیشتر ...',
									'container': '#book-list',
									'item': '.thumbnail-container',
									'pagination': '#book-list .pager',
									'next': '#book-list .next:not(.disabled):not(.hidden) a',
									'loader': 'در حال دریافت ...'
								});
							}",
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <?php $this->renderPartial('//partial-views/inner-sidebar') ?>
        </div>
    </div>
</div>