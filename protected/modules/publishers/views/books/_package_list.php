<?php
/* @var $data BookPackages*/
?>

<tr>
    <td><?php echo CHtml::encode($data->version);?></td>
    <td><?php echo Controller::fileSize(Yii::getPathOfAlias("webroot") . '/uploads/books/files/'.$data->file_name);?></td>
    <td><?php echo JalaliDate::date('d F Y', $data->create_date);?></td>
    <td><?php if($data->status=='accepted')echo JalaliDate::date('d F Y', $data->publish_date);else echo '-';?></td>
    <td><?php echo Controller::parseNumbers(number_format($data->price)).' تومان'?></td>
    <td><?php echo Controller::parseNumbers(number_format($data->printed_price)).' تومان'?></td>
    <td>
        <span class="label <?php if($data->status=='accepted')echo 'label-success';elseif($data->status=='refused' || $data->status=='change_required')echo 'label-danger';else echo 'label-info';?>">
            <?php echo CHtml::encode($data->statusLabels[$data->status]);?>
        </span>
        <?php if($data->status=='refused' or $data->status=='change_required'):?>
            <a class="btn btn-info btn-xs" style="margin-right: 5px;margin-top: 5px;" data-toggle="collapse" data-parent="#packages-list" href="#reason-<?php echo $data->id?>">دلیل</a>
        <?php endif;?>
    </td>
    <?php if($data->status=='refused' or $data->status=='change_required'):?>
        <td id="reason-<?php echo $data->id?>" class="collapse">
            <div class="reason-collapse">
                <?php if($data->status=='refused'):?>
                    <p>این نوبت چاپ به دلایل زیر رد شده است:</p>
                <?php elseif($data->status=='change_required'):?>
                    <p>این نوبت چاپ نیاز به تغییرات زیر دارد:</p>
                <?php endif;?>
                <?php echo CHtml::encode($data->reason);?>
            </div>
        </td>
    <?php endif;?>
</tr>
