<?php
/* @var $this PublicController */
/* @var $model Users */
?>

<div class="col-md-6">
    <h3>اعتبار</h3>
    <p>اعتبار فعلی شما:<?php echo number_format($model->userDetails->credit, 0);?> تومان</p>
    <a href="<?php echo $this->createUrl('/users/credit/buy');?>" class="btn btn-primary">خرید اعتبار</a>
</div>