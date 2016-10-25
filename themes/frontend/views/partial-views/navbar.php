<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="<?php echo Yii::app()->theme->baseUrl.'/svg/logo.svg';?>" alt="<?php echo Yii::app()->name;?>"><h1>بــــــوک شــــــاپ<small>نزدیکترین کتابفروشی شهر</small></h1></a>
        </div>

        <div class="collapse navbar-collapse" id="mobile-menu">
            <form class="navbar-form navbar-center">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="جستجو کنید...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"></button>
                    </span>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-left">
                <li><a href="#categories-modal" data-toggle="modal">موضوعات</a></li>
                <li><a href="#">ثبت نام</a></li>
                <li><a href="#login-modal" data-toggle="modal">ورود</a></li>
            </ul>
        </div>
    </div>
</nav>