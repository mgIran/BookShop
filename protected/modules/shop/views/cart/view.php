<?php
/* @var $this ShopCartController */
/* @var $cart Books[] */
/* @var $model Books */
?>
<div class="page">
	<div class="page-heading">
		<div class="container">
			<h1>سبد خرید شما</h1>
		</div>
	</div>
	<div class="container page-content">
		<div class="white-box cart">
			<table class="table table-striped">
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
                        <tr>
                            <td>
                                <img src="<?php echo Yii::app()->baseUrl."/uploads/books/icons/".$model->icon;?>" alt="<?php echo CHtml::encode($model->title);?>" class="hidden-xs hidden-sm">
                                <div class="info">
                                    <h4><?php echo CHtml::encode($model->title);?></h4>
                                    <span class="item hidden-xs">نویسنده: <span class="value"><?php echo CHtml::encode($model->getPerson("نویسنده"));?></span></span>
                                    <span class="item hidden-xs">ناشر: <span class="value"><?php echo CHtml::encode($model->getPublisherName());?></span></span>
                                    <span class="item hidden-xs">سال چاپ: <span class="value"><?php echo CHtml::encode($model->lastPackage->print_year);?></span></span>
                                    <span class="item hidden-xs">تعداد صفحات: <span class="value"><?php echo CHtml::encode($model->number_of_pages);?> صفحه</span></span>
                                </div>
                            </td>
                            <td class="vertical-middle text-center">
                                <?php echo CHtml::dropDownList('qty_'.$position, $book["qty"], array(1,2,3,4,5,6,7,8,9,10), array("class"=>"quantity"));?>
                                <?php CHtml::link("حذف", array('//shop/cart/remove', 'id' => $position), array("class"=>"remove", 'confirm' => Shop::t('Are you sure?')));?>
                            </td>
                            <td class="vertical-middle text-center hidden-xs">
                                <span class="price"><?php echo Controller::parseNumbers(number_format($model->lastPackage->price))?><small> تومان</small></span>
                            </td>
                            <td class="vertical-middle text-center hidden-xs">
                                <span class="price"><?php echo Controller::parseNumbers(number_format($book["qty"]*$model->lastPackage->price))?><small> تومان</small></span>
                            </td>
                            <td class="vertical-middle text-center hidden-xs">
                                <?php CHtml::link("حذف", array('//shop/cart/remove', 'id' => $position), array("class"=>"remove", 'confirm' => Shop::t('Are you sure?')));?>
                            </td>
                        </tr>
                    <?php endif;?>
                <?php endforeach;?>
				</tbody>
			</table>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left total-container">
				<div class="row">
                    <?php $cartStatistics=Shop::getPriceTotal();?>
					<ul class="list-group green-list">
						<li class="list-group-item">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">جمع کل خرید شما</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalPrice"]));?><small> تومان</small></div>
						</li>
						<li class="list-group-item">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 tax-container">مالیات بر ارزش افزوده<small> (9 درصد)</small></div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 price text-center"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalTax"]));?><small> تومان</small></div>
						</li>
						<li class="list-group-item">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 total">مبلغ قابل پرداخت</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 price text-center total-value"><?php echo Controller::parseNumbers(number_format($cartStatistics["totalPayment"]));?><small> تومان</small></div>
						</li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="buttons">
				<input type="submit" class="btn-black pull-right" value="بازگشت به صفحه اصلی">
				<input type="submit" class="btn-blue pull-left" value="انتخاب شیوه ارسال">
			</div>
		</div>
	</div>
</div>