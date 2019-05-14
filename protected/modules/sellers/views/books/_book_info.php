<?php
/* @var $this PublishersBooksController */
/* @var $model Books */
/* @var $form CActiveForm */
/* @var $icon [] */
/* @var $tax string */
/* @var $commission string */
?>

<div class="container-fluid">
    <div class="form">

        <?= $this->renderPartial('//partial-views/_flashMessage'); ?>

        <div class="row">

            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('title');?>: </label>
                <?php echo $model->title ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('language');?>: </label>
                <?php echo $model->language ?>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>نویسنده: </label>
                <?php echo implode(',', $model->formAuthor) ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>مترجم: </label>
                <?php echo implode(',', $model->formTranslator) ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('number_of_pages');?>: </label>
                <?php echo $model->number_of_pages ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('category_id');?>: </label>
                <?php echo $model->category->title ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('isbn');?>: </label>
                <?php echo $model->isbn ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('status');?>: </label>
                <?php echo $model->status == 'enable' ? 'فعال' : 'غیرفعال' ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('description');?>: </label>
                <?php echo $model->description ?>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $model->getAttributeLabel('change_log');?>: </label>
                <?php echo $model->change_log ?>
            </div>

        </div>

    </div><!-- form -->
</div>