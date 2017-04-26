<?php

class DiscountCodesManageController extends Controller
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
			'frontend' => array('view', 'removeCode'),
			'backend' => array('admin', 'create', 'update', 'delete', 'codeGenerator', 'report')
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - view, removeCode', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			'ajaxOnly + codeGenerator', // we only allow deletion via POST request
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DiscountCodes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DiscountCodes']))
		{
			$model->attributes=$_POST['DiscountCodes'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success','کد تخفیف جدید اضافه گردید!');
				$this->refresh();
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DiscountCodes']))
		{
			$model->attributes=$_POST['DiscountCodes'];
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DiscountCodes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DiscountCodes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DiscountCodes']))
			$model->attributes=$_GET['DiscountCodes'];
		$model->user_id=NULL;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionReport()
	{
		$this->layout = '//layouts/column1';
		$model=new DiscountUsed('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DiscountUsed']))
			$model->attributes=$_GET['DiscountUsed'];

		$this->render('report',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DiscountCodes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DiscountCodes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DiscountCodes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='discount-codes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionCodeGenerator(){
        $code= DiscountCodes::model()->codeGenerator();
        if($code)
            $result = ['status' => true, 'code' => $code];
        else
            $result = ['status' => false, 'msg' => "متاسفانه مشکلی در تولید کد بوجود آمده است! لطفاً مجددا امتحان کنید."];
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    #region remove discount code
    public function actionRemoveCode(){
        if(isset($_POST['code'])) {
            $code = $_POST['code'];
            if (Yii::app()->user->hasState('discount-codes')) {
                $discountCodesInSession = Yii::app()->user->getState('discount-codes');
                $discountCodesInSession = CJSON::decode(base64_decode($discountCodesInSession));
                if(is_array($discountCodesInSession) && in_array($code, $discountCodesInSession))
                {
                    $key = array_search($code, $discountCodesInSession);
                    unset($discountCodesInSession[$key]);
                }
                else if(!is_array($discountCodesInSession) && $code == $discountCodesInSession)
                    $discountCodesInSession = null;
                if($discountCodesInSession)
                    Yii::app()->user->setState('discount-codes', base64_encode(CJSON::encode($discountCodesInSession)));
                else
                    Yii::app()->user->setState('discount-codes', null);
                echo CJSON::encode(['status' => true]);
                Yii::app()->end();
            }
        }
    }
    #endregion
}
