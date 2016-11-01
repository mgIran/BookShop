<div class="comment-widget <?= Yii::app()->language != 'fa_ir'?'en':'' ?>" id="<?php echo $this->id?>">
<?php
    echo '<div class="comments-list-outer">';
    $this->render('ECommentsWidgetComments', array('newComment' => $newComment ,'comments' => $comments));
    echo '</div>';
    echo '<div class="comment-form-outer" id="comment-form" >';
    echo "<h4>نظرتان را بگویید</h4>";
    if($this->showPopupForm === true)
    {
        if($this->registeredOnly === false || Yii::app()->user->isGuest === false)
        {
            echo '<div class="loading-container"><div class="overly"></div><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
            echo "<div class='comment-form' id=\"addCommentDialog-{$this->id}\">";
            $this->widget('comments.widgets.ECommentsFormWidget', array(
                'model' => $this->model,
            ));
            echo "</div>";
        }
    }
    if($this->registeredOnly === true && Yii::app()->user->isGuest === true)
    {
        // @todo change login and signup links
        Yii::app()->user->returnUrl = Yii::app()->request->url;
        echo Yii::t($this->_config['translationCategory'], 'To add any '.$this->_config['moduleObjectName'].', you should sign up first.');
        echo '&nbsp;<a href="'.Yii::app()->createUrl('/login').'">'.Yii::t($this->_config['translationCategory'], 'Log In').'</a>';
        echo '&nbsp;'.Yii::t($this->_config['translationCategory'],'or').'&nbsp;';
        echo '<a target="_blank" href="'.Yii::app()->createUrl('/register').'">'.Yii::t($this->_config['translationCategory'], 'Sign Up.').'</a>';
    }
    echo "</div>";
?>
</div>
