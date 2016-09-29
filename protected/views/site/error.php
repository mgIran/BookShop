<?php
/* @var $this SiteController */
/* @var $error array */
?>

<!-----start-wrap--------->
<div class="wrap">
    <!-----start-content--------->
    <div class="content">
        <!-----start-logo--------->
        <div class="logo">
            <h1><?php echo $code; ?></h1>
            <span><img src="<?php echo Yii::app()->theme->baseUrl.'/images/signal.png';?>"/><?php echo CHtml::encode($message);?></span>
        </div>
        <!-----end-logo--------->
        <!-----start-search-bar-section--------->
        <div class="buttom">
            <div class="seach_bar">
                <p>شما می توانید به <span><a href="<?php echo $this->createAbsoluteUrl('//');?>">صفحه اصلی</a></span> بازگردید یا از همین جا جستجو کنید</p>
                <!-----start-sear-box--------->
                <div class="search_box">
                    <form>
                        <input type="text" placeholder="جستجو کنید..." ><input type="submit" value="">
                    </form>
                </div>
            </div>
        </div>
        <!-----end-sear-bar--------->
    </div>
</div>
<!---------end-wrap---------->