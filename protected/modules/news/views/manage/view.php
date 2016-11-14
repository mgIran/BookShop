<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $latestNewsProvider CActiveDataProvider */
?>
<div class="page">
    <div class="page-heading">
        <div class="container">
            <h1><?= CHtml::encode($model->title) ?></h1>
            <div class="page-info">
                <div>تاریخ انتشار<a><?= JalaliDate::date('Y F d - h:i') ?></a></div>
                <div>دسته بندی<a href="<?php echo $this->createUrl('/news/category/'.$model->category_id.'/'.urlencode($model->category->title));?>"
                    ><?= CHtml::encode($model->category->title) ?></a></div>
            </div>
        </div>
    </div>
    <div class="container page-content book-view news-view">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 book-info">
                        <div class="heading">
                            <h4><?= CHtml::encode($model->title)?></h4>
                            <span>تاریخ: <a><?= $date = JalaliDate::date("Y F d - H:i",$model->publish_date); ?></a></span>
                            <span>دسته بندی: <a href="<?= $this->createUrl('/news/category/'.$model->category_id.'/'.urldecode($model->category->title)) ?>" ><?= CHtml::encode($model->category->title) ?></a></span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 thumb"><img src="<?= Yii::app()->baseUrl.'/uploads/news/'.$model->image ?>" alt="<?= CHtml::encode($model->title) ?>" ></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 book-tabs">
                        <?php
                        if(!empty($model->summary)):
                        ?>
                        <div class="well">
                            <?= $model->summary ?>
                        </div>
                        <?php
                        endif;
                        ?>
                        <div class="tab-content">
                            <div id="summary" class="tab-pane fade in active"><?php
                                echo $model->body;
                            ?></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="social-list list-inline">
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $this->createAbsoluteUrl('/news/'.$model->id.'/'.urlencode($model->title)) ?>"
                                   class="social-icon"><i class="facebook-icon"></i></a></li>
                            <li><a href="https://twitter.com/home?status=<?= $this->createAbsoluteUrl('/news/'.$model->id.'/'.urlencode($model->title)) ?>"
                                   class="social-icon"><i class="twitter-icon"></i></a></li>
                        </ul>
                    </div>
<!--                    --><?php
//                    if($similar->totalItemCount):
//                        ?>
<!--                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
<!--                            <div class="similar-books">-->
<!--                                <div class="heading">-->
<!--                                    <h4>کتاب های مشابه</h4>-->
<!--                                    <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="0" data-nav="1">-->
<!--                                        --><?php
//                                        $this->widget('zii.widgets.CListView',array(
//                                            'id' => 'latest-list',
//                                            'dataProvider' => $similar,
//                                            'itemView' => '//site/_book_item',
//                                            'template' => '{items}',
//                                            'viewData' => array('itemClass' => 'small')
//                                        ));
//                                        ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        --><?php
//                    endif;
//                    ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 sidebar-col">
                <div class="boxed">
                    <div class="heading">
                        <h4>دسته بندی های خبر</h4>
                    </div>
                    <ul class="categories">
                        <?php
                        foreach($this->categories as $category):
                            ?>
                            <li class="<?= $category->id===$model->category_id?'active':'' ?>"><a href="<?= $this->createUrl('/news/category/'.$category->id.'/'.urlencode($category->title)) ?>"><?= $category->title ?>
                                    <small>(<?= $category->countNews() ?>)</small></a></li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
                <?php if($model->tags): ?>
                    <div class="boxed">
                        <div class="heading">
                            <h4>برچسب ها</h4>
                        </div>
                        <div class="tags">
                            <?php
                            foreach ($model->tags as $tag):
                                if(!empty($tag->title))
                                    echo '<a href="'.$this->createUrl('/news/tag/'.$tag->id.'/'.urldecode($tag->title)).'">'.$tag->title.'</a>';
                            endforeach;
                            ?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>