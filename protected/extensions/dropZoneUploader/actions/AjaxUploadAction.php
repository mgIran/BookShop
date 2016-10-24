<?php
class AjaxUploadAction extends CAction
{
    /**
     * @var string upload folder Dir
     */
    public $uploadDir = '/uploads/temp';

    /**
     * @var string model class name
     */
    public $model;
    /**
     * @var string attribute name
     */
    public $attribute;
    /**
     * @var string rename random|none
     */
    public $rename;
    /**
     * @var string rename string length
     */
    public $randomLength = 5;
    /**
     * @var array of valid options
     */
    public $validateOptions = array();

    private function init(){
        if (!$this->attribute)
            throw new CException('{attribute} attribute is not specified.', 500);
    }
    
    public function run()
    {
        $this->init();
        if (Yii::app()->request->isAjaxRequest) {
            $validFlag = true;
            $uploadDir = Yii::getPathOfAlias("webroot").$this->uploadDir;
            if (!is_dir($uploadDir))
                mkdir($uploadDir);

            if (isset($_FILES[$this->attribute])) {
                $file = $_FILES[$this->attribute];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                switch ($this->rename) {
                    case 'random':
                        $filename = Controller::generateRandomString($this->randomLength).time();
                        while (file_exists($uploadDir.DIRECTORY_SEPARATOR.$filename.'.'.$ext))
                            $filename = Controller::generateRandomString($this->randomLength).time();
                        $filename = $filename.'.'.$ext;
                        break;
                    case 'none':
                    default:
                        $filename = CHtml::encode(str_replace(' ', '_', $file['name']));
                        $filename = str_replace('.'.$ext, '', $filename);
                        $i = 1;
                        while (file_exists($uploadDir.DIRECTORY_SEPARATOR.$filename.'.'.$ext)) {
                            $filename = $filename.'('.$i.')';
                            $i++;
                        }
                        $filename = $filename.'.'.$ext;
                        break;
                }
                $msg = '';
                if ($this->validateOptions) {
                    if (isset($this->validateOptions['dimensions'])) {
                        $minW = isset($this->validateOptions['dimensions']['minWidth']) ? $this->validateOptions['dimensions']['minWidth'] : null;
                        $maxW = isset($this->validateOptions['dimensions']['maxWidth']) ? $this->validateOptions['dimensions']['maxWidth'] : null;
                        $minH = isset($this->validateOptions['dimensions']['minHeight']) ? $this->validateOptions['dimensions']['minHeight'] : null;
                        $maxH = isset($this->validateOptions['dimensions']['maxHeight']) ? $this->validateOptions['dimensions']['maxHeight'] : null;

                        $imager = new Imager();
                        $imageInfo = $imager->getImageInfo($file['tmp_name']);
                        if ($minW && $imageInfo['width'] < $minW) {
                            $msg .= 'عرض تصویر نباید کوچکتر از '.$minW.' پیکسل باشد.<br>';
                            $validFlag = false;
                        }
                        if ($maxW && $imageInfo['width'] > $maxW) {
                            $msg .= 'عرض تصویر نباید بزرگتر از '.$maxW.' پیکسل باشد.<br>';
                            $validFlag = false;
                        }
                        if ($minH && $imageInfo['height'] < $minH) {
                            $msg .= 'ارتفاع تصویر نباید کوچکتر از '.$minH.' پیکسل باشد.<br>';
                            $validFlag = false;
                        }
                        if ($maxH && $imageInfo['height'] > $maxH) {
                            $msg .= 'عرض تصویر نباید بزرگتر از '.$maxH.' پیکسل باشد.<br>';
                            $validFlag = false;
                        }
                    }
                    if (isset($this->validateOptions['acceptedTypes']) && is_array($this->validateOptions['acceptedTypes'])) {
                        if (!in_array($ext,$this->validateOptions['acceptedTypes'])) {
                            $msg .= 'فرمت فایل مجاز نیست.<br>فرمت های مجاز: '.implode(',',$this->validateOptions['acceptedTypes']).'<br>';
                            $validFlag = false;
                        }
                    }
                }
                if ($validFlag) {
                    if (move_uploaded_file($file['tmp_name'], $uploadDir.DIRECTORY_SEPARATOR.$filename))
                        $response = ['status' => true, 'fileName' =>$filename];
                    else
                        $response = ['status' => false, 'message' => 'در عملیات آپلود فایل خطایی رخ داده است.'];
                } else
                    $response = ['status' => false, 'message' => $msg];
            } else
                $response = ['status' => false, 'message' => 'فایلی ارسال نشده است.'];
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }
}