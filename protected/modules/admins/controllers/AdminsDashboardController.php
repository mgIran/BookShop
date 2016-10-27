<?php

class AdminsDashboardController extends Controller
{
    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index',
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
        );
    }

	public function actionIndex()
    {
        Yii::app()->getModule('users');

        $criteria=new CDbCriteria();
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->addCondition('title!=""');
        $criteria->params=array(':confirm'=>'pending',':deleted'=>'0');
        $newestPrograms=new CActiveDataProvider('Books', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='user';
        $criteria->addCondition('user.role_id=2');
        $criteria->addCondition('user.status=:userStatus');
        $criteria->addCondition('details_status=:status');
        $criteria->params=array(':status'=>'pending',':userStatus'=>'active');
        $newestPublishers=new CActiveDataProvider('UserDetails', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='user';
        $criteria->addCondition('user.status=:userStatus');
        $criteria->params=array(':userStatus'=>'active');
        $newestDevIdRequests=new CActiveDataProvider('UserDevIdRequests', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='book';
        $criteria->alias='package';
        $criteria->addCondition('package.status=:packageStatus');
        $criteria->addCondition('book.title!=""');
        $criteria->params=array(
            ':packageStatus'=>'pending',
        );
        $newestPackages=new CActiveDataProvider('BookPackages', array(
            'criteria'=>$criteria,
        ));

        Yii::import("tickets.models.*");
        $criteria = new CDbCriteria();
        $criteria->with[]='messages';
        $criteria->compare('messages.visit' ,0);
        $criteria->compare('messages.sender','user');
        $tickets['new'] = Tickets::model()->count($criteria);

		$this->render('index', array(
            'newestPackages'=>$newestPackages,
            'newestPrograms'=>$newestPrograms,
            'devIDRequests'=>$newestDevIdRequests,
            'newestPublishers'=>$newestPublishers,
            'tickets'=>$tickets,
        ));
	}

}