<?php
/* @var $this ShopCartController */
/* @var $books Books[] */
/* @var $model Books */
/* @var $package BookPackages */
if($books):?>
    <table class="table">
        <thead>
        <tr>
            <th>شرح محصول</th>
            <th class="text-center">تعداد</th>
            <th class="text-center hidden-xs">قیمت واحد</th>
            <th class="text-center hidden-xs">قیمت کل</th>
            <th class="hidden-xs"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($books as $position => $book):?>
            <?php if(@$model = Books::model()->findByPk($book['book_id'])):?>
                <?php if(@$package = BookPackages::model()->findByPk($book['package'])):?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->createUrl("/book/".$model->id."/".urlencode($model->title));?>"><img src="<?php echo Yii::app()->baseUrl."/uploads/books/icons/".$model->icon;?>" alt="<?php echo CHtml::encode($model->title);?>" class="hidden-xs hidden-sm"></a>
                            <div class="info">
                                <h4><a href="<?php echo $this->createUrl("/book/".$model->id."/".urlencode($model->title));?>"><?php echo CHtml::encode($model->title);?></a></h4>
                                <span class="item hidden-xs">نویسنده: <span class="value"><?php echo $model->getPersonsTags("نویسنده", "fullName", true, "span");?></span></span>
                                <span class="item hidden-xs">ناشر: <span class="value"><?php echo CHtml::encode($model->getPublisherName());?></span></span>
                                <?php if($package->type == BookPackages::TYPE_PRINTED):?>
                                    <span class="item hidden-xs">نوبت چاپ: <span class="value"><?php echo Controller::parseNumbers($package->print_year);?></span></span>
                                <?php endif;?>
                                <span class="item hidden-xs">تعداد صفحات: <span class="value"><?php echo Controller::parseNumbers($model->number_of_pages);?> صفحه</span></span>
                            </div>
                        </td>
                        <td class="vertical-middle text-center">
<!--                            --><?php //echo CHtml::dropDownList('qty_'.$position, $book["qty"], Shop::$qtyList, array("class"=>"quantity", "data-id"=>$position));?>
                            <div class="input-group">
                                <?php echo CHtml::textField('qty_'.$position, $book["qty"], array("class"=>"quantity", "id"=>"quantity-".$position));?>
                                <?php echo CHtml::button('ثبت', array("class"=>"btn input-group-addon quantity-btn", "data-id"=>$position));?>
                            </div>
                            <?php echo CHtml::link("حذف", array('//shop/cart/remove'), array("class"=>"remove hidden-lg hidden-md hidden-sm", 'data-message' => 'آیا از حذف این کتاب مطمئن هستید؟', 'data-id' => $position));?>
                        </td>
                        <td class="vertical-middle text-center hidden-xs">
                            <?php $price = ($package->type == BookPackages::TYPE_PRINTED ? $package->printed_price : $package->electronic_price);?>
                            <?php if($package->hasDiscount()):?>
                                <?php $off = $package->getOffPrice();?>
                                <?php if($package->cover_price != $package->printed_price):?>
                                    <div class="price">قیمت روی جلد: <span class="text-line-through"><?php echo Controller::parseNumbers(number_format($package->cover_price))?><small> تومان</small></span></div>
                                <?php endif;?>
                                <div class="price">قیمت فروش: <span class="text-line-through"><?= Controller::parseNumbers(number_format($model->printed_price, 0)); ?><small> تومان</small></span></div>
                                <span class="price center-block">قیمت همراه با تخفیف: <?= Controller::parseNumbers(number_format($off, 0)); ?><small> تومان</small></span>
                            <?php else:?>
                                <?php if($package->cover_price != $package->printed_price):?>
                                    <div class="price">قیمت روی جلد: <span class="text-line-through"><?php echo Controller::parseNumbers(number_format($package->cover_price))?><small> تومان</small></span></div>
                                    <span class="price">قیمت فروش: <?php echo Controller::parseNumbers(number_format($price))?><small> تومان</small></span>
                                <?php else:?>
                                    <span class="price"><?php echo Controller::parseNumbers(number_format($price))?><small> تومان</small></span>
                                <?php endif;?>
                            <?php endif;?>
                        </td>
                        <td class="vertical-middle text-center hidden-xs">
                            <span class="price"><?php echo Controller::parseNumbers(number_format((double)($book["qty"]*$package->getOffPrice())))?><small> تومان</small></span>
                        </td>
                        <td class="vertical-middle text-center hidden-xs">
                            <?php echo CHtml::link("حذف", array('//shop/cart/remove'), array("class"=>"remove", 'data-message' => 'آیا از حذف این کتاب مطمئن هستید؟', 'data-id' => $position));?>
                        </td>
                    </tr>
                <?php endif;?>
            <?php endif;?>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left total-container">
        <div class="row">
            <?php $cartStatistics=Shop::getPriceTotal(); ?>
            <ul class="list-group green-list">
                <li class="list-group-item">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">جمع کل خرید شما</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalPrice"]));?><small> تومان</small></div>
                </li>
                <li class="list-group-item">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 tax-container">تخفیف</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalDiscount"]));?><small> تومان</small></div>
                </li>
                <li class="list-group-item">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 total">مبلغ قابل پرداخت</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 price text-center total-value"><?php echo Controller::parseNumbers(number_format($cartStatistics["cartPrice"]));?><small> تومان</small></div>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="buttons">
        <a href="<?php echo $this->createUrl("/site");?>" class="btn-black pull-right">بازگشت به صفحه اصلی</a>
        <a href="<?php echo $this->createUrl("/shop/order/create");?>" class="btn-blue pull-left">انتخاب شیوه ارسال</a>
    </div>
<?php else:?>
    <div class="empty-message">
        <h4>سبد خرید شما خالی می باشد<small>جهت خرید کتاب می توانید به لیست کتاب ها مراجعه کنید.</small></h4>
        <a class="btn-blue" href="<?php echo $this->createUrl("/book/index");?>">لیست کتاب ها</a>
    </div>
<?php endif;?>