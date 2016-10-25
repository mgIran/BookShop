<?php
/* @var $this PublicController */
/* @var $model Users*/
?>

<div class="container-fluid">
    <?php if(empty($model->bookBuys)):?>
        نتیجه ای یافت نشد.
    <?php else:?>
        <div class="table text-center">
            <div class="thead">
                <div class="td col-lg-4 col-md-4 col-sm-4 hidden-xs">زمان</div>
                <div class="td col-lg-4 col-md-4 col-sm-4 col-xs-12">نام کتاب</div>
                <div class="td col-lg-4 col-md-4 col-sm-4 hidden-xs">مبلغ</div>
            </div>
            <div class="tbody">
                <?php foreach($model->bookBuys as $buy):?>
                    <div class="tr">
                        <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs"><?php echo JalaliDate::date('d F Y - H:i', $buy->date);?></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><?php echo CHtml::encode($buy->book->title);?></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs"><?php echo number_format($buy->book->price, 0).' تومان';?></div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
</div>