<?php
/* @var $this PublishersPanelController */
/* @var $form CActiveForm */
/* @var $userDetailsModel UserDetails */
/* @var $helpText string */
/* @var $settlementHistory CActiveDataProvider */
/* @var $formDisabled boolean */
?>
<div class="white-form">
    <h3>تسویه حساب</h3>
    <p class="description">می توانید ماهیانه با کتابیک تسویه حساب کنید.</p>

    <?php $this->renderPartial('//partial-views/_flashMessage');?>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-details-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true
        ),
        'htmlOptions'=>array(
            'class'=>'form'
        )
    ));?>

    <label>مبلغ قابل تسویه این ماه :</label><span><?php echo number_format($userDetailsModel->getSettlementAmount(), 0);?> تومان</span>
    <div class="form-row">
<!--        --><?php //echo $form->checkBox($userDetailsModel, 'monthly_settlement', array(
//            'onchange'=>"$('#UserDetails_iban').prop('disabled', function(i, v){return !v;});",
//            'disabled'=>$formDisabled,
//        ));?>
        <?php echo $form->label($userDetailsModel, 'monthly_settlement', array(
            'style'=>'display:inline-block;margin:15px 0;',
        ));?>
        <span>: مبلغ قابل تسویه حداقل <?= Controller::parseNumbers(number_format($min_credit)) ?> تومان است که 20اُم هر ماه به شماره شبای زیر واریز می شود.</span>
    </div>
    <div class="form-row">
        <div class="iban-container">
            <?php echo $form->label($userDetailsModel, 'iban');?>
            <div class="input-group">
                <?php
                if(!$formDisabled)
                    $disabled=(!is_null($userDetailsModel->iban))?false:true;
                else
                    $disabled=true;
                ?>
                <?php echo $form->textField($userDetailsModel, 'iban', array(
                    'class'=>'form-control',
                    'maxLength' => 24,
                    'aria-describedby'=>'basic-addon1',
                    'style'=>'direction: ltr;',
                    'placeholder'=>'100020003000400050006047:مثال',
                    'disabled'=>$disabled,
                ));?>
                <span id="basic-addon1" class="input-group-addon">IR</span>
            </div>
            <?php echo $form->error($userDetailsModel, 'iban');?>
        </div>
        <div class="buttons overflow-hidden">
            <?php echo CHtml::submitButton('ثبت', array(
                'class'=>'btn btn-default pull-right',
                'id'=>'settlement-button',
                'disabled'=>$formDisabled,
            ));?>
<!--            <a data-toggle="collapse" href="#help-box" class="btn btn-danger pull-left">راهنما</a>-->
        </div>
    </div>
    <?php $this->endWidget();?>

    <div class="panel panel-warning settlement-help">
        <div id="help-box" class="panel-collapse collapse">
            <div class="panel-body"><?php echo $helpText;?></div>
        </div>
    </div>

    <div class="settlement-history">
        <h3>تاریخچه تسویه حساب</h3>
        <p class="description">تسویه حساب هایی که تا به امروز انجام شده است.</p>
        <table class="table">
            <thead>
                <tr>
                    <td>مبلغ</td>
                    <td>تاریخ</td>
                    <td>کد رهگیری</td>
                    <td>شماره شبا</td>
                </tr>
            </thead>
            <tbody>
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$settlementHistory,
                    'itemView'=>'_settlement_list',
                    'template'=>'{items}'
                ));?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">جمع کل درآمد</td>
                    <td colspan="2"><?= Controller::parseNumbers(number_format($this::$sumSettlement)).' تومان' ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>