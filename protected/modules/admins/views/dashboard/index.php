<?php
/* @var $this DashboardController*/
/* @var $devIDRequests CActiveDataProvider*/
/* @var $newestPrograms CActiveDataProvider*/
/* @var $newestPublishers CActiveDataProvider*/
/* @var $newestPackages CActiveDataProvider*/
/* @var $newestFinanceInfo CActiveDataProvider*/
/* @var $tickets []*/
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('failed')):?>
    <div class="alert alert-danger fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('failed');?>
    </div>
<?php endif;?>
<?
if(Yii::app()->user->roles == 'superAdmin' || Yii::app()->user->roles == 'admin'):
?>
<div class="row">
    <div class="panel panel-default col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel-heading">جدیدترین کتاب ها</div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'newest-books-grid',
                'dataProvider'=>$newestPrograms,
                'columns'=>array(
                    'title',
                    'publisher_id'=>array(
                        'name'=>'publisher_id',
                        'value'=>'(is_null($data->publisher_id) or empty($data->publisher_id))?$data->publisher_name:$data->publisher->userDetails->publisher_id'
                    ),
                    'category_id'=>array(
                        'name'=>'category_id',
                        'value'=>'$data->category->title'
                    ),
                    'lastPackage.price'=>array(
                        'name'=>'lastPackage.price',
                        'value'=>'number_format($data->lastPackage->price)." تومان"'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view}{delete}',
                        'buttons'=>array(
                            'view'=>array(
                                'label'=>'مشاهده کتاب',
                                'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/view/".$data->id)',
                            ),
                            'delete'=>array(
                                'url'=>'CHtml::normalizeUrl(array(\'/manageBooks/baseManage/delete/\'.$data->id))'
                            ),
                        ),
                    ),
                ),
            ));?>
        </div>
    </div>
