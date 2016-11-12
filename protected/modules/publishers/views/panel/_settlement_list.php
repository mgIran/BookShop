<?php
/* @var $this PublishersPanelController */
/* @var $data UserSettlement */
$this::$sumSettlement += $data->amount;
?>

<tr>
    <td><?php echo CHtml::encode(Controller::parseNumbers(number_format($data->amount, 0)));?> تومان</td>
    <td><?php echo JalaliDate::date('d F Y - H:i', $data->date);?></td>
    <td><?php echo CHtml::encode($data->token) ?></td>
    <td>IR<?php echo CHtml::encode($data->iban);?></td>
</tr>