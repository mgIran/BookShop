<?php

class ManageBooksBaseManageController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $formats = '.epub ,.pdf';

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'view',
                'create',
                'update',
                'admin',
                'delete',
                'upload',
                'deleteUpload',
                'uploadFile',
                'deleteUploadedFile',
                'changeConfirm',
                'deletePackage',
                'savePackage',
                'images',
                'download',
                'updatePackage',
                'downloadPackage',
                'discount',
                'createDiscount',
                'groupDiscount',
                'updateDiscount',
                'deleteDiscount',
                'deleteSelectedDiscount',
                'uploadPreview',
                'deleteUploadedPreview',
                'deletePdfFile',
                'deleteEpubFile',
                'changePublisherCommission',
                'getBookPackages',
            )
        );
    }

    public function beforeAction($action)
    {
        if(!is_dir(Yii::getPathOfAlias("webroot") . "/uploads/books/files/"))
            mkdir(Yii::getPathOfAlias("webroot") . "/uploads/books/files/");
        if(!is_dir(Yii::getPathOfAlias("webroot") . "/uploads/books/previews/"))
            mkdir(Yii::getPathOfAlias("webroot") . "/uploads/books/previews/");
        return true;
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess', // perform access control for CRUD operations
            'postOnly + delete, changePublisherCommission', // we only allow deletion via POST request
        );
    }

    public function actions()
    {
        return array(
            'upload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'icon',
                'rename' => 'random',
                'validateOptions' => array(
                    'dimensions' => array(
                        'minWidth' => 400,
                        'minHeight' => 590,
                        'maxWidth' => 400,
                        'maxHeight' => 600
                    ),
                    'acceptedTypes' => array('jpg', 'jpeg', 'png')
                )
            ),
            'uploadFile' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'tempFile',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('pdf', 'epub')
                )
            ),
            'uploadPreview' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'preview_file',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('epub', 'pdf')
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'Books',
                'attribute' => 'icon',
                'uploadDir' => '/uploads/books/icons',
                'storedMode' => 'field'
            ),
            'deleteUploadPreview' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'Books',
                'attribute' => 'preview_file',
                'uploadDir' => '/uploads/books/previews',
                'storedMode' => 'field'
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Books();
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if(!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->baseUrl . '/uploads/temp/';
        $bookIconsDIR = Yii::getPathOfAlias("webroot") . "/uploads/books/icons/";
        if(!is_dir($bookIconsDIR))
            mkdir($bookIconsDIR);
        $bookPreviewDIR = Yii::getPathOfAlias("webroot") . "/uploads/books/previews/";
        if(!is_dir($bookPreviewDIR))
            mkdir($bookPreviewDIR);
        $icon = array();
        $previewFile = array();

        $this->performAjaxValidation($model);
        if(isset($_POST['Books']) && is_file($tmpDIR . $_POST['Books']['icon'])){
            $model->attributes = $_POST['Books'];
            if(isset($_POST['Books']['icon'])){
                $file = $_POST['Books']['icon'];
                $icon = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
            if(isset($_POST['Books']['preview_file'])){
                $file = $_POST['Books']['preview_file'];
                $previewFile = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
            $model->confirm = 'accepted';
            $model->formTags = isset($_POST['Books']['formTags'])?explode(',', $_POST['Books']['formTags']):null;
            $model->formSeoTags = isset($_POST['Books']['formSeoTags'])?explode(',', $_POST['Books']['formSeoTags']):null;
            $model->formAuthor = isset($_POST['Books']['formAuthor'])?explode(',', $_POST['Books']['formAuthor']):null;
            $model->formTranslator = isset($_POST['Books']['formTranslator'])?explode(',', $_POST['Books']['formTranslator']):null;
            if($model->save()){
                if($model->icon)
                    @rename($tmpDIR . $model->icon, $bookIconsDIR . $model->icon);
                if($model->preview_file)
                    @rename($tmpDIR . $model->preview_file, $bookPreviewDIR . $model->preview_file);
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->redirect('update/' . $model->id . '/?step=2');
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        Yii::app()->getModule('setting');
        $this->render('create', array(
            'model' => $model,
            'icon' => $icon,
            'previewFile' => $previewFile,
            'tax' => SiteSetting::model()->findByAttributes(array('name' => 'tax'))->value,
            'commission' => SiteSetting::model()->findByAttributes(array('name' => 'commission'))->value,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if(!is_dir($tmpDIR)) mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
        $bookIconsDIR = Yii::getPathOfAlias("webroot") . '/uploads/books/icons/';
        $bookPreviewDIR = Yii::getPathOfAlias("webroot") . '/uploads/books/previews/';
        $bookImagesDIR = Yii::getPathOfAlias("webroot") . '/uploads/books/images/';
        $bookIconsUrl = Yii::app()->createAbsoluteUrl('/uploads/books/icons');
        $bookPreviewUrl = Yii::app()->createAbsoluteUrl('/uploads/books/previews');
        $bookImagesUrl = Yii::app()->createAbsoluteUrl('/uploads/books/images');

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $icon = array();
        if($model->icon && is_file($bookIconsDIR . $model->icon))
            $icon = array(
                'name' => $model->icon,
                'src' => $bookIconsUrl . '/' . $model->icon,
                'size' => filesize($bookIconsDIR . $model->icon),
                'serverName' => $model->icon,
            );

        $previewFile = array();
        if($model->preview_file && is_file($bookPreviewDIR . $model->preview_file))
            $previewFile = array(
                'name' => $model->preview_file,
                'src' => $bookPreviewUrl . '/' . $model->preview_file,
                'size' => filesize($bookPreviewDIR . $model->preview_file),
                'serverName' => $model->preview_file,
            );

        $images = array();
        if($model->images)
            foreach($model->images as $image)
                if(is_file($bookImagesDIR . $image->image))
                    $images[] = array(
                        'name' => $image->image,
                        'src' => $bookImagesUrl . '/' . $image->image,
                        'size' => filesize($bookImagesDIR . $image->image),
                        'serverName' => $image->image,
                    );

        foreach($model->showTags as $tag)
            array_push($model->formTags, $tag->title);
        foreach($model->seoTags as $tag)
            array_push($model->formSeoTags, $tag->title);
        foreach($model->persons(array('condition' => 'role_id = 1')) as $person)
            array_push($model->formAuthor, $person->name_family);
        foreach($model->persons(array('condition' => 'role_id = 2')) as $person)
            array_push($model->formTranslator, $person->name_family);

        if(isset($_POST['Books'])){
            $iconFlag = false;
            $previewFileFlag = false;
            $newFileSize = $model->size;
            if(isset($_POST['Books']['icon']) && !empty($_POST['Books']['icon']) && $_POST['Books']['icon'] != $model->icon){
                $file = $_POST['Books']['icon'];
                $icon = array('name' => $file, 'src' => $tmpUrl . '/' . $file, 'size' => filesize($tmpDIR . $file), 'serverName' => $file,);
                $iconFlag = true;
            }
            if(isset($_POST['Books']['preview_file']) && !empty($_POST['Books']['preview_file']) && $_POST['Books']['preview_file'] != $model->preview_file){
                $file = $_POST['Books']['preview_file'];
                $previewFile = array('name' => $file, 'src' => $tmpUrl . '/' . $file, 'size' => filesize($tmpDIR . $file), 'serverName' => $file,);
                $previewFileFlag = true;
            }
            $model->attributes = $_POST['Books'];

            if(isset($_POST['default_commission']))
                $model->publisher_commission = null;

            $model->size = $newFileSize;
            $model->formTags = isset($_POST['Books']['formTags'])?explode(',', $_POST['Books']['formTags']):null;
            $model->formSeoTags = isset($_POST['Books']['formSeoTags'])?explode(',', $_POST['Books']['formSeoTags']):null;
            $model->formAuthor = isset($_POST['Books']['formAuthor'])?explode(',', $_POST['Books']['formAuthor']):null;
            $model->formTranslator = isset($_POST['Books']['formTranslator'])?explode(',', $_POST['Books']['formTranslator']):null;
            if($model->save()){
                if($iconFlag)
                    rename($tmpDIR . $model->icon, $bookIconsDIR . $model->icon);
                if($previewFileFlag)
                    rename($tmpDIR . $model->preview_file, $bookPreviewDIR . $model->preview_file);
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ویرایش شد.');
                $this->refresh();
            }else{
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('book_id=:book_id');
        $criteria->params = array(
            ':book_id' => $id,
        );
        $packageDataProvider = new CActiveDataProvider('BookPackages', array('criteria' => $criteria));

        Yii::app()->getModule('setting');
        $this->render('update', array(
            'model' => $model,
            'icon' => $icon,
            'previewFile' => $previewFile,
            'images' => $images,
            'step' => 1,
            'packageDataProvider' => $packageDataProvider,
            'tax' => SiteSetting::model()->findByAttributes(array('name' => 'tax'))->value,
            'commission' => SiteSetting::model()->findByAttributes(array('name' => 'commission'))->value,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $model->deleted = 1;
        $model->setScenario('delete');
        if($model->save())
            $this->createLog('کتاب ' . $model->title . ' توسط مدیر سیستم حذف شد.', $model->publisher_id);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->layout = '//layouts/column1';
        $model = new Books('search');
        $model->unsetAttributes();
        if(isset($_GET['Books']))
            $model->attributes = $_GET['Books'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Books the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Books::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Books $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'books-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionChangeConfirm()
    {
        $model = $this->loadModel($_POST['book_id']);
        $model->confirm = $_POST['value'];
        $model->confirm_date = time();
        if($model->save()){
            $electronicPackage = $model->lastElectronicPackage;
            $printedPackage = $model->lastPrintedPackage;
            $electronicPackage->setScenario('publish');
            $printedPackage->setScenario('publish');
            if($model->confirm == 'accepted') {
                $electronicPackage->publish_date = time();
                $printedPackage->publish_date = time();
            }
            if($model->confirm == 'refused' or $model->confirm == 'change_required') {
                $electronicPackage->reason = $_POST['electronic_reason'];
                $printedPackage->reason = $_POST['printed_reason'];
            }
            if($electronicPackage->save() and $printedPackage->save()){
                $message = '';
                switch($model->confirm){
                    case 'refused':
                        $message = 'کتاب ' . $model->title . ' رد شده است. جهت اطلاع از دلیل تایید نشدن این کتاب به صفحه ویرایش کتاب مراجعه فرمایید.';
                        break;

                    case 'accepted':
                        $message = 'کتاب ' . $model->title . ' تایید شده است.';
                        break;

                    case 'change_required':
                        $message = 'کتاب ' . $model->title . ' نیاز به تغییرات دارد. جهت مشاهده پیام کارشناسان به صفحه ویرایش کتاب مراجعه فرمایید.';
                        break;

                    case 'pending':
                        $message = 'کتاب ' . $model->title . ' در حالت تعلیق قرار گرفت.';
                        break;
                }
                $this->createLog($message, $model->publisher_id);

                echo CJSON::encode(array(
                    'status' => true
                ));
            }else
                echo CJSON::encode(array('status' => false));
        }else
            echo CJSON::encode(array(
                'status' => false,
                'message' => $this->implodeErrors($model)
            ));
    }

    public function actionDeletePackage($id)
    {
        $model = BookPackages::model()->findByPk($id);
        $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/books/files';
        if(is_file($uploadDir . '/' . $model->pdf_file_name)){
            @unlink($uploadDir . '/' . $model->pdf_file_name);
            if(is_file($uploadDir . '/' . $model->epub_file_name)){
                @unlink($uploadDir . '/' . $model->epub_file_name);
                if($model->delete())
                    $this->createLog('چاپ ' . $model->package_name . ' توسط مدیر سیستم حذف شد.', $model->book->publisher_id);
            }
        }

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
    }

    /**
     * Save book package info
     */
    public function actionSavePackage()
    {
        if (isset($_POST['book_id'])) {
            $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/books/files';
            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';
            if (!is_dir($uploadDir))
                mkdir($uploadDir);

            $model = new BookPackages();
            $model->attributes = $_POST;
            $model->publish_date = time();

            if (!isset($_POST['sale_printed']))
                $model->sale_printed = 0;

            if (!$model->printed_price || empty($model->printed_price))
                $model->printed_price = $model->price;

            if (isset($_POST['tempFile'])) {
                if (pathinfo($_POST['tempFile'], PATHINFO_EXTENSION) == 'pdf')
                    $model->pdf_file_name = $_POST['tempFile'];
                else if (pathinfo($_POST['tempFile'], PATHINFO_EXTENSION) == 'epub')
                    $model->epub_file_name = $_POST['tempFile'];
            }

            if ($model->save()) {
                $response = ['status' => true, 'pdfFileName' => $model->pdf_file_name, 'epubFileName' => $model->epub_file_name];

                if (isset($_POST['tempFile'])) {
                    if (pathinfo($_POST['tempFile'], PATHINFO_EXTENSION) == 'pdf')
                        @rename($tempDir . DIRECTORY_SEPARATOR . $_POST['pdf_file_name'], $uploadDir . DIRECTORY_SEPARATOR . $model->pdf_file_name);
                    else if (pathinfo($_POST['tempFile'], PATHINFO_EXTENSION) == 'epub')
                        @rename($tempDir . DIRECTORY_SEPARATOR . $_POST['epub_file_name'], $uploadDir . DIRECTORY_SEPARATOR . $model->epub_file_name);
                }
            } else {
                $response = ['status' => false, 'message' => $this->implodeErrors($model)];
                if (isset($_POST['tempFile'])) {
                    if (pathinfo($_POST['tempFile'], PATHINFO_EXTENSION) == 'pdf')
                        @unlink($tempDir . '/' . $_POST['pdf_file_name']);
                    else if (pathinfo($_POST['tempFile'], PATHINFO_EXTENSION) == 'epub')
                        @unlink($tempDir . '/' . $_POST['epub_file_name']);
                }
            }

            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionImages($id)
    {
        $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/books/images/';
        if(isset($_POST['image'])){
            $flag = true;
            foreach($_POST['image'] as $image){
                if(is_file($tempDir . $image)){
                    $model = new BookImages();
                    $model->book_id = (int)$id;
                    $model->image = $image;
                    rename($tempDir . $image, $uploadDir . $image);
                    if(!$model->save(false))
                        $flag = false;
                }
            }
            if($flag)
                Yii::app()->user->setFlash('images-success', 'اطلاعات با موفقیت ثبت شد.');
            else
                Yii::app()->user->setFlash('images-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }else
            Yii::app()->user->setFlash('images-failed', 'تصاویر کتاب را آپلود کنید.');
        $this->redirect('update/' . $id . '/?step=3');
    }

    /**
     * Download book
     * @param $id
     * @param $title
     * @throws CHttpException
     */
    public function actionDownload($id, $title)
    {
        $model = $this->loadModel($id);
        /* @var $model Books */
        $filename = $folder = null;
        switch($title){
            case 'pdf':
                $filename = $model->lastElectronicPackage->pdf_file_name;
                $folder = 'files';
                break;
            case 'epub':
                $filename = $model->lastElectronicPackage->epub_file_name;
                $folder = 'files';
                break;
            case 'preview':
                $filename = $model->preview_file;
                $folder = 'previews';
                break;
        }

        $this->download($filename, Yii::getPathOfAlias("webroot") . '/uploads/books/' . $folder . '/');
    }

    /**
     * Download book package
     * @param $id
     * @param $title
     */
    public function actionDownloadPackage($id, $title)
    {
        $model = BookPackages::model()->findByPk($id);
        $this->download($model->{$title . '_file_name'}, Yii::getPathOfAlias("webroot") . '/uploads/books/files/');
    }

    protected function download($fileName, $filePath)
    {
        $fakeFileName = $fileName;
        $realFileName = $fileName;

        $file = $filePath . DIRECTORY_SEPARATOR . $realFileName;
        $fp = fopen($file, 'rb');

        $mimeType = '';
        switch(pathinfo($fileName, PATHINFO_EXTENSION)){
            case 'pdf':
                $mimeType = 'application/pdf';
                break;

            case 'epub':
                $mimeType = 'application/epub+zip';
                break;
        }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename=' . $fakeFileName);

        echo stream_get_contents($fp);
    }

    public function actionUpdatePackage()
    {
        if(isset($_GET['id']) && isset($_GET['book_id']) && !empty($_GET['id']) && !empty($_GET['book_id'])){
            $id = (int)$_GET['id'];
            $book_id = (int)$_GET['book_id'];
            $model = BookPackages::model()->findByAttributes(array(
                'id' => $id,
                'book_id' => $book_id
            ));
            /* @var $model BookPackages */
            if($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/books/files/';
            $uploadUrl = Yii::app()->baseUrl . '/uploads/books/files';
            $encDir = Yii::getPathOfAlias("webroot") . '/uploads/books/encrypted/';
            $encUrl = Yii::app()->baseUrl . '/uploads/books/encrypted';
            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';
            if(!is_dir($uploadDir))
                mkdir($uploadDir);

            $pdfPackage = $epubPackage = array();
            $tempPackage = array();
            if($model->pdf_file_name && is_file($uploadDir . $model->pdf_file_name))
                $tempPackage = array(
                    'name' => $model->pdf_file_name,
                    'src' => $uploadUrl . '/' . $model->pdf_file_name,
                    'size' => filesize($uploadDir . $model->pdf_file_name),
                    'serverName' => $model->pdf_file_name,
                );
            else if($model->pdf_file_name && is_file($encDir . $model->pdf_file_name))
                $tempPackage = array(
                    'name' => $model->pdf_file_name,
                    'src' => $encUrl . '/' . $model->pdf_file_name,
                    'size' => filesize($encDir . $model->pdf_file_name),
                    'serverName' => $model->pdf_file_name,
                );

            if($model->epub_file_name && is_file($uploadDir . $model->epub_file_name))
                $tempPackage = array(
                    'name' => $model->epub_file_name,
                    'src' => $uploadUrl . '/' . $model->epub_file_name,
                    'size' => filesize($uploadDir . $model->epub_file_name),
                    'serverName' => $model->epub_file_name,
                );
            else if($model->epub_file_name && is_file($encDir . $model->epub_file_name))
                $tempPackage = array(
                    'name' => $model->epub_file_name,
                    'src' => $encUrl . '/' . $model->epub_file_name,
                    'size' => filesize($encDir . $model->epub_file_name),
                    'serverName' => $model->epub_file_name,
                );
            
            if(isset($_POST['BookPackages'])){
                $model->attributes = $_POST['BookPackages'];
                $model->for = $model::FOR_OLD_BOOK;

                if($model->type == BookPackages::TYPE_ELECTRONIC) {
                    if (
                        (!is_null($model->pdf_file_name) and $model->pdf_file_name != $_POST['BookPackages']['tempFile']) or
                        (!is_null($model->epub_file_name) and $model->epub_file_name != $_POST['BookPackages']['tempFile'])
                    )
                        $model->encrypted = 0;

                    if (pathinfo($_POST['BookPackages']['tempFile'], PATHINFO_EXTENSION) == 'pdf') {
                        $model->pdf_file_name = $_POST['BookPackages']['tempFile'];
                        $model->epub_file_name = null;
                    } else if (pathinfo($_POST['BookPackages']['tempFile'], PATHINFO_EXTENSION) == 'epub') {
                        $model->epub_file_name = $_POST['BookPackages']['tempFile'];
                        $model->pdf_file_name = null;
                    }
                }

                if($model->save()){
                    if($model->pdf_file_name && is_file($tempDir . DIRECTORY_SEPARATOR . $model->pdf_file_name))
                        @rename($tempDir . DIRECTORY_SEPARATOR . $model->pdf_file_name, $uploadDir . DIRECTORY_SEPARATOR . $model->pdf_file_name);
                    if($model->epub_file_name && is_file($tempDir . DIRECTORY_SEPARATOR . $model->epub_file_name))
                        @rename($tempDir . DIRECTORY_SEPARATOR . $model->epub_file_name, $uploadDir . DIRECTORY_SEPARATOR . $model->epub_file_name);
                    Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                    $this->redirect('update/' . $model->book_id . '/?step=2');
                }else
                    Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
            $this->render('update_package', array(
                'model' => $model,
                'pdfPackage' => $pdfPackage,
                'epubPackage' => $epubPackage,
                'tempPackage' => $tempPackage,
            ));
        }else
            $this->redirect(array('/manageBooks/baseManage/admin'));
    }

    public function actionDiscount()
    {
        $model = new BookDiscounts('admin_side');

        if(isset($_GET['ajax']) && $_GET['ajax'] === 'books-discount-form'){
            $model->attributes = $_POST['BookDiscounts'];
            $errors = CActiveForm::validate($model);
            if(CJSON::decode($errors)){
                echo $errors;
                Yii::app()->end();
            }
        }
        $this->render('discount', array(
            'model' => $model
        ));
    }

    public function actionCreateDiscount()
    {
        $model = new BookDiscounts();
        if(Yii::app()->user->type == 'admin')
            $model->scenario = 'admin_side';
        if(isset($_POST['BookDiscounts'])){
            $model->attributes = $_POST['BookDiscounts'];
            if($model->save()){
                if(isset($_GET['ajax'])){
                    echo CJSON::encode(array('status' => true, 'msg' => 'تخفیف با موفقیت اعمال شد.'));
                    Yii::app()->end();
                }else{
                    Yii::app()->user->setFlash('discount-success', 'اعمال تخفیف با موفقیت اعمال شد.');
                    $this->redirect(array('discount'));
                }
            }else
                Yii::app()->user->setFlash('failed', 'متاسفانه در انجام درخواست مشکلی ایجاد شده است.');
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('deleted = 0');
        $criteria->addCondition('printedPackages.printed_price != 0');
        $criteria->addCondition('title != ""');
        $criteria->with[] = 'discount';
        $criteria->with[] = 'printedPackages';
        $criteria->addCondition('discount.book_id IS NULL');
        $books = CHtml::listData(Books::model()->findAll($criteria), 'id', 'title');
        $this->render('_discount_form', array('model' => $model, 'books' => $books));
    }

    public function actionGroupDiscount()
    {
        $model = new BookDiscounts('group');
        if(isset($_POST['BookDiscounts'])){
            $model->attributes = $_POST['BookDiscounts'];
            if($model->validate() && isset($_POST['group_type'])){
                $criteria = Books::model()->getValidBooks();
                $criteria->addCondition('printedPackages.price != 0');
                $criteria->addCondition('title != ""');
                $criteria->with[] = 'discount';
                $criteria->with[] = 'printedPackages';
                $criteria->addCondition('discount.book_id IS NULL');
                if($_POST['group_type'] == 'publisher'){
                    $criteria->compare('publisher_id', $_POST['publisher_id']);
                }
                $books = Books::model()->findAll($criteria);
                $count = Books::model()->count($criteria);
                $i = 0;
                foreach($books as $book){
                    $model = new BookDiscounts();
                    $model->attributes = $_POST['BookDiscounts'];
                    $model->book_id = $book->id;
                    if($model->save())
                        $i++;
                }
                if($i > 0){
                    Yii::app()->user->setFlash('discount-success', "تخفیف بر روی {$i} کتاب از مجموع {$count} کتاب با موفقیت اعمال شد.");
                    $this->redirect(array('discount'));
                }
            }
        }

        $publishers = CHtml::listData(Users::model()->getPublishers()->getData(), 'id', 'userDetails.fa_name');
        $this->render('_group_discount_form', array('model' => $model, 'publishers' => $publishers));
    }

    public function actionUpdateDiscount($id)
    {
        $model = BookDiscounts::model()->findByPk($id);
        if(isset($_POST['BookDiscounts'])){
            $model->attributes = $_POST['BookDiscounts'];
            if($model->save()){
                if(isset($_GET['ajax'])){
                    echo CJSON::encode(array('status' => true, 'msg' => 'تخفیف با موفقیت اعمال شد.'));
                    Yii::app()->end();
                }else{
                    Yii::app()->user->setFlash('discount-success', 'اعمال تخفیف با موفقیت اعمال شد.');
                    $this->redirect(array('discount'));
                }
            }else
                Yii::app()->user->setFlash('discount-failed', 'متاسفانه در انجام درخواست مشکلی ایجاد شده است.');
        }
        $this->render('_discount_form', array('model' => $model));
    }

    public function actionDeleteDiscount($id)
    {
        $model = BookDiscounts::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if($model->book->publisher_id)
            $this->createLog('تخفیف کتاب ' . $model->book->title . ' توسط مدیر سیستم حذف شد.', $model->book->publisher_id);
        $model->delete();

        if(!isset($_GET['ajax']) && !Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
    }

    public function actionDeleteSelectedDiscount()
    {
        foreach($_POST['selectedItems'] as $modelId){
            $this->actionDeleteDiscount($modelId);
        }
    }


    public function actionChangePublisherCommission()
    {
        $model = Books::model()->findByPk($_POST['book_id']);
        $model->setScenario('change-publisher-commission');

        if(isset($_POST['default_commission']))
            $model->publisher_commission = null;
        else
            $model->publisher_commission = $_POST['publisher_commission'];

        if($model->save())
            echo CJSON::encode(array('status' => 'success'));
        else
            echo CJSON::encode(array('status' => 'failed'));
    }

    public function actionDeleteUploadedFile()
    {
        $Dir = Yii::getPathOfAlias("webroot") . '/uploads/books/';

        if(isset($_POST['fileName'])){

            $fileName = $_POST['fileName'];

            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

            $model = BookPackages::model()->findByAttributes(array('pdf_file_name' => $fileName));
            if($model === null)
                $model = BookPackages::model()->findByAttributes(array('epub_file_name' => $fileName));
            if($model){
                if($model->encrypted)
                    $Dir .= 'encrypted';
                else
                    $Dir .= 'files';


                if($model->pdf_file_name && is_file($Dir . '/' . $model->pdf_file_name)){
                    @unlink($Dir . '/' . $model->pdf_file_name);
                    $model->updateByPk($model->id, array('pdf_file_name' => null, 'encrypted' => 0));
                    $response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
                }else if($model->epub_file_name && is_file($Dir . '/' . $model->epub_file_name)){
                    @unlink($Dir . '/' . $model->epub_file_name);
                    $model->updateByPk($model->id, array('epub_file_name' => null, 'encrypted' => 0));
                    $response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
                }else
                    $response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
            }else{
                @unlink($tempDir . $fileName);
                $response = ['state' => 'ok', 'msg' => 'حذف شد.'];
            }

            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionGetBookPackages()
    {
        $bookID = $_POST['id'];
        /* @var BookPackages[] $packages */
        $packages = BookPackages::model()->findAll('book_id = :id', [':id' => $bookID]);
        $result = [];
        foreach($packages as $package){
            $result[] = [
                'id' => $package->id,
                'name' => $package->version,
            ];
        }

        echo CJSON::encode($result);
    }
}