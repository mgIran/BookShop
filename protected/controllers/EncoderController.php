<?php

class EncoderController extends Controller
{
    private $_privateKey;

    public function encode($sourceFileName, $destFileName)
    {
        set_time_limit(0);

        $encoder = Yii::app()->phpseclib->createAES();
        $encoder->setKey($this->_privateKey);

        $bufferSize = 1024 * 100;
        try{
            $sp = fopen($sourceFileName, 'r');
            $op = fopen($destFileName, 'w');
            while(!feof($sp)){
                $buffer = fread($sp, $bufferSize);
                fwrite($op, $encoder->encrypt($buffer));
            }
            fclose($op);
            fclose($sp);
        }catch(CException $e){
            die("Encrypting Error.");
        }
    }

    public function actionDecode()
    {
        $start = time();
        $path = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'books' . DIRECTORY_SEPARATOR;

        $originalPath = $path . 'files' . DIRECTORY_SEPARATOR;
        $encryptPath = $path . 'encrypted' . DIRECTORY_SEPARATOR;

        $sourceFileName = $encryptPath . 'CCNA-decoded.pdf';
        $destFileName = $encryptPath . '/CCNA-aes.ktb.sec';

        $encoder = Yii::app()->phpseclib->createAES();
        $encoder->setKey($this->_privateKey);
        $content = file_get_contents($destFileName);
        $decoded = $encoder->decrypt($content);
        file_put_contents($sourceFileName, $decoded);
        echo '<pre>';
        echo "Time Remaining: " . (time() - $start);
        echo '<br>';
        echo "Encrypted Content Length: " . filesize($destFileName);
        echo '<br>';
        echo "DECODED Content Length: " . filesize($sourceFileName);
    }

    public function actionEncryptCron()
    {
        $path = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'books' . DIRECTORY_SEPARATOR;
        $originalPath = $path . 'files' . DIRECTORY_SEPARATOR;
        $encryptPath = $path . 'encrypted' . DIRECTORY_SEPARATOR;
        if(!is_dir($encryptPath))
            mkdir($encryptPath);

        $this->_privateKey =

        $sourceFileName = $originalPath . 'CCNA.pdf';
        $destFileName = $encryptPath . '/CCNA-aes.ktb.sec';
        
        $criteria = new CDbCriteria();
        $files = BookPackages::model()-> 
        $this->encode($sourceFileName, $destFileName);
    }
}