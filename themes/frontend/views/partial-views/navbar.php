<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Yii::app()->baseUrl ?>"><img src="<?php echo Yii::app()->theme->baseUrl.'/svg/logo.svg';?>" alt="<?php echo Yii::app()->name;?>"><h1>بــــــوک شــــــاپ<small>نزدیکترین کتابفروشی شهر</small></h1></a>
        </div>

        <div class="collapse navbar-collapse" id="mobile-menu">
            <?php
            echo CHtml::beginForm(array('/book/search'),'get',array('class'=>'navbar-form navbar-center'))
            ?>
                <div class="input-group">
                    <?php echo CHtml::textField('term',isset($_GET['term'])?CHtml::encode($_GET['term']):'',array('class'=>'form-control','placeholder'=>'جستجو کنید...')) ?>
                    <span class="input-group-btn">
                        <?php echo CHtml::submitButton('',array('name'=>'','class'=>'btn btn-default')) ?>
                    </span>
                </div>
            <?php
            echo CHtml::endForm();
            ?>
            <ul class="nav navbar-nav navbar-left">
                <li><a href="#categories-modal" data-toggle="modal">موضوعات</a></li>
                <li><a href="#">ثبت نام</a></li>
                <li><a href="#login-modal" data-toggle="modal">ورود</a></li>
            </ul>
        </div>
    </div>
</nav>