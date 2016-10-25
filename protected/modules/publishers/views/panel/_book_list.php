<?php
/* @var $data Books */
?>

<div class="tr">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-5"><a target="_blank" href="<?= $this->createUrl('/books/'.$data->id.'/'.urlencode($data->title)) ?>"><?php echo $data->title;?></a></div>
    <div class="col-lg-2 col-md-1 col-sm-1 hidden-xs"><?php echo ($data->status=='enable')?'فعال':'غیر فعال';?></div>
    <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs"><?php echo ($data->price==0)?'رایگان':Controller::parseNumbers(number_format($data->price,0)).' تومان';?></div>
    <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs"><?php echo ($data->printed_price==0)?'رایگان':Controller::parseNumbers(number_format($data->printed_price,0)).' تومان';?></div>
    <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs"><?= Controller::parseNumbers(number_format($data->download)) ?></div>
    <div class="col-lg-2 col-md-1 col-sm-1 col-xs-3">
        <span style="margin-right: 6px;font-size: 17px">
            <a class="icon-pencil text-info" href="<?php echo $this->createUrl('/publishers/books/update/'.$data->id);?>"></a>
        </span>
        <span style="font-size: 16px">
            <a class="icon-trash text-danger" href="<?php echo $this->createUrl('/publishers/books/delete/'.$data->id);?>"></a>
        </span>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><span class="label <?php if($data->confirm=='accepted')echo 'label-success';elseif($data->confirm=='refused' or $data->confirm=='change_required')echo 'label-danger';else echo 'label-info';?>"><?php echo $data->confirmLabels[$data->confirm];?></span></div>
</div>