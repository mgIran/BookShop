<?php

class AdvertisesManageController extends Controller
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
			'backend' => array(
				'create',
				'update',
				'admin',
				'delete',
				'upload',
				'deleteUpload'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessAdmin', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function actions(){
		return array(
			'upload' => array(
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'cover',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('jpg','jpeg','png')
				)
			),
			'deleteUpload' => array(
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'Advertises',
				'attribute' => 'cover',
				'uploadDir' => 'uploads/advertisesCover',
				'storedMode' => 'field'
			)
		);
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Advertises;

		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = $this->createAbsoluteUrl('/uploads/temp/');
		$coverDIR = Yii::getPathOfAlias("webroot") . "/uploads/advertisesCover/";
		if (!is_dir($coverDIR))
			mkdir($coverDIR);
		$cover = array();

		if(isset($_POST['Advertises'])) {
			$model->attributes = $_POST['Advertises'];
			if(isset($_POST['Advertises']['cover'])) {
				$file = $_POST['Advertises']['cover'];
				$cover = array(
						'name' => $file,
						'src' => $tmpUrl.'/'.$file,
						'size' => filesize($tmpDIR.$file),
						'serverName' => $file,
				);
			}
			if($model->save()) {
				if($model->cover)
					rename($tmpDIR.$model->cover, $coverDIR.$model->cover);
				Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
				$this->redirect(array('admin'));
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
			'model' => $model,
			'cover' => $cover,
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

		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = $this->createAbsoluteUrl('/uploads/temp/');

		$coverDIR = Yii::getPathOfAlias("webroot") . "/uploads/advertisesCover/";
		$coverUrl = $this->createAbsoluteUrl("/uploads/advertisesCover/");

		$cover = array();
		if($model->cover && file_exists($coverDIR . $model->cover))
			$cover = array(
					'name' => $model->cover,
					'src' => $coverUrl . '/' . $model->cover,
					'size' => filesize($coverDIR . $model->cover),
					'serverName' => $model->cover,
			);
		if(isset($_POST['Advertises']))
		{
			$model->attributes=$_POST['Advertises'];
			if(isset($_POST['Advertises']['cover'])) {
				$file = $_POST['Advertises']['cover'];
				$cover = array(
						'name' => $file,
						'src' => $tmpUrl.'/'.$file,
						'size' => filesize($tmpDIR.$file),
						'serverName' => $file,
				);
			}
			if($model->save()) {
				if($model->cover)
					rename($tmpDIR.$model->cover, $coverDIR.$model->cover);
				Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ویرایش شد.');
				$this->redirect(array('admin'));
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}
		$this->render('update',array(
			'model'=>$model,
			'cover' => $cover,
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Advertises('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Advertises']))
			$model->attributes=$_GET['Advertises'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Advertises the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Advertises::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}

