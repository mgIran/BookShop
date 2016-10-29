<?php
/* @var $this PublicController */
/* @var $model Users */
/* @var $suggestedDataProvider CActiveDataProvider */
?>
<div class="statistics">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="green">
            <h4>اعتبار</h4>
            <span>مانده اعتبار</span>
            <h3><?php echo number_format($model->userDetails->credit, 0, ',', '.');?> تومان</h3>
            <a href="<?php echo $this->createUrl('/users/credit/buy');?>">خرید اعتبار<i class="arrow-icon"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="red">
            <h4>نشان شده ها</h4>
            <span>تعداد کتاب</span>
            <h3><?php echo number_format(count($model->userDetails->user->bookmarkedBooks), 0, ',', '.');?> کتاب</h3>
            <a href="<?php echo Yii::app()->createUrl('users/public/bookmarked');?>">نشان شده ها<i class="arrow-icon"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="blue">
            <h4>کتابخانه من</h4>
            <span>تعداد کتاب</span>
            <h3>10 کتاب</h3>
            <a href="#">کتابخانه من<i class="arrow-icon"></i></a>
        </div>
    </div>
</div>
<div class="tabs tables">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#downloaded"><h5>دانلود شده ها<small> / <?php echo number_format(count($model->bookBuys), 0, ',', '.');?> مورد</small></h5></a></li>
        <li><a data-toggle="tab" href="#transactions"><h5>تراکنش ها<small> / <?php echo number_format(count($model->transactions), 0, ',', '.');?> تراکنش</small></h5></a></li>
    </ul>
    <div class="tab-content">
        <div id="downloaded" class="tab-pane fade in active">
            <?php if(empty($model->bookBuys)):?>
                نتیجه ای یافت نشد.
            <?php else:?>
                <table class="table">
                    <thead>
                        <tr>
                            <td>زمان</td>
                            <td>نام کتاب</td>
                            <td>مبلغ</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($model->bookBuys as $buy):?>
                            <tr>
                                <td><?php echo JalaliDate::date('d F Y - H:i', $buy->date);?></td>
                                <td><?php echo CHtml::encode($buy->book->title);?></td>
                                <td><?php echo number_format($buy->book->price, 0).' تومان';?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </div>
        <div id="transactions" class="tab-pane fade">
            <?php if(empty($model->transactions)):?>
                نتیجه ای یافت نشد.
            <?php else:?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>زمان</th>
                        <th>مبلغ</th>
                        <th>توضیحات</th>
                        <th>کد رهگیری</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($model->transactions as $transaction):?>
                            <tr>
                                <td><?php echo JalaliDate::date('d F Y - H:i', $transaction->date);?></td>
                                <td><?php echo number_format($transaction->amount, 0).' تومان';?></td>
                                <td><?php echo CHtml::encode($transaction->description);?></td>
                                <td><?php echo CHtml::encode($transaction->token);?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="offers">
    <div class="head">
        <h4>پیشنهاد ما به شما</h4>
    </div>
    <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-nav="1" data-dots="1">
        <?php $this->widget('zii.widgets.CListView',array(
            'id' => 'suggested-list',
            'dataProvider' => $suggestedDataProvider,
            'itemView' => '//site/_book_item',
            'template' => '{items}',
            'viewData' => array('itemClass' => 'simple')
        )); ?>
    </div>
</div>