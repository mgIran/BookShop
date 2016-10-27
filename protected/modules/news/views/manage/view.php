<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $latestNewsProvider CActiveDataProvider */
?>
<div class="page-title-container courses personnel-page-header news-page-header ">
    <div class="mask"></div>
    <div class="container">
        <h2><?= $model->title ?></h2>
        <div class="details">
            <span><?= Yii::t('app','Views') ?></span>
            <span><?= Yii::app()->language == 'fa'?Controller::parseNumbers($model->seen):$model->seen ?></span>
            <span class="svg svg-eye pull-right"></span>
        </div>
    </div>
</div>
<div class="page-content courses">
    <div class="container">
        <div class="news-view col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <h2><?= $model->title ?></h2>

            <div class="news-details">
                <span><?= Yii::t('app','News ID') ?>: <?= $model->id ?></span>

                <!-- category -->
                <span><?= Yii::t('app','Category') ?>:</span>
                <a class="link-blue" target="_blank" href="<?= $this->createUrl('category/'.$model->category_id.'/'.urlencode($model->category->title)) ?>">
                    <?= $model->category->title ?>
                </a>
                <span class="clearfix">
                    <span class="clock-icon"></span>
                    <?= Yii::app()->language=="fa"?JalaliDate::date("Y/m/d - H:i",$model->publish_date):date("Y/m/d - H:i",$model->publish_date) ?>
                </span>
            </div>
            <div class="news-pic">
                <img src="<?= Yii::app()->baseUrl.'/uploads/news/'.$model->image ?>" alt="<?= $model->title ?>">
            </div>
            <?php
            if($model->summary):
            ?>
            <div class="news-summery text-justify well"><?= $model->summary ?></div>
            <?php
            endif;
            ?>
            <div class="news-text"><?= $model->body ?></div>
            <!-- END OF NEWS CONTENT -->


            <?php
            if($model->tags):
            ?>
            <!-- NEWS META DATA : TAGS -->
            <div class="news-tags">
                <h5><?= Yii::t('app','Tags') ?></h5>
                <?php
                foreach ($model->tags as $tag)
                    if($tag->title && !empty($tag->title))
                        echo CHtml::link($tag->title,array('/news/tag/'.$tag->id.'/'.urlencode($tag->title)),array('class'=>'label label-blue'));
                ?>
            </div>
            <?php
            endif;
            ?>
            <!-- NEWS META DATA : SOCIAL MEDIA -->
            <div class="overflow-fix">
                <div class="news-share pull-right">
                    <span><?= Yii::t('app','Sharing') ?></span><span class="share-icons">
                        <a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= $this->createAbsoluteUrl('/news/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                        <a target="_blank" class="twitter" href="https://twitter.com/home?status=<?= $this->createAbsoluteUrl('/news/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                        <a target="_blank" class="google-plus" href="https://plus.google.com/share?url=<?= $this->createAbsoluteUrl('/news/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                        <a target="_blank" class="telegram" href="https://telegram.me/share/url?url=<?= $this->createAbsoluteUrl('/news/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                    </span>
                </div>
                <div class="short-url pull-left">
                    <div class="icon">
                        <span class="glyphicon glyphicon-link"></span>
                    </div>
                    <input class="auto-select" aria-label="<?= $this->createAbsoluteUrl('/news/'.$model->id) ?>" value="<?= $this->createAbsoluteUrl('/news/'.$model->id) ?>" type="text">
                </div>
            </div>
        </div>
        <div class="latest-news col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <h3><?= Yii::t('app','Category') ?></h3>
            <ul class="main-menu nav nav-stacked tree">
                <?php
                NewsCategories::getHtmlSortList(Null,$model->category->id);
                ?>
            </ul>
            <?php
            if($latestNewsProvider->totalItemCount):
            ?>
            <h3><?= Yii::t('app','Latest News') ?></h3>
            <div class="news-container">
                <?php
                $this->widget("zii.widgets.CListView",array(
                    'id' => 'latest-news-list',
                    'dataProvider' => $latestNewsProvider,
                    'itemView' => 'news.views.manage._side_view',
                    'template' => '{items}',
                ));
                ?>

                <?php
                if(News::model()->count(News::getValidNews()) > 4):
                    ?>
                    <a class="more-btn" href="<?= $this->createUrl('/news') ?>">
                        <?= Yii::t('app','See More') ?>
                        <div class="bounces">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <?php
                endif;
                ?>
            </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>