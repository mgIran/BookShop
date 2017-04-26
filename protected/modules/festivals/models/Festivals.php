<?php

/**
 * This is the model class for table "{{festivals}}".
 *
 * The followings are the available columns in table '{{festivals}}':
 * @property string $id
 * @property string $title
 * @property string $start_date
 * @property string $end_date
 * @property string $limit_times
 * @property string $type
 * @property string $range
 * @property string $gift_type
 * @property string $gift_amount
 * @property string $disposable
 */
class Festivals extends CActiveRecord
{
    const FESTIVAL_TYPE_CREDIT = 1;
    const FESTIVAL_TYPE_BOOK_BUY = 2;

    const FESTIVAL_GIFT_TYPE_PERCENT = 1;
    const FESTIVAL_GIFT_TYPE_AMOUNT = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{festivals}}';
    }

    public $typeLabels = [
        self::FESTIVAL_TYPE_CREDIT => 'خرید اعتبار',
        self::FESTIVAL_TYPE_BOOK_BUY => 'خرید کتاب'
    ];

    public $giftTypeLabels = [
        self::FESTIVAL_TYPE_CREDIT => 'درصدی',
        self::FESTIVAL_TYPE_BOOK_BUY => 'مبلغی'
    ];

    public $year_altField;
    public $month_altField;
    public $from_date_altField;
    public $to_date_altField;
    public $report_type;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('start_date, end_date, type, gift_type', 'required'),
            array('title, start_date, end_date', 'length', 'max' => 50),
            array('start_date, end_date', 'length', 'max' => 20),
            array('limit_times, range, gift_amount', 'length', 'max' => 10),
            array('type, gift_type, disposable', 'length', 'max' => 1),
            array('disposable', 'default', 'value' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, start_date, end_date, limit_times, type, range, gift_type, gift_amount, disposable', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'عنوان',
            'start_date' => 'تاریخ شروع',
            'end_date' => 'تاریخ پایان',
            'limit_times' => 'محدودیت استفاده',
            'type' => 'نوع طرح',
            'range' => 'اعتبار خریداری شده',
            'gift_type' => 'نوع هدیه',
            'gift_amount' => 'میزان هدیه',
            'disposable' => 'یکبار مصرف',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('limit_times', $this->limit_times, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('range', $this->range, true);
        $criteria->compare('gift_type', $this->gift_type, true);
        $criteria->compare('gift_amount', $this->gift_amount, true);
        $criteria->compare('disposable', $this->disposable, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Festivals the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Return Valid Discount Codes Criteria
     * @return CDbCriteria
     */
    public static function ValidCodes()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('start_date <= :time AND end_date >= :time');
        $criteria->params[':time'] = time();
        return $criteria;
    }

    /**
     * @return string count of user that used this festival
     */
    public function usedCount()
    {
        return FestivalUsed::model()->count('festival_id = :id', array(':id' => $this->id));
    }

    /**
     * @param $userID
     * @return string
     */
    public function userUsedStatus($userID)
    {
        return FestivalUsed::model()->count('festival_id = :id AND user_id = :user_id', array(':id' => $this->id, ':user_id' => $userID));
    }

    /**
     * Check Festivals and return gift amounts
     *
     * @param $user_id
     * @param $type
     * @param $range
     * @return array of gift amount and used festival ids
     */
    public static function CheckFestivals($user_id, $type, $range){
        $criteria = self::ValidCodes();
        $criteria->compare('t.type', $type);
        $criteria->compare('t.range', (double)$range);
        $records = Festivals::model()->findAll($criteria);
        $GiftSum = 0;
        $ids = [];
        foreach($records as $record)
        {
            // check festival disposable or not
            if($record->disposable && $record->userUsedStatus($user_id))
                continue;
            // check expire limitation user times or not
            if($record->limit_times && $record->usedCount() >= $record->limit_times)
                continue;
            if($record->gift_type == self::FESTIVAL_GIFT_TYPE_AMOUNT)
            {
                $GiftSum+=(double)$record->gift_amount;
                $ids[] = $record->id;
            }
            elseif($record->gift_type == self::FESTIVAL_GIFT_TYPE_PERCENT)
            {
                $GiftSum+= (double)$range * ((double)$record->gift_amount/100);
                $ids[] = $record->id;
            }
        }
        return ['gift' => $GiftSum, 'ids' => $ids];
    }

    public static function DeleteExpires(){
        $criteria = new CDbCriteria();
        $criteria->addCondition('end_date < :time');
        $criteria->params[':time'] = time();
        @Festivals::model()->deleteAll($criteria);
    }

    /**
     * Save User used festival in database
     *
     * @param $festival_id
     * @param $user_id
     * @param $range
     * @param $gift_amount
     * @param null $transaction_id
     * @param null $book_id
     * @return bool
     */
    public static function ApplyUsed($festival_id, $user_id, $range, $gift_amount, $transaction_id = NULL, $book_id = NULL)
    {
        $model = new FestivalUsed();
        $model->festival_id = $festival_id;
        $model->user_id = $user_id;
        $model->transaction_id = $transaction_id;
        $model->book_id = $book_id;
        $model->range = $range;
        $model->gift_amount = $gift_amount;
        return @$model->save();
    }
}