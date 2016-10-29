<?php
/* @var $data Books */
?>

<tr>
    <td><a target="_blank" href="<?= $this->createUrl('/book/'.$data->id.'/'.urlencode($data->title)) ?>"><?php echo $data->title;?></a></td>
    <td><?php echo ($data->status=='enable')?'فعال':'غیر فعال';?></td>
    <td><?php echo ($data->price==0)?'رایگان':Controller::parseNumbers(number_format($data->price,0,',','.')).' تومان';?></td>
    <td><?php echo ($data->printed_price==0)?'رایگان':Controller::parseNumbers(number_format($data->printed_price,0,',','.')).' تومان';?></td>
    <td><?= Controller::parseNumbers(number_format($data->download)) ?></td>
    <td>
        <span style="margin-right: 6px;font-size: 17px">
            <a class="icon-pencil text-info" href="<?php echo $this->createUrl('/publishers/books/update/'.$data->id);?>"></a>
        </span>
        <span style="font-size: 16px">
            <a class="icon-trash text-danger" href="<?php echo $this->createUrl('/publishers/books/delete/'.$data->id);?>"></a>
        </span>
    </td>
    <td><span class="label <?php if($data->confirm=='accepted')echo 'label-success';elseif($data->confirm=='refused' or $data->confirm=='change_required')echo 'label-danger';else echo 'label-info';?>"><?php echo $data->confirmLabels[$data->confirm];?></span></td>
</tr>