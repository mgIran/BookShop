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

    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2>جدیدترین برنامه ها</h2>
            </div>
            <a class="pull-left btn btn-success more-app" href="<?php echo $this->createUrl('/books/programs');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$newestProgramDataProvider,
            'id'=>'newest-programs',
            'itemView'=>'_app_item',
            'template'=>'{items}',
            'itemsCssClass'=>'app-carousel'
        ));?>
    </div>
    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2>جدیدترین بازی ها</h2>
            </div>
            <a class="pull-left btn btn-success more-app" href="<?php echo $this->createUrl('/books/games');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'newest-games',
            'dataProvider'=>$newestGameDataProvider,
            'itemView'=>'_app_item',
            'template'=>'{items}',
            'itemsCssClass'=>'app-carousel'
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
                <?= $this->renderPartial('/books/_vertical_app_item', array('data' => $advertise->app)) ?>
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
<!--    <div class="app-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>برترین ها</h2>-->
<!--            </div>-->
<!--            <button type="button" class="pull-left btn btn-success more-app" >-->
<!--                بیشتر-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="app-carousel">-->
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--    <div class="app-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>پر فروش های هفته</h2>-->
<!--            </div>-->
<!--            <button type="button" class="pull-left btn btn-success more-app" >-->
<!--                بیشتر-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="app-carousel">-->
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
<!--            <div class="app-item">-->
<!--                <div class="app-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="app-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="app-any">-->
<!--                                    <span class="app-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="app-rate">-->
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
    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2>تازه های آموزشی</h2>
            </div>
            <a class="pull-left btn btn-success more-app" href="<?php echo $this->createUrl('/books/educations');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'newest-educations',
            'dataProvider'=>$newestEducationDataProvider,
            'itemView'=>'_app_item',
            'template'=>'{items}',
            'itemsCssClass'=>'app-carousel'
        ));?>
    </div>
    <div class="app-box suggested-list">
        <div class="top-box">
            <div class="title pull-right">
                <h2>پیشنهاد ما به شما</h2>
            </div>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'newest-educations',
            'dataProvider'=>$suggestedDataProvider,
            'itemView'=>'_app_item',
            'template'=>'{items}',
            'itemsCssClass'=>'app-carousel'
        ));?>
    </div>
<?
Yii::app()->clientScript->registerScript('carousels','
    var owl = $(".app-carousel");
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