<?php
/* @var $this PublicController */
/* @var $transactions[] UserTransactions */
/* @var $transaction UserTransactions */
?>

<div class="transparent-form">
    <h3>تراکنش ها</h3>
    <p class="description">لیست تراکنش هایی که انجام داده اید.</p>

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
        <?php if(empty($transactions)):?>
            <tr>
                <td colspan="4" class="text-center">نتیجه ای یافت نشد.</td>
            </tr>
        <?php else:?>
            <?php foreach($transactions as $transaction):?>
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