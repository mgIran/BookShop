<?php /* @var $books array */ ?>

<table class="table">
    <thead>
    <tr>
        <th>شرح محصول</th>
        <th class="text-center">تعداد</th>
        <th class="text-center hidden-xs">قیمت واحد</th>
        <th class="text-center hidden-xs">قیمت کل</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($books as $position => $book):?>
        <?php if(@$model = Books::model()->findByPk($book['book_id'])):?>
            <?php if(@$package = BookPackages::model()->findByPk($book['package'])):?>
                <tr>
                    <td>
                        <img src="<?php echo Yii::app()->baseUrl."/uploads/books/icons/".$model->icon;?>" alt="<?php echo CHtml::encode($model->title);?>" class="hidden-xs hidden-sm">
                        <div class="info">
                            <h4><?php echo CHtml::encode($model->title);?></h4>
                            <span class="item hidden-xs">نویسنده: <span class="value"><?php echo $model->getPersonsTags("نویسنده", "fullName", true, "span");?></span></span>
                            <span class="item hidden-xs">ناشر: <span class="value"><?php echo CHtml::encode($model->getPublisherName());?></span></span>
                            <span class="item hidden-xs">سال چاپ: <span class="value"><?php echo Controller::parseNumbers($model->lastPrintedPackage->print_year);?></span></span>
                            <span class="item hidden-xs">تعداد صفحات: <span class="value"><?php echo Controller::parseNumbers($model->number_of_pages);?> صفحه</span></span>
                        </div>
                    </td>
                    <td class="vertical-middle text-center">
                        <strong><?php echo Controller::parseNumbers($book["qty"]);?></strong> عدد
                    </td>
                    <td class="vertical-middle text-center hidden-xs">
                        <?php $price = $model->getPrinted_price();?>
                        <?php if($model->lastPrintedPackage->hasDiscount()):?>
                            <?php $off = $model->lastPrintedPackage->getOffPrice();?>
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
                </tr>
            <?php endif;?>
        <?php endif;?>
    <?php endforeach;?>
    </tbody>
</table>