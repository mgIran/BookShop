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
			'value'=>$model->publisher ? $model->publisher->userDetails->fa_name : '-',
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
            'name'=>'preview_file',
            'value'=>empty($model->preview_file)?'-':CHtml::link($model->preview_file, $this->createUrl('/manageBooks/baseManage/download/'.$model->id.'?title=preview')),
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
//        array(
//            'name'=>'change_log',
//            'value'=>$purifier->purify($model->change_log),
//            'type'=>'raw'
//        ),
        array(
            'name'=>'icon',
            'value'=>CHtml::image(Yii::app()->baseUrl.'/uploads/books/icons/'.$model->icon, '', array('style'=>'max-width:200px;')),
            'type'=>'raw'
        ),
        'seen',
        'download',
    ),
)); ?>

<?php if($model->lastElectronicPackage):?>
    <h3 style="margin-top: 70px;">نسخه الکترونیکی</h3>
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model->lastElectronicPackage,
        'attributes'=>array(
            array(
                'name'=>'cover_price',
                'value'=>number_format($model->lastElectronicPackage->cover_price).' تومان',
                'header'=>'قیمت',
            ),
            array(
                'name'=>'electronic_price',
                'value'=>number_format($model->lastElectronicPackage->electronic_price).' تومان',
                'header'=>'قیمت',
            ),
            array(
                'name'=>'pdf_file_name',
                'value'=>is_null($model->lastElectronicPackage->pdf_file_name)?'-':CHtml::link($model->lastElectronicPackage->pdf_file_name, $this->createUrl('/manageBooks/baseManage/download/'.$model->id.'?title=pdf')),
                'type'=>'raw'
            ),
            array(
                'name'=>'epub_file_name',
                'value'=>is_null($model->lastElectronicPackage->epub_file_name)?'-':CHtml::link($model->lastElectronicPackage->epub_file_name, $this->createUrl('/manageBooks/baseManage/download/'.$model->id.'?title=epub')),
                'type'=>'raw'
            ),
            array(
                'name'=>'size',
                'value'=>'<div style="direction: ltr;text-align: right;">'.$model->lastElectronicPackage->getUploadedFilesSize().'</div>',
                'type'=>'raw'
            ),
        ),
    )); ?>
<?php endif;?>

<?php if($model->printedPackages):?>
    <h3 style="margin-top: 70px;">نسخه چاپی</h3>
    <table class="table">
        <thead>
        <tr>
            <th>نوبت چاپ</th>
            <th>فروشنده</th>
            <th>زمان چاپ</th>
            <th>قیمت روی جلد</th>
            <th>قیمت فروش</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($model->printedPackages as $printedPackage):?>
            <tr>
                <td><?php echo $printedPackage->version?></td>
                <td><a href="<?php echo $this->createUrl('/users/'.$printedPackage->user_id)?>"><?php echo $printedPackage->user->userDetails->fa_name?></a></td>
                <td><?php echo $printedPackage->print_year?></td>
                <td><?php echo number_format($printedPackage->cover_price)." تومان"?></td>
                <td><?php echo number_format($printedPackage->printed_price)." تومان"?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php endif;?>

<?php Yii::app()->clientScript->registerScript('changeConfirm', "
    $('body').on('change','.change-confirm', function(){
        if($(this).val()=='accepted'){
            $('#book-id').val($(this).data('id'));
            $('#book-modal').modal('show');
        }else if($(this).val()=='refused' || $(this).val()=='change_required'){
            $('#reason-modal').modal('show');
            $('#reason-modal input.book-id').val($(this).data('id'));
            $('#reason-modal input.book-status').val($(this).val());
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

    $('.close-reason-modal').click(function(){
        $('#electronic-reason-text').val('');
        $('#printed-reason-text').val('');
    });

    $('.save-reason-modal').click(function(){
        if($('#electronic-reason-text').val()=='' && $('#printed-reason-text').val()==''){
            $('.reason-modal-message').addClass('error').text('لطفا دلیل را ذکر کنید.');
            return false;
        }else{
            $('.reason-modal-message').removeClass('error').text('در حال ثبت...');
            $.ajax({
                url:'".$this->createUrl('/manageBooks/baseManage/changeConfirm')."',
                type:'POST',
                dataType:'JSON',
                data:{book_id:$('#reason-modal .book-id').val(), value:$('#reason-modal .book-status').val(), electronic_reason:$('#electronic-reason-text').val(), printed_reason:$('#printed-reason-text').val()},
                success:function(data){
                    if(data.status){
                        $('#reason-modal').modal('hide');
                        $('#electronic-reason-text').val('');
                        $('#printed-reason-text').val('');
                        $('.reason-modal-message').text('');
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

<div id="reason-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo CHtml::hiddenField('book_id', '', array('class'=>'book-id'));?>
                <?php echo CHtml::hiddenField('book_status', '', array('class'=>'book-status'));?>
                <?php echo CHtml::label('لطفا دلیل این انتخاب را برای نسخه الکترونیکی بنویسید:', 'electronic-reason-text')?>
                <div class="form-group">
                    <?php echo CHtml::textArea('electronic_reason', '', array('placeholder'=>'دلیل', 'class'=>'form-control', 'id'=>'electronic-reason-text'));?>
                </div>
                <?php echo CHtml::label('لطفا دلیل این انتخاب را برای نسخه چاپی بنویسید:', 'printed-reason-text')?>
                <div class="form-group">
                    <?php echo CHtml::textArea('printed_reason', '', array('placeholder'=>'دلیل', 'class'=>'form-control', 'id'=>'printed-reason-text'));?>
                </div>
                <div class="reason-modal-message error"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-reason-modal" data-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-success save-reason-modal">ثبت</button>
            </div>
        </div>
    </div>
</div>