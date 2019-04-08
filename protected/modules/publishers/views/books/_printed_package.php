<?php
/* @var $this PublishersBooksController */
/* @var $model Books */
/* @var $dataProvider CActiveDataProvider */
/* @var $for string */
?>

<div class="packages-list-container">
    <a class="btn btn-success add-package" href="#package-modal" data-toggle="modal">ثبت نسخه چاپی</a>
    <table class="table">
        <thead class="thead">
            <tr>
                <th>نسخه چاپ</th>
                <th>تاریخ بارگذاری</th>
                <th>تاریخ انتشار</th>
                <th>قیمت فروش</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'packages-list',
            'dataProvider'=>$dataProvider,
            'itemView'=>'_package_list',
            'ajaxUrl'=>array('/publishers/books/update/'.$model->id),
            'itemsTagName'=>'tr',
            'tagName'=>'tbody',
            'emptyTagName'=>'td colspan="8"',
            'emptyCssClass'=>'text-center',
            'template'=>'{items}',
            'htmlOptions'=>array('class'=>'table'),
        ));?>
    </table>
    <div id="package-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">ثبت نسخه چاپی جدید</h4>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group">
                            <?php echo CHtml::beginForm('','post',array('id'=>'package-info-form'));?>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('version', '', array('class'=>'form-control', 'placeholder'=>'نوبت چاپ'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('print_year', '', array('class'=>'form-control', 'placeholder'=>'زمان چاپ *'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('cover_price', '', array('class'=>'form-control', 'placeholder'=>'قیمت روی جلد (تومان) *'));?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?php echo CHtml::textField('printed_price', '', array('class'=>'form-control', 'placeholder'=>'قیمت فروش (تومان) *'));?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo CHtml::hiddenField('for', $for);?>
                                        <?php echo CHtml::hiddenField('book_id', $model->id);?>
                                        <?php echo CHtml::hiddenField('type', BookPackages::TYPE_PRINTED);?>
                                        <?php echo CHtml::ajaxSubmitButton('ثبت', $this->createUrl('/publishers/books/savePackage'), array(
                                            'type'=>'POST',
                                            'dataType'=>'JSON',
                                            'data'=>'js:$("#package-info-form").serialize()',
                                            'beforeSend'=>"js:function(){
                                                if($('#package-info-form #isbn').val()=='' || $('#package-info-form #print_year').val()==''){
                                                    $('.uploader-message').text('لطفا فیلد های ستاره دار را پر کنید.').addClass('error');
                                                    return false;
                                                }else if($('#package-info-form #price').val()=='' && !$('#free').is(':checked')){
                                                    $('.uploader-message').text('لطفا قیمت را مشخص کنید.').addClass('error');
                                                    return false;
                                                }else
                                                    $('.uploader-message').text('در حال ثبت اطلاعات...').removeClass('error');
                                            }",
                                            'success'=>"js:function(data){
                                                if(data.status){
                                                    $('.save-package-message').text('اطلاعات با موفقیت ثبت شد. کتاب ثبت شده بعد از تایید توسط کارشناسان در سایت نمایش داده خواهد شد.').removeClass('hidden');
                                                    $.fn.yiiListView.update('packages-list');
                                                    $('.uploader-message').text('');
                                                    $('#package-modal').modal('hide');
                                                    $('.dz-preview').remove();
                                                    $('.dropzone').removeClass('dz-started');
                                                    $('#package-info-form #version').val('');
                                                    $('#package-info-form #package_name').val('');
                                                    $('#package-info-form #isbn').val('');
                                                    $('#package-info-form #price').val('');
                                                    $('#package-info-form #print_year').val('');
                                                    $('#package-info-form #printed_price').val('');
                                                    $('.add-package').addClass('hidden');
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
            </div>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerCss('package-form','
#package-info-form input[type="text"]{margin-top:20px;}
#package-info-form input[type="submit"], .uploader-message{margin-top:20px;}
.uploader-message{line-height:32px;}
');?>
<?php Yii::app()->clientScript->registerScript('inline-script', "
$('body').on('click', '.delete-package', function(){
    var confirmation=confirm('آیا از حذف این نسخه مطمئن هستید؟');
    if(confirmation){
        $.ajax({
            url:$(this).attr('href'),
            type:'GET',
            dataType:'JSON',
            success:function(data){
                if(data.status == 'success'){
                    $.fn.yiiListView.update('packages-list');
                    if(data.count == 0)
                        $('.add-package').removeClass('hidden');
                }else
                    alert('در انجام عملیات خطایی رخ داده است.');
            },
            error:function(){
                alert('در انجام عملیات خطایی رخ داده است.');
            }
        });
    }
    return false;
});

var price = null;
$('#free').on('change', function(){
    if($(this).is(':checked')){
        price = $('#price').val();
        $('#price').addClass('hidden').val(0);
        $(this).parent().css('margin-top', 30);
    }else{
        if(price==0)
            $('#price').val('').removeClass('hidden');
        else
            $('#price').val(price).removeClass('hidden');
        $(this).parent().css('margin-top', 10);
    }
});
");?>