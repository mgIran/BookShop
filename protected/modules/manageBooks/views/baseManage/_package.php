<?php
/* @var $this BaseManageController */
/* @var $model Books */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerCss('inline',"
    #uploaderFile .dropzone.single{width:100%;}
    a[href='#package-modal']{margin-top:20px;}
");
?>
<?php echo CHtml::beginForm('','post',array('id'=>'package-info-form'));?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                'id' => 'uploaderPdfFile',
                'name' => 'pdf_file_name',
                'maxFileSize' => 1024,
                'maxFiles' => false,
                'url' => Yii::app()->createUrl('/manageBooks/baseManage/uploadPdfFile'),
                'deleteUrl' => Yii::app()->createUrl('/manageBooks/baseManage/deleteUploadPdfFile'),
                'acceptedFiles' => '.pdf',
                'serverFiles' => array(),
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
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                'id' => 'uploaderEpubFile',
                'name' => 'epub_file_name',
                'maxFileSize' => 1024,
                'maxFiles' => false,
                'url' => Yii::app()->createUrl('/manageBooks/baseManage/uploadEpubFile'),
                'deleteUrl' => Yii::app()->createUrl('/manageBooks/baseManage/deleteUploadEpubFile'),
                'acceptedFiles' => '.epub',
                'serverFiles' => array(),
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
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php echo CHtml::textField('version', '', array('class'=>'form-control', 'placeholder'=>'نسخه *'));?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php echo CHtml::textField('isbn', '', array('class'=>'form-control', 'placeholder'=>'شابک *'));?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php echo CHtml::textField('print_year', '', array('class'=>'form-control', 'placeholder'=>'سال چاپ *'));?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php echo CHtml::textField('price', '', array('class'=>'form-control', 'placeholder'=>'قیمت نسخه دیجیتال * (تومان)'));?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 clearfix" style="margin-top: 15px;">
            <?php echo CHtml::checkBox('sale_printed', false, array('data-toggle'=>'collapse', 'data-target'=>'#printed-price'));?>
            <?php echo CHtml::label('میخواهم نسخه چاپی این کتاب را هم بفروشم.', 'sale_printed');?>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 collapse clearfix" id="printed-price">
            <?php echo CHtml::textField('printed_price', '', array('class'=>'form-control', 'placeholder'=>'قیمت نسخه چاپی * (تومان)'));?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo CHtml::hiddenField('book_id', $model->id);?>
            <?php echo CHtml::ajaxSubmitButton('ثبت', $this->createUrl('/manageBooks/baseManage/savePackage'), array(
                'type'=>'POST',
                'dataType'=>'JSON',
                'data'=>'js:$("#package-info-form").serialize()',
                'beforeSend'=>"js:function(){
                    if($('#package-info-form #version').val()=='' || $('#package-info-form #package_name').val()==''){
                        $('.uploader-message').text('لطفا فیلد های ستاره دار را پر کنید.');
                        return false;
                    }else if($('input[type=\"hidden\"][name=\"pdf_file_name\"]').length==0 && $('input[type=\"hidden\"][name=\"epub_file_name\"]').length==0){
                        $('.uploader-message').text('لطفا فایل چاپ جدید را آپلود کنید.');
                        return false;
                    }else
                        $('.uploader-message').text('');
                }",
                'success'=>"js:function(data){
                    if(data.status){
                        $.fn.yiiGridView.update('packages-grid');
                        $('.uploader-message').text('');
                        $('.dz-preview').remove();
                        $('.dropzone').removeClass('dz-started');
                        $('#package-info-form #version').val('');
                        $('#package-info-form #package_name').val('');
                        $('#package-info-form #isbn').val('');
                        $('#package-info-form #price').val('');
                        $('#package-info-form #print_year').val('');
                        $('#package-info-form #printed_price').val('');
                    }
                    else
                        $('.uploader-message').html(data.message);
                }",
            ), array('class'=>'btn btn-success pull-left'));?>
        </div>
    </div>
<?php echo CHtml::endForm();?>
<h5 class="uploader-message error"></h5>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'packages-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'version',
        'isbn',
        array(
            'name' => 'price',
            'value' => 'Controller::parseNumbers(number_format($data->price))." تومان"',
            'filter' => false
        ),
        array(
            'name' => 'printed_price',
            'value' => 'Controller::parseNumbers(number_format($data->printed_price))." تومان"',
            'filter' => false
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update} {delete}',
            'buttons'=>array(
                'delete'=>array(
                    'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/deletePackage/".$data->id)',
                ),
                'update'=>array(
                    'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/updatePackage/", array("id" => $data->id,"book_id"=>$data->book_id))',
                ),
            ),
        ),
    ),
));?>

<?php Yii::app()->clientScript->registerCss('package-form','
#package-info-form input[type="text"]{margin-top:20px;}
#package-info-form input[type="submit"]{margin-top:20px;}
');?>