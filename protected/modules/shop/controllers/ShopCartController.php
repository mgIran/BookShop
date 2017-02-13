<?php

class ShopCartController extends Controller
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
			'frontend' => array('view', 'index', 'add', 'remove', 'getPriceTotal'),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess + s',
			'postOnly + add',
		);
	}

	public function actionView()
	{
		$cart = Shop::getCartContent();

		$this->render('view',array(
			'books'=>$cart
		));
	}

	public function actionGetPriceTotal() {
		echo Shop::getPriceTotal();
	}

	public function actionUpdateAmount()
	{
		$cart = Shop::getCartContent();

		foreach($_GET as $key => $value){
			if(substr($key, 0, 4) == 'qty_'){
				if($value == '')
					return true;
				if(!is_numeric($value) || $value <= 0)
					throw new CException('تعداد نامعتبر است.');
				$position = explode('_', $key);
				$position = $position[1];

				if(isset($cart[$position]['amount']))
					$cart[$position]['amount'] = $value;
				$book = Books::model()->findByPk($position);
				echo $book->getOff_printed_price();
				return Shop::setCartContent($cart);
			}
		}
	}


	public function actionRemove($id){
		$id = (int) $id;
		$cart = json_decode(Yii::app()->user->getState('cart'), true);

		unset($cart[$id]);
		Yii::app()->user->setState('cart', json_encode($cart));

		$this->redirect(array('//shop/cart/view'));
	}

	public function actionAdd(){
		$cart = Shop::getCartContent();
		// remove potential clutter
		if(isset($_POST['yt0']))
			unset($_POST['yt0']);
		if(isset($_POST['yt1']))
			unset($_POST['yt1']);
		$id = $_POST['book_id'];
		if(is_array($cart) && in_array($id,$cart))
		{
			$amount = $cart[$id]['amount'];
			if($amount<10)
				$cart[$id]['amount']+= $amount;
		}else
			$cart[$id] = $_POST;
		Shop::setCartcontent($cart);
		$this->redirect(array('//shop/cart/view'));
	}

	public function actionIndex()
	{
		$this->redirect(array('view'));
	}
}
