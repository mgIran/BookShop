<?php
/* @var $this ShopOrderController */
/* @var $message string */
?>
<div class="page">
    <div class="page-heading">
        <div class="container">
            <h1>جزئیات سفارش</h1>
        </div>
    </div>
    <div class="container page-content">
        <div class="white-box cart">
            <div class="payment-message">
                <?php $this->renderPartial("//partial-views/_flashMessage");?>
                <div class="desc"><?php echo $message;?></div>
                <div class="overflow-hidden alert-warning alert">
                    <div class="text-center">شما می توانید مجددا مبلغ سفارش را با یکی از روش های زیر پرداخت نمایید تا سفارش شما تکمیل شود.</div>
                    <div class="buttons center-block text-center">
                        <input type="button" class="btn-green btn-sm" value="پرداخت اینترنتی"><input type="button" class="btn-blue btn-sm" value="پرداخت در محل"><input type="button" class="btn-red btn-sm" value="کسر از اعتبار">
                    </div>
                </div>
            </div>
            <div class="order-details table-responsive">
                <h5>خلاصه وضعیت سفارش</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="green-text">شماره رسید</th>
                            <th>قیمت کل</th>
                            <th class="red-text">وضعیت پرداخت</th>
                            <th>وضعیت سفارش</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="green-text">KBC-15056633</td>
                            <td><span class="price">63.000<small> تومان</small></span></td>
                            <td class="red-text">در انتظار پرداخت</td>
                            <td>تایید شده</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="shipping-details table-responsive">
                <h5>اطلاعات ارسالی سفارش</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>تحویل گیرنده</th>
                            <th>آدرس</th>
                            <th>شماره های تماس</th>
                            <th>شیوه ارسال</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>مسعود قراگوزلو</td>
                            <td> بلوار سوم خرداد خیابان شهید شوندی کوچه 12 پلاک 5 </td>
                            <td> 38846821-09373252746 </td>
                            <td>تحويل اکسپرس ديجي‌کالا (هزينه ارسال 8000 تومان ثابت)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="transaction-details table-responsive">
                <h5>جزییات پرداخت های شما</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نوع پرداخت</th>
                        <th>درگاه پرداخت</th>
                        <th>شماره رسید</th>
                        <th>تاریخ</th>
                        <th>مبلغ</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>پرداخت اینترنتی</td>
                            <td>زرین پال</td>
                            <td>KBC-15056633</td>
                            <td>1395 بهمن 29</td>
                            <td><span class="price">63.000<small> تومان</small></span></td>
                            <td class="red-text">پرداخت ناموفق</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <ul class="steps after-accept in-verify">
                <li class="done">
                    <div>تایید سفارش</div>
                </li>
                <li class="doing">
                    <div>پرداخت</div>
                </li>
                <li>
                    <div>پردازش انبار</div>
                </li>
                <li>
                    <div>در حال ارسال</div>
                </li>
                <li>
                    <div>تحویل شده</div>
                </li>
            </ul>
        </div>
    </div>
</div>