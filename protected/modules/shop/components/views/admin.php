<p> <?php echo 'Shop'; ?> </p>
<ul>
<li> <?php echo CHtml::link('Article categories', array('//shop/category/admin')); ?> </li>
<li> <?php echo CHtml::link('Article specifications', array('/shop/productSpecification/admin')); ?> </li>
<li> <?php echo CHtml::link('Articles', array('/shop/products/admin')); ?> </li>
<li> <?php echo CHtml::link('Shipping methods', array('/shop/shippingMethod/admin')); ?> </li>
<li> <?php echo CHtml::link('Payment methods', array('/shop/paymentMethod/admin')); ?> </li>
<li> <?php echo CHtml::link('Tax', array('/shop/tax/admin')); ?> </li>
<li> <?php echo CHtml::link('Orders', array('/shop/order/admin')); ?> </li>

<?php if(isset(Yii::app()->controller->menu)) {
	foreach(Yii::app()->controller->menu as $value) {
		printf('<li>%s</li>', CHtml::link($value['label'], $value['url']));
	}
}
?>
</ul>

