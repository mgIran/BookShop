<?php /* @var $data ShopShippingMethod */ ?>
<div class="shipping-method-item">
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 radio-container">
        <div class="radio-control">
            <?php echo CHtml::radioButton("ShippingMethod", false, array("id"=>"shipping-method-".$data->id, "value"=>$data->id));?>
            <?php echo CHtml::label("", "shipping-method-".$data->id);?>
        </div>
    </div>
    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 info-container">
        <div class="pull-right">
            <h5 class="name"><?= CHtml::encode($data->title) ?></h5>
            <div class="desc"><?= strip_tags($data->description) ?></div>
        </div>
        <div class="pull-left">
            <span>هزینه ارسال</span>
            <div class="price"><?= Controller::parseNumbers(number_format($data->price)) ?><small> تومان</small></div>
        </div>
    </div>
</div>