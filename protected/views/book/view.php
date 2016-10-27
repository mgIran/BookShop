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

<div class="book col-sm-12 col-xs-12">
    <div class="book-inner">
        <div class="pic">
            <img src="<?= Yii::app()->createUrl('/uploads/books/icons/'.$model->icon);?>" alt="<?= $model->title ?>">
        </div>
        <div class="book-heading">
            <h2><?= $model->title ?></h2>
            <div class="row-fluid">
                <span ><a href="<?php echo $this->createUrl('book/publisher?title='.($model->publisher?urlencode($model->publisher->userDetails->publisher_id).'&id='.$model->publisher_id:urlencode($model->publisher_name).'&t=1'));?>"><?= $model->getPublisherName(); ?></a></span>
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