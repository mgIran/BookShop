<?php
/* @var $this BooksController */
/* @var $model Books */
/* @var $form CActiveForm */
/* @var $tax string */
/* @var $commission string */
?>

<div class="container-fluid">
    <div class="form col-md-6">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'books-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true
        )
    ));
    echo $form->hiddenField($model,'platform_id');
    ?>
        <?= $this->renderPartial('//layouts/_flashMessage'); ?>

        <div class="form-group">
            <?php echo $form->textField($model,'title',array('placeholder'=>$model->getAttributeLabel('title').' *','maxlength'=>50,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->dropDownList($model,'category_id',BookCategories::model()->sortList(),array('prompt'=>'لطفا دسته مورد نظر را انتخاب کنید *','class'=>'form-control')); ?>
            <?php echo $form->error($model,'category_id'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->dropDownList($model,'status',array('enable'=>'فعال','disable'=>'غیرفعال',),array('class'=>'form-control')); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>

        <div class="form-group">
            <br>
            <h5>نوع قیمت گذاری</h5>
            <?php
            if($model->price == 0)
            {
                $r = 'free';
                $p = null;
            }
            else if($model->price == -1)
            {
                $r = 'in-app-payment';
                $p = null;
            }else
            {
                $r = 'online-payment';
                $p = $model->price;
            }
            echo CHtml::radioButtonList('priceType',$r,array('online-payment'=>'پرداخت آنلاین','in-app-payment'=>'پرداخت درون برنامه ای','free'=>'رایگان'),
                array(
                    'class'=>'form-control priceType',
                )
            );
            Yii::app()->clientScript->registerScript('priceType', '
                $("body").on("change",".priceType",function(){
                    var priceType = $(this).val();
                    var priceInput = $("#price-input");
                    $(\'.portion\').addClass(\'hidden\');
                    $(\'#tax-tag\').text("");
                    $(\'#market-portion\').text("");
                    $(\'#publisher-portion\').text("");
                    switch(priceType){
                        case \'free\':
                            priceInput.val("").attr("disabled",true).attr("readonly",true);
                            break;
                        case \'in-app-payment\':
                            priceInput.val("").attr("disabled",true).attr("readonly",true);
                            break;
                        case \'online-payment\':
                            priceInput.val("").attr("disabled",false).attr("readonly",false);
                            break;
                    }
                });
            ');
            ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::textField('Books[price]',$p,array(
                'placeholder'=>$model->getAttributeLabel('price').' (تومان) *',
                'class'=>'form-control price',
                'id'=>'price-input',
                'disabled' => $model->price>0?false:true,
                'readonly' => $model->price>0?false:true
            )); ?>
            <div class="desc portion hidden" style="margin: 15px 0;">
                <p><b>سهم توسعه دهنده:</b><span id="publisher-portion">0</span> تومان</p>
                <p><b>سهم <?= Yii::app()->name ?>:</b><span id="market-portion">0</span> تومان</p>
                <p><b>مالیات:</b><span id="tax-tag">0</span> تومان</p>
            </div>
            <?php echo $form->error($model,'price'); ?>
            <?php echo CHtml::hiddenField('tax', $tax);?>
            <?php echo CHtml::hiddenField('commission', $commission);?>
            <?php Yii::app()->clientScript->registerScript('portion', "
                $('#price-input').on('keydown', function(e){
                    if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8)
                        return true;
                    else
                        return false;
                });
                if($('#price-input').val()!='') {
                    $('.portion').removeClass('hidden');
                    var price=$(this).val();
                    $('#tax-tag').text((price*parseInt($('#tax').val()))/100);
                    $('#market-portion').text((price*parseInt($('#commission').val()))/100);
                    $('#publisher-portion').text(price-parseInt($('#tax-tag').text())-parseInt($('#market-portion').text()));
                }
                else
                    $('.portion').addClass('hidden');
                $('#price-input').on('keyup', function(e){
                    if($(this).val()!='') {
                        $('.portion').removeClass('hidden');
                        var price=$(this).val();
                        $('#tax-tag').text((price*parseInt($('#tax').val()))/100);
                        $('#market-portion').text((price*parseInt($('#commission').val()))/100);
                        $('#publisher-portion').text(price-parseInt($('#tax-tag').text())-parseInt($('#market-portion').text()));
                    }
                    else
                        $('.portion').addClass('hidden');
                });
            ");?>
        </div>

        <div class="form-group">
            <?= $form->labelEx($model,'description');?>
            <?php
            $this->widget('ext.ckeditor.CKEditor',array(
                'model' => $model,
                'attribute' => 'description',
                'config' =>'basic'
            ));
            ?>
            <?php echo $form->error($model,'description'); ?>
        </div>

        <div class="form-group">
            <?= $form->labelEx($model,'change_log');?>
            <?php
            $this->widget('ext.ckeditor.CKEditor',array(
                'model' => $model,
                'attribute' => 'change_log',
                'config' =>'basic'
            ));
            ?>
            <?php echo $form->error($model,'change_log'); ?>
        </div>

        <?php if($model->platform->name != 'android'):?>
            <div class="form-group multipliable-input-container">
                <?php if($model->isNewRecord):?>
                    <?php echo CHtml::textField('Books[permissions][0]','',array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input')); ?>
                <?php else:?>
                    <?php
                    if($model->permissions) {
                        foreach(CJSON::decode($model->permissions) as $key => $permission):?>
                            <?php echo CHtml::textField('Books[permissions]['.$key.']', $permission, array('placeholder' => 'دسترسی', 'class' => 'form-control multipliable-input')); ?>
                            <?php
                        endforeach;
                    }
                    else {
                        echo CHtml::textField('Books[permissions][0]','',array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input'));
                    }
                    ?>
                <?php endif;?>
                <a href="#add-permission" class="add-multipliable-input"><i class="icon icon-plus"></i></a>
                <a href="#remove-permission" class="remove-multipliable-input"><i class="icon icon-trash"></i></a>
                <?php echo $form->error($model,'permissions'); ?>
            </div>
        <?php endif;?>

        <div class="form-group col-md-12">
            <?php echo $form->labelEx($model,'icon',array('class'=> 'block')); ?>
            <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                'id' => 'uploaderIcon',
                'model' => $model,
                'name' => 'icon',
                'maxFiles' => 1,
                'maxFileSize' => 0.3, //MB
                'url' => Yii::app()->createUrl('/publishers/books/upload'),
                'deleteUrl' => Yii::app()->createUrl('/publishers/books/deleteUpload'),
                'acceptedFiles' => 'image/png',
                'serverFiles' => $icon,
                'data' => array(
                    'filesFolder' => $model->platform->name
                ),
                'onSuccess' => '
                    var responseObj = JSON.parse(res);
                    if(responseObj.state == "ok")
                        {serverName} = responseObj.fileName;
                    else if(responseObj.state == "error"){
                        alert(responseObj.msg);
                        this.removeFile(file);
                    }
                ',
            )); ?>
            <?php echo $form->error($model,'icon'); ?>
        </div>
        <br>
        <div class="input-group buttons" style="clear:both;">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره تغییرات',array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>