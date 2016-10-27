<?php

class SettingManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $defaultAction = 'changeSetting';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'changeSetting'
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

	/**
	 * Change site setting
	 */
    public function actionChangeSetting(){
        if(isset($_POST['SiteSetting'])){
            foreach($_POST['SiteSetting'] as $name => $value)
            {
                if($name=='buy_credit_options')
                {
                    $value=explode(',', $value);
                    $field = SiteSetting::model()->findByAttributes(array('name'=>$name));
                    SiteSetting::model()->updateByPk($field->id,array('value'=>CJSON::encode($value)));
                }
                else
                {
                    $field = SiteSetting::model()->findByAttributes(array('name'=>$name));
                    SiteSetting::model()->updateByPk($field->id,array('value'=>$value));
                }
            }
            Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
            $this->refresh();
        }
        $model = SiteSetting::model()->findAll();
        $this->render('_general',array(
            'model'=>$model
        ));
    }
}
