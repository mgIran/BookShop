<?php
/* @var $this PublicController */
/* @var $downloaded[] BookBuys */
/* @var $downloaded BookBuys */
?>

<div class="transparent-form">
    <h3>دانلود شده ها</h3>
    <p class="description">لیست کتاب هایی که دانلود کرده اید.</p>

    <table class="table">
        <thead>
        <tr>
            <td>زمان</td>
            <td>نام کتاب</td>
            <td>مبلغ</td>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($downloaded)):?>
            <tr>
                <td colspan="3" class="text-center">نتیجه ای یافت نشد.</td>
            </tr>
        <?php else:?>
            <?php foreach($downloaded as $buy):?>
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