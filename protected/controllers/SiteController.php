<?php

class SiteController extends Controller
{
    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'index',
                'error',
                'contact',
                'about',
                'contactUs',
                'help',
                'terms',
                'privacy',
            )
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&views=FileName
            'page' => array(
                'class' => 'CViewAction',
            )
        );
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        Yii::import('rows.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';

        $categoriesDataProvider = new CActiveDataProvider('BookCategories' ,array('criteria' => BookCategories::model()->getValidCategories()));
        // get suggested list
        $suggestedDataProvider = null;
        $model = RowsHomepage::model()->findByAttributes(array('title' => 'پیشنهاد ما'));
        if($model && $model->status == 1)
        {
            $visitedCats = CJSON::decode(base64_decode(Yii::app()->request->cookies['VC']));
            $suggestedCookieDataProvider = Books::model()->findAll(Books::model()->getValidBooks($visitedCats));
            if(count($suggestedCookieDataProvider)<10) {
                $criteria = $model->getConstCriteria(Books::model()->getValidBooks(null, 'id DESC', 10));
                $suggestedDataProvider = Books::model()->findAll($criteria);
                $data = $suggestedCookieDataProvider;
                $cookieIds = CHtml::listData($suggestedCookieDataProvider,'id','id');
                var_dump($data);
                foreach ($suggestedDataProvider as $item)
                {
                    if(!in_array($item->id,$cookieIds))
                        $data[] = $item;
                }
                var_dump($data);exit;
            }else $data = $suggestedCookieDataProvider;
            $suggestedDataProvider = new CArrayDataProvider($data);exit;
        }
        // latest books
        $latestBooksDataProvider = null;
        $model = RowsHomepage::model()->findByAttributes(array('title' => 'تازه ترین کتاب ها'));
        if($model && $model->status == 1)
        {
            $criteria = $model->getConstCriteria(Books::model()->getValidBooks(null ,'id DESC' ,10));
            $latestBooksDataProvider = new CActiveDataProvider('Books' ,array(
                'criteria' => $criteria
            ));
            var_dump($latestBooksDataProvider->getData());exit;
        }
        // most purchase books
        $mostPurchaseBooksDataProvider = new CActiveDataProvider('Books' ,array('criteria' => Books::model()->getValidBooks(null ,'download DESC' ,10)));

        // get advertise
        Yii::import('advertises.models.*');
        $advertises = new CActiveDataProvider('Advertises' ,array('criteria' => Advertises::model()->getActiveAdvertises()));
        
        // get rows
        Yii::import('rows.models.*');
        $rows = new CActiveDataProvider('RowsHomepage' ,array(
            'criteria' => RowsHomepage::model()->getActiveRows(),
            'pagination' => false
        ));

        // get news
        Yii::import('news.models.*');
        $news = new CActiveDataProvider('News' ,array(
            'criteria' => News::model()->getValidNews(null,10),
            'pagination' => array('pageSize' => 10)
        ));

        $this->render('index' ,array(
            'categoriesDataProvider' => $categoriesDataProvider ,
            'latestBooksDataProvider' => $latestBooksDataProvider ,
            'mostPurchaseBooksDataProvider' => $mostPurchaseBooksDataProvider ,
            'suggestedDataProvider' => $suggestedDataProvider ,
            'advertises' => $advertises ,
            'news' => $news ,
            'rows' => $rows
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/error';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionAbout()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';
        $model = Pages::model()->findByPk(1);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionContactUs()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';
        $model = Pages::model()->findByPk(8);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionHelp()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';
        $model = Pages::model()->findByPk(6);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionPublishers()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/index';
        $model = Pages::model()->findByPk(9);
        $this->render('//site/pages/page', array('model' => $model));
    }
}