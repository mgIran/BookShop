<?php

/**
 * This is the model class for table "{{discount_used}}".
 *
 * The followings are the available columns in table '{{discount_used}}':
 * @property string $id
 * @property string $discount_id
 * @property integer $user_id
 * @property string $date
 * @property string $discount_amount
 *
 * The followings are the available model relations:
 * @property UserTransactions $transaction
 * @property DiscountCodes $discount
 * @property Users $user
 */
class DiscountUsed extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{discount_used}}';
	}

	public $year_altField;
	public $month_altField;
	public $from_date_altField;
	public $to_date_altField;
	public $report_type;
	public $totalAmount;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('discount_id, user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('discount_id, discount_amount', 'length', 'max'=>10),
			array('date', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, discount_id, user_id, date, discount_amount, year_altField, month_altField, to_date_altField, from_date_altField, report_type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'discount' => array(self::BELONGS_TO, 'DiscountCodes', 'discount_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'discount_id' => 'Discount',
			'user_id' => 'User',
			'date' => 'Date',
			'discount_amount' => 'Date',
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

		$criteria=new CDbCriteria;

		$this->reportConditions($criteria);
		$criteria->order = 't.date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @param $criteria CDbCriteria
	 */
	public function reportConditions(&$criteria)
	{
		$criteria->compare('discount_id',$this->discount_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('discount_amount',$this->discount_amount,true);
		if($this->report_type){
			switch($this->report_type){
				case 'yearly':
					$startDate = JalaliDate::toGregorian(JalaliDate::date('Y', $this->year_altField, false), 1, 1);
					$startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
					$endTime = $startTime + (60 * 60 * 24 * 365);
					$criteria->addCondition('t.date >= :start_date');
					$criteria->addCondition('t.date <= :end_date');
					$criteria->params[':start_date'] = $startTime;
					$criteria->params[':end_date'] = $endTime;
					break;
				case 'monthly':
					$startDate = JalaliDate::toGregorian(JalaliDate::date('Y', $this->month_altField, false), JalaliDate::date('m', $this->month_altField, false), 1);
					$startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
					if(JalaliDate::date('m', $this->month_altField, false) <= 6)
						$endTime = $startTime + (60 * 60 * 24 * 31);
					else
						$endTime = $startTime + (60 * 60 * 24 * 30);
					$criteria->addCondition('t.date >= :start_date');
					$criteria->addCondition('t.date <= :end_date');
					$criteria->params[':start_date'] = $startTime;
					$criteria->params[':end_date'] = $endTime;
					break;
				case 'by-date':
					$criteria->addCondition('t.date >= :start_date');
					$criteria->addCondition('t.date <= :end_date');
					$criteria->params[':start_date'] = $this->from_date_altField;
					$criteria->params[':end_date'] = $this->to_date_altField;
					break;
			}
		}
	}

	public function getTotalAmount()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'SUM(t.discount_amount) as totalAmount';
		$this->reportConditions($criteria);
		$record = $this->find($criteria);
		return $record?$record->totalAmount:0;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DiscountUsed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
