<?php

/**
 * This is the model class for table "{{book_packages}}".
 *
 * The followings are the available columns in table '{{book_packages}}':
 * @property string $id
 * @property string $book_id
 * @property string $version
 * @property string $package_name
 * @property string $pdf_file_name
 * @property string $epub_file_name
 * @property string $create_date
 * @property string $publish_date
 * @property string $reason
 * @property string $for
 * @property string $electronic_price
 * @property string $printed_price
 * @property string $print_year
 * @property integer $encrypted
 * @property integer $cover_price
 * @property integer $type
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Books $book
 * @property BookDiscounts $discount
 * @property Users $user
 */
class BookPackages extends CActiveRecord
{
    const FOR_NEW_BOOK = 'new_book';
    const FOR_OLD_BOOK = 'old_book';
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REFUSED = 'refused';
    const STATUS_CHANGE_REQUIRED = 'change_required';
    const TYPE_ELECTRONIC = 0;
    const TYPE_PRINTED = 1;

    public $tempFile;

    public $forLabels = array(
        'new_book' => '<span class="label label-success">کتاب جدید</span>',
        'old_book' => '<span class="label label-warning">کتاب تغییر داده شده</span>',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{book_packages}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('book_id, cover_price, user_id', 'required'),
            array('print_year, printed_price', 'required', 'on' => 'save_printed_package'),
            array('electronic_price', 'required', 'on' => 'save_electronic_package'),
            array('pdf_file_name', 'orRequired', 'other' => 'epub_file_name', 'on' => 'save_electronic_package'),
            array('book_id, user_id, electronic_price, printed_price, cover_price', 'length', 'max' => 10),
            array('print_year', 'length', 'max' => 50),
            array('version, create_date, publish_date', 'length', 'max' => 20),
            array('electronic_price, printed_price, cover_price, encrypted', 'numerical', 'integerOnly' => true),
            array('create_date, publish_date, reason, print_year', 'filter', 'filter' => 'strip_tags'),
            array('package_name', 'length', 'max' => 100),
            array('pdf_file_name, epub_file_name', 'length', 'max' => 255),
            array('for', 'length', 'max' => 8),
            array('encrypted, type', 'length', 'max' => 1),
            array('create_date', 'default', 'value' => time()),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, book_id, user_id, version, package_name, pdf_file_name, epub_file_name, create_date, publish_date, reason, for, electronic_price, printed_price', 'safe', 'on' => 'search'),
        );
    }

    public function orRequired($attribute, $params)
    {
        if (is_null($this->$attribute) and is_null($this->{$params['other']}))
            $this->addError($attribute, '"' . $this->getAttributeLabel($attribute) . '" و "' . $this->getAttributeLabel($params['other']) . '" نمی توانند خالی باشند. لطفا یکی از آنها را پر کنید.');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'book' => array(self::BELONGS_TO, 'Books', 'book_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'شناسه',
            'book_id' => 'کتاب',
            'version' => 'نوبت چاپ',
            'package_name' => 'نام نوبت چاپ',
            'pdf_file_name' => 'فایل PDF',
            'epub_file_name' => 'فایل EPUB',
            'create_date' => 'تاریخ بارگذاری',
            'publish_date' => 'تاریخ انتشار',
            'reason' => 'دلیل',
            'for' => 'نوع نوبت چاپ',
            'electronic_price' => 'قیمت نسخه الکترونیک',
            'printed_price' => 'قیمت نسخه چاپی',
            'print_year' => 'زمان چاپ',
            'encrypted' => 'رمز گذاری شده',
            'cover_price' => 'قیمت روی جلد',
            'type' => 'نوع',
            'user_id' => 'کاربر',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('book_id', $this->book_id, true);
        $criteria->compare('version', $this->version, true);
        $criteria->compare('package_name', $this->package_name, true);
        $criteria->compare('pdf_file_name', $this->pdf_file_name, true);
        $criteria->compare('epub_file_name', $this->epub_file_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BookPackages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getUploadedFilesType()
    {
        $types = array();
        if (!is_null($this->pdf_file_name))
            $types[] = 'PDF';
        if (!is_null($this->epub_file_name))
            $types[] = 'EPUB';
        return implode(', ', $types);
    }

    public function getUploadedFilesSize()
    {
        $types = array();
        $filePath = Yii::getPathOfAlias("webroot") . "/uploads/books/files/";
        if (!is_null($this->pdf_file_name))
            $types[] = 'PDF: ' . Controller::fileSize($filePath . $this->pdf_file_name);
        if (!is_null($this->epub_file_name))
            $types[] = 'EPUB: ' . Controller::fileSize($filePath . $this->epub_file_name);
        return implode('<br>', $types);
    }

    public function getPrintYearAndPrice()
    {
        return $this->print_year . ' (' . Controller::parseNumbers(number_format($this->printed_price)) . ' تومان)';
    }

    public function hasDiscount()
    {
        if ($this->discount && $this->discount->hasPriceDiscount())
            return true;
        else
            return false;
    }

    public function getOffPrice()
    {
        if ($this->discount)
            return $this->discount->getOffPrice();
        else
            return $this->type == self::TYPE_PRINTED ? $this->printed_price : $this->electronic_price;
    }

    public function getDiscount()
    {
        $discount = BookDiscounts::model()->find('package_id = :id', [':id' => $this->id]);
        return $discount;
    }
}