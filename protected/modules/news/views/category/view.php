<?php
/* @var $this NewsCategoriesManageController */
/* @var $dataProvider CActiveDataProvider */
/* @var $model NewsCategories */
?>

<div class="page">
	<div class="page-heading">
		<div class="container">
			<h1>اخبار <?= $model->title ?></h1>
			<div class="page-info">
				<span>تعداد<a><?= $dataProvider->totalItemCount ?> خبر</a></span>
			</div>
		</div>
	</div>
	<div class="container page-content news-list">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
				<div class="row">
					<div class="thumbnail-list">
						<?php
						$this->widget('zii.widgets.CListView', array(
							'id' => 'news-list',
							'dataProvider' => $dataProvider,
							'itemView' => '//site/_news_item',
							'template' => '{items} {pager}',
							'viewData' => array('type' => 'list-view'),
							'ajaxUpdate' => true,
							'pager' => array(
								'class' => 'ext.infiniteScroll.IasPager',
								'rowSelector'=>'.news-list-item',
								'listViewId' => 'news-list',
								'header' => '',
								'loaderText'=>'در حال دریافت ...',
								'options' => array('history' => true, 'triggerPageTreshold' => 2, 'trigger'=>'بارگذاری بیشتر ...'),
							),
							'afterAjaxUpdate'=>"function(id, data) {
								$.ias({
									'history': true,
									'triggerPageTreshold': 2,
									'trigger': 'بارگذاری بیشتر ...',
									'container': '#news-list',
									'item': '.news-list-item',
									'pagination': '#news-list .pager',
									'next': '#news-list .next:not(.disabled):not(.hidden) a',
									'loader': 'در حال دریافت ...'
								});
							}",
						));
						?>
					</div>
				</div>
			</div>
			<?php $this->renderPartial('//partial-views/news-sidebar') ?>
		</div>
	</div>
</div>