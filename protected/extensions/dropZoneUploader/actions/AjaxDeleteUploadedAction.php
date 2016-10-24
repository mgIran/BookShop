<?php
class AjaxDeleteUploadedAction extends CAction
{
    /**
     * @var string temp folder Dir
     */
    public $tempDir = '/uploads/temp';
    /**
     * @var string upload folder Dir
     */
    public $uploadDir;

    /**
     * @var string model class name
     */
    public $modelName;
    /**
     * @var string attribute name
     */
    public $attribute;

    public function run()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $uploadDir = Yii::getPathOfAlias("webroot") . $this->uploadDir;
            if(!$this->uploadDir)
                throw new CException('مسیر پوشه اصلی فایل ها مشخص نشده است.',500);
            if (isset($_POST['fileName'])) {
                $fileName = $_POST['fileName'];
                $tempDir = Yii::getPathOfAlias("webroot") . $this->tempDir;
                $ownerModel = call_user_func(array($this->modelName, 'model'));
                $model = $ownerModel->findByAttributes(array($this->attribute => $fileName));
                if ($model) {
                    if (@unlink($uploadDir .DIRECTORY_SEPARATOR. $model->{$this->attribute})) {
                        $ownerModel->updateByPk($model->id, array($this->attribute => null));
                        $response = ['status' => 'ok', 'msg' => Yii::app()->controller->implodeErrors($ownerModel)];
                    } else
                        $response = ['status' => 'error', 'msg' => 'در حذف فایل مشکل ایجاد شده است'];
                } else {
                    @unlink($tempDir .DIRECTORY_SEPARATOR. $fileName);
                    $response = ['status' => 'ok', 'msg' => 'فایل با موفقیت حذف شد.'];
                }
            } else
                $response = ['status' => false, 'message' => 'نام فایل موردنظر ارسال نشده است.'];
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }
}