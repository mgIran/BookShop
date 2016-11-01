<?php 
/**
 * @var $newComment Comment
 * @var $form CActiveForm
 */
?>

<div class="comment-form">
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>$this->id,
)); ?>
    <?php 
        echo $form->hiddenField($newComment, 'owner_name'); 
        echo $form->hiddenField($newComment, 'owner_id'); 
        echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
    ?>
    <?php
    if($newComment->avatarLink)
        echo '<div class="default-comment-avatar"><img src="'.$newComment->avatarLink.'" ></div>';
    else
        echo '<div class="default-comment-avatar"></div>';
    ?>
    <div class="inputs-container">
        <div>
            <?php if(!$newComment->user_name): ?>
                <?= $form->textField($newComment,'user_name', array('class'=>'text-field','placeholder' => $newComment->getAttributeLabel('user_name'))); ?>
            <?php else: ?>
                <?= CHtml::textField('',$newComment->user_name, array('class'=>'text-field','disabled'=>'disabled')); ?>
            <?php
            endif;
            ?>
            <?= $form->error($newComment,'user_name'); ?>
        </div>
        <div>
            <?php if(!$newComment->user_email): ?>
                <?= $form->textField($newComment,'user_email', array('class'=>'text-field','placeholder' => $newComment->getAttributeLabel('user_email'))); ?>
            <?php else: ?>
                <?= CHtml::textField('',$newComment->user_email, array('class'=>'text-field','disabled'=>'disabled')); ?>
                <?php
            endif;
            ?>
            <?php echo $form->error($newComment,'user_email'); ?>
        </div>
        <?php
        if(!BookRatings::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId(),'book_id'=>$newComment->owner_id))):
        ?>
        <div class="rating">
            <span>امتیاز</span>
            <ul>
                <li class="stars">
                    <?= CHtml::radioButton('Comment[rate]',false,array('value'=>1,'class'=>'comment-radio-rate')); ?>
                    <i class="icon"></i>
                </li>
                <li class="stars">
                    <?= CHtml::radioButton('Comment[rate]',false,array('value'=>2,'class'=>'comment-radio-rate')); ?>
                    <i class="icon"></i><i class="icon"></i></li>
                <li class="stars">
                    <?= CHtml::radioButton('Comment[rate]',false,array('value'=>3,'class'=>'comment-radio-rate')); ?>
                    <i class="icon"></i><i class="icon"></i><i class="icon"></i></li>
                <li class="stars">
                    <?= CHtml::radioButton('Comment[rate]',false,array('value'=>4,'class'=>'comment-radio-rate')); ?>
                    <i class="icon"></i><i class="icon"></i><i class="icon"></i><i class="icon"></i></li>
                <li class="stars">
                    <?= CHtml::radioButton('Comment[rate]',false,array('value'=>5,'class'=>'comment-radio-rate')); ?>
                    <i class="icon"></i><i class="icon"></i><i class="icon"></i><i class="icon"></i><i class="icon"></i></li>
            </ul>
        </div>
        <?php
        endif;
        ?>
        <div>
            <?php echo $form->textArea($newComment, 'comment_text', array('cols' => 60, 'rows' => 5,'class'=>'text-field','placeholder' => 'نظر خود را بنویسید ...')); ?>
            <?php echo $form->error($newComment, 'comment_text'); ?>
        </div>
        <?php if($this->useCaptcha === true && extension_loaded('gd')): ?>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div>
                    <div class="captcha-box">
                        <?php $this->widget('CCaptcha', array(
                            'captchaAction'=>CommentsModule::CAPTCHA_ACTION_ROUTE,
                            'showRefreshButton' => true
                        )); ?>
                    </div>
                    <?php echo $form->textField($newComment,'verifyCode',array('class' => 'form-control','placeholder' => $newComment->getAttributeLabel('verifyCode'))); ?>

                </div>
                <div class="hint">
                    <?php echo Yii::t($this->_config['translationCategory'], 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.');?>
                </div>
                <?php echo $form->error($newComment, 'verifyCode'); ?>
            </div>
        <?php endif; ?>
        <div class="button-block">
            <?php echo CHtml::button(Yii::t($this->_config['translationCategory'],'Add '.$this->_config['moduleObjectName']),
                array('data-url'=>Yii::app()->createAbsoluteUrl($this->postCommentAction),'class'=> 'btn-blue pull-left comment-submit-form-btn'));
            ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
