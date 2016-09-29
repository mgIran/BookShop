<?php
/* @var $this PublicController */
/* @var $model UserNotifications */
?>
<div class="container dashboard-container">
    <a class="btn btn-default" href="<?php echo Yii::app()->createUrl('/dashboard')?>">پنل کاربری</a>
    <?php if(Yii::app()->user->roles=='publisher'):?>
        <a class="btn btn-default" href="<?php echo Yii::app()->createUrl('/publishers/panel')?>">پنل توسعه دهندگان</a>
    <?php endif;?>
    <div class="tab-content card-container">
        <h4>اطلاعیه ها</h4>
        <hr>
        <ul>
            <?php foreach($model as $notification):?>
                <li style="margin: 15px 0;font-weight: <?php echo ($notification->seen==0)?'bold;color:#d9534f;':'normal';?>"><?php echo CHtml::encode($notification->message);?> | <small><?php echo JalaliDate::date('d F Y - H:i', $notification->date);?></small></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>