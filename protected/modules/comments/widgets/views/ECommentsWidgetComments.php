<?php if(count($comments) > 0):?>
    <ul class="comments-list">
        <?php foreach($comments as $key => $comment):
            if($key % 2 == 0)
                echo '<div class="col">';
            ?>
            <li id="comment-<?php echo $comment->comment_id; ?>">
                <div class="comment-avatar">
                    <?php
                    if($comment->avatarLink && !empty($comment->avatarLink) && file_exists($comment->avatarLink))
                        echo '<img src="'.$comment->avatarLink.'" >';
                    else
                        echo '<div class="default-comment-avatar"></div>';
                    ?>
                </div>
                <div class="comment-header">
                    <span class="comment-name"><?php echo $comment->userName;?></span>
                    <span class="comment-date"><?php echo JalaliDate::differenceTime($comment->create_time);?></span>
                </div>
                <p dir="auto">
                    <?php echo $comment->comment_text;?>
                </p>

                <?php if($this->adminMode === true):?>
                    <div class="admin-panel">
                        <?php if($this->_config['premoderate'] === true && ($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROWED)) {
                            echo CHtml::link(Yii::t($this->_config['translationCategory'], 'approve'), Yii::app()->urlManager->createUrl(
                                CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                            ), array('class'=>'text-success approve'));
                        }?>
                        <?php echo CHtml::link(Yii::t($this->_config['translationCategory'], 'delete'), Yii::app()->urlManager->createUrl(
                            CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                        ), array('class'=>'text-danger delete'));?>
                    </div>
                <?php endif; ?>
                <?php
                    if($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
                    {
                        echo CHtml::link(Yii::t($this->_config['translationCategory'], 'Reply'), '#reply-'.$comment->comment_id, array(
                            'data-comment-id'=>$comment->comment_id,
                            'class'=>'btn btn-info collapsed add-comment',
                            'data-toggle' => 'collapse',
                            'data-parent'=>'#comment-'.$comment->comment_id
                        ));
                        echo "<div class='comment-form comment-form-outer collapse' id='reply-".$comment->comment_id."'>";
                        Yii::app()->controller->renderPartial('//layouts/_loading');
                        $this->widget('comments.widgets.ECommentsFormWidget', array(
                            'model' => $this->model,
                        ));
                        echo "</div>";
                    }
                ?>
                <?php if(count($comment->childs) > 0 && $this->allowSubcommenting === true) $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));?>
            </li>
        <?php
            if($key % 2 == 1)
                echo '</div>';
        endforeach;
        Yii::app()->clientScript->registerScript('comments-carousel','
        $(".comments-list").owlCarousel({
            items : 2,
            nav:true,
            dots:false,
            rtl:true,
            navText:[\'<span class="icon icon-chevron-right"></span>\',\'<span class="icon icon-chevron-left"></span>\'],
            navClass: [\'owl-prev disabled\',\'owl-next\'],
            callbacks: true,
            info: true,
            onTranslated: $(this).on(\'translated.owl.carousel\', function(e) {
                var items_per_page = e.page.size;
                var nav_container = $(\'.comments-list .owl-nav\');
                var item_index = e.item.index;
                var item_count = e.item.count;
                var last_vis_item_index = items_per_page + item_index;
                if(last_vis_item_index === item_count){
                    $(nav_container).find(\'div:last\').addClass(\'disabled\');
                }
                else{
                    $(nav_container).find(\'div:last\').removeClass(\'disabled\');
                }
                if(item_index != 0){
                    $(nav_container).find(\'div:first\').removeClass(\'disabled\');
                }
                else{
                    $(nav_container).find(\'div:first\').addClass(\'disabled\');
                }
            })
        });',CClientScript::POS_LOAD);
        ?>
    </ul>
<?php else:?>
    <p><?php echo Yii::t($this->_config['translationCategory'], 'No '.$this->_config['moduleObjectName'].'s');?></p>
<?php endif;
?>
<script>
function checkRtl( character ) {
    var RTL = ['ا','ب','پ','ت','س','ج','چ','ح','خ','د','ذ','ر','ز','ژ','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ک','گ','ل','م','ن','و','ه','ی'];
    return RTL.indexOf( character ) > -1;
}

function checkChar( character ) {
    if (character.match(/\s/) || character.match(/[0-9-!@#$%^&()_+|~=`{}\[\]:";\'<>?,.\/]/))
        return true;
    else
        return false;
}
var pTags = $(".comments-list").find("p");
pTags.each(function(){
    var firstChar = $(this).text().trim().substr(2,1);
    var $i=3;
    while(checkChar(firstChar) && $i < $(this).text().trim().length)
    {
        firstChar = $(this).text().trim().substr($i,1);
        console.log(firstChar);
        $i++;
    }
    if( checkRtl(firstChar) ) {
        $(this).removeClass("ltr").addClass("rtl");
    } else {
        $(this).removeClass("rtl").addClass("ltr");
    }
});
</script>

