<?php

class EncoderController extends Controller
{
    private $_privateKey;

    public function encode($sourceFileName, $destFileName)
    {
        set_time_limit(0);

        $encoder = Yii::app()->phpseclib->createAES();
        /* @var $encoder Crypt_AES*/
        $encoder->setKey($this->_privateKey);
        $bufferSize = 1024 * 100;
        try {
            $sp = fopen($sourceFileName, 'r');
            $op = fopen($destFileName, 'w');
            while (!feof($sp)) {
                $buffer = fread($sp, $bufferSize);
                fwrite($op, $encoder->encrypt($buffer));
            }
            fclose($op);
            fclose($sp);
            return true;
        } catch (CException $e) {
            return false;
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
        if (!is_dir($encryptPath))
            mkdir($encryptPath);

        $this->_privateKey = file_get_contents(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'private.key');

        $criteria = new CDbCriteria();
        $criteria->addCondition('encrypted = 0');
        $files = BookPackages::model()->findAll($criteria);
        $total = 0;
        $totalEn = 0;
        if ($files) {
            foreach ($files as $file) {
                if ($file->epub_file_name && file_exists($originalPath . $file->epub_file_name)) {
                    $total++;
                    $sourceFileName = $originalPath . $file->epub_file_name;
                    $ext = pathinfo($file->epub_file_name, PATHINFO_EXTENSION);
                    $secureFileName = str_replace('.' . $ext, '', $file->epub_file_name) . '.secure';
                    $destFileName = $encryptPath . $secureFileName;
                    if ($this->encode($sourceFileName, $destFileName) && file_exists($destFileName)) {
                        $totalEn++;
                        $file->epub_file_name = $secureFileName;
                        $file->encrypted = 1;
                        $file->save(false);
                    }
                }

                if ($file->pdf_file_name && file_exists($originalPath . $file->pdf_file_name)) {
                    $total++;
                    $sourceFileName = $originalPath . $file->pdf_file_name;
                    $ext = pathinfo($file->pdf_file_name, PATHINFO_EXTENSION);
                    $secureFileName = str_replace('.' . $ext, '', $file->pdf_file_name) . '.secure';
                    $destFileName = $encryptPath . $secureFileName;
                    if ($this->encode($sourceFileName, $destFileName) && file_exists($destFileName)) {
                        $totalEn++;
                        $file->pdf_file_name = $secureFileName;
                        $file->encrypted = 1;
                        $file->save(false);
                    }
                }
            }
        }

        echo "Total Files: " . $total . '<br>';
        echo "Total Encrypted: " . $totalEn;
    }
}