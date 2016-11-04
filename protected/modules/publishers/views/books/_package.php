<?php
/* @var $this PublishersBooksController */
/* @var $model Books */
/* @var $dataProvider CActiveDataProvider */
/* @var $package BookPackages */
/* @var $for string */
Yii::app()->clientScript->registerCss('inline',"
.dropzone.single{width:100%;}
");
?>

<div class="packages-list-container">
    <a class="btn btn-success" href="#package-modal" data-toggle="modal"><i class="icon icon-plus"></i> ثبت نوبت چاپ</a>
    <div id="packages-list-loading" class="hidden" style="margin-top: 20px;">در حال بروز رسانی لیست...</div>
    <table class="table book-package">
        <thead class="thead">
            <tr>
                <th>نسخه چاپ</th>
                <th>حجم فایل</th>
                <th>تاریخ بارگذاری</th>
                <th>تاریخ انتشار</th>
                <th>قیمت نسخه دیجیتال</th>
                <th>قیمت نسخه چاپی</th>
                <th>وضعیت</th>
            </tr>
        </thead>
        <tbody id="packages-list">
        <?php if($dataProvider->totalItemCount==0):?>
            <tr>
                <td colspan="7" class="text-center">نتیجه ای یافت نشد.</td>
            </tr>
        <?php else:?>
            <?php foreach($dataProvider->getData() as $package):?>
                <tr>
                    <td><?php echo CHtml::encode($package->version);?></td>
                    <td><?php echo Controller::fileSize(Yii::getPathOfAlias("webroot") . '/uploads/books/files/'.$package->file_name);?></td>
                    <td><?php echo JalaliDate::date('d F Y', $package->create_date);?></td>
                    <td><?php if($package->status=='accepted')echo JalaliDate::date('d F Y', $package->publish_date);else echo '-';?></td>
                    <td><?php echo Controller::parseNumbers(number_format($package->price)).' تومان'?></td>
                    <td><?php echo Controller::parseNumbers(number_format($package->printed_price)).' تومان'?></td>
                    <td>
                        <span class="label <?php if($package->status=='accepted')echo 'label-success';elseif($package->status=='refused' || $package->status=='change_required')echo 'label-danger';else echo 'label-info';?>">
                            <?php echo CHtml::encode($package->statusLabels[$package->status]);?>
                        </span>
                        <?php if($package->status=='refused' or $package->status=='change_required'):?>
                            <a class="btn btn-info btn-xs" style="margin-right: 5px;margin-top: 5px;" data-toggle="collapse" data-parent="#packages-list" href="#reason-<?php echo $data->id?>">دلیل</a>
                        <?php endif;?>
                    </td>
                    <?php if($package->status=='refused' or $package->status=='change_required'):?>
                        <td id="reason-<?php echo $package->id?>" class="collapse">
                            <div class="reason-collapse">
                                <?php if($package->status=='refused'):?>
                                    <p>این نوبت چاپ به دلایل زیر رد شده است:</p>
                                <?php elseif($package->status=='change_required'):?>
                                    <p>این نوبت چاپ نیاز به تغییرات زیر دارد:</p>
                                <?php endif;?>
                                <?php echo CHtml::encode($package->reason);?>
                            </div>
                        </td>
                    <?php endif;?>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>

    <?php echo CHtml::beginForm();?>
        <?php echo CHtml::submitButton('تایید نهایی', array('class'=>'btn btn-default', 'name'=>'packages-submit'));?>
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
                                        <?php echo CHtml::textField('version', '', array('class'=>'form-control', 'placeholder'=>'نسخه چاپ *'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php //echo CHtml::textField('package_name', '', array('class'=>'form-control', 'placeholder'=>'نام نوبت چاپ *'));?>
                                        <?php echo CHtml::textField('isbn', '', array('class'=>'form-control', 'placeholder'=>'شابک *'));?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('price', '', array('class'=>'form-control', 'placeholder'=>'قیمت نسخه دیجیتال * (تومان)'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                        <?php echo CHtml::checkBox('sale_printed', false, array('data-toggle'=>'collapse', 'data-target'=>'#printed-price'));?>
                                        <?php echo CHtml::label('میخواهم نسخه چاپی این کتاب را هم بفروشم.', 'sale_printed');?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 collapse" id="printed-price">
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
                                                    $('#packages-list-loading').removeClass('hidden');
                                                    $.ajax({
                                                        url:'".$this->createUrl('/publishers/books/getPackages', array('id'=>$model->id))."',
                                                        dataType:'HTML',
                                                        success: function(data){
                                                            $('#packages-list').html(data);
                                                            $('#packages-list-loading').addClass('hidden');
                                                        }
                                                    });
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