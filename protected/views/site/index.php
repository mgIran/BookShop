<?
/* @var $this SiteController */
/* @var $categoriesDataProvider CActiveDataProvider */
/* @var $latestBooksDataProvider CActiveDataProvider */
/* @var $mostPurchaseBooksDataProvider CActiveDataProvider */
/* @var $suggestedDataProvider CActiveDataProvider */
/* @var $advertises CActiveDataProvider */
/* @var $news CActiveDataProvider */

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
<!--    <div class="tabs">-->
<!--        <div class="container">-->
<!--            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">-->
<!--                <ul class="nav nav-pills nav-stacked row">-->
<!--                    <li role="presentation" class="active"><a data-toggle="tab" href="#row-1">برترین ها</a></li>-->
<!--                    <li role="presentation"><a data-toggle="tab" href="#row-2">محبوب ترین ها</a></li>-->
<!--                    <li role="presentation"><a data-toggle="tab" href="#row-3">رایگان ها</a></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 tabs-container">-->
<!--                <div class="tab-content">-->
<!--                    <div id="row-1" class="tab-pane fade in active">-->
<!--                        <div class="is-carousel auto-width" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="0">-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/914.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>-->
<!--                                        <span class="price">4.000 تومان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>-->
<!--                                        <span class="price">1.500 تومان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="row-2" class="tab-pane fade">-->
<!--                        <div class="is-carousel auto-width" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="0">-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>-->
<!--                                        <span class="price">1.500 تومان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/914.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>-->
<!--                                        <span class="price">4.000 تومان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="row-3" class="tab-pane fade">-->
<!--                        <div class="is-carousel auto-width" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="0">-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>-->
<!--                                        <span class="price">رایگان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/914.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>-->
<!--                                        <span class="price">4.000 تومان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="thumbnail-container">-->
<!--                                <div class="thumbnail simple">-->
<!--                                    <div class="thumb">-->
<!--                                        <a href="#" title="عنوان کتاب">-->
<!--                                            <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >-->
<!--                                            <div class="thumbnail-overlay"></div>-->
<!--                                            <div class="thumbnail-overlay-icon">-->
<!--                                                <i class="icon"></i>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <div class="caption">-->
<!--                                        <div class="stars">-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon"></i>-->
<!--                                            <i class="icon off"></i>-->
<!--                                        </div>-->
<!--                                        <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>-->
<!--                                        <span class="price">1.500 تومان</span>-->
<!--                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php
if($news->totalItemCount):
?>
    <div class="news">
        <div class="container">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="is-carousel" data-item-selector="news-item" data-dots="0" data-nav="1" data-autoplay="1" data-autoplay-hover-pause="1" data-loop="0" data-items="1" data-mouseDrag="0">
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







<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>جدیدترین برنامه ها</h2>-->
<!--            </div>-->
<!--            <a class="pull-left btn btn-success more-book" href="--><?php //echo $this->createUrl('/book/programs');?><!--">بیشتر</a>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'dataProvider'=>$newestProgramDataProvider,
//            'id'=>'newest-programs',
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>جدیدترین بازی ها</h2>-->
<!--            </div>-->
<!--            <a class="pull-left btn btn-success more-book" href="--><?php //echo $this->createUrl('/book/games');?><!--">بیشتر</a>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'id'=>'newest-games',
//            'dataProvider'=>$newestGameDataProvider,
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<!---->
<?//
//if($advertise) {
//    ?>
<!--    <div class="banner-box">-->
<!--        <div class="banner-carousel">-->
<!--            <div class="banner-item">-->
<!--                <div class="fade-overly"></div>-->
<!--                --><?//
//                Yii::app()->clientScript->registerCss('fade-overly', "
//                    .content .banner-box .banner-carousel .banner-item{
//                        background-color: #{$advertise->fade_color};
//                    }
//                    .content .banner-box .banner-carousel .banner-item .fade-overly{
//                        background: -moz-linear-gradient(left,#{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: -webkit-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: -o-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: -ms-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: linear-gradient(to right, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                    }
//                ");
//                ?>
<!--                --><?//= $this->renderPartial('/books/_vertical_book_item', array('data' => $advertise->book)) ?>
<!--                --><?//
//                if($advertise->cover && file_exists(Yii::getPathOfAlias('webroot').'/uploads/advertisesCover/'.$advertise->cover)) {
//                    ?>
<!--                    <img src="--><?//= $this->createAbsoluteUrl('/uploads/advertisesCover/'.$advertise->cover) ?><!--">-->
<!--                    --><?//
//                }
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    --><?//
//}
//?>
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>برترین ها</h2>-->
<!--            </div>-->
<!--            <button type="button" class="pull-left btn btn-success more-book" >-->
<!--                بیشتر-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="book-carousel">-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>پر فروش های هفته</h2>-->
<!--            </div>-->
<!--            <button type="button" class="pull-left btn btn-success more-book" >-->
<!--                بیشتر-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="book-carousel">-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>تازه های آموزشی</h2>-->
<!--            </div>-->
<!--            <a class="pull-left btn btn-success more-book" href="--><?php //echo $this->createUrl('/book/educations');?><!--">بیشتر</a>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'id'=>'newest-educations',
//            'dataProvider'=>$newestEducationDataProvider,
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<!--    <div class="book-box suggested-list">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>پیشنهاد ما به شما</h2>-->
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'id'=>'newest-educations',
//            'dataProvider'=>$suggestedDataProvider,
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<?//
//Yii::app()->clientScript->registerScript('carousels','
//    var owl = $(".book-carousel");
//    owl.owlCarousel({
//        responsive:{
//            0:{
//                items : 1,
//            },
//            410:{
//                items : 2,
//            },
//            580:{
//                items : 3
//            },
//            800:{
//                items : 4
//            },
//            1130:{
//                items : 5
//            },
//            1370:{
//                items : 6
//            }
//        },
//        lazyLoad :true,
//        margin :0,
//        rtl:true,
//        nav:true,
//        navText : ["","<span class=\'icon-chevron-left\'></span>"]
//    });
//
//'
//);