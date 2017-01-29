<?php

class FestivalsManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array('admin', 'create', 'update', 'delete')
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Festivals;

		if(isset($_POST['Festivals']))
		{
			$model->attributes=$_POST['Festivals'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success','طرح جدید اضافه گردید!');
                $this->redirect(array('admin'));
            }
            else
                Yii::app()->user->setFlash('failed','خطا در هنگام ثبت!');
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

		if(isset($_POST['Festivals']))
		{
			$model->attributes=$_POST['Festivals'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success','ویرایش با موفقیت انجام شد');
                $this->refresh();
            }
            else
                Yii::app()->user->setFlash('failed','خطا در هنگام ویرایش!');
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
        
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Festivals');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		Festivals::DeleteExpires();
		$model=new Festivals('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Festivals']))
			$model->attributes=$_GET['Festivals'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Festivals the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Festivals::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Festivals $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='festivals-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
