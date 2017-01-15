<?php
/* @var $this ManageBooksBaseManageController */
/* @var $model Books */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'افزودن کتاب', 'url'=>array('create')),
	array('label'=>'ویرایش', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف این کتاب مطمئن هستید؟')),
	array('label'=>'مدیریت کتاب ها', 'url'=>array('admin')),
);

$purifier=new CHtmlPurifier();
?>

<h1><?php echo $model->title; ?></h1>

<p>
    <label>وضعیت انتشار:</label>
    <?php echo CHtml::dropDownList("confirm", $model->confirm, $model->confirmLabels, array("class"=>"change-confirm", "data-id"=>$model->id));?>
</p>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		array(
			'name'=>'publisher_id',
			'value'=>$model->publisher->userDetails->fa_name,
		),
		array(
			'name'=>'category_id',
			'value'=>$model->category->title,
		),
		array(
			'name'=>'status',
			'value'=>$model->statusLabels[$model->status],
		),
		array(
            'name'=>'lastPackage.price',
            'value'=>number_format($model->lastPackage->price).' تومان',
            'header'=>'قیمت',
        ),
		array(
            'name'=>'lastPackage.pdf_file_name',
            'value'=>is_null($model->lastPackage->pdf_file_name)?'-':CHtml::link($model->lastPackage->pdf_file_name, $this->createUrl('/manageBooks/baseManage/download/'.$model->id.'?title=pdf')),
            'type'=>'raw'
        ),
        array(
            'name'=>'lastPackage.epub_file_name',
            'value'=>is_null($model->lastPackage->epub_file_name)?'-':CHtml::link($model->lastPackage->epub_file_name, $this->createUrl('/manageBooks/baseManage/download/'.$model->id.'?title=epub')),
            'type'=>'raw'
        ),
        array(
            'name'=>'preview_file',
            'value'=>empty($model->preview_file)?'-':CHtml::link($model->preview_file, $this->createUrl('/manageBooks/baseManage/download/'.$model->id.'?title=preview')),
            'type'=>'raw'
        ),
        array(
            'name'=>'size',
            'value'=>'<div style="direction: ltr;text-align: right;">'.$model->lastPackage->getUploadedFilesSize().'</div>',
            'type'=>'raw'
        ),
        'language',
        'number_of_pages',
        'publisher_commission',
		array(
            'name'=>'description',
            'value'=>$purifier->purify($model->description),
            'type'=>'raw'
        ),
        array(
            'name'=>'change_log',
            'value'=>$purifier->purify($model->change_log),
            'type'=>'raw'
        ),
        array(
            'name'=>'icon',
            'value'=>CHtml::image(Yii::app()->baseUrl.'/uploads/books/icons/'.$model->icon, '', array('style'=>'max-width:200px;')),
            'type'=>'raw'
        ),
    ),
)); ?>

<?php Yii::app()->clientScript->registerScript('changeConfirm', "
    $('body').on('change','.change-confirm', function(){
        if($(this).val()=='accepted'){
            $('#book-id').val($(this).data('id'));
            $('#book-modal').modal('show');
        }else{
            $.ajax({
                url:'".$this->createUrl('/manageBooks/baseManage/changeConfirm')."',
                type:'POST',
                dataType:'JSON',
                data:{book_id:$(this).data('id'), value:$(this).val()},
                success:function(data){
                    if(data.status){
                        alert('اطلاعات با موفقیت ثبت شد.');
                    }else
                        alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                }
            });
        }
    });

    $('body').on('change', '#default_commission', function(){
        $('#commission-text').prop('disabled', function(i, v) { return !v; }).val('');
    });

    $('.save-book-modal').click(function(){
        if(!$('#default_commission').is(':checked') && $('#commission-text').val()==''){
            $('.book-modal-message').addClass('error').text('لطفا میزان کمیسیون را تعیین نمایید.');
            return false;
        }else{
            $('.book-modal-message').removeClass('error').text('در حال ثبت...');
            $.ajax({
                url:'".$this->createUrl('/manageBooks/baseManage/changePublisherCommission')."',
                type:'POST',
                dataType:'JSON',
                data:$('#book-commission-form').serialize(),
                success:function(data){
                    if(data.status == 'success'){
                        $.ajax({
                            url:'".$this->createUrl('/manageBooks/baseManage/changeConfirm')."',
                            type:'POST',
                            dataType:'JSON',
                            data:{book_id:$('.change-confirm').data('id'), value:$('.change-confirm').val()},
                            success:function(data){
                                if(data.status){
                                    $('#book-modal').modal('hide');
                                    $('#commission-text').val('');
                                    $('.book-modal-message').text('');

                                    alert('اطلاعات با موفقیت ثبت شد.');
                                }else
                                    alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                            }
                        });
                    } else
                        alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                }
            });
        }
    });
");?>

<div id="book-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo CHtml::beginForm('', 'post', array('id'=>'book-commission-form'));?>
                <?php echo CHtml::hiddenField('book_id', '', array('id'=>'book-id'));?>
                <?php echo CHtml::label('لطفا کمیسیون ناشر برای این کتاب را وارد کنید:', 'commission-text')?>
                <?php echo CHtml::textField('publisher_commission', '', array('placeholder'=>'کمیسیون ناشر (درصد)', 'class'=>'form-control', 'id'=>'commission-text'));?>
                <?php echo CHtml::checkBox('default_commission', false, array('style'=>'margin-top:15px;'));?>
                <?php echo CHtml::label('کمیسیون پیش فرض در نظر گرفته شود.', 'default_commission');?>
                <?php echo CHtml::endForm();?>
            </div>
            <div class="modal-footer">
                <div class="book-modal-message error pull-right"></div>
                <button type="button" class="btn btn-success save-book-modal">ثبت</button>
            </div>
        </div>
    </div>
</div>
