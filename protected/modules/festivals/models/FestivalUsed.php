<?php

/**
 * This is the model class for table "{{festival_used}}".
 *
 * The followings are the available columns in table '{{festival_used}}':
 * @property string $id
 * @property string $festival_id
 * @property string $user_id
 * @property string $transaction_id
 * @property string $book_id
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Festivals $festival
 */
class FestivalUsed extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{festival_used}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('festival_id, user_id, transaction_id, book_id', 'required'),
			array('festival_id, user_id, transaction_id, book_id', 'length', 'max'=>10),
			array('date', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, festival_id, user_id, transaction_id, book_id, date', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'festival' => array(self::BELONGS_TO, 'Festivals', 'festival_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'festival_id' => 'Festival',
			'user_id' => 'User',
			'transaction_id' => 'Transaction',
			'book_id' => 'Book',
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
		$criteria->compare('festival_id',$this->festival_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FestivalUsed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
