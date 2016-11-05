<?php
/* @var $this BookController */
/* @var $model Books */
/* @var $user Users */
/* @var $bought boolean */
/* @var $price string */
?>
<div class="white-form">
    <h3>خرید کتاب</h3>
    <p class="description">جزئیات خرید شما به شرح ذیل می باشد:</p>

    <?php $this->renderPartial('//partial-views/_flashMessage');?>

    <?php if(Yii::app()->user->hasFlash('credit-failed')):?>
        <div class="alert alert-danger fade in">
            <?php echo Yii::app()->user->getFlash('credit-failed');?>
            <?php if(Yii::app()->user->hasFlash('failReason') and Yii::app()->user->getFlash('failReason')=='min_credit'):?>
                <a href="<?php echo $this->createUrl('/users/credit/buy');?>">خرید اعتبار</a>
            <?php endif;?>
        </div>
    <?php endif;?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'book-buys-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <p><label class="buy-label">کتاب</label><span><a href="<?php echo $this->createUrl('/book/view', array('id'=>$model->id, 'title'=>$model->title));?>" title="<?php echo CHtml::encode($model->title);?>"><?php echo CHtml::encode($model->title);?></a></span></p>
    <p><label class="buy-label">مبلغ</label><span><?php echo CHtml::encode(number_format($price, 0));?> تومان</span></p>
    <hr>
    <p><label class="buy-label">اعتبار فعلی</label><span><?php echo CHtml::encode(number_format($user->userDetails->credit, 0));?> تومان</span></p>
    <?php if($bought):?>
        <div class="alert alert-success">
            مبلغ این کتاب قبلا از حساب شما کسر گردیده است. شما می توانید از طریق برنامه موبایل و ویندوز کتاب مورد نظر را دریافت و مطالعه کنید.
        </div>
    <?php else:?>
        <div class="buttons">
            <?php echo CHtml::submitButton('پرداخت', array(
                'class'=>'btn btn-default',
                'name'=>'buy'
            ))?>
        </div>
    <?php endif;?>
    <?php $this->endWidget();?>

</div>