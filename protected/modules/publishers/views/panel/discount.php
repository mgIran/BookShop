<?php
/* @var $this PanelController */
/* @var $booksDataProvider CActiveDataProvider */
/* @var $books [] */
/* @var $discount BookDiscounts */
?>
<div class="transparent-form">
    <h3>تخفیفات</h3>
    <p class="description">لیست تخفیفاتی که در نظر گرفته اید.</p>

    <?php $this->renderPartial('//partial-views/_flashMessage', array('prefix'=>'discount-'));?>

    <a class="btn btn-success" data-toggle="modal" href="#discount-modal">ثبت تخفیف جدید</a>

    <table class="table">
        <thead>
            <tr>
                <td>عنوان کتاب</td>
                <td>وضعیت</td>
                <td>قیمت</td>
                <td>درصد</td>
                <td>قیمت با تخفیف</td>
                <td>مدت تخفیف</td>
            </tr>
        </thead>
        <tbody id="discounts-list">
        <?php if($booksDataProvider->totalItemCount==0):?>
            <tr>
                <td colspan="6" class="text-center">نتیجه ای یافت نشد.</td>
            </tr>
        <?php else:?>
            <?php foreach($booksDataProvider->getData() as $discount):?>
                <tr>
                    <td><a target="_blank" href="<?= $this->createUrl('/book/'.$discount->book->id.'/'.urlencode($discount->book->title)) ?>"><?php echo $discount->book->title;?></a></td>
                    <td><?php echo ($discount->book->status=='enable')?'فعال':'غیر فعال';?></td>
                    <td><?php echo ($discount->book->price==0)?'رایگان':Controller::parseNumbers(number_format($discount->book->price,0)).' تومان';?></td>
                    <td><?= Controller::parseNumbers($discount->percent).'%' ?></td>
                    <td><?= Controller::parseNumbers(number_format($discount->offPrice)).' تومان' ?></td>
                    <td>
                        <?php echo Controller::parseNumbers(JalaliDate::date('Y/m/d - H:i',$discount->start_date));
                        echo '<br>الی<br>';
                        echo Controller::parseNumbers(JalaliDate::date('Y/m/d - H:i',$discount->end_date)); ?>
                    </td>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>
</div>
<div id="discount-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" >&times;</button>
                <h5>افزودن تخیف</h5>
            </div>
            <div class="modal-body">
                <? $this->renderPartial('_discount_form',array('model' => new BookDiscounts(),'books' => $books)); ?>
            </div>
        </div>
    </div>
</div>