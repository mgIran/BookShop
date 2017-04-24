<?php
/**
 * Comment controller class file.
 *
 * @author Dmitry Zasjadko <segoddnja@gmail.com>
 * @link https://github.com/segoddnja/ECommentable
 * @version 1.0
 * @package Comments module
 *
 */
class CommentsCommentController extends Controller
{
    public $defaultAction = 'admin';
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend'=>array(
                'postComment',
                'captcha'
            ),
            'backend' => array(
                //'admin',
                'adminBooks',
                'delete',
                'approve'
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess + admin, adminBooks, delete, approve',
            'ajaxOnly + PostComment, Delete, Approve',
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Deletes a particular model.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        // we only allow deletion via POST request
        $result = array('deletedID' => $id);
        if ($this->loadModel($id)->setDeleted())
            $result['code'] = 'success';
        else
            $result['code'] = 'fail';
        echo CJSON::encode($result);
    }

    /**
     * Approves a particular model.
     * @param integer $id the ID of the model to be approve
     */
    public function actionApprove($id)
    {
        // we only allow deletion via POST request
        $result = array('approvedID' => $id);
        if ($this->loadModel($id)->setApproved())
            $result['code'] = 'success';
        else
            $result['code'] = 'fail';
        echo CJSON::encode($result);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Comment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Comment']))
            $model->attributes = $_GET['Comment'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminBooks()
    {
        $model = new Comment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Comment']))
            $model->attributes = $_GET['Comment'];
        $model->owner_name = 'Books';
        $this->render('admin_books', array(
            'model' => $model,
        ));
    }

    public function actionPostComment()
    {
        if (isset($_POST['Comment']) && Yii::app()->request->isAjaxRequest) {
            $comment = new Comment();
            $comment->attributes = $_POST['Comment'];
            $criteria = new CDbCriteria;
            $criteria->compare('owner_name', $comment->owner_name, true);
            $criteria->compare('owner_id', $comment->owner_id);
            $criteria->compare('parent_comment_id', $comment->parent_comment_id);
            $criteria->compare('creator_id', $comment->creator_id);
            $criteria->compare('user_name', $comment->user_name, false);
            $criteria->compare('user_email', $comment->user_email, false);
            $criteria->compare('comment_text', $comment->comment_text, false);
            $criteria->addCondition('create_time>:time');
            $criteria->params[':time'] = time() - 30;
            $model = Comment::model()->find($criteria);
            if ($model)
                Yii::app()->end();
            $result = array();
            if ($comment->save()) {
                if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user' && isset($_POST['Comment']['rate'])) {
                    $rateModel = BookRatings::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->getId(),'book_id'=>$comment->owner_id));
                    if($rateModel)
                        BookRatings::model()->deleteAllByAttributes(array('user_id'=>Yii::app()->user->getId(),'book_id'=>$comment->owner_id));
                    $rateModel = new BookRatings();
                    $rateModel->book_id = $comment->owner_id;
                    $rateModel->user_id = Yii::app()->user->getId();
                    $rateModel->rate = $_POST['Comment']['rate'];
                    @$rateModel->save();
                }
                $result['code'] = 'success';
                $this->beginClip('form');
                $this->widget('comments.widgets.ECommentsFormWidget', array(
                    'model' => $comment->ownerModel,
                ));
                $this->endClip();
                $this->beginClip("list");
                $this->widget('comments.widgets.ECommentsListWidget', array(
                    'model' => $comment->ownerModel,
                    'showPopupForm' => true,
                ));
                $this->endClip();
                $result['list'] = $this->clips['list'];
            } else {
                $result['code'] = 'fail';
                $this->beginClip('form');
                $this->widget('comments.widgets.ECommentsFormWidget', array(
                    'model' => $comment->ownerModel,
                    'validatedComment' => $comment,
                ));
                $this->endClip();
            }
            $result['form'] = $this->clips['form'];
            echo CJSON::encode($result);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Comment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}