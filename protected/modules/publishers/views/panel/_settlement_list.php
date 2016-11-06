<?php
/* @var $data UserSettlement */
?>

<tr>
    <td><?php echo CHtml::encode(number_format($data->amount, 0));?> تومان</td>
    <td><?php echo JalaliDate::date('d F Y - H:i', $data->date);?></td>
    <td>IR<?php echo CHtml::encode($data->iban);?></td>
</tr>