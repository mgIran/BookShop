<?php
/* @var $this BooksController */
/* @var $model Books */
/* @var $similar CActiveDataProvider */
/* @var $bookmarked boolean */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.theme.default.min.css');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.magnific-popup.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/magnific-popup.css');

$filePath = Yii::getPathOfAlias("webroot")."/uploads/books/files/";
?>
<div class="page <?= $model->hasDiscount()?'has-discount':'' ?>">
    <div class="page-heading">
        <div class="container">
            <h1><?= CHtml::encode($model->title) ?></h1>
            <div class="page-info">
                <span>نویسنده<a href="#">حمید داوود آبادی</a></span>
                <span>ناشر<a href="<?php echo $this->createUrl('/book/publisher?title='.($model->publisher?urlencode($model->publisher->userDetails->publisher_id).'&id='.$model->publisher_id:urlencode($model->publisher_name).'&t=1'));?>"
                    ><?= CHtml::encode($model->getPublisherName()) ?></a></span>
            </div>
        </div>
    </div>
    <div class="container page-content book-view">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 thumb"><img src="<?= Yii::app()->baseUrl.'/uploads/books/icons/'.$model->icon ?>" alt="<?= CHtml::encode($model->title) ?>" ></div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 book-info">
                        <div class="info">
                            <h4><?= CHtml::encode($model->title)?></h4>
                            <div class="book-meta">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-right"><i class="page-count-icon"></i></div>
                                        <div class="meta-body">تعداد صفحات<div class="meta-heading"><?= CHtml::encode(Controller::parseNumbers(number_format($model->number_of_pages))) ?> صفحه</div></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-right"><i class="calendar-icon"></i></div>
                                        <div class="meta-body">تاریخ انتشار آخرین چاپ<div class="meta-heading"><?= CHtml::encode(JalaliDate::date('Y F d',$model->lastPackage->publish_date)) ?></div></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-right"><i class="file-icon"></i></div>
                                        <div class="meta-body">نوع فایل<div class="meta-heading"><?= CHtml::encode(pathinfo($model->lastPackage->file_name,PATHINFO_EXTENSION)) ?></div></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-right"><i class="download-icon"></i></div>
                                        <div class="meta-body">حجم فایل<div class="meta-heading"><?= CHtml::encode(Controller::fileSize($filePath.$model->lastPackage->file_name)) ?></div></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-right"><i class="earth-icon"></i></div>
                                        <div class="meta-body">زبان<div class="meta-heading"><?= CHtml::encode($model->language) ?></div></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-right"><i class="isbn-icon"></i></div>
                                        <div class="meta-body">شابک<div class="meta-heading"><?= CHtml::encode($model->lastPackage->isbn) ?></div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-container">
                                <div class="stars">
                                    <?= Controller::printRateStars($model->rate) ?>
                                    <span>(<?= CHtml::encode(Controller::parseNumbers($model->getCountRate())) ?> کاربر)</span>
                                </div>
                                <?
                                if($model->hasDiscount()):
                                    ?>
                                    <h5 class="price text-line-through text-danger">
                                        <?= CHtml::encode(Controller::parseNumbers(number_format($model->price)).' تومان') ?>
                                        <small> / <?= CHtml::encode('نسخه چاپی '.Controller::parseNumbers(number_format($model->printed_price)).' تومان') ?></small>
                                    </h5>
                                    <h5 class="price">
                                        <?= CHtml::encode(Controller::parseNumbers(number_format($model->offPrice)).' تومان') ?>
                                        <small> / <?= CHtml::encode('نسخه چاپی '.Controller::parseNumbers(number_format($model->off_printed_price)).' تومان') ?></small>
                                    </h5>
                                    <?
                                else:
                                    ?>
                                    <h5 class="price">
                                        <?= CHtml::encode(Controller::parseNumbers(number_format($model->price)).' تومان') ?>
                                        <small> / <?= CHtml::encode('نسخه چاپی '.Controller::parseNumbers(number_format($model->printed_price)).' تومان') ?></small>
                                    </h5>
                                    <?
                                endif;
                                ?>
                                <a href="#" class="btn-red"><i class="add-to-library-icon"></i>افزودن به کتابخانه</a>
                                <div class="small-info">
                                    <p>دسته بندی: <span><?= CHtml::encode($model->category->title) ?></span></p>
                                    <p>بر چسب ها: <span><?= CHtml::encode($model->category->title) ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 book-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#summary">توضیحات</a></li>
                            <li><a data-toggle="tab" href="#comments">نظرات (<?= CHtml::encode(Controller::parseNumbers($model->getCountComments())) ?>)</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="summary" class="tab-pane fade in active"><?php
                            echo $model->description;
                                ?></div>
                            <div id="comments" class="tab-pane fade">
                                <ul class="comments-list">
                                    <li>
                                        <img src="uploads/users/user_1.jpg" alt="user name">
                                        <div class="comment-text">
                                            <div class="text">
                                                <div class="stars">
                                                    <?= Controller::printRateStars($model->rate) ?>
                                                </div>
                                                <div>کتاب خیلی خوبی بود...</div>
                                            </div>
                                            <p class="meta">
                                                <span class="pull-right">حسین رامین فر</span>
                                                <span class="pull-left">10:36 - 16 شهریور 1395</span>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="uploads/users/user_1.jpg" alt="user name">
                                        <div class="comment-text">
                                            <div class="text">
                                                <div class="stars">
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon off"></i>
                                                </div>
                                                <div>من از این کتاب خیلی چیزا یاد گرفتم. امیدوارم شما هم این کتاب رو مطالعه کنید و از مطالب خوبش استفاده کنید.</div>
                                            </div>
                                            <p class="meta">
                                                <span class="pull-right">حسین رامین فر</span>
                                                <span class="pull-left">10:36 - 16 شهریور 1395</span>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                                <div class="comment-form">
                                    <h4>نظرتان را بگویید</h4>
                                    <form>
                                        <img src="uploads/users/user_1.jpg" alt="user name">
                                        <div class="inputs-container">
                                            <input type="text" class="text-field" placeholder="نام و نام خانوادگی" value="حسین رامین فر" disabled>
                                            <input type="text" class="text-field" placeholder="پست الکترونیکی">
                                            <div class="rating">
                                                <span>امتیاز</span>
                                                <ul>
                                                    <li class="stars"><i class="icon"></i></li>
                                                    <li class="stars"><i class="icon"></i><i class="icon"></i></li>
                                                    <li class="stars"><i class="icon"></i><i class="icon"></i><i class="icon"></i></li>
                                                    <li class="stars"><i class="icon"></i><i class="icon"></i><i class="icon"></i><i class="icon"></i></li>
                                                    <li class="stars"><i class="icon"></i><i class="icon"></i><i class="icon"></i><i class="icon"></i><i class="icon"></i></li>
                                                </ul>
                                            </div>
                                            <textarea class="text-field" placeholder="شرح..."></textarea>
                                            <div class="button-block">
                                                <input type="submit" class="btn-blue pull-left" value="ثبت نظر">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="social-list list-inline">
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $this->createAbsoluteUrl('/book/'.$model->id.'/'.urlencode($model->title)) ?>"
                                   class="social-icon"><i class="facebook-icon"></i></a></li>
                            <li><a href="https://twitter.com/home?status=<?= $this->createAbsoluteUrl('/book/'.$model->id.'/'.urlencode($model->title)) ?>"
                                   class="social-icon"><i class="twitter-icon"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="similar-books">
                            <div class="heading">
                                <h4>کتاب های مشابه</h4>
                                <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-dots="0" data-nav="1">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail small">
                                            <div class="thumb">
                                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/12927.jpg" alt="نام کتاب" ></a>
                                            </div>
                                            <div class="caption">
                                                <div class="cat-icon" style="background: #cd3660;">
                                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/3.svg"></a>
                                                </div>
                                                <div class="heading">
                                                    <h4>تخم مرغ ها</h4>
                                                </div>
                                                <div class="stars">
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon off"></i>
                                                </div>
                                                <span class="price">1.500 تومان</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail-container">
                                        <div class="thumbnail small">
                                            <div class="thumb">
                                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/12210.jpg" alt="نام کتاب" ></a>
                                            </div>
                                            <div class="caption">
                                                <div class="cat-icon" style="background: #fbb11a;">
                                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/2.svg"></a>
                                                </div>
                                                <div class="heading">
                                                    <h4>مطلع مهر</h4>
                                                </div>
                                                <div class="stars">
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon off"></i>
                                                </div>
                                                <span class="price">1.500 تومان</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail-container">
                                        <div class="thumbnail small">
                                            <div class="thumb">
                                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/8420.jpg" alt="نام کتاب" ></a>
                                            </div>
                                            <div class="caption">
                                                <div class="cat-icon" style="background: #2e9fc7;">
                                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/1.svg"></a>
                                                </div>
                                                <div class="heading">
                                                    <h4>مزرعه حیوانات</h4>
                                                </div>
                                                <div class="stars">
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon off"></i>
                                                </div>
                                                <span class="price">1.500 تومان</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail-container">
                                        <div class="thumbnail small">
                                            <div class="thumb">
                                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/914.jpg" alt="نام کتاب" ></a>
                                            </div>
                                            <div class="caption">
                                                <div class="cat-icon" style="background: #28c295;">
                                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/4.svg"></a>
                                                </div>
                                                <div class="heading">
                                                    <h4>دختر شینا</h4>
                                                </div>
                                                <div class="stars">
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon off"></i>
                                                </div>
                                                <span class="price">1.500 تومان</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail-container">
                                        <div class="thumbnail small">
                                            <div class="thumb">
                                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/6032.jpg" alt="نام کتاب" ></a>
                                            </div>
                                            <div class="caption">
                                                <div class="cat-icon" style="background: #2a664c;">
                                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/2.svg"></a>
                                                </div>
                                                <div class="heading">
                                                    <h4>دنیای آشنا</h4>
                                                </div>
                                                <div class="stars">
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon"></i>
                                                    <i class="icon off"></i>
                                                </div>
                                                <span class="price">1.500 تومان</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 sidebar">
                <div class="boxed">
                    <div class="heading">
                        <h4>درباره بوک شاپ</h4>
                    </div>
                    <div class="text-justify">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                    </div>
                </div>
                <div class="boxed">
                    <div class="heading">
                        <h4>دسته بندی ها</h4>
                    </div>
                    <ul class="categories">
                        <li><a href="#">ادبیات</a></li>
                        <li><a href="#">سیاست و جامعه</a></li>
                        <li><a href="#">کسب و کار</a></li>
                        <li><a href="#">گذشته و تاریخ</a></li>
                        <li><a href="#">سبک زندگی</a></li>
                        <li><a href="#">هنر و اندیشه</a></li>
                        <li><a href="#">کودک و نوجوان</a></li>
                    </ul>
                </div>
                <div class="boxed">
                    <div class="heading">
                        <h4>برچسب ها</h4>
                    </div>
                    <div class="tags">
                        <a href="#">ادبیات</a>
                        <a href="#">سیاست و جامعه</a>
                        <a href="#">کسب و کار</a>
                        <a href="#">گذشته و تاریخ</a>
                        <a href="#">سبک زندگی</a>
                        <a href="#">هنر و اندیشه</a>
                        <a href="#">کودک و نوجوان</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="book col-sm-12 col-xs-12">
    <div class="book-inner">
        <div class="pic">
            <img src="<?= Yii::app()->createUrl('/uploads/books/icons/'.$model->icon);?>" alt="<?= $model->title ?>">
        </div>
        <div class="book-heading">
            <h2><?= $model->title ?></h2>
            <div class="row-fluid">
                <span ><a href=""><?= $model->getPublisherName(); ?></a></span>
                <span ><a href="<?php echo $this->createUrl('book/'.((strpos($model->category->path,'2-')!==false)?'games':'programs').'/'.$model->category->id.'/'.urlencode($model->category->title));?>"><?= $model->category?$model->category->title:''; ?></a></span>
                <span class="book-rate">
                    <? ?>
                </span>
            </div>
            <div class="row-fluid">
                <svg class="svg svg-bag green"><use xlink:href="#bag"></use></svg>
                <span ><?= Controller::parseNumbers($model->download) ?>&nbsp;نصب فعال</span>
            </div>
            <div class="row-fluid">
                <svg class="svg svg-coin green"><use xlink:href="#coin"></use></svg>
                <?
                if($model->hasDiscount()):
                ?>
                    <span class="text-danger text-line-through"><?= Controller::parseNumbers(number_format($model->price, 0)).' تومان'; ?></span>
                    <span ><?= Controller::parseNumbers(number_format($model->offPrice, 0)).' تومان' ; ?></span>
                <?
                else:
                ?>
                    <span ><?= $model->price?Controller::parseNumbers(number_format($model->price, 0)).' تومان':'رایگان'; ?></span>
                <?
                endif;
                ?>
            </div>
            <div class="row-fluid">
                <span class="pull-left">
                    <button class="btn btn-success btn-install hidden-sm hidden-xs" type="button" data-toggle="modal" data-target="#install-modal">نصب</button>
                    <?php if($model->price>0):?>
                        <a class="btn btn-success btn-install hidden-md hidden-lg" href="<?php echo Yii::app()->createAbsoluteUrl('/book/buy/'.CHtml::encode($model->id).'/'.urlencode(CHtml::encode($model->title)));?>">نصب</a>
                    <?php else:?>
                        <a class="btn btn-success btn-install hidden-md hidden-lg" href="<?php echo Yii::app()->createAbsoluteUrl('/book/download/'.CHtml::encode($model->id).'/'.urlencode(CHtml::encode($model->title)));?>">نصب</a>
                    <?php endif;?>
                </span>
                <?php if(!Yii::app()->user->isGuest):?>
                    <span class="pull-left relative bookmark<?php echo ($bookmarked)?' bookmarked':'';?>">
                        <?= CHtml::ajaxLink('',array('/books/bookmark'),array(
                            'data' => "js:{bookId:$model->id}",
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'success' => 'js:function(data){
                                if(data.status){
                                    if($(".bookmark").hasClass("bookmarked")){
                                        $(".svg-bookmark#bookmark").html("<use xlink:href=\'#add-to-bookmark\'></use>");
                                        $(".bookmark").removeClass("bookmarked");
                                        $(".bookmark").find(".title").text("نشان کردن");
                                    }
                                    else{
                                        $(".svg-bookmark#bookmark").html("<use xlink:href=\'#bookmarked\'></use>");
                                        $(".bookmark").find(".title").text("نشان شده");
                                        $(".bookmark").addClass("bookmarked");
                                    }
                                }
                                else
                                    alert("در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.");
                                return false;
                            }'
                        ),array(
                            'id' =>"bookmark-book"
                        )); ?>
                        <svg id="bookmark" class="svg svg-bookmark green"><use xlink:href="<?php echo ($bookmarked)?'#bookmarked':'#add-to-bookmark';?>"></use></svg>
                        <svg id="remove" class="svg svg-bookmark green"><use xlink:href="#remove-bookmark"></use></svg>
                        <script>
                            $(function(){
                                $(this).find(".svg-bookmark#remove").hide();
                                $('body').on('mouseenter','.bookmark',function(){
                                    if($(this).hasClass('bookmarked')) {
                                        $(this).find(".svg-bookmark#bookmark").hide();
                                        $(this).find(".svg-bookmark#remove").show();
                                    }
                                });
                                $('body').on('mouseleave','.bookmark',function(){
                                    $(this).find(".svg-bookmark#bookmark").show();
                                    $(this).find(".svg-bookmark#remove").hide();
                                });
                            });
                        </script>
                        <span class="green title" ><?php echo ($bookmarked)?'نشان شده':'نشان کردن';?></span>
                    </span>
                <?php endif;
                ?>
            </div>
        </div>
        <div class="book-body">
            <?
            if($model->images) {
            ?>
                <div class="images-carousel">
                <?
                $imager = new Imager();
                foreach($model->images as $key => $image):
                    if(file_exists(Yii::getPathOfAlias("webroot").'/uploads/books/images/'.$image->image)):
                        $imageInfo = $imager->getImageInfo(Yii::getPathOfAlias("webroot").'/uploads/books/images/'.$image->image);
                        $ratio = $imageInfo['width'] / $imageInfo['height'];
                        ?>
                        <div class="image-item" style="width: <?php echo ceil(318 * $ratio); ?>px;"
                             data-toggle="modal" data-index="<?= $key ?>" data-target="#carousesl-modal">
                            <a href="<?= Yii::app()->createAbsoluteUrl('/uploads/books/images/'.$image->image) ?>"><img
                                    src="<?= Yii::app()->createAbsoluteUrl('/uploads/books/images/'.$image->image) ?>"
                                    alt="<?= $model->title ?>"></a>
                        </div>
                        <?
                    endif;
                endforeach;
                ?>
                </div>
            <?
                Yii::app()->clientScript->registerScript('callImageGallery',"
                    $('.images-carousel').magnificPopup({
                        delegate: 'a',
                        type: 'image',
                        tLoading: 'Loading image #%curr%...',
                        mainClass: 'mfp-img-mobile',
                        gallery: {
                            enabled: true,
                            navigateByImgClick: true,
                            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                        },
                        image: {
                            tError: '<a href=\"%url%\">The image #%curr%</a> could not be loaded.',
                            titleSrc: function(item) {
                                return '';
                            }
                        }
                    });
                ");
                Yii::app()->clientScript->registerScript('book-images-carousel',"
                    $('.images-carousel').owlCarousel({
                        autoWidth:true,
                        margin:10,
                        rtl:true,
                        dots:false,
                        items:1
                    });
                ");
            }
            ?>
            <section>
                <div class="book-description">
                    <h4>توضیحات کتاب</h4>
                    <p><?= strip_tags(nl2br($model->description)); ?></p>
                </div>
                <a class="more-text" href="#">
                    <span>توضیحات بیشتر</span>
                </a>
            </section>
            <?php if($model->change_log || !empty($model->change_log)):?>
                <div class="change-log">
                    <h4>آخرین تغییرات</h4>
                    <div class="book-description">
                        <?= $model->change_log ?>
                    </div>
                </div>
            <?php endif;?>
            <div class="book-details">
                <h4>اطلاعات کتاب</h4>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 detail">
                    <h5>حجم</h5>
                    <span class="ltr" ><?= Controller::fileSize($filePath.$model->lastPackage->file_name) ?></span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 detail">
                    <h5>نسخه</h5>
                    <span class="ltr" ><?= $model->lastPackage->version ?></span>
                </div>
            </div>
            <div class="book-comments border-none">
                <div id="rate-wrapper">
                    <?
                    $this->renderPartial('_rating',array(
                        'model' => $model
                    ));
                    ?>
                </div>
                <div class="comments">
                    <?
                    $this->widget('comments.widgets.ECommentsListWidget', array(
                        'model' => $model,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="book-like col-sm-12 col-xs-12">
        <div class="book-box">
            <div class="top-box">
                <div class="title pull-right">
                    <h2>مشابه</h2>
                </div>
            </div>
            <div class="book-vertical">
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'similar-books',
                    'dataProvider'=>$similar,
                    'itemView'=>'_vertical_book_item',
                    'template'=>'{items}',
                ));?>
            </div>
        </div>
    </div>

    <div id="install-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3>برای دانلود کتاب کد زیر را اسکن کنید</h3>
                    <div class="qr-code-container">
                        <?php if($model->price>0):?>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode(Yii::app()->createAbsoluteUrl('/book/buy/'.CHtml::encode($model->id).'/'.urlencode(CHtml::encode($model->title))));?>" />
                        <?php else:?>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode(Yii::app()->createAbsoluteUrl('/book/download/'.CHtml::encode($model->id).'/'.urlencode(CHtml::encode($model->title))));?>" />
                        <?php endif;?>
                    </div>
                    <?php
                    if($model->price>0) {
                        ?>
                        <a href="<?php echo $this->createUrl('/book/buy/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title)); ?>"
                           class="btn btn-success btn-buy">خرید</a>
                        <?php
                    }else {
                        ?>
                        <a href="#"
                           data-dismiss="modal"
                           class="btn btn-default">بستن</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div id="carousel-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">

                </div>
            </div>
        </div>
    </div>