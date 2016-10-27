<?php

class ClassTagsManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				  'actions'=>array('index','create','update','admin','delete','list'),
				  'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ClassTags;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['ClassTags']))
		{
			$model->attributes=$_POST['ClassTags'];
			if($model->save())
			{
				if(isset($_GET['ajax-request']))
				{
					echo CJSON::encode(array('state' => 1,'msg' => 'اطلاعات با موفقیت ذخیره شد.'));
					Yii::app()->end();
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
			{
				if(isset($_GET['ajax-request']))
				{
					echo CJSON::encode(array('state' => 0,'msg' => 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.'));
					Yii::app()->end();
				}
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClassTags']))
		{
			$model->attributes=$_POST['ClassTags'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ClassTags('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClassTags']))
			$model->attributes=$_GET['ClassTags'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ClassTags the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ClassTags::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ClassTags $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionList($term = null ,$currentTags = null) {
		if ($currentTags && !empty($currentTags))
			$currentTags = CJSON::decode($currentTags);
		if ($term && !empty($term)) {
			$criteria = new CDbCriteria();
			$criteria->limit = '10';
			$criteria->condition = 'title REGEXP :title';
			$criteria->params = array(':title'=>$term);
			$criteria->addNotInCondition('title',$currentTags);
			$data = ClassTags::model()->findAll($criteria);
			$temp = array();
			foreach($data as $k=>$value)
			{
				$temp[$k]['value'] = $value->id;
				$temp[$k]['text'] = $value->title;
			}
			echo CJSON::encode($temp);
		}
	}
}
