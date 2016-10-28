<?php

class ManageBooksImagesManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'upload',
				'deleteUploaded'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess',
		);
	}

	public function actions(){
		return array(
			'upload' => array(
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'image',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('jpg','jpeg','png')
				)
			)
		);
	}

	/**
	 * Delete book images
	 */
	public function actionDeleteUploaded()
	{
		if (isset($_POST['fileName'])) {
			$fileName = $_POST['fileName'];
			$uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/books/images/';

			$model = BookImages::model()->findByAttributes(array('image' => $fileName));
			$response = null;
			if (!is_null($model)) {
				if (@unlink($uploadDir . $fileName)) {
					$response = ['state' => 'ok', 'msg' => 'حذف شد.'];
					$model->delete();
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}
}
