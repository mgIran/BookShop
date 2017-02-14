<?php
/* @var $this ShopOrderController */
/* @var $form CActiveForm */
/* @var $user Users */
/* @var $shippingMethods ShopShippingMethod[] */

Yii::app()->clientScript->registerScript('delete-update-address-script','
    $("body").on("click", ".edit-link", function(){
        var $this = $(this);
        $.ajax({
            url: $this.attr("href"),
            dataType: "JSON",
            beforeSend: function(){
                $("#basket-loading").fadeIn();
            },
            success: function(data){
                console.log($(data.content).find("#add-address-modal").html());
                $("#basket-loading").fadeOut();
            }
        });
    });
    
    $("body").on("click", ".remove-link", function(e){
        e.preventDefault();
        if(confirm("آیا از حذف این آدرس اطمینان دارید؟")){
            var $this = $(this);
            $.ajax({
                url: $this.attr("href"),
                type: "POST",
                data: {id: $this.data("id")},
                dataType: "JSON",
                beforeSend: function(){
                    $("#basket-loading").fadeIn();
                },
                success: function(data){
                    $("#addresses-list-container").html(data.content);
                    $("#basket-loading").fadeOut();
                }
            });
        }
    });
');
?>
<div class="page">
    <div class="page-heading">
        <div class="container">
            <h1>اطلاعات ارسال سفارش</h1>
        </div>
    </div>
    <div class="container page-content relative">
        <?php $this->renderPartial('shop.views.shipping._loading', array('id' => 'basket-loading')) ?>
        <div class="white-box cart">
            <?php $this->renderPartial('/order/_steps', array('point' => 1));?>
            <div class="select-address">
                <h5 class="pull-right">انتخاب آدرس</h5>
                <a href="#" data-toggle="modal" data-target="#add-address-modal" class="btn-green pull-left">افزودن آدرس جدید</a>
                <div class="clearfix"></div>
                <div id="addresses-list-container">
                    <?php $this->renderPartial("/shipping/_addresses_list", array("addresses"=>$user->addresses));?>
                </div>
                <?php $this->renderPartial("/shipping/_add_address_modal");?>
                <div class="shipping-method">
                    <h5>شیوه ارسال</h5>
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'id' => 'shipping-list',
                        'dataProvider' => new CArrayDataProvider($shippingMethods,array(
                            'pagination' => false
                        )),
                        'itemView' => 'shop.views.shipping._shipping_item',
                        'template' => '{items}',
                        'itemsCssClass' => 'shipping-methods-list'
                    ));
                    ?>
                </div>
                <div class="buttons">
                    <a href="<?= $this->createUrl('/shop/cart/view') ?>" class="btn-black pull-right">بازگشت به سبد خرید</a>
                    <a href="<?= $this->createUrl('/shop/order/create') ?>" class="btn-blue pull-left">بازبینی سفارش</a>
                </div>
            </div>
        </div>
    </div>
</div>
