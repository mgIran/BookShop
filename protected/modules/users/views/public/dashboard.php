<?php
/* @var $this PublicController */
/* @var $model Users */
$tab ='credit-tab';
if(isset($_GET['tab']))
    $tab = $_GET['tab'];
?>
<div class="statistics">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="green">
            <h4>اعتبار</h4>
            <span>مانده اعتبار</span>
            <h3><?php echo number_format($model->userDetails->credit, 0, ',', '.');?> تومان</h3>
            <a href="<?php echo $this->createUrl('/users/credit/buy');?>">خرید اعتبار<i class="arrow-icon"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="red">
            <h4>نشان شده ها</h4>
            <span>تعداد کتاب</span>
            <h3><?php echo number_format(count($model->userDetails->user->bookmarkedBooks), 0, ',', '.');?> کتاب</h3>
            <a href="<?php echo Yii::app()->createUrl('users/public/bookmarked');?>">نشان شده ها<i class="arrow-icon"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="blue">
            <h4>کتابخانه من</h4>
            <span>تعداد کتاب</span>
            <h3>10 کتاب</h3>
            <a href="#">کتابخانه من<i class="arrow-icon"></i></a>
        </div>
    </div>
</div>
<div class="tabs tables">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#downloaded"><h5>دانلود شده ها<small> / 2 مورد</small></h5></a></li>
        <li><a data-toggle="tab" href="#transactions"><h5>تراکنش ها<small> / <?php echo number_format(count($model->transactions), 0, ',', '.');?> تراکنش</small></h5></a></li>
    </ul>
    <div class="tab-content">
        <div id="downloaded" class="tab-pane fade in active">
            <table class="table">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>نویسنده</th>
                    <th>ناشر</th>
                    <th>قیمت</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>دیدم که جانم میرود</td>
                    <td>حمید داوود آبادی</td>
                    <td>نشر شهید کاظمی</td>
                    <td>4.000 تومان</td>
                </tr>
                <tr>
                    <td>دختر شینا</td>
                    <td>قدم خیر محمدی</td>
                    <td>معروف</td>
                    <td>1.500 تومان</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div id="transactions" class="tab-pane fade">
            <?php if(empty($model->transactions)):?>
                نتیجه ای یافت نشد.
            <?php else:?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>زمان</th>
                        <th>مبلغ</th>
                        <th>توضیحات</th>
                        <th>کد رهگیری</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($model->transactions as $transaction):?>
                            <tr>
                                <td><?php echo JalaliDate::date('d F Y - H:i', $transaction->date);?></td>
                                <td><?php echo number_format($transaction->amount, 0).' تومان';?></td>
                                <td><?php echo CHtml::encode($transaction->description);?></td>
                                <td><?php echo CHtml::encode($transaction->token);?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="offers">
    <div class="head">
        <h4>پیشنهاد ما به شما</h4>
    </div>
    <div class="is-carousel auto-width" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-nav="1" data-dots="1">
        <div class="thumbnail-container">
            <div class="thumbnail simple">
                <div class="thumb">
                    <a href="#" title="عنوان کتاب">
                        <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >
                        <div class="thumbnail-overlay"></div>
                        <div class="thumbnail-overlay-icon">
                            <i class="icon"></i>
                        </div>
                    </a>
                </div>
                <div class="caption">
                    <div class="stars">
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon off"></i>
                    </div>
                    <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
                    <span class="price">رایگان</span>
                    <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                </div>
            </div>
        </div>
        <div class="thumbnail-container">
            <div class="thumbnail simple">
                <div class="thumb">
                    <a href="#" title="عنوان کتاب">
                        <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >
                        <div class="thumbnail-overlay"></div>
                        <div class="thumbnail-overlay-icon">
                            <i class="icon"></i>
                        </div>
                    </a>
                </div>
                <div class="caption">
                    <div class="stars">
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon off"></i>
                    </div>
                    <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                    <span class="price">رایگان</span>
                    <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                </div>
            </div>
        </div>
        <div class="thumbnail-container">
            <div class="thumbnail simple">
                <div class="thumb">
                    <a href="#" title="عنوان کتاب">
                        <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >
                        <div class="thumbnail-overlay"></div>
                        <div class="thumbnail-overlay-icon">
                            <i class="icon"></i>
                        </div>
                    </a>
                </div>
                <div class="caption">
                    <div class="stars">
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon off"></i>
                    </div>
                    <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                    <span class="price">رایگان</span>
                    <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                </div>
            </div>
        </div>
        <div class="thumbnail-container">
            <div class="thumbnail simple">
                <div class="thumb">
                    <a href="#" title="عنوان کتاب">
                        <img src="uploads/books/images/914.jpg" alt="نام کتاب" >
                        <div class="thumbnail-overlay"></div>
                        <div class="thumbnail-overlay-icon">
                            <i class="icon"></i>
                        </div>
                    </a>
                </div>
                <div class="caption">
                    <div class="stars">
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon off"></i>
                    </div>
                    <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>
                    <span class="price">4.000 تومان</span>
                    <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                </div>
            </div>
        </div>
        <div class="thumbnail-container">
            <div class="thumbnail simple">
                <div class="thumb">
                    <a href="#" title="عنوان کتاب">
                        <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >
                        <div class="thumbnail-overlay"></div>
                        <div class="thumbnail-overlay-icon">
                            <i class="icon"></i>
                        </div>
                    </a>
                </div>
                <div class="caption">
                    <div class="stars">
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon off"></i>
                    </div>
                    <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>
                    <span class="price">1.500 تومان</span>
                    <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                </div>
            </div>
        </div>
        <div class="thumbnail-container">
            <div class="thumbnail simple">
                <div class="thumb">
                    <a href="#" title="عنوان کتاب">
                        <img src="uploads/books/images/8420.jpg" alt="نام کتاب" >
                        <div class="thumbnail-overlay"></div>
                        <div class="thumbnail-overlay-icon">
                            <i class="icon"></i>
                        </div>
                    </a>
                </div>
                <div class="caption">
                    <div class="stars">
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon off"></i>
                    </div>
                    <h4><a href="#" title="عنوان کتاب">مزرعه حیوانات</a></h4>
                    <span class="price">1.500 تومان</span>
                    <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                </div>
            </div>
        </div>
        <div class="thumbnail-container">
            <div class="thumbnail simple">
                <div class="thumb">
                    <a href="#" title="عنوان کتاب">
                        <img src="uploads/books/images/12210.jpg" alt="نام کتاب" >
                        <div class="thumbnail-overlay"></div>
                        <div class="thumbnail-overlay-icon">
                            <i class="icon"></i>
                        </div>
                    </a>
                </div>
                <div class="caption">
                    <div class="stars">
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon"></i>
                        <i class="icon off"></i>
                    </div>
                    <h4><a href="#" title="عنوان کتاب">مطلع مهر</a></h4>
                    <span class="price">1.500 تومان</span>
                    <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="container dashboard-container">
    <ul class="nav nav-tabs">
        <li <?= ($tab && $tab=="credit-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#credit-tab">اعتبار</a>
        </li>
        <li <?= ($tab && $tab=="transactions-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#transactions-tab">تراکنش ها</a>
        </li>
        <li <?= ($tab && $tab=="buys-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#buys-tab">خریدها</a>
        </li>
        <li <?= ($tab && $tab=="bookmarks-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#bookmarks-tab">نشان شده ها</a>
        </li>
        <li>
            <a href="<?= $this->createUrl('/tickets/manage/') ?>">پشتیبانی</a>
        </li>
        <li <?= ($tab && $tab=="setting-tab"?'class="active"':'') ?>>
            <a data-toggle="tab" href="#setting-tab">تنظیمات</a>
        </li>
    </ul>
    <?php if(Yii::app()->user->roles!='publisher'):?>
        <a class="btn btn-danger publisher-signup-link" href="<?php echo Yii::app()->createUrl('/publishers/panel/signup/step/agreement')?>">ناشر شوید</a>
    <?php elseif(Yii::app()->user->roles=='publisher'):?>
        <a class="btn btn-success publisher-signup-link" href="<?php echo Yii::app()->createUrl('/publishers/panel')?>">پنل ناشران</a>
    <?php endif;?>

    <div class="tab-content">

        <div id="transactions-tab" class="tab-pane fade <?= ($tab && $tab=="transactions-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_transactions',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="buys-tab" class="tab-pane fade <?= ($tab && $tab=="buys-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_buys_list',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="setting-tab" class="tab-pane fade <?= ($tab && $tab=="setting-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_setting',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="bookmarks-tab" class="tab-pane fade <?= ($tab && $tab=="bookmarks-tab"?'in active':'') ?>">
            <?php $this->renderPartial('_bookmarks',array(
                'model'=>$model,
            ));?>
        </div>
    </div>
</div>