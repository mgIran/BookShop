<?php
/* @var $model Comment */
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comment-grid',
	'dataProvider'=>$model->searchBooks(),
	'template' => '{pager} {items} {pager}',
	'ajaxUpdate' => true,
	'afterAjaxUpdate' => "function(id, data){
		$('html, body').animate({
			scrollTop: ($('#'+id).offset().top-130)
		},1000);
	}",
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
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('commentsModule.msg', 'User Name'),
			'value'=>'$data->userName?$data->userName:"کاربر حذف شده"',
			'htmlOptions'=>array('width'=>80),
		),
		array(
			'header'=>'نام کتاب',
			'value'=>'CHtml::link($data->books->title, $data->pageUrl, array("target"=>"_blank"))',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>100),
		),
		array(
			'header'=>Yii::t('commentsModule.msg', 'Comment Text'),
			'name' => 'comment_text',
		),
		array(
			'header'=>'امتیاز',
			'value' => '"<div class=\'stars\'>".Controller::printRateStars($data->getUserRate())."</div>"',
			'type' => 'raw',
			'htmlOptions'=>array('width'=>120),
		),
		array(
			'header'=>Yii::t('commentsModule.msg', 'Create Time'),
			'name'=>'create_time',
			'value'=>'JalaliDate::date("Y/m/d - H:i",$data->create_time)',
			'htmlOptions'=>array('width'=>70),
			'filter'=>false,
		),
		/*'update_time',*/
		array(
			'header'=>Yii::t('commentsModule.msg', 'Status'),
			'name'=>'status',
			'value'=>'$data->textStatus',
			'htmlOptions'=>array('width'=>50),
			'filter'=>Comment::model()->statusLabels,
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>$this->getPageSizeDropDownTag(),
			'deleteButtonImageUrl'=>false,
			'template'=>'{approve} {delete}',
			'buttons'=>array(
				'delete' => array(
					'url'=>'Yii::app()->urlManager->createUrl(CommentsModule::DELETE_ACTION_ROUTE, array("id"=>$data->comment_id))',
					'visible' => '$data->status <> 2',
				),
				'approve' => array(
					'label'=>Yii::t('commentsModule.msg', 'Approve').' | ',
					'url'=>'Yii::app()->urlManager->createUrl(CommentsModule::APPROVE_ACTION_ROUTE, array("id"=>$data->comment_id))',
					'options'=>array('style'=>'margin: 0 5px;'),
					'visible'=>'$data->status == 0',
					'click'=>'function(){
						$.post($(this).attr("href")).success(function(data){
							data = $.parseJSON(data);
							if(data["code"] === "success")
							{
								$.fn.yiiGridView.update("comment-grid");
							}
						});
						return false;
					}',
				),
			),
		),
	),
));