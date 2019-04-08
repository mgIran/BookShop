<?php
/* @var $this PublishersBooksController */
/* @var $model Books */
/* @var $dataProvider CActiveDataProvider */
/* @var $for string */
/* @var $electronicPackage array */
?>

<div class="packages-list-container">
    <div class="form">
        <div class="form-group">
            <?php echo CHtml::beginForm('','post',array('id'=>'electronic-package-info-form'));?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div><?php echo CHtml::label('فایل کتاب', ''); ?></div>
                    <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                        'id' => 'uploaderFile',
                        'name' => 'tempFile',
                        'maxFileSize' => 1024,
                        'maxFiles' => 1,
                        'url' => Yii::app()->createUrl('/publishers/books/uploadFile'),
                        'deleteUrl' => Yii::app()->createUrl('/publishers/books/deleteUploadedFile'),
                        'acceptedFiles' => '.pdf, .epub',
                        'serverFiles' => $electronicPackage,
                        'onSuccess' => '
                            var responseObj = JSON.parse(res);
                            if(responseObj.status){
                                {serverName} = responseObj.fileName;
                                $(".uploader-message").html("");
                            }
                            else{
                                $(".uploader-message").html(responseObj.message).addClass("error");
                                this.removeFile(file);
                            }
                        ',
                    ));?>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="cover_price">قیمت روی جلد (تومان) *</label>
                        <?php echo CHtml::textField('cover_price', $model->lastElectronicPackage ? $model->lastElectronicPackage->cover_price : null, array('class'=>'form-control', 'placeholder'=>'قیمت روی جلد (تومان) *'));?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="electronic_price">قیمت نسخه الکترونیک (تومان) *</label>
                        <?php echo CHtml::textField('electronic_price', $model->lastElectronicPackage ? $model->lastElectronicPackage->electronic_price : null, array('class'=>'form-control', 'placeholder'=>'قیمت نسخه الکترونیک (تومان) *'));?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo CHtml::hiddenField('for', $for);?>
                        <?php echo CHtml::hiddenField('book_id', $model->id);?>
                        <?php echo CHtml::hiddenField('type', BookPackages::TYPE_ELECTRONIC);?>
                        <?php echo CHtml::ajaxSubmitButton('ثبت', $this->createUrl('/publishers/books/savePackage'), array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'data'=>'js:$("#electronic-package-info-form").serialize()',
                            'beforeSend'=>"js:function(){
                                if($('#electronic-package-info-form #print_year').val()==''){
                                    $('.uploader-message').text('لطفا فیلد های ستاره دار را پر کنید.').addClass('error');
                                    return false;
                                }else if($('#electronic-package-info-form #electronic_price').val()=='' || $('#electronic-package-info-form #cover_price').val()==''){
                                    $('.uploader-message').text('لطفا قیمت را مشخص کنید.').addClass('error');
                                    return false;
                                }else if($('input[type=\"hidden\"][name=\"tempFile\"]').length==0){
                                    $('.uploader-message').text('لطفا فایل کتاب را آپلود کنید.').addClass('error');
                                    return false;
                                }else
                                    $('.uploader-message').text('در حال ثبت اطلاعات نوبت چاپ...').removeClass('error');
                            }",
                            'success'=>"js:function(data){
                                if(data.status){
                                    $('.save-package-message').text('اطلاعات با موفقیت ثبت شد. کتاب ثبت شده بعد از تایید توسط کارشناسان در سایت نمایش داده خواهد شد.').removeClass('hidden');
                                    $('.uploader-message').text('');
                                } else
                                    $('.uploader-message').html(data.message).addClass('error');
                            }",
                        ), array('class'=>'btn btn-success pull-left'));?>
                        <h5 class="uploader-message error pull-right"></h5>
                    </div>
                </div>
            <?php echo CHtml::endForm();?>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerCss('package-form','
#electronic-package-info-form label{margin-top:20px;}
#electronic-package-info-form input[type="submit"], .uploader-message{margin-top:20px;}
.uploader-message{line-height:32px;}
');?>