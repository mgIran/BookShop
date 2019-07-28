<?php
/* @var $this PublishersBooksController */
/* @var $model BookDiscounts */
/* @var $books [] */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
    'لیست تخفیفات' => array('discount'),
);
$this->menu=array(
    array('label'=>'لیست تخفیفات', 'url'=>array('discount')),
);
?>
<h1>افزودن تخفیف کتاب</h1>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'books-discount-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        )
    ));
    ?>
    <div class="row"><?php
        if($model->isNewRecord):
    ?>
            <?php echo $form->labelEx($model, 'book_id'); ?>
            <?php echo $form->dropDownList($model, 'book_id', $books,array(
                'data-live-search' => true,
                'prompt' => 'کتاب مورد نظر را انتخاب کنید'
            )); ?>
            <?php echo $form->error($model, 'book_id'); ?>
    <?php
        else:
            echo CHtml::label('عنوان کتاب','');
            echo $form->hiddenField($model,'book_id');
            echo CHtml::textField('',$model->book->title,array('readOnly' => true,'disabled' => true));
    endif;
    ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'package_id', array('class' => 'control-label')); ?>
        <?php echo $form->dropDownList($model, 'package_id', [], array('prompt' => 'کتاب مورد نظر را انتخاب کنید')); ?>
        <?php echo $form->error($model, 'package_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'start_date'); ?>
        <?php echo CHtml::textField('', '', array('id' => 'start_date')); ?>
        <?php echo $form->hiddenField($model, 'start_date', array('id' => 'start_date_alt')); ?>
        <?php echo $form->error($model, 'start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'end_date'); ?>
        <?php echo CHtml::textField('', '', array('id' => 'end_date')); ?>
        <?php echo $form->hiddenField($model, 'end_date', array('id' => 'end_date_alt')); ?>
        <?php echo $form->error($model, 'end_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'discount_type', array('class' => 'control-label')); ?>
        <?php echo $form->dropDownList($model, 'discount_type', $model->discountTypeLabels, array('maxLength' => 2)); ?>
        <?php echo $form->error($model, 'discount_type'); ?>
    </div>
    <div class="fade hidden" id="percent-field">
        <div class="row">
            <?php echo $form->labelEx($model, 'percent', array('class' => 'control-label')); ?>
            <?php echo $form->textField($model, 'percent', array('maxLength' => 2)); ?>
            <?php echo $form->error($model, 'percent'); ?>
        </div>
    </div>
    <div class="fade hidden" id="amount-field">
        <div class="row">
            <?php echo $form->labelEx($model, 'amount', array('class' => 'control-label')); ?>
            <?php echo $form->textField($model, 'amount', array('maxLength' => 12)); ?>تومان
            <?php echo $form->error($model, 'amount'); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('ثبت', array('class' => 'btn btn-success')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?

Yii::app()->clientScript->registerScript('change-discount-type', '
        var $type = $("#BookDiscounts_discount_type").val();
        if($type == 1){
            $("#percent-field").removeClass("hidden").addClass("in");
            $("#amount-field").removeClass("in").addClass("hidden");
        }else{
            $("#amount-field").removeClass("hidden").addClass("in");
            $("#percent-field").removeClass("in").addClass("hidden");
        }
        $("body").on("change", "#BookDiscounts_discount_type", function(){
            var $type = $("#BookDiscounts_discount_type").val();
            if($type == 1){
                $("#percent-field").removeClass("hidden").addClass("in");
                $("#amount-field").removeClass("in").addClass("hidden");
            }else{
                $("#amount-field").removeClass("hidden").addClass("in");
                $("#percent-field").removeClass("in").addClass("hidden");
            }
        }).on("change", "#BookDiscounts_book_id", function(){
            var book = $("#BookDiscounts_book_id").val();
            $.ajax({
                url: "'.$this->createUrl('getBookPackages').'",
                type: "POST",
                dataType: "JSON",
                data: {id: book},
                success: function(data){
                    if(data.length != 0){
                        $("#BookDiscounts_package_id").html("");
                        for(var i=0;i<data.length;i++)
                            $("#BookDiscounts_package_id").append("<option value=\'"+data[i].id+"\'>"+data[i].name+"</option>");
                    }else
                        alert("نوبت چاپی برای این کتاب تعریف نشده است!");
                }
            });
        });
    ');
Yii::app()->clientScript->registerScript('datesScript', '
    $(\'#start_date\').persianDatepicker({
        altField: \'#start_date_alt\',
        maxDate:'.(time()*100).',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY  -  h:mm a\',
        autoClose:false,
        persianDigit: true,
        timePicker:{
            enabled:true
        }
    });


    $(\'#end_date\').persianDatepicker({
        altField: \'#end_date_alt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY  -  h:mm a\',
        autoClose:false,
        persianDigit: true,
        timePicker:{
            enabled:true
        }
    });
');

$ss = explode('/', JalaliDate::date("Y/m/d/H/i/s", $model->isNewRecord?time():$model->start_date, false));
$es = explode('/', JalaliDate::date("Y/m/d/H/i/s", $model->isNewRecord?time():$model->end_date, false));
Yii::app()->clientScript->registerScript('dateSets', '
    $("#start_date").persianDatepicker("setDate",['.$ss[0].','.$ss[1].','.$ss[2].','.$ss[3].','.$ss[4].','.$ss[5].']);
    $("#end_date").persianDatepicker("setDate",['.$es[0].','.$es[1].','.$es[2].','.$es[3].',00,00]);
');