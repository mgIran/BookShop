<?php
/* @var $this NewsManageController */
/* @var $data News */
?>
<div class="news-item">
    <div class="thumb"><img alt="<?= CHtml::encode($data->title) ?>" src="<?= Yii::app()->baseUrl.'/uploads/news/200x200/'.$data->image ?>"></div>
    <div class="text">
        <h2><a href="<?= $this->createUrl('/news/'.$data->id.'/'.urlencode($data->title)) ?>"><?= CHtml::encode($data->title) ?></a></h2>
        <div class="info">
            <span class="date"><?= JalaliDate::date('Y F d - H:i',$data->publish_date) ?></span>
        </div>
        <div class="summary"><?= $data->summary ?></div>
    </div>
</div>