<?php
/* @var $data Books */
/* @var $itemClass string */
?>
<div class="thumbnail-container">
    <div class="thumbnail <?= $itemClass?$itemClass:'' ?>">
        <div class="thumb">
            <a href="#" title="عنوان کتاب">
                <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >
                <div class="thumbnail-overlay"></div>
                <div class="thumbnail-overlay-icon">
                    <i class="icon"></i>
                </div>
            </a>
        </div>
        <div class="caption">
            <div class="cat-icon" style="background: #fbb11a;">
                <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/4.svg"></a>
            </div>
            <div class="stars">
                <i class="icon"></i>
                <i class="icon"></i>
                <i class="icon"></i>
                <i class="icon"></i>
                <i class="icon off"></i>
            </div>
            <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
            <span class="price">رایگان</span>
            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
        </div>
    </div>
</div>
<div class="book-item <?=$data->hasDiscount()?'discount':''?>">
    <div class="book-item-content">
        <div class="pic">
            <div>
                <a href="<?php echo Yii::app()->createUrl('/books/'.$data->id.'/'.urlencode($data->lastPackage->package_name));?>">
                    <img src="<?php echo Yii::app()->baseUrl.'/uploads/books/icons/'.CHtml::encode($data->icon);?>">
                </a>
            </div>
        </div>
        <div class="detail">
            <div class="book-title">
                <a href="<?php echo Yii::app()->createUrl('/books/'.$data->id.'/'.urlencode($data->lastPackage->package_name));?>">
                    <?php echo CHtml::encode($data->title);?>
                    <span class="paragraph-end"></span>
                </a>
            </div>
            <div class="book-any">
                <span class="book-price">
                    <?php if($data->price==0):?>
                        <a href="<?php echo Yii::app()->createUrl('/books/free')?>">رایگان</a>
                    <?php else:?>
                        <?
                        if($data->hasDiscount()):
                            ?>
                            <span class="text-danger text-line-through center-block"><?= Controller::parseNumbers(number_format($data->price, 0)).' تومان'; ?></span>
                            <span ><?= Controller::parseNumbers(number_format($data->offPrice, 0)).' تومان' ; ?></span>
                            <?
                        else:
                            ?>
                            <span ><?= $data->price?Controller::parseNumbers(number_format($data->price, 0)).' تومان':'رایگان'; ?></span>
                            <?
                        endif;
                        ?>
                    <?php endif;?>
                </span>
                <span class="book-rate">
                    <?= Controller::printRateStars($data->rate); ?>
                </span>
            </div>
        </div>
    </div>
</div>