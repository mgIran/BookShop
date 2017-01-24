<?php

/**
 * This is the model class for table "{{discount_used}}".
 *
 * The followings are the available columns in table '{{discount_used}}':
 * @property string $id
 * @property string $discount_id
 * @property integer $user_id
 * @property string $buy_id
 * @property string $date
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
			array('discount_id, buy_id', 'length', 'max'=>10),
			array('date', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, discount_id, user_id, buy_id, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'buy' => array(self::BELONGS_TO, 'BookBuys', 'buy_id'),
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
			'buy_id' => 'Transaction',
			'date' => 'Date',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('discount_id',$this->discount_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('buy_id',$this->buy_id,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
