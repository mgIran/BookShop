<?php

class ShopAddressesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/public';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'frontend' => array('add', 'remove', 'update'),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess',
//			'postOnly + add, remove, update',
		);
	}




	public function actionRemove(){
		if(isset($_POST['id'])){
			$model = $this->loadModel((int)$_POST['id']);
			Yii::app()->getModule('places');
			$this->beginClip('address-list');

			if($model->delete())
				$this->renderPartial('shop.views.shipping._alertMessage', array(
					'type' => 'success',
					'class' => 'address-list',
					'message' => '<span class="icon icon-check"></span> آدرس با موفقیت حذف گردید.',
					'autoHide' => true
				));
			else
				$this->renderPartial('shop.views.shipping._alertMessage', array(
					'type' => 'danger',
					'class' => 'address-list',
					'message' => 'متاسفانه در حذف آدرس مشکلی پیش آمده است! لطفا مجددا تلاش کنید.',
					'autoHide' => true
				));

			$this->renderPartial('shop.views.shipping._addresses_list', array('addresses' => $model->user->addresses));
			$this->endClip();
			echo CJSON::encode(['status' => true, 'content' => $this->clips['address-list']]);
		}
	}

	public function actionAdd()
	{
		$model = new ShopAddresses();
		$model->user_id = Yii::app()->user->getId();
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'address-form'){
			$errors = CActiveForm::validate($model);
			if(CJSON::decode($errors)){
				echo $errors;
				Yii::app()->end();
			}
		}
		if(isset($_POST['ShopAddresses'])){
			$model->attributes = $_POST['ShopAddresses'];
			Yii::app()->getModule('places');
			$this->beginClip('address-list');
			if($model->save())
				$this->renderPartial('shop.views.shipping._alertMessage', array(
					'type' => 'success',
					'class' => 'address-list',
					'message' => '<span class="icon icon-check"></span> آدرس با موفقیت ثبت گردید.',
					'autoHide' => true
				));
			else
				$this->renderPartial('shop.views.shipping._alertMessage', array(
					'type' => 'danger',
					'class' => 'address-list',
					'message' => 'متاسفانه در ثبت آدرس مشکلی پیش آمده است! لطفا مجددا تلاش کنید.',
					'autoHide' => true
				));

			$this->renderPartial('shop.views.shipping._addresses_list', array('addresses' => $model->user->addresses));
			$this->endClip();
			echo CJSON::encode(['status' => true, 'content' => $this->clips['address-list']]);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopOrder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopAddresses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
