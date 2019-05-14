<?php

/**
 * This is the model class for table "{{book_discounts}}".
 *
 * The followings are the available columns in table '{{book_discounts}}':
 * @property string $id
 * @property string $book_id
 * @property string $package_id
 * @property string $start_date
 * @property string $end_date
 * @property string $discount_type
 * @property string $percent
 * @property string $amount
 * @property string $offPrice
 * @property string $off_printed_price
 *
 * The followings are the available model relations:
 * @property Books $book
 * @property BookPackages $package
 */
class BookDiscounts extends CActiveRecord
{
	const DISCOUNT_TYPE_PERCENT = 1;
	const DISCOUNT_TYPE_AMOUNT = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{book_discounts}}';
	}

	public $discountTypeLabels = array(
		self::DISCOUNT_TYPE_PERCENT => 'درصدی' ,
		self::DISCOUNT_TYPE_AMOUNT => 'مبلغی' ,
	);

	public function getDiscountTypeLabels()
	{
		return $this->discountTypeLabels;
	}

	public function getDiscountTypeLabel()
	{
		return $this->discountTypeLabels[$this->discount_type];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id, package_id, discount_type' ,'required', 'except' => 'group') ,
			array('discount_type' ,'required', 'on' => 'group') ,
			array('book_id, package_id' ,'length' ,'max' => 11) ,
			array('start_date, end_date' ,'length' ,'max' => 20) ,
			array('discount_type' ,'length' ,'max' => 1) ,
			array('discount_type' ,'checkDiscount') ,
			array('percent' ,'length' ,'max' => 3) ,
			array('amount' ,'length' ,'max' => 12) ,
			array('start_date' ,'compare' ,'operator' => '>=' ,'compareValue' => time() - 60 * 60 ,'message' => 'تاریخ شروع کمتر از حال حاضر است.') ,
			array('end_date' ,'compare' ,'operator' => '>' ,'compareAttribute' => 'start_date' ,'message' => 'تاریخ پایان باید از تاریخ شروع بیشتر باشد.') ,
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, package_id, start_date, end_date, discount_type, percent, amount' ,'safe' ,'on' => 'search') ,
		);
	}

	public function checkDiscount()
	{
		if($this->scenario != 'admin_side'){
            if ($this->discount_type == self::DISCOUNT_TYPE_PERCENT && (!$this->percent || empty($this->percent)))
                $this->addError('percent', 'درصد تخفیف نمی تواند خالی باشد.');
            elseif ($this->discount_type == self::DISCOUNT_TYPE_AMOUNT && (!$this->amount || empty($this->amount)))
                $this->addError('amount', 'مبلغ تخفیف نمی تواند خالی باشد.');
		}else{
			if($this->discount_type == self::DISCOUNT_TYPE_PERCENT && (!$this->percent || empty($this->percent) || !$this->printed_percent || empty($this->printed_percent)))
				$this->addError('printed_percent' ,'درصد تخفیف نسخه الکترونیک یا چاپی نمی تواند خالی باشد.');
			elseif($this->discount_type == self::DISCOUNT_TYPE_AMOUNT && (!$this->amount || empty($this->amount) || !$this->printed_amount || empty($this->printed_amount)))
				$this->addError('amount' ,'مبلغ تخفیف نسخه الکترونیک یا چاپی نمی تواند خالی باشد.');
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
			'book' => array(self::BELONGS_TO ,'Books' ,'book_id') ,
			'package' => array(self::BELONGS_TO ,'BookPackages' ,'package_id') ,
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'book_id' => 'کتاب' ,
			'package_id' => 'نوبت چاپ' ,
			'start_date' => 'تاریخ شروع' ,
			'end_date' => 'تاریخ پایان' ,
			'discount_type' => 'نوع تخفیف' ,
			'percent' => 'درصد' ,
			'amount' => 'مقدار تخفیف' ,
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

		$criteria->compare('id' ,$this->id ,true);
		$criteria->compare('book_id' ,$this->book_id ,true);
		$criteria->compare('package_id' ,$this->package_id ,true);
		$criteria->compare('start_date' ,$this->start_date ,true);
		$criteria->compare('end_date' ,$this->end_date ,true);
		$criteria->compare('discount_type' ,$this->discount_type ,true);
		$criteria->compare('percent' ,$this->percent ,true);
		$criteria->compare('amount' ,$this->amount ,true);

		return new CActiveDataProvider($this ,array(
			'criteria' => $criteria ,
		));
	}

	public function searchDiscount()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		// delete expire discounts
		$criteria = new CDbCriteria();
		$criteria->addCondition('end_date < :now');
		$criteria->params = array(
			':now' => time()
		);
		BookDiscounts::model()->deleteAll($criteria);

		$criteria = new CDbCriteria();
		$criteria->with[] = 'book';
		$criteria->addCondition('book.deleted = 0');
		$criteria->addCondition('book.title != ""');
		$criteria->addCondition('end_date > :now');
		$criteria->params = array(
			':now' => time()
		);

		return new CActiveDataProvider($this ,array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => isset($_GET['pageSize'])?$_GET['pageSize']:30)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookDiscounts the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function getOffPrice()
	{
        $price = $package = null;
        if($this->hasPriceDiscount()){
            $disVal = 0;
            $package = $this->package;
            $price = $package->type == BookPackages::TYPE_ELECTRONIC ? $package->electronic_price : $package->printed_price;
            if($this->percent && !empty($this->percent) && $this->discount_type == self::DISCOUNT_TYPE_PERCENT)
                $disVal = $price * $this->percent / 100;
            elseif($this->amount && !empty($this->amount) && $this->discount_type == self::DISCOUNT_TYPE_AMOUNT)
                $disVal = $this->amount;
			$offPrice = $price - $disVal;
			return $offPrice < 100 ? 0 : $offPrice;
		}
		return $package ? $price : false;
	}

	public function getPrintedOffPrice($packageID)
	{
		$package = $this->book->printedPackages(['condition' => 'printedPackages.id = :id', 'params' => [':id' => $packageID]]);
		$package = isset($package[0]) ? $package[0] : $package;

		if($this->hasPriceDiscount()){
			$price = $package->printed_price;
			$disVal = 0;
			if($this->percent && !empty($this->percent) && $this->discount_type == self::DISCOUNT_TYPE_PERCENT)
				$disVal = $package->printed_price * $this->percent / 100;
			elseif($this->amount && !empty($this->amount) && $this->discount_type == self::DISCOUNT_TYPE_AMOUNT)
				$disVal = $this->amount;
			$offPrice = $price - $disVal;
			return $offPrice < 100 ? 0 : $offPrice;
		}
		return $package ? $package->printed_price : false;
	}

	public function hasPriceDiscount()
	{
		if($this->start_date < time() && $this->end_date > time() &&
			(($this->discount_type == self::DISCOUNT_TYPE_PERCENT && $this->percent && !empty($this->percent)) ||
				($this->discount_type == self::DISCOUNT_TYPE_AMOUNT && $this->amount && !empty($this->amount)))
		)
			return true;

		return false;
	}
}

