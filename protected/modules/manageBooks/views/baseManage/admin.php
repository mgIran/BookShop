<?php
/* @var $this BaseManageController */
/* @var $model Books */

$this->breadcrumbs=array(
	'مدیریت',
);
?>

<h1>مدیریت کتاب ها</h1>
<a href="<?= Yii::app()->createUrl('/manageBooks/baseManage/create') ?>" class=" btn btn-success pull-right">افزودن کتاب</a>
<div class="clearfix"></div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'books-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'htmlOptions' => array('style' => 'width: 30px;'),
			'filterHtmlOptions' => array('style' => 'width: 30px;'),
		),
		'title',
		array(
			'header' => 'ناشر',
			'value' => '$data->publisher_id?$data->publisher->userDetails->publisher_id:$data->publisher_name',
			'filter' => CHtml::activeTextField($model,'devFilter')
		),
		array(
			'name' => 'category_id',
			'value' => '$data->category->fullTitle',
			'filter' => CHtml::activeDropDownList($model,'category_id',BookCategories::model()->sortList(true),array('prompt' => 'همه'))
		),
		array(
			'name' => 'status',
			'value' => '$data->statusLabels[$data->status]',
			'filter' => CHtml::activeDropDownList($model,'status',$model->statusLabels,array('prompt' => 'همه'))
		),
		array(
			'name' => 'lastPackage.price',
			'value' => '$data->price != 0?$data->price." تومان":"رایگان"'
		),
		array(
			'name' => 'lastPackage.printed_price',
			'value' => '$data->printed_price?$data->printed_price." تومان":"غیرقابل فروش"'
		),
		array(
			'header' => 'تغییر وضعیت',
			'value' => function($data){
				return CHtml::dropDownList("confirm", $data->confirm, $data->confirmLabels, array("class"=>"change-confirm", "data-id"=>$data->id));
			},
			'type' => 'raw'
		),
		array(
			'class'=>'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/manageBooks/baseManage/update", array("id"=>$data->id))'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/manageBooks/baseManage/delete", array("id"=>$data->id))'
                ),
				'view' => array(
					'label'=>'مشاهده کتاب',
					'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/view/".$data->id)',
					'options'=>array(
						'target'=>'_blank'
					),
                )
            )
		),
	),
)); ?>


<?php Yii::app()->clientScript->registerScript('changeConfirm', "
	var row_id,row_val;
    $('body').on('change','.change-confirm', function(){
    	row_id = $(this).data('id');
    	row_val = $(this).val();
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
    $('body').on('change', '#default_commission', function(){
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
                            data:{book_id:row_id, value:row_val},
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
