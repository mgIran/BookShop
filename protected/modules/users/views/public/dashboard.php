<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $suggestedDataProvider CActiveDataProvider */
/* @var $messages CArrayDataProvider */
?>
<?php if($messages->totalItemCount > 0):?>
    <?php $this->widget('zii.widgets.CListView', array(
        'id' => 'messages-list',
        'dataProvider' => $messages,
        'itemView' => '_message',
        'template' => '{items}'
    )); ?>
<?php endif;?>
<div class="statistics">
    <div>
        <div class="green">
            <h4>اعتبار</h4>
            <span>میزان اعتبار شما در کتابیک</span>
            <h3><?php echo number_format($model->userDetails->credit, 0, ',', '.');?> تومان</h3>
            <a href="<?php echo $this->createUrl('/users/credit/buy');?>">خرید اعتبار<i class="arrow-icon"></i></a>
        </div>
    </div><div>
        <div class="red">
            <h4>نشان شده ها</h4>
            <span>کتاب هایی که مایلید مطالعه کنید</span>
            <h3><?php echo number_format(count($model->bookmarkedBooks), 0, ',', '.');?> کتاب</h3>
            <a href="<?php echo Yii::app()->createUrl('users/public/bookmarked');?>">نشان شده ها<i class="arrow-icon"></i></a>
        </div>
    </div><div>
        <div class="blue">
            <h4>کتابخانه من</h4>
            <span>کتابخانه مجازی خود را بسازید</span>
            <h3><?php echo number_format(count($model->bookmarkedBooks)+count($model->bookBuys), 0, ',', '.');?> کتاب</h3>
            <a href="<?php echo Yii::app()->createUrl('users/public/library');?>">کتابخانه من<i class="arrow-icon"></i></a>
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
            <table class="table">
                <thead>
                <tr>
                    <th>زمان</th>
                    <th>نام کتاب</th>
                    <th>مبلغ</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($model->bookBuys)):?>
                    <tr>
                        <td colspan="3" class="text-center">نتیجه ای یافت نشد.</td>
                    </tr>
                <?php else:?>
                    <?php foreach($model->bookBuys as $buy):?>
                        <tr>
                            <td><?php echo JalaliDate::date('d F Y - H:i', $buy->date);?></td>
                            <td><?php echo CHtml::encode($buy->book->title);?></td>
                            <td><?php echo number_format($buy->book->price, 0).' تومان';?></td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
        <div id="transactions" class="tab-pane fade">
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
            <?php if(empty($model->transactions)):?>
                <tr>
                    <td colspan="4" class="text-center">نتیجه ای یافت نشد.</td>
                </tr>
                <?php else:?>
                    <?php foreach($model->transactions as $transaction):?>
                        <tr>
                            <td><?php echo JalaliDate::date('d F Y - H:i', $transaction->date);?></td>
                            <td><?php echo number_format($transaction->amount, 0).' تومان';?></td>
                            <td><?php echo CHtml::encode($transaction->description);?></td>
                            <td><?php echo CHtml::encode($transaction->token);?></td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="offers">
    <div class="head">
        <h4>پیشنهاد ما به شما</h4>
    </div>
    <div class="is-carousel" data-item-selector="thumbnail-container" data-mouse-drag="1" data-responsive='{"1600":{"items":"5"},"1400":{"items":"4"},"1024":{"items":"3"},"992":{"items":"3"},"768":{"items":"2"},"700":{"items":"3"},"480":{"items":"2"},"0":{"items":"1"}}' data-dots="1" data-nav="1">
        <?php $this->widget('zii.widgets.CListView',array(
            'id' => 'suggested-list',
            'dataProvider' => $suggestedDataProvider,
            'itemView' => '//site/_book_item',
            'template' => '{items}',
            'viewData' => array('itemClass' => 'simple')
        )); ?>
    </div>
</div>