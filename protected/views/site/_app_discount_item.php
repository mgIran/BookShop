<?php
/* @var $data AppDiscounts */
$app = $data->app;
if($app && $app->hasDiscount()) {
    ?>

    <div class="app-item <?=$app->hasDiscount()?'discount':''?>">
        <div class="app-item-content">
            <div class="pic">
                <div>
                    <a href="<?php echo Yii::app()->createUrl('/books/'.$app->id.'/'.urlencode($app->lastPackage->package_name)); ?>">
                        <img src="<?php echo Yii::app()->baseUrl.'/uploads/books/icons/'.CHtml::encode($app->icon); ?>">
                    </a>
                </div>
            </div>
            <div class="detail">
                <div class="app-title">
                    <a href="<?php echo Yii::app()->createUrl('/books/'.$app->id.'/'.urlencode($app->lastPackage->package_name)); ?>">
                        <?php echo CHtml::encode($app->title); ?>
                        <span class="paragraph-end"></span>
                    </a>
                </div>
                <div class="app-any">
                    <span class="app-price">
                        <?
                        if($app->hasDiscount()):
                            ?>
                            <span class="text-danger text-line-through center-block"><?= Controller::parseNumbers(number_format($app->price, 0)).' تومان'; ?></span>
                            <span ><?= Controller::parseNumbers(number_format($app->offPrice, 0)).' تومان' ; ?></span>
                            <?
                        else:
                            ?>
                            <span ><?= $app->price?Controller::parseNumbers(number_format($app->price, 0)).' تومان':'رایگان'; ?></span>
                            <?
                        endif;
                        ?>
                    </span>
                    <span class="app-rate">
                        <?= Controller::printRateStars($app->rate); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?
}