<!--    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">-->
<!--        <div class="panel-heading">نوبت چاپ های جدید</div>-->
<!--        <div class="panel-body">-->
<!--            --><?php //$this->widget('zii.widgets.grid.CGridView', array(
//                'id'=>'newest-packages-grid',
//                'dataProvider'=>$newestPackages,
//                'columns'=>array(
//                    'book_id'=>array(
//                        'name'=>'book_id',
//                        'value'=>'CHtml::link($data->book->title, Yii::app()->createUrl("/book/".$data->book_id."/".$data->book->title))',
//                        'type'=>'raw'
//                    ),
//                    'for'=>array(
//                        'name'=>'for',
//                        'value'=>'$data->forLabels[$data->for]',
//                        'type'=>'raw'
//                    ),
//                    'version',
//                    'status'=>array(
//                        'name'=>'status',
//                        'value'=>'CHtml::dropDownList("confirm", "pending", $data->statusLabels, array("class"=>"change-package-status", "data-id"=>$data->id))',
//                        'type'=>'raw'
//                    ),
//                    array(
//                        'class'=>'CButtonColumn',
//                        'template' => '{delete}{downloadPdf} {downloadEpub}',
//                        'buttons'=>array(
//                            'delete'=>array(
//                                'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/deletePackage/".$data->id)',
//                            ),
//                            'downloadPdf'=>array(
//                                'label'=>'دانلود PDF',
//                                'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/downloadPackage/".$data->id."?title=pdf")',
//                                'visible'=>function($data,$model){
//                                    if(is_null($model->pdf_file_name))
//                                        return false;
//                                    return true;
//                                },
//                            ),
//                            'downloadEpub'=>array(
//                                'label'=>'دانلود EPUB',
//                                'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/downloadPackage/".$data->id."?title=epub")',
//                                'visible'=>function($data,$model){
//                                    if(is_null($model->epub_file_name))
//                                        return false;
//                                    return true;
//                                },
//                            ),
//                        ),
//                    ),
//                ),
//            ));?>
<!--            --><?php //Yii::app()->clientScript->registerScript('changePackageStatus', "
//                $('body').on('change', '.change-package-status', function(){
//                    if($(this).val()=='refused' || $(this).val()=='change_required'){
//                        $('#reason-modal').modal('show');
//                        $('input#package-id').val($(this).data('id'));
//                        $('input#package-status').val($(this).val());
//                    }else{
//                        $.ajax({
//                            url:'".$this->createUrl('/manageBooks/baseManage/changePackageStatus')."',
//                            type:'POST',
//                            dataType:'JSON',
//                            data:{package_id:$(this).data('id'), value:$(this).val()},
//                            success:function(data){
//                                if(data.status)
//                                    $.fn.yiiGridView.update('newest-packages-grid');
//                                else
//                                    alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
//                            }
//                        });
//                    }
//                });
//                $('.close-reason-modal').click(function(){
//                    $.fn.yiiGridView.update('newest-packages-grid');
//                    $('#reason-text').val('');
//                });
//                $('.save-reason-modal').click(function(){
//                    if($('#reason-text').val()==''){
//                        $('.reason-modal-message').addClass('error').text('لطفا دلیل را ذکر کنید.');
//                        return false;
//                    }else{
//                        $('.reason-modal-message').removeClass('error').text('در حال ثبت...');
//                        $.ajax({
//                            url:'".$this->createUrl('/manageBooks/baseManage/changePackageStatus')."',
//                            type:'POST',
//                            dataType:'JSON',
//                            data:{package_id:$('#package-id').val(), value:$('#package-status').val(), reason:$('#reason-text').val()},
//                            success:function(data){
//                                if(data.status){
//                                    $.fn.yiiGridView.update('newest-packages-grid');
//                                    $('#reason-modal').modal('hide');
//                                    $('#reason-text').val('');
//                                    $('.reason-modal-message').text('');
//                                } else
//                                    alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
//                            }
//                        });
//                    }
//                });
//            ");?>
<!--        </div>-->
<!--    </div>-->
</div>
<div class="row">
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            درخواست های تغییر شناسه ناشر
        </div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'dev-id-requests-grid',
                'dataProvider'=>$devIDRequests,
                'columns'=>array(
                    'user_id'=>array(
                        'name'=>'user_id',
                        'value'=>'CHtml::link($data->user->userDetails->fa_name, Yii::app()->createUrl("/users/".$data->user->id))',
                        'type'=>'raw'
                    ),
                    'requested_id',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{confirm}{delete}',
                        'buttons'=>array(
                            'confirm'=>array(
                                'label'=>'تایید کردن',
                                'url'=>"CHtml::normalizeUrl(array('/users/manage/confirmDevID', 'id'=>\$data->user_id))",
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/confirm.png',
                            ),
                            'delete'=>array(
                                'url'=>'CHtml::normalizeUrl(array(\'/users/manage/deleteDevID\', \'id\'=>$data->user_id))'
                            ),
                        ),
                    ),
                ),
            ));?>
        </div>
    </div>
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            اطلاعات ناشران<small>(تایید نشده)</small>
        </div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'newest-publishers-grid',
                'dataProvider'=>$newestPublishers,
                'columns'=>array(
                    'email'=>array(
                        'name'=>'email',
                        'value'=>'CHtml::link($data->user->email, Yii::app()->createUrl("/users/".$data->user_id))',
                        'type'=>'raw'
                    ),
                    'fa_name',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view}{confirm}{refused}',
                        'buttons'=>array(
                            'confirm'=>array(
                                'label'=>'تایید کردن',
                                'url'=>"CHtml::normalizeUrl(array('/users/manage/confirmPublisher', 'id'=>\$data->user_id))",
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/confirm.png',
                            ),
                            'refused'=>array(
                                'label'=>'رد کردن',
                                'url'=>'CHtml::normalizeUrl(array(\'/users/manage/refusePublisher\', \'id\'=>$data->user_id))',
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/refused.png',
                            ),
                            'view'=>array(
                                'url'=>'CHtml::normalizeUrl(array("/users/".$data->user_id))',
                            ),
                        ),
                    ),
                ),
            ));?>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
        <div class="panel-heading">اطلاعات مالی ناشران<small>(تایید نشده)</small></div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'newest-finance-info-grid',
                'dataProvider'=>$newestFinanceInfo,
                'columns'=>array(
                    array(
                        'name'=>'fa_name',
                        'value'=>'CHtml::link($data->fa_name, Yii::app()->createUrl("/users/".$data->user_id))',
                        'type'=>'raw'
                    ),
                    array(
                        'name' => 'account_type',
                        'value' => '$data->typeLabels[$data->account_type]',
                    ),
                    'account_owner_name',
                    'account_owner_family',
                    'account_number',
                    'bank_name',
                    array(
                        'name'=>'iban',
                        'value'=>'"IR".$data->iban'
                    ),
                    array(
                        'name'=>'financial_info_status',
                        'value'=>'CHtml::dropDownList("financial_info_status", "pending", $data->detailsStatusLabels, array("class"=>"change-finance-status", "data-id"=>$data->user_id))',
                        'type'=>'raw'
                    ),
                ),
            ));?>
            <?php Yii::app()->clientScript->registerScript('changeFinanceStatus', "
                $('body').on('change', '.change-finance-status', function(){
                    $.ajax({
                        url:'".$this->createUrl('/manageBooks/baseManage/changeFinanceStatus')."',
                        type:'POST',
                        dataType:'JSON',
                        data:{user_id:$(this).data('id'), value:$(this).val()},
                        success:function(data){
                            if(data.status)
                                $.fn.yiiGridView.update('newest-finance-info-grid');
                            else
                                alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                        }
                    });
                });
            ");?>
        </div>
    </div>
</div>


<div id="reason-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo CHtml::hiddenField('package_id', '', array('id'=>'package-id'));?>
                <?php echo CHtml::hiddenField('package_status', '', array('id'=>'package-status'));?>
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
<?
endif;
?>
<div class="row">
    <div class="panel <?= $tickets['new']?'panel-success':'panel-default' ?> col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            پشتیبانی
        </div>
        <div class="panel-body">
            <p>
                تیکت های جدید: <?= $tickets['new'] ?>
            </p>
            <p>
                <?= CHtml::link('لیست تیکت ها',$this->createUrl('/tickets/manage/admin'),array('class'=>'btn btn-success')) ?>
            </p>
        </div>
    </div>
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            آمار بازدیدکنندگان
        </div>
        <div class="panel-body">
            <p>
                افراد آنلاین : <?php echo Yii::app()->userCounter->getOnline(); ?><br />
                بازدید امروز : <?php echo Yii::app()->userCounter->getToday(); ?><br />
                بازدید دیروز : <?php echo Yii::app()->userCounter->getYesterday(); ?><br />
                تعداد کل بازدید ها : <?php echo Yii::app()->userCounter->getTotal(); ?><br />
                بیشترین بازدید : <?php echo Yii::app()->userCounter->getMaximal(); ?><br />
            </p>
        </div>
    </div>
</div>