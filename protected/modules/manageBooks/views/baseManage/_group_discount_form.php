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

Yii::app()->clientScript->registerScript('change-group-type','
    changeGroup();
    
    $("body").on("change", "#group_type", function(){
        changeGroup();
    });
    
    function changeGroup(){
        if($("#group_type").val() == "all")
            $("#publisher").hide();
        else
            $("#publisher").fadeIn();
    }
');


?>
<h1>افزودن تخفیف گروهی</h1>
<? $this->renderPartial('//layouts/_flashMessage',array('prefix' => 'discount-')); ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'books-discount-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        )
    ));
    ?>

    <div class="row">
        <?php
        echo CHtml::label('گروه مورد نظر','');
        ?>
        <?php echo CHtml::dropDownList('group_type', isset($_POST['group_type'])?$_POST['group_type']:'',[
            'all' => 'همه کتاب های سایت',
            'publisher' => 'همه کتاب های ناشر'
        ]); ?>
    </div>

    <div class="row" id="publisher">
        <?php
        echo CHtml::label('انتخاب ناشر','');
        ?>
        <?php echo CHtml::dropDownList('publisher_id', isset($_POST['publisher_id'])?$_POST['publisher_id']:'',$publishers,array(
            'class' => 'selectpicker',
            'data-live-search' => true,
        )); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'start_date'); ?>
        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
            'id'=>'start_date',
            'model' => $model,
            'attribute' => 'start_date',
            'options'=>array(
                'format'=>'DD MMMM YYYY  -  h:mm a',
                'autoClose' => false,
                'persianDigit'=> true,
                'timePicker'=>array(
                    'enabled'=>true
                )
            )
        ));?>
        <?php echo $form->error($model, 'start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'end_date'); ?>
        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
            'id'=>'end_date',
            'model' => $model,
            'attribute' => 'end_date',
            'options'=>array(
                'format'=>'DD MMMM YYYY  -  h:mm a',
                'autoClose' => false,
                'persianDigit'=> true,
                'timePicker'=>array(
                    'enabled'=>true
                )
            )
        ));?>
        <?php echo $form->error($model, 'end_date'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'printed_start_date'); ?>
        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
            'id'=>'printed_start_date',
            'model' => $model,
            'attribute' => 'printed_start_date',
            'options'=>array(
                'format'=>'DD MMMM YYYY  -  h:mm a',
                'autoClose' => false,
                'persianDigit'=> true,
                'timePicker'=>array(
                    'enabled'=>true
                )
            )
        ));?>
        <?php echo $form->error($model, 'printed_start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'printed_end_date'); ?>
        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
            'id'=>'printed_end_date',
            'model' => $model,
            'attribute' => 'printed_end_date',
            'options'=>array(
                'format'=>'DD MMMM YYYY  -  h:mm a',
                'autoClose' => false,
                'persianDigit'=> true,
                'timePicker'=>array(
                    'enabled'=>true
                )
            )
        ));?>
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