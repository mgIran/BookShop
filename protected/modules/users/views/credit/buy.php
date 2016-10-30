<?php
/* @var $this CreditController */
/* @var $model Users */
/* @var $amounts Array */
?>

<div class="white-form">

<?php echo CHtml::beginForm($this->createUrl('/users/credit/bill'));?>

    <?php if(Yii::app()->user->hasFlash('min_credit_fail')):?>
    <div class="alert alert-danger fade in">
        <p>اعتبار شما کافی نیست!</p>
        <?php echo Yii::app()->user->getFlash('min_credit_fail');?>
    </div>
    <?php endif;?>

    <h3>خرید اعتبار</h3>
    <p class="description">میزان اعتبار مورد نظر را انتخاب کنید:</p>
    <div class="form-group">
        <?php echo CHtml::radioButtonList('amount', '5000', $amounts);?>
    </div>
    <div class="buttons">
        <?php echo CHtml::submitButton('خرید', array('class'=>'btn btn-default'));?>
    </div>

<?php echo CHtml::endForm(); ?>

</div>