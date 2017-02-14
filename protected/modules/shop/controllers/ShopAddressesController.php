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
			'postOnly + add, remove, update',
		);
	}




	public function actionRemove(){
		if(isset($_POST)){
			$id = (int)$_POST['book_id'];
			$cart = json_decode(Yii::app()->user->getState('cart'), true);

			unset($cart[$id]);
			Yii::app()->user->setState('cart', json_encode($cart));
			$this->beginClip('basket-table');
			$this->renderPartial('_basket_table', array('books' => $cart));
			$this->endClip();
			echo CJSON::encode([
				'status' => true,
				'countCart' => Controller::parseNumbers(number_format(Shop::getCartCount())),
				'table' => $this->clips['basket-table']
			]);
			Yii::app()->end();
		}
	}

	public function actionAdd(){
		$model = new ShopAddresses();
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'address-form') {
			$errors = CActiveForm::validate($model);
			if (CJSON::decode($errors)) {
				echo $errors;
				Yii::app()->end();
			}
		}
		if(isset($_POST['ShopAddresses']))
		{
			$model->attributes = $_POST['ShopAddresses'];  
			$model->user_id = Yii::app()->user->getId();
			if($model->save())
			{
//				$model->user->refresh();
				$this->beginClip('address-list');
				$this->renderPartial('_addresses_list', array('addresses' => $model->user->addresses));
				$this->endClip();
				echo CJSON::encode(['status' => true, 'html' => $this->clips['address-list']]);
			}
		}
	}
}
