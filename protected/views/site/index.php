<?
/* @var $this SiteController */
/* @var $newestProgramDataProvider CActiveDataProvider */
/* @var $newestGameDataProvider CActiveDataProvider */
/* @var $newestEducationDataProvider CActiveDataProvider */
/* @var $suggestedDataProvider CActiveDataProvider */
/* @var $advertise Advertises */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');
?>

    <div class="book-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2>جدیدترین کتاب ها</h2>
            </div>
            <a class="pull-left btn btn-success more-book" href="<?php echo $this->createUrl('/books/programs');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$newestProgramDataProvider,
            'id'=>'newest-programs',
            'itemView'=>'_book_item',
            'template'=>'{items}',
            'itemsCssClass'=>'book-carousel'
        ));?>
    </div>
    <div class="book-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2>جدیدترین بازی ها</h2>
            </div>
            <a class="pull-left btn btn-success more-book" href="<?php echo $this->createUrl('/books/games');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'newest-games',
            'dataProvider'=>$newestGameDataProvider,
            'itemView'=>'_book_item',
            'template'=>'{items}',
            'itemsCssClass'=>'book-carousel'
        ));?>
    </div>

<?
if($advertise) {
    ?>
    <div class="banner-box">
        <div class="banner-carousel">
            <div class="banner-item">
                <div class="fade-overly"></div>
                <?
                Yii::app()->clientScript->registerCss('fade-overly', "
                    .content .banner-box .banner-carousel .banner-item{
                        background-color: #{$advertise->fade_color};
                    }
                    .content .banner-box .banner-carousel .banner-item .fade-overly{
                        background: -moz-linear-gradient(left,#{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
                        background: -webkit-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
                        background: -o-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
                        background: -ms-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
                        background: linear-gradient(to right, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
                    }
                ");
                ?>
                <?= $this->renderPartial('/books/_vertical_book_item', array('data' => $advertise->book)) ?>
                <?
                if($advertise->cover && file_exists(Yii::getPathOfAlias('webroot').'/uploads/advertisesCover/'.$advertise->cover)) {
                    ?>
                    <img src="<?= $this->createAbsoluteUrl('/uploads/advertisesCover/'.$advertise->cover) ?>">
                    <?
                }
                ?>
            </div>
        </div>
    </div>
    <?
}
?>
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
    <div class="book-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2>تازه های آموزشی</h2>
            </div>
            <a class="pull-left btn btn-success more-book" href="<?php echo $this->createUrl('/books/educations');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'newest-educations',
            'dataProvider'=>$newestEducationDataProvider,
            'itemView'=>'_book_item',
            'template'=>'{items}',
            'itemsCssClass'=>'book-carousel'
        ));?>
    </div>
    <div class="book-box suggested-list">
        <div class="top-box">
            <div class="title pull-right">
                <h2>پیشنهاد ما به شما</h2>
            </div>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'newest-educations',
            'dataProvider'=>$suggestedDataProvider,
            'itemView'=>'_book_item',
            'template'=>'{items}',
            'itemsCssClass'=>'book-carousel'
        ));?>
    </div>
<?
Yii::app()->clientScript->registerScript('carousels','
    var owl = $(".book-carousel");
    owl.owlCarousel({
        responsive:{
            0:{
                items : 1,
            },
            410:{
                items : 2,
            },
            580:{
                items : 3
            },
            800:{
                items : 4
            },
            1130:{
                items : 5
            },
            1370:{
                items : 6
            }
        },
        lazyLoad :true,
        margin :0,
        rtl:true,
        nav:true,
        navText : ["","<span class=\'icon-chevron-left\'></span>"]
    });

'
);