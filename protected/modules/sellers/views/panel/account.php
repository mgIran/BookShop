<?php
/* @var $this PanelController */
/* @var $detailsModel UserDetails */
/* @var $devIdRequestModel UserDevIdRequests */
/* @var $nationalCardImage array */
/* @var $registrationCertificateImage array */
?>
<div class="white-form">
    <h3>پروفایل ناشر</h3>
    <p class="description">لطفا فرم زیر را پر کنید.</p>

    <?php $this->renderPartial('//partial-views/_flashMessage'); ?>

    <div class="row">
        <?php $this->renderPartial('_update_profile_form', array(
            'model'=>$detailsModel,
            'nationalCardImage'=>$nationalCardImage,
            'registrationCertificateImage'=>$registrationCertificateImage,
        ));?>
    </div>
</div>