<?php
/* @var $this BooksController */
/* @var $model Books */
/* @var $dataProvider CActiveDataProvider */
/* @var $for string */
Yii::app()->clientScript->registerCss('inline',"
.dropzone.single{width:100%;}
");
?>

<div class="container-fluid packages-list-container">
    <a class="btn btn-success" href="#package-modal" data-toggle="modal"><i class="icon icon-plus"></i> ثبت نوبت چاپ</a>
    <div class="table text-center">
        <div class="thead">
            <div class="col-lg-2 col-md-1 col-sm-4 col-xs-8">نام نوبت چاپ</div>
            <div class="col-lg-1 col-md-1 col-sm-4 hidden-xs">نسخه</div>
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">حجم</div>
            <div class="col-lg-2 col-md-3 hidden-sm hidden-xs">تاریخ بارگذاری</div>
            <div class="col-lg-2 col-md-3 hidden-sm hidden-xs">تاریخ انتشار</div>
            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">قیمت اینترنتی</div>
            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">قیمت چاپی</div>
            <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">وضعیت</div>
        </div>
        <div class="tbody">
            <?php $this->widget('zii.widgets.CListView', array(
                'id'=>'packages-list',
                'dataProvider'=>$dataProvider,
                'itemView'=>'_package_list',
                'template'=>'{items}'
            ));?>
        </div>
    </div>

    <?php echo CHtml::beginForm();?>
        <?php echo CHtml::submitButton('ادامه', array('class'=>'btn btn-success', 'name'=>'packages-submit'));?>
    <?php echo CHtml::endForm();?>

    <div id="package-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ثبت نوبت چاپ جدید</h4>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group">
                            <?php echo CHtml::beginForm('','post',array('id'=>'package-info-form'));?>
                                <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                                    'id' => 'uploaderFile',
                                    'name' => 'file_name',
                                    'maxFileSize' => 1024,
                                    'maxFiles' => false,
                                    'url' => Yii::app()->createUrl('/publishers/books/uploadFile'),
                                    'deleteUrl' => Yii::app()->createUrl('/publishers/books/deleteUploadFile'),
                                    'acceptedFiles' => $this->formats,
                                    'serverFiles' => array(),
                                    'onSuccess' => '
                                        var responseObj = JSON.parse(res);
                                        if(responseObj.status){
                                            {serverName} = responseObj.fileName;
                                            $(".uploader-message").html("");
                                        }
                                        else{
                                            $(".uploader-message").text(responseObj.message).addClass("error");
                                            this.removeFile(file);
                                        }
                                    ',
                                ));?>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('version', '', array('class'=>'form-control', 'placeholder'=>'ورژن *'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('package_name', '', array('class'=>'form-control', 'placeholder'=>'نام نوبت چاپ *'));?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('isbn', '', array('class'=>'form-control', 'placeholder'=>'شابک *'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('price', '', array('class'=>'form-control', 'placeholder'=>'قیمت خرید اینترنتی * (تومان)'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('printed_price', '', array('class'=>'form-control', 'placeholder'=>'قیمت نسخه چاپی * (تومان)'));?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo CHtml::hiddenField('for', $for);?>
                                        <?php echo CHtml::hiddenField('book_id', $model->id);?>
                                        <?php echo CHtml::ajaxSubmitButton('ثبت', $this->createUrl('/publishers/books/savePackage'), array(
                                            'type'=>'POST',
                                            'dataType'=>'JSON',
                                            'data'=>'js:$("#package-info-form").serialize()',
                                            'beforeSend'=>"js:function(){
                                                if($('#package-info-form #version').val()=='' || $('#package-info-form #package_name').val()==''){
                                                    $('.uploader-message').text('لطفا فیلد های ستاره دار را پر کنید.').addClass('error');
                                                    return false;
                                                }else if($('input[type=\"hidden\"][name=\"file_name\"]').length==0){
                                                    $('.uploader-message').text('لطفا نوبت چاپ جدید را آپلود کنید.').addClass('error');
                                                    return false;
                                                }else
                                                    $('.uploader-message').text('در حال ثبت اطلاعات نوبت چاپ...').removeClass('error');
                                            }",
                                            'success'=>"js:function(data){
                                                if(data.status){
                                                    $.fn.yiiListView.update('packages-list',{});
                                                    $('.uploader-message').text('');
                                                    $('#package-modal').modal('hide');
                                                    $('.dz-preview').remove();
                                                    $('.dropzone').removeClass('dz-started');
                                                    $('#package-info-form #version').val('');
                                                    $('#package-info-form #package_name').val('');
                                                    $('#package-info-form #isbn').val('');
                                                    $('#package-info-form #price').val('');
                                                    $('#package-info-form #printed_price').val('');
                                                }
                                                else
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
            </div>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerCss('package-form','
#package-info-form input[type="text"]{margin-top:20px;}
#package-info-form input[type="submit"], .uploader-message{margin-top:20px;}
.uploader-message{line-height:32px;}
');?>