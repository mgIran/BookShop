<?php
/* @var $this ShopOrderController */
/* @var $form CActiveForm */
/* @var $user Users */
/* @var $shippingMethods ShopShippingMethod[] */

Yii::app()->clientScript->registerScript('delete-update-address-script','
    $("body").on("click", ".edit-link", function(e){
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            url: $this.attr("href"),
            dataType: "JSON",
            beforeSend: function(){
                $("#basket-loading").fadeIn();
            },
            success: function(data){
                $("#add-address-modal").html($(data.content).html());
                $("#basket-loading").fadeOut();
                $("#add-address-modal").modal("show");
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

    $("body").on("click", "#add-address-modal #address-form input[type=\'submit\']", function(){
        var form = $("#add-address-modal #address-form");
        var loading = $("#add-address-modal.modal .loading-container");
        submitAjaxForm(
            form,
            form.attr("action"),
            loading,
            "if(html.status){ $(\'#addresses-list-container\').html(html.content); $(\'#add-address-modal #address-form input[type=\"text\"]\').val(\'\'); $(\'#add-address-modal .close\').trigger(\'click\'); $(\'#places-label\').html(\'شهرستان مورد نظر را انتخاب کنید\'); $(\'#places\').html(\'\'); $(\'#places-hidden\').val(\'\'); $(\'#towns-label\').html(\'استان مورد نظر را انتخاب کنید\'); $(\'#towns-hidden\').val(\'\'); }else $(\'#add-address-modal #summary-errors\').html(html.errors);");
        return false;
    });

    $("body").on("click", "#add-address-modal-trigger", function(){
        $("#add-address-modal #address-form").attr("action", "'.Yii::app()->createUrl("/shop/addresses/add").'");
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
            <?php $this->renderPartial('//partial-views/_flashMessage');?>
            <div class="select-address">
                <?php echo CHtml::beginForm(array("/shop/order/create"));?>
                    <?php echo CHtml::hiddenField("form", "shipping-form");?>
                    <h5 class="pull-right">انتخاب آدرس</h5>
                    <a href="#" data-toggle="modal" data-target="#add-address-modal" id="add-address-modal-trigger" class="btn-green pull-left">افزودن آدرس جدید</a>
                    <div class="clearfix"></div>
                    <div id="addresses-list-container">
                        <?php $this->renderPartial("/shipping/_addresses_list", array("addresses"=>$user->addresses));?>
                    </div>
                    <div class="shipping-method">
                        <h5>شیوه ارسال</h5>
                        <?php $this->widget('zii.widgets.CListView', array(
                            'id' => 'shipping-list',
                            'dataProvider' => new CArrayDataProvider($shippingMethods,array(
                                'pagination' => false
                            )),
                            'itemView' => 'shop.views.shipping._shipping_item',
                            'template' => '{items}',
                            'itemsCssClass' => 'shipping-methods-list'
                        )); ?>
                    </div>
                    <div class="buttons">
                        <a href="<?= $this->createUrl('/shop/cart/view') ?>" class="btn-black pull-right">بازگشت به سبد خرید</a>
                        <?php echo CHtml::submitButton("بازبینی سفارش", array("class"=>"btn-blue pull-left"));?>
                    </div>
                <?php echo CHtml::endForm();?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial("/shipping/_add_address_modal");?>