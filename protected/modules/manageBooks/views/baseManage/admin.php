<?php
/* @var $this ManageBooksBaseManageController */
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
	'itemsCssClass'=>'table',
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
			'header' => 'قیمت دیجیتال با تخفیف',
			'value' => function($data){
				if($data->discount && $data->discount->hasPriceDiscount())
					return Controller::parseNumbers(number_format($data->offPrice))." تومان";
				return '-';
			}
		),
		array(
			'name' => 'lastPackage.printed_price',
			'value' => '$data->printed_price?$data->printed_price." تومان":"غیرقابل فروش"'
		),
		array(
			'header' => 'قیمت چاپی با تخفیف',
			'value' => function($data){
				if($data->discount && $data->discount->hasPrintedPriceDiscount())
					return Controller::parseNumbers(number_format($data->off_printed_price))." تومان";
				return '-';
			}
		),
		array(
			'name'=>'seen',
			'filter'=>false,
			'sortable'=>false
		),
		array(
			'name'=>'download',
			'filter'=>false,
			'sortable'=>false
		),
		array(
			'header' => 'تغییر وضعیت',
			'value' => function($data){
				$form=CHtml::dropDownList("confirm", $data->confirm, $data->confirmLabels, array("class"=>"change-confirm", "data-id"=>$data->id));
				$form.=CHtml::button("ثبت", array("class"=>"btn btn-sm btn-success confirm-status", 'style'=>'margin-right:5px;'));
				return $form;
			},
			'htmlOptions' => ['style' => 'width:190px'],
			'type' => 'raw'
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete} {sell_printed}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/manageBooks/baseManage/update", array("id"=>$data->id))',
					'visible' => function(){
						return Yii::app()->user->roles == 'admin';
					}
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
                ),
				'sell_printed' => array(
					'label'=>'تنظیمات فروش',
					'url'=>'Yii::app()->createUrl("/manageBooks/baseManage/updatePackage?id=".$data->lastPackage->id."&book_id=".$data->id)',
					'options'=>array(
						'style' => 'margin-top:5px',
						'class'=>'btn btn-sm btn-success'
					),
					'visible' => function(){
						return Yii::app()->user->roles != 'admin';
					}
                )
            )
		),
	),
)); ?>


<?php Yii::app()->clientScript->registerScript('changeConfirm', "
	var row_id,row_val;
    $('body').on('click','.confirm-status', function(){
        var el = $(this),
        	tr = el.parents('tr');
    	row_id = tr.find('.change-confirm').data('id');
    	row_val = tr.find('.change-confirm').val();
        if(el.val()=='accepted'){
        console.log(3);
            $('#book-id').val(row_id);
            $('#book-modal').modal('show');
        }else if(row_val=='refused' || row_val=='change_required'){
        console.log(2);
            $('#reason-modal').modal('show');
            $('#reason-modal input.book-id').val(row_id);
            $('#reason-modal input.book-status').val(row_val);
        }else{
        console.log(1);
            $.ajax({
                url:'".$this->createUrl('/manageBooks/baseManage/changeConfirm')."',
                type:'POST',
                dataType:'JSON',
                data:{book_id:row_id, value:row_val},
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
