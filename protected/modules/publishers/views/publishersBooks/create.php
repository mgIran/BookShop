<?php
/* @var $this BooksController */
/* @var $model Books */
?>

<div class="container">
    <h3>افزودن کتاب جدید</h3>

    <?php $this->renderPartial("//layouts/_flashMessage") ?>

    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#">اطلاعات کتاب</a>
        </li>
        <li class="disabled" >
            <a href="#">نوبت های چاپ کتاب</a>
        </li>
        <li class="disabled">
            <a href="#">تصاویر کتاب</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="platform" class="tab-pane fade in active">
            <?php $this->renderPartial('_form', array(
                'model'=>$model,
                'icon'=>$icon,
                'tax'=>$tax,
                'commission'=>$commission,
            )); ?>
        </div>
    </div>
</div>