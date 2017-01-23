<?php
/* @var $this BaseManageController */
/* @var $model Books */
/* @var $icon array */
/* @var $packageDataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>Yii::app()->createUrl('/manageBooks/baseManage/create')),
    array('label'=>'مدیریت', 'url'=>Yii::app()->createUrl('/manageBooks/baseManage/admin')),
    array('label'=>'مشاهده کتاب', 'url'=>Yii::app()->createUrl("/manageBooks/baseManage/view/".$model->id)),
);
if(isset($_GET['step']))
    $step = (int)$_GET['step'];
?>

<h1>ویرایش کتاب <?php echo $model->title; ?></h1>

<p>
    <label>وضعیت انتشار:</label>
    <?php echo CHtml::dropDownList("confirm", $model->confirm, $model->confirmLabels, array("class"=>"change-confirm", "data-id"=>$model->id));?>
</p>

    <ul class="nav nav-tabs">
        <li class="<?= ($step == 1?'active':''); ?>"><a data-toggle="tab" href="#general">عمومی</a></li>
        <li class="<?= $model->getIsNewRecord()?'disabled':''; ?> <?= ($step == 2?'active':''); ?>"><a data-toggle="tab" href="#packages">نوبت چاپ</a></li>
    </ul>

    <div class="tab-content">
    <div id="general" class="tab-pane fade <?= ($step == 1?'in active':''); ?>">
        <?php $this->renderPartial('_form', array(
            'model'=>$model,
            'icon'=>$icon,
            'previewFile'=>$previewFile,
            'tax'=>$tax,
            'commission'=>$commission,
        )); ?>
    </div>
    <? if(!$model->getIsNewRecord()):?>
        <div id="packages" class="tab-pane fade <?= ($step == 2?'in active':''); ?>">
            <?php $this->renderPartial('_package', array('model'=>$model, 'dataProvider'=>$packageDataProvider)); ?>
        </div>
    <? endif;?>
</div>

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
    var commission_checked = false;
    $('body').on('change', '#default-commission', function(){
        commission_checked = $(this).is(':checked');
        $('#commission-text').prop('disabled', function(i, v) { return !v; }).val('');
    });

    $('.save-book-modal').click(function(){
        if(!commission_checked && $('#commission-text').val()==''){
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
        $('#reason-text').val('');
    });

    $('.save-reason-modal').click(function(){
        if($('#reason-text').val()==''){
            $('.reason-modal-message').addClass('error').text('لطفا دلیل را ذکر کنید.');
            return false;
        }else{
            $('.reason-modal-message').removeClass('error').text('در حال ثبت...');
            $.ajax({
                url:'".$this->createUrl('/manageBooks/baseManage/changeConfirm')."',
                type:'POST',
                dataType:'JSON',
                data:{book_id:$('#reason-modal .book-id').val(), value:$('#reason-modal .book-status').val(), reason:$('#reason-text').val()},
                success:function(data){
                    if(data.status){
                        $('#reason-modal').modal('hide');
                        $('#reason-text').val('');
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
                <?php echo CHtml::checkBox('default_commission', false, array('style'=>'margin-top:15px;','id'=>'default-commission'));?>
                <?php echo CHtml::label('کمیسیون پیش فرض در نظر گرفته شود.', 'default-commission');?>
                <?php echo CHtml::endForm();?>
            </div>
            <div class="modal-footer">
                <div class="book-modal-message error pull-right"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
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
                <?php echo CHtml::label('لطفا دلیل این انتخاب را بنویسید:', 'reason-text')?>
                <?php echo CHtml::textArea('reason', '', array('placeholder'=>'دلیل', 'class'=>'form-control', 'id'=>'reason-text'));?>
                <div class="reason-modal-message error"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-reason-modal" data-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-success save-reason-modal">ثبت</button>
            </div>
        </div>
    </div>
</div>