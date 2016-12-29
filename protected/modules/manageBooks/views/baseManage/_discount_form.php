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
            <?php echo $form->dropDownList($model, 'book_id', $books); ?>
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
        <?php echo $form->labelEx($model, 'printed_start_date'); ?>
        <?php echo CHtml::textField('', '', array('id' => 'printed_start_date')); ?>
        <?php echo $form->hiddenField($model, 'printed_start_date', array('id' => 'printed_start_date_alt')); ?>
        <?php echo $form->error($model, 'printed_start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'printed_end_date'); ?>
        <?php echo CHtml::textField('', '', array('id' => 'printed_end_date')); ?>
        <?php echo $form->hiddenField($model, 'printed_end_date', array('id' => 'printed_end_date_alt')); ?>
        <?php echo $form->error($model, 'printed_end_date'); ?>
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
        <div class="row">
            <?php echo $form->labelEx($model, 'printed_percent', array('class' => 'control-label')); ?>
            <?php echo $form->textField($model, 'printed_percent', array('maxLength' => 2)); ?>
            <?php echo $form->error($model, 'printed_percent'); ?>
        </div>
    </div>
    <div class="fade hidden" id="amount-field">
        <div class="row">
            <?php echo $form->labelEx($model, 'amount', array('class' => 'control-label')); ?>
            <?php echo $form->textField($model, 'amount', array('maxLength' => 12)); ?>تومان
            <?php echo $form->error($model, 'amount'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'printed_amount', array('class' => 'control-label')); ?>
            <?php echo $form->textField($model, 'printed_amount', array('maxLength' => 12)); ?>تومان
            <?php echo $form->error($model, 'printed_amount'); ?>
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
    
    $(\'#printed_start_date\').persianDatepicker({
        altField: \'#printed_start_date_alt\',
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


    $(\'#printed_end_date\').persianDatepicker({
        altField: \'#printed_end_date_alt\',
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
$pss = explode('/', JalaliDate::date("Y/m/d/H/i/s", $model->isNewRecord?time():$model->printed_start_date, false));
$pes = explode('/', JalaliDate::date("Y/m/d/H/i/s", $model->isNewRecord?time():$model->printed_end_date, false));
Yii::app()->clientScript->registerScript('dateSets', '
    $("#start_date").persianDatepicker("setDate",['.$ss[0].','.$ss[1].','.$ss[2].','.$ss[3].','.$ss[4].','.$ss[5].']);
    $("#end_date").persianDatepicker("setDate",['.$es[0].','.$es[1].','.$es[2].','.$es[3].',00,00]);
    $("#printed_start_date").persianDatepicker("setDate",['.$pss[0].','.$pss[1].','.$pss[2].','.$pss[3].','.$pss[4].','.$pss[5].']);
    $("#printed_end_date").persianDatepicker("setDate",['.$pes[0].','.$pes[1].','.$pes[2].','.$pes[3].',00,00]);
');