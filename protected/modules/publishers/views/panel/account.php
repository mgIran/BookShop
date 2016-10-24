<?php
/* @var $this PanelController */
/* @var $detailsModel UserDetails */
/* @var $devIdRequestModel UserDevIdRequests */
/* @var $nationalCardImage array */
/* @var $registrationCertificateImage array */
?>

<div class="container">
    <? $this->renderPartial('_tab_links',array('active' => $this->action->id)); ?>

    <div class="tab-content card-container">
        <div class="tab-pane active">
            <?php $this->renderPartial('//layouts/_flashMessage'); ?>

            <?php $this->renderPartial('_update_profile_form', array(
                'model'=>$detailsModel,
                'nationalCardImage'=>$nationalCardImage,
                'registrationCertificateImage'=>$registrationCertificateImage,
            ));?>

            <?php if(empty($detailsModel->publisher_id)):?>
                <?php $this->renderPartial('_change_publisher_id_form', array(
                    'model'=>$devIdRequestModel,
                ));?>
            <?php else:?>
                <div class="col-md-6">
                    <h1>شناسه ناشر</h1>
                    <?php echo CHtml::label('شناسه شما: ', '');?>
                    <?php echo $detailsModel->publisher_id;?>
                    <p class="desc">این شناسه دیگر قابل تغییر نیست.</p>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>