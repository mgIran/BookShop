<?php
/* @var $data BookPackages*/
?>

<tr>
    <td><?php echo CHtml::encode($data->version);?></td>
    <td><?php echo JalaliDate::date('d F Y', $data->create_date);?></td>
    <td><?php echo $data->publish_date ? JalaliDate::date('d F Y', $data->publish_date) : '-';?></td>
    <td><?php echo ($data->printed_price==0)?'رایگان':(Controller::parseNumbers(number_format($data->printed_price)).' تومان');?></td>
<!--    <td>--><?php //echo Controller::parseNumbers(number_format($data->printed_price)).' تومان'?><!--</td>-->
    <td>
        <?php if($data->user_id == Yii::app()->user->getId()):?>
            <span style="margin-right: 6px;font-size: 17px">
                <a class="icon-pencil text-info" href="<?php echo $this->createUrl('/sellers/books/updatePackage/'.$data->id);?>"></a>
            </span>
            <span style="font-size: 16px">
                <a class="icon-trash text-danger delete-package" href="<?php echo $this->createUrl('/sellers/books/deletePackage/'.$data->id);?>"></a>
            </span>
        <?php endif;?>
    </td>
</tr>
