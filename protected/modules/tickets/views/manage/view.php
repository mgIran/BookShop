
<?php
/* @var $this TicketsManageController */
/* @var $model Tickets */

?>

<div class="container dashboard-container ticket-box">
	<div class="container-fluid tab-content">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-left">
			<?
			if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'admin'):
			?>
				<div class="form-group text-center">
					<a class="btn btn-info" href="<?= $this->createUrl('/tickets/manage/admin') ?>" >لیست تیکت ها</a>
				</div>
			<?
			endif;
			?>
			<?
			if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):
			?>
				<div class="form-group text-center">
					<a class="btn btn-info" href="<?= $this->createUrl('/tickets/manage/') ?>" >لیست تیکت ها</a>
				</div>
			<?
			endif;
			?>
			<?
			if($model->status != 'close'):
			?>
				<div class="form-group text-center">
					<a class="btn btn-danger" href="<?= $this->createUrl('/tickets/manage/closeTicket/'.$model->code) ?>" >بستن تیکت</a>
				</div>
			<?
			endif;
			?>
			<?
			if(!Yii::app()->user->isGuest && Yii::app()->user->type != 'user'):
				if($model->status != 'pending'):
					?>
					<div class="form-group text-center">
						<a class="btn btn-warning" href="<?= $this->createUrl('/tickets/manage/pendingTicket/'.$model->code) ?>" >در حال بررسی</a>
					</div>
					<?
				endif;
				if($model->status == 'pending' || $model->status == 'close' || $model->status == 'waiting'):
					?>
					<div class="form-group text-center">
						<a class="btn btn-info" href="<?= $this->createUrl('/tickets/manage/openTicket/'.$model->code) ?>" >باز</a>
					</div>
					<?
				endif;
			endif;
			?>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-right">
			<?
			if($model->status == 'close'):
				$this->renderPartial('//layouts/_alertMessage',array(
					'type' => 'danger',
					'message' => 'تیکت مورد نظر بسته شده و امکان ارسال پیام وجود ندارد.'
				));
			elseif($model->status == 'pending'):
				$this->renderPartial('//layouts/_alertMessage',array(
						'type' => 'warning',
						'message' => 'پیام شما در حال بررسی توسط کارشناس می باشد.'
				));
			endif;
			?>
			<h4>تیکت شماره #<?php echo $model->code; ?></h4>
			<div class="ticket-detail">
				<h5>موضوع: <?= $model->subject ?></h5>
				<span class="ticket-date">تاریخ ایجاد: <?= Controller::parseNumbers(JalaliDate::date("Y/m/d H:i:s" ,$model->date)) ?></span>
			</div>
			<? $this->renderPartial('//layouts/_flashMessage') ?>
			<?php
			if($model->status != 'close')
				$this->renderPartial('tickets.views.messages._form',array(
					'model' => new TicketMessages(),
					'ticket' => $model
				))
			?>
			<?php
			$this->widget('zii.widgets.CListView', array(
				'id' => 'message-list',
				'dataProvider' => new CArrayDataProvider($model->messages),
				'itemView' => '_messageView',
				'template' => '{items}'
			));
			?>

		</div>
	</div>
</div>