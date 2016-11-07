<?
/* @var $this SiteController */
/* @var $categoriesDataProvider CActiveDataProvider */
/* @var $latestBooksDataProvider CActiveDataProvider */
/* @var $mostPurchaseBooksDataProvider CActiveDataProvider */
/* @var $suggestedDataProvider CActiveDataProvider */
/* @var $advertises CActiveDataProvider */
/* @var $news CActiveDataProvider */
/* @var $rows CActiveDataProvider */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');
?>
<?php
if($advertises->totalItemCount):
    ?>
    <div class="slider" <?= $advertises->totalItemCount>1?'data-loop="true"':'' ?>>
        <?php
        foreach($advertises->getData() as $advertise):
            $this->renderPartial('_advertise_item',array('data'=>$advertise));
        endforeach;
        ?>
    </div>
<?
endif;
?>
    <div class="categories">
        <div class="container">
            <div class="heading">
                <h2>دسته بندی ها</h2>
            </div>
            <div class="is-carousel" data-items="4" data-item-selector="cat-item" data-margin="10" data-dots="1" data-nav="0" data-mouse-drag="1" data-responsive='{"1200":{"items":"4"},"992":{"items":"3"},"768":{"items":"3"},"650":{"items":"2"},"0":{"items":"1"}}'>
                <?php
                $this->widget('zii.widgets.CListView',array(
                    'id' => 'categories-list',
                    'dataProvider' => $categoriesDataProvider,
                    'itemView' => '_category_item',
                    'template' => '{items}'
                ))
                ?>
            </div>
        </div>
    </div>
<?php if($suggestedDataProvider->totalItemCount):?>
    <div class="offers paralax">
        <div class="container">
            <div class="content">
                <div class="head">
                    <h2>پیشنهاد ما</h2>
                </div>
                <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-nav="1" data-dots="1">
                    <?php
                    $this->widget('zii.widgets.CListView',array(
                        'id' => 'suggested-list',
                        'dataProvider' => $suggestedDataProvider,
                        'itemView' => '_book_item',
                        'template' => '{items}',
                        'viewData' => array('itemClass' => 'full')
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?
endif;
?>
<?php
if($latestBooksDataProvider->totalItemCount):
    ?>
    <div class="newest">
        <div class="container">
            <div class="heading">
                <h2>تازه ترین کتابها</h2>
            </div>
            <div class="thumbnail-list">
                <?php
                $this->widget('zii.widgets.CListView',array(
                    'id' => 'latest-list',
                    'dataProvider' => $latestBooksDataProvider,
                    'itemView' => '_book_item',
                    'template' => '{items}',
                    'viewData' => array('itemClass' => 'simple')
                ));
                ?>
            </div>
            <a href="<?= $this->createUrl('/book/index') ?>" class="more"><i class="icon"></i>کتابهای بیشتر</a>
        </div>
    </div>
<?php
endif;
?>
<?php
if($mostPurchaseBooksDataProvider->totalItemCount):
?>
    <div class="bestselling paralax">
        <div class="container">
            <div class="content">
                <div class="head">
                    <h2>پرفروش ترین ها</h2>
                </div>
                <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="1">
                    <?php
                    $this->widget('zii.widgets.CListView',array(
                        'id' => 'latest-list',
                        'dataProvider' => $latestBooksDataProvider,
                        'itemView' => '_book_item',
                        'template' => '{items}',
                        'viewData' => array('itemClass' => 'small')
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
endif;
?>
<?php
if($rows->totalItemCount):
    $rowData = $rows->getData();
?>
    <div class="tabs">
        <div class="container">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <ul class="nav nav-pills nav-stacked row">
                    <?php
                    foreach ($rowData as $key=>$row):
                        ?>
                        <li role="presentation"<?= $key == 0?' class="active"':'' ?>><a data-toggle="tab" href="#row-<?= $key ?>"><?= $row->title ?></a></li>
                        <?
                    endforeach;
                    ?>
                </ul>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 tabs-container">
                <div class="tab-content">
                    <?php
                    foreach ($rowData as $key=>$row):
                        ?>
                        <div id="row-<?= $key ?>" class="tab-pane fade<?= $key == 0?' in active':'' ?>">
                            <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="0" data-nav="1">
                                <?php
                                $this->widget('zii.widgets.CListView',array(
                                    'id' => 'row-'.$key.'-carousel-list',
                                    'dataProvider' => new CArrayDataProvider($row->books(Books::model()->getValidBooks(array(),'confirm_date DESC',null,'books'))),
                                    'itemView' => '_book_item',
                                    'template' => '{items}',
                                    'viewData' => array('itemClass' => 'simple')
                                ));
                                ?>
                            </div>
                        </div>
                        <?
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
endif;
?>
<?php
if($news->totalItemCount):
?>
    <div class="news">
        <div class="container">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="is-carousel" data-dots="0" data-nav="1" data-autoplay="1" data-autoplay-hover-pause="1" data-loop="0" data-items="1" data-mouseDrag="0">
                    <?php
                    foreach($news->getData() as $new):
                        $this->renderPartial('_news_item',array('data'=>$new));
                    endforeach;
                    ?>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 controls">
                <i class="arrow-icon next"></i>
                <i class="arrow-icon prev"></i>
            </div>
        </div>
    </div>
    <?php
endif;
?>