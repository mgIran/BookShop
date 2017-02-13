<?php
/* @var $this ShopCartController */
/* @var $books Books[] */
/* @var $model Books */
?>
<div class="page">
	<div class="page-heading">
		<div class="container">
			<h1>سبد خرید شما</h1>
		</div>
	</div>
	<div class="container page-content relative">
        <?php $this->renderPartial('//partial-views/_loading',array('id' => 'basket-loading')) ?>
		<div class="white-box cart" id="basket-table">
            <?php $this->renderPartial('_basket_table',array('books' => $books)) ?>
		</div>
	</div>
</div>
<?php Yii::app()->clientScript->registerScript("update-qty", '
$("body").on("change", ".quantity", function(){
    $.ajax({
        url: "'.$this->createUrl("/shop/cart/updateQty").'",
        type: "POST",
        dataType: "JSON",
        data: {book_id:$(this).data("id"), qty: $(this).val()},
        beforeSend: function(){
            $("#basket-loading").fadeIn();
        },
        success: function(data){
            if(data.status)
            {
            	$("#basket-table").html(data.table);
            	$(".navbar-default .navbar-nav li a .cart-count").text(data.countCart);
			}
            $("#basket-loading").fadeOut();
        }
    });
});
');

Yii::app()->clientScript->registerScript("delete-book", '
$("body").on("click", ".remove", function(e){
	e.preventDefault();
    $.ajax({
        url: $(this).attr("href"),
        type: "POST",
        dataType: "JSON",
        data: {book_id:$(this).data("id")},
        beforeSend: function(){
            $("#basket-loading").fadeIn();
        },
        success: function(data){
            if(data.status)
            {
            	$("#basket-table").html(data.table);
            	$(".navbar-default .navbar-nav li a .cart-count").text(data.countCart);
			}
            $("#basket-loading").fadeOut();
        }
    });
});
');?>