<?php

class NewsManageController extends Controller
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
			'frontend'=>array(
				'index',
				'tag',
				'view'
			),
			'backend' => array(
				'create',
				'update',
				'admin',
				'delete',
				'upload',
				'deleteUpload',
				'order'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess + create, update, admin, delete, upload, deleteUpload, order', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
            'upload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'image',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('jpg','jpeg','png')
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'News',
                'attribute' => 'image',
                'uploadDir' => '/uploads/news',
                'thumbSizes' => array('200x200'),
                'storedMode' => 'field'
            ),
		);
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		Yii::app()->theme = 'frontend';
		$this->layout = '//layouts/index';
		$model = $this->loadModel($id);
		$this->keywords = $model->getKeywords();
		$this->description = mb_substr(strip_tags($model->summary),0,160,'UTF-8');
		$this->pageTitle = $model->title;
		// increase seen counter
		Yii::app()->db->createCommand()->update('{{news}}',array('seen'=>((int)$model->seen+1)),'id = :id',array(":id"=>$model->id));

		// get latest news
		$criteria = News::getValidNews(null,4);
		$criteria->addCondition('id <> :id');
		$criteria->params = array(':id' => $id);
		$latestNewsProvider = new CActiveDataProvider("News",array(
			'criteria' => $criteria,
            'pagination' => array('pageSize' => 4)
		));

		$this->categories = NewsCategories::model()->findAll();
		$this->render('view',array(
			'model'=>$model,
			'latestNewsProvider' => $latestNewsProvider
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionTag($id)
	{
		Yii::app()->theme = 'frontend';
		$this->layout = '//layouts/index';

		$model = Tags::model()->findByPk($id);
		$this->keywords = 'کتابیک,برچسب اخبار '.$model->title.',برچسب '.$model->title.','.$model->title;
		$this->pageTitle = 'برچسب '.$model->title;

		// get latest news
		$criteria = News::getValidNews();
		$criteria->together = true;
		$criteria->compare('tagsRel.tag_id',$model->id);
		$criteria->with[] = 'tagsRel';
		$dataProvider = new CActiveDataProvider("News",array(
			'criteria' => $criteria,
            'pagination' => array('pageSize' => 8)
		));
		$this->categories = NewsCategories::model()->findAll();
		$this->render('tags',array(
			'model' => $model,
			'dataProvider' => $dataProvider
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new News;

		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/news/";
		if (!is_dir($imageDIR))
			mkdir($imageDIR);
		if (!is_dir($imageDIR.'200x200'))
			mkdir($imageDIR.'200x200');

		$image = array();
		if(isset($_POST['News']))
		{
			$model->attributes=$_POST['News'];
			if (isset($_POST['News']['image'])) {
				$file = $_POST['News']['image'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl . '/' . $file,
					'size' => filesize($tmpDIR . $file),
					'serverName' => $file,
				);
			}
			if($model->status == 'publish')
				$model->publish_date = time();
			$model->formTags = isset($_POST['News']['formTags'])?explode(',',$_POST['News']['formTags']):null;
			if($model->save())
			{
				if ($model->image and file_exists($tmpDIR.$model->image)) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR . $model->image, 200, 200, false, $imageDIR.'200x200/' . $model->image);
					rename($tmpDIR . $model->image, $imageDIR . $model->image);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
			'image' => $image
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
		$tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/news/";
		if (!is_dir($imageDIR))
			mkdir($imageDIR);
		if (!is_dir($imageDIR.'200x200'))
			mkdir($imageDIR.'200x200');
		$imageUrl = Yii::app()->baseUrl .'/uploads/news/';

		$image = array();
		if ($model->image and file_exists($imageDIR.$model->image)) {
			$file = $model->image;
			$image = array(
				'name' => $file,
				'src' => $imageUrl . '/' . $file,
				'size' => filesize($imageDIR . $file),
				'serverName' => $file,
			);
		}

		foreach($model->tags as $tag)
			array_push($model->formTags,$tag->title);

		if(isset($_POST['News']))
		{
			$model->attributes=$_POST['News'];
			if (isset($_POST['News']['image']) and file_exists($tmpDIR.$_POST['News']['image'])) {
				$file = $_POST['News']['image'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl . '/' . $file,
					'size' => filesize($tmpDIR . $file),
					'serverName' => $file,
				);
			}
			if($model->status == 'publish' && !$model->publish_date)
				$model->publish_date = time();
			$model->formTags = isset($_POST['News']['formTags'])?explode(',',$_POST['News']['formTags']):null;
			if($model->save())
			{
				if ($model->image and file_exists($tmpDIR.$model->image)) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR . $model->image, 200, 200, false, $imageDIR.'200x200/' . $model->image);
					rename($tmpDIR . $model->image, $imageDIR . $model->image);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
			'image' => $image
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/news/";
		$model = $this->loadModel($id);
		if(file_exists($imageDIR.$model->image))
		{
			@unlink($imageDIR.$model->image);
			@unlink($imageDIR.'200x200/'.$model->image);
		}
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Yii::app()->theme = 'frontend';
		$this->layout = '//layouts/index';
		$criteria = News::model()->getValidNews();
		$this->categories = NewsCategories::model()->findAll();
		$dataProvider=new CActiveDataProvider('News',array(
			'criteria' => $criteria,
			'pagination' => false
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return News the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param News $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
