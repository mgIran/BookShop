<?php
$this->breadcrumbs=array(
	Yii::t('commentsModule.msg', 'Messages')=>array('index'),
	Yii::t('commentsModule.msg', 'Manage'),
);
?>

<h1><?php echo Yii::t('commentsModule.msg', 'Manage Messages');?></h1>

<? $this->renderPartial('comments.views.comment._comments_list_widget',array('model' => $model)) ?>
