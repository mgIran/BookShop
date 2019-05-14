<?php
/* @var $this PublishersBooksController */
/* @var $model Books */
?>

<div class="white-form">
    <h3>افزودن کتاب جدید</h3>
    <p class="description">جهت ثبت کتاب لطفا فرم زیر را پر کنید.</p>

    <?php $this->renderPartial("//partial-views/_flashMessage") ?>
    <div class="alert alert-success save-package-message hidden"></div>

    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#">اطلاعات کتاب</a>
        </li>
        <li class="disabled" >
            <a href="#">نسخه چاپی</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="platform" class="tab-pane fade in active">
            <?php $this->renderPartial('_form', array(
                'model'=>$model,
                'icon'=>$icon,
                'previewFile' => $previewFile,
                'tax'=>$tax,
                'commission'=>$commission,
            )); ?>
        </div>
    </div>
</div>