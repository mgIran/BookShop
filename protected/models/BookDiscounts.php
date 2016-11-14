<?php

/**
 * This is the model class for table "{{book_discounts}}".
 *
 * The followings are the available columns in table '{{book_discounts}}':
 * @property string $id
 * @property string $book_id
 * @property string $start_date
 * @property string $end_date
 * @property string $percent
 * @property string $offPrice
 * @property string $off_printed_price
 *
 * The followings are the available model relations:
 * @property Books $book
 */
class BookDiscounts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{book_discounts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id,percent', 'required'),
			array('id, book_id', 'length', 'max'=>11),
			array('start_date, end_date', 'length', 'max'=>20),
			array('start_date','compare' ,'operator' => '>=','compareValue' => time()-60*60 ,'message' => 'تاریخ شروع کمتر از حال حاضر است.'),
			array('end_date','compare' ,'operator' => '>','compareAttribute' => 'start_date','message' => 'تاریخ پایان باید از تاریخ شروع بیشتر باشد.'),
			array('percent', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id ,book_id, start_date, end_date, percent', 'safe', 'on'=>'search'),
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
			'book_id' => 'کتاب',
			'start_date' => 'تاریخ شروع',
			'end_date' => 'تاریخ پایان',
			'percent' => 'درصد',
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

		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('percent',$this->percent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchDiscount()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		// delete expire discounts
		$criteria=new CDbCriteria();
		$criteria->addCondition('end_date < :now');
		$criteria->params=array(
			':now' => time()
		);
		BookDiscounts::model()->deleteAll($criteria);

		$criteria=new CDbCriteria();
		$criteria->with[] = 'book';
		$criteria->addCondition('book.deleted = 0');
		$criteria->addCondition('book.title != ""');
		$criteria->addCondition('end_date > :now');
		$criteria->params=array(
			':now' => time()
		);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookDiscounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getOffPrice(){
		return $this->book->lastPackage->price - $this->book->lastPackage->price * $this->percent /100;
	}
	public function getOff_printed_price(){
		return $this->book->lastPackage->printed_price - $this->book->lastPackage->printed_price * $this->percent /100;
	}
}

