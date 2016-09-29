<?php
/* @var $this BaseManageController */
/* @var $model Books */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerCss('inline',"
.dropzone.single{width:100%;}
a[href='#package-modal']{margin-top:20px;}
");
?>

<?php if($model->platform_id==1):?>
    <?php echo CHtml::beginForm('','post',array('id'=>'package-info-form'));?>
    <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
        'id' => 'uploaderFile',
        'model' => $model,
        'name' => 'file_name',
        'maxFileSize' => 1024,
        'maxFiles'=>false,
        'url' => Yii::app()->createUrl('/manageBooks/'.$model->platform->name.'/uploadFile'),
        'deleteUrl' => Yii::app()->createUrl('/manageBooks/'.$model->platform->name.'/deleteUploadFile'),
        'acceptedFiles' => $this->formats,
        'serverFiles' => array(),
        'onSuccess' => '
            var responseObj = JSON.parse(res);
            if(responseObj.status)
                {serverName} = responseObj.fileName;
            else
                $(".uploader-message").text(responseObj.message);
        ',
    ));?>
    <div class="row">
        <div class="col-md-12">
            <?php echo CHtml::hiddenField('app_id', $model->id);?>
            <?php echo CHtml::hiddenField('filesFolder', $model->platform->name);?>
            <?php echo CHtml::hiddenField('platform', $model->platform->name);?>
            <?php echo CHtml::ajaxSubmitButton('ثبت', $this->createUrl('/manageBooks/'.$model->platform->name.'/savePackage'), array(
                'type'=>'POST',
                'dataType'=>'JSON',
                'data'=>'js:$("#package-info-form").serialize()',
                'beforeSend'=>"js:function(){
                    if($('input[type=\"hidden\"][name=\"Books[file_name]\"]').length==0){
                        $('.uploader-message').text('لطفا بسته جدید را آپلود کنید.');
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
                    }
                    else
                        $('.uploader-message').text(data.message);
                }",
                'error'=>"js:function(){ $('.uploader-message').text('فایل ارسالی ناقص می باشد.').addClass('error'); }",
            ), array('class'=>'btn btn-success pull-left'));?>
        </div>
    </div>
    <?php echo CHtml::endForm();?>
<?php else:?>
    <?php echo CHtml::beginForm('','post',array('id'=>'package-info-form'));?>
    <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
        'id' => 'uploaderFile',
        'model' => $model,
        'name' => 'file_name',
        'maxFileSize' => 1024,
        'maxFiles' => false,
        'url' => Yii::app()->createUrl('/manageBooks/'.$model->platform->name.'/uploadFile'),
        'deleteUrl' => Yii::app()->createUrl('/manageBooks/'.$model->platform->name.'/deleteUploadFile'),
        'acceptedFiles' => $this->formats,
        'serverFiles' => array(),
        'onSuccess' => '
            var responseObj = JSON.parse(res);
            if(responseObj.status)
                {serverName} = responseObj.fileName;
            else
                $(".uploader-message").text(responseObj.message);
        ',
    ));?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php echo CHtml::textField('version', '', array('class'=>'form-control', 'placeholder'=>'ورژن *'));?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php echo CHtml::textField('package_name', '', array('class'=>'form-control', 'placeholder'=>'نام بسته *'));?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo CHtml::hiddenField('app_id', $model->id);?>
            <?php echo CHtml::hiddenField('filesFolder', $model->platform->name);?>
            <?php echo CHtml::hiddenField('platform', $model->platform->name);?>
            <?php echo CHtml::ajaxSubmitButton('ثبت', $this->createUrl('/manageBooks/'.$model->platform->name.'/savePackage'), array(
                'type'=>'POST',
                'dataType'=>'JSON',
                'data'=>'js:$("#package-info-form").serialize()',
                'beforeSend'=>"js:function(){
                    if($('#package-info-form #version').val()=='' || $('#package-info-form #package_name').val()==''){
                        $('.uploader-message').text('لطفا فیلد های ستاره دار را پر کنید.');
                        return false;
                    }else if($('input[type=\"hidden\"][name=\"Books[file_name]\"]').length==0){
                        $('.uploader-message').text('لطفا بسته جدید را آپلود کنید.');
                        return false;
                    }else
                        $('.uploader-message').text('');
                }",
                'success'=>"js:function(data){
                    if(data.status){
                        $.fn.yiiGridView.update('packages-grid');
                        $('.uploader-message').text('');
                    }
                    else
                        $('.uploader-message').text(data.message);
                    $('.dz-preview').remove();
                    $('.dropzone').removeClass('dz-started');
                    $('#package-info-form #version').val('');
                    $('#package-info-form #package_name').val('');
                }",
                'error'=>"js:function(){ $('.uploader-message').text('فایل ارسالی ناقص می باشد.').addClass('error'); }",
            ), array('class'=>'btn btn-success pull-left'));?>
        </div>
    </div>
    <?php echo CHtml::endForm();?>
<?php endif;?>
<h5 class="uploader-message error"></h5>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'packages-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'version',
        'package_name',
        array(
            'class'=>'CButtonColumn',
            'template' => '{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'url'=>'Yii::app()->createUrl("/manageBooks/'.$model->platform->name.'/deletePackage/".$data->id)',
                ),
            ),
        ),
    ),
));?>

<?php Yii::app()->clientScript->registerCss('package-form','
#package-info-form input[type="text"]{margin-top:20px;}
#package-info-form input[type="submit"]{margin-top:20px;}
');?>