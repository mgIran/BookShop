<?php

/**
 * This is the model class for table "{{book_packages}}".
 *
 * The followings are the available columns in table '{{book_packages}}':
 * @property string $id
 * @property string $book_id
 * @property string $version
 * @property string $package_name
 * @property string $file_name
 * @property string $create_date
 * @property string $publish_date
 * @property string $status
 * @property string $reason
 * @property string $for
 * @property string $isbn
 * @property string $price
 * @property string $printed_price
 *
 * The followings are the available model relations:
 * @property Books $book
 */
class BookPackages extends CActiveRecord
{
    public $statusLabels = array(
        'pending' => 'بارگذاری شده',
        'accepted' => 'تایید شده',
        'refused' => 'رد شده',
        'change_required' => 'نیاز به تغییر',
    );

    public $forLabels = array(
        'new_book'=>'<span class="label label-success">کتاب جدید</span>',
        'old_book'=>'<span class="label label-warning">کتاب تغییر داده شده</span>',
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
            array('book_id, package_name, version, isbn, price, printed_price, file_name', 'required'),
            array('book_id, price, printed_price', 'length', 'max'=>10),
            array('version, isbn, create_date, publish_date', 'length', 'max'=>20),
            array('version, price, printed_price', 'numerical', 'integerOnly'=>true),
            array('isbn, create_date, publish_date, reason', 'filter', 'filter'=>'strip_tags'),
            array('package_name', 'length', 'max'=>100),
            array('file_name', 'length', 'max'=>255),
            array('status', 'length', 'max'=>15),
            array('for', 'length', 'max'=>8),
            array('create_date', 'default', 'value'=>time()),
            array('isbn', 'isbnChecker'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, book_id, version, package_name, isbn, file_name, create_date, publish_date, status, reason, for, price, printed_price', 'safe', 'on'=>'search'),
        );
    }

    public function isbnChecker($attribute ,$params)
    {
        $isbn = str_ireplace('-','',$this->$attribute);
        if(strlen($isbn) !== 10 && strlen($isbn) !== 13)
                $this->addError($attribute ,'طول رشته شابک اشتباه است.');
        $numbers = str_split($isbn);
        $sum = 0;
        if(strlen($isbn) === 13)
        {
            foreach($numbers as $key => $number)
            {
                $z = 1;
                if($key % 2)
                    $z = 3;
                $sum += $number * $z;
            }
            if($sum%10 !== 0)
                $this->addError($attribute ,'شابک نامعتبر است.');
        }
        elseif(strlen($isbn) === 10)
        {
            $z = 10;
            foreach($numbers as $key => $number)
            {
                $sum += $number * $z;
                $z--;
            }
            if($sum%11 !== 0)
                $this->addError($attribute ,'شابک نامعتبر است.');
        }
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
            'version' => 'نسخه',
            'package_name' => 'نام نوبت چاپ',
            'file_name' => 'فایل',
            'create_date' => 'تاریخ بارگذاری',
            'publish_date' => 'تاریخ انتشار',
            'status' => 'وضعیت',
            'reason' => 'دلیل',
            'for' => 'نوع نوبت چاپ',
            'isbn' => 'شابک',
            'price' => 'قیمت',
            'printed_price' => 'قیمت نسخه چاپی',
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
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('isbn',$this->isbn,true);

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

    public function getOffPrice()
    {
        if($this->book->discount)
            return $this->price - $this->price * $this->book->discount->percent / 100;
        else
            return $this->price;
    }

    /**
     * Return publisher portion
     */
    public function getPublisherPortion()
    {
        Yii::app()->getModule('setting');
        $tax = SiteSetting::model()->findByAttributes(array('name' => 'tax'))->value;
        $commission = SiteSetting::model()->findByAttributes(array('name' => 'commission'))->value;
        $price = $this->price;
        $tax = ($price * $tax) / 100;
        $commission = ($price * $commission) / 100;
        return $price - $tax - $commission;
    }
}