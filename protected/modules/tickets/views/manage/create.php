<?php
/* @var $this TicketsManageController */
/* @var $model Tickets */

?>

<div class="container dashboard-container ticket-box">
	<div class="container-fluid tab-content">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>
