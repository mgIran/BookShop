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
            <tr>
                <td>
                    <img src="<?php echo Yii::app()->baseUrl."/uploads/books/icons/".$model->icon;?>" alt="<?php echo CHtml::encode($model->title);?>" class="hidden-xs hidden-sm">
                    <div class="info">
                        <h4><?php echo CHtml::encode($model->title);?></h4>
                        <span class="item hidden-xs">نویسنده: <span class="value"><?php echo $model->getPersonsTags("نویسنده", "fullName", true, "span");?></span></span>
                        <span class="item hidden-xs">ناشر: <span class="value"><?php echo CHtml::encode($model->getPublisherName());?></span></span>
                        <span class="item hidden-xs">سال چاپ: <span class="value"><?php echo Controller::parseNumbers($model->lastPackage->print_year);?></span></span>
                        <span class="item hidden-xs">تعداد صفحات: <span class="value"><?php echo Controller::parseNumbers($model->number_of_pages);?> صفحه</span></span>
                    </div>
                </td>
                <td class="vertical-middle text-center">
                    <strong><?php echo $book["qty"];?></strong>
                </td>
                <td class="vertical-middle text-center hidden-xs">
                    <span class="price"><?php echo Controller::parseNumbers(number_format($model->getPrinted_price()))?><small> تومان</small></span>
                </td>
                <td class="vertical-middle text-center hidden-xs">
                    <span class="price"><?php echo Controller::parseNumbers(number_format((double)($book["qty"]*$model->getPrinted_price())))?><small> تومان</small></span>
                </td>
            </tr>
        <?php endif;?>
    <?php endforeach;?>
    </tbody>
</table>