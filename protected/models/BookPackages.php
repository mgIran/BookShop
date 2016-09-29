<?php

/**
 * This is the model class for table "ym_book_packages".
 *
 * The followings are the available columns in table 'ym_book_packages':
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
        'new_book'=>'<span class="label label-success">بسته جدید</span>',
        'old_book'=>'<span class="label label-warning">بسته تغییر داده شده</span>',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ym_book_packages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('package_name', 'uniquePublisher', 'on' => 'insert, update'),
            array('book_id', 'length', 'max' => 10),
            array('version, create_date, publish_date', 'length', 'max' => 20),
            array('package_name', 'length', 'max' => 100),
            array('file_name', 'length', 'max' => 255),
            array('status', 'length', 'max' => 15),
            array('reason', 'safe'),
            array('for', 'length', 'max'=>7),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, book_id, version, package_name, file_name, create_date, publish_date, status, reason, for', 'safe', 'on' => 'search'),
        );
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
            'book_id' => 'برنامه',
            'version' => 'نسخه',
            'package_name' => 'نام بسته',
            'file_name' => 'فایل',
            'create_date' => 'تاریخ بارگذاری',
            'publish_date' => 'تاریخ انتشار',
            'status' => 'وضعیت',
            'reason' => 'دلیل',
            'for' => 'نوع بسته',
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
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('publish_date', $this->publish_date, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('reason',$this->reason,true);
        $criteria->compare('for',$this->for,true);

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

    /**
     * Check book be unique
     * @param string $attribute field name.
     */
    public function uniquePublisher($attribute)
    {
        $models = $this->findAllByAttributes(array('package_name' => $this->$attribute));
        if (!is_null($models))
            foreach ($models as $model)
                if ($model->book->platform_id == $this->book->platform_id)
                    if ($model->book->publisher_id != Yii::app()->user->getId())
                        $this->addError($attribute, 'این بسته قبلا توسط کاربر دیگری ثبت شده است.');
                    else {
                        if ($model->book_id == $this->book_id) {
                            if ($model->version == $this->version)
                                $this->addError($attribute, 'این نسخه قبلا ثبت شده است.');
                        } else
                            $this->addError($attribute, 'این بسته قبلا ثبت شده است.');
                    }
    }
}