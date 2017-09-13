<?php

/**
 * This is the model class for table "{{discount_codes}}".
 *
 * The followings are the available columns in table '{{discount_codes}}':
 * @property string $id
 * @property string $title
 * @property string $code
 * @property string $start_date
 * @property string $expire_date
 * @property string $limit_times
 * @property string $off_type
 * @property string $percent
 * @property string $amount
 * @property integer $user_id
 * @property integer $shop_allow
 * @property integer $digital_allow
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property DiscountUsed $codeUsed
 * @property DiscountUsed[] $codesUsed
 */
class DiscountCodes extends CActiveRecord
{

	const DISCOUNT_TYPE_PERCENT = 1;
	const DISCOUNT_TYPE_AMOUNT = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{discount_codes}}';
	}

    public $offTypeLabels = [
        self::DISCOUNT_TYPE_PERCENT => 'درصدی',
        self::DISCOUNT_TYPE_AMOUNT => 'مبلغی'
    ];
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO ,'Users' ,'user_id') ,
			'codesUsed' => array(self::HAS_MANY ,'DiscountUsed' ,'discount_id'),
			'codeUsed' => array(self::HAS_ONE ,'DiscountUsed' ,'discount_id')
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, code, start_date, expire_date, off_type', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('code' ,'unique') ,
			array('title, code', 'length', 'max'=>50),
			array('code', 'length', 'min'=>5),
			array('start_date, expire_date', 'length', 'max'=>20),
			array('limit_times, amount', 'length', 'max'=>10),
			array('off_type, shop_allow, digital_allow', 'length', 'max'=>1),
			array('percent', 'length', 'max'=>2),
			array('percent' ,'compare' ,'operator' => '!=' ,'compareValue' => 0 ,'message' => 'درصد تخفیف نمی تواند 0 درصد باشد.', 'on' => 'percent_off') ,
			array('amount' ,'compare' ,'operator' => '!=' ,'compareValue' => 0 ,'message' => 'مبلغ تخفیف نمی تواند 0 تومان باشد.', 'on' => 'amount_off') ,
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, code, start_date, expire_date, limit_times, off_type, percent, amount, user_id, shop_allow, digital_allow', 'safe', 'on'=>'search'),
		);
	}


	public function codeGenerator()
	{
		$len = 5;
		$this->code = Controller::generateRandomString($len);
		$i = 0;
		while($this->findByAttributes(array('code' => $this->code))){
			$this->code = Controller::generateRandomString($len);
			$i++;
			if($i > 5)
				$len++;
		}
		return $this->code;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'code' => 'کدتخفیف',
			'start_date' => 'تاریخ شروع',
			'expire_date' => 'تاریخ انقضا',
			'limit_times' => 'محدودیت تعداد',
			'off_type' => 'نوع تخفیف',
			'percent' => 'درصد تخفیف',
			'amount' => 'مبلغ تخفیف',
			'user_id' => 'User',
			'shop_allow' => 'مجاز در فروشگاه',
			'digital_allow' => 'مجاز در خرید نسخه الکترونیک',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('expire_date',$this->expire_date,true);
		$criteria->compare('limit_times',$this->limit_times,true);
		$criteria->compare('off_type',$this->off_type,true);
		$criteria->compare('percent',$this->percent,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('shop_allow',$this->shop_allow);
		$criteria->compare('digital_allow',$this->digital_allow);
        if(!$this->user_id)
		    $criteria->addCondition('user_id IS NULL');
        else
		    $criteria->compare('user_id',$this->user_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DiscountCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Return Valid Discount Codes Criteria
     * @return CDbCriteria
     */
    public static function ValidCodes(){
        $criteria = new CDbCriteria();
        $criteria->addCondition('start_date <= :time AND expire_date >= :time');
        $criteria->params[':time'] = time();
        return $criteria;
    }

    public function usedCount(){
        return DiscountUsed::model()->count('discount_id = :id',array(':id' => $this->id));
    }

	public function userUsedStatus($userID){
        return DiscountUsed::model()->count('discount_id = :id AND user_id = :user_id',array(':id' => $this->id, ':user_id' => $userID));
    }



	#region calculate discount
	/**
	 * @param $price
	 * @param $allow_type
	 * @return array|mixed|null
	 */
	public static function calculateDiscountCodes(&$price, $allow_type)
    {
        $discountCodesInSession = array();
        if (Yii::app()->user->hasState('discount-codes')) {
            $discountCodesInSession = Yii::app()->user->getState('discount-codes');
            $discountCodesInSession = CJSON::decode(base64_decode($discountCodesInSession));
            $priceZero = false;
            if (is_array($discountCodesInSession)) { // add multiple discount codes in invoice
                foreach ($discountCodesInSession as $key => $code) {
                    if (!$priceZero) {
                        $criteria = DiscountCodes::ValidCodes();
                        $criteria->compare('code', $code);
                        $discountObj = DiscountCodes::model()->find($criteria);
                        if ($discountObj && $discountObj->{$allow_type . '_allow'} && !$discountObj->userUsedStatus(Yii::app()->user->getId())) {
                            $disVal = $discountObj->getAmount($price);
                            if ($price < 100 || $price - $disVal < 100) {
                                $price = 0;
                                $priceZero = true;
                            } else
                                $price -= $disVal;
                        } else
                            unset($discountCodesInSession[$key]);
                    } else
                        unset($discountCodesInSession[$key]);
                }
            } else // add single discount code in invoice
            {
                $code = $discountCodesInSession;
                $criteria = DiscountCodes::ValidCodes();
                $criteria->compare('code', $code);
                $discountObj = DiscountCodes::model()->find($criteria);
                if ($discountObj && $discountObj->{$allow_type . '_allow'} && !$discountObj->userUsedStatus(Yii::app()->user->getId())) {
                    $disVal = $discountObj->getAmount($price);
                    if ($price < 100 || $price - $disVal < 100) {
                        $price = 0;
                    } else
                        $price -= $disVal;
                } else
                    $discountCodesInSession = null;
            }

            Yii::app()->user->setState('discount-codes', base64_encode(CJSON::encode($discountCodesInSession)));
        }
        return $discountCodesInSession;
    }

    /**
	 * @param $price
	 * @param $allow_type
	 * @param $codes
	 * @param $userID
	 * @return array|mixed|null
	 */
	public static function calculateDiscountCodesManual(&$price, $allow_type, $codes = false, $userID)
	{
		$discountCodes = array();
		if ($codes) {
			$discountCodes = $codes;
			$priceZero = false;
			if (is_array($discountCodes)) { // add multiple discount codes in invoice
				foreach ($discountCodes as $key => $code) {
					if (!$priceZero) {
						$criteria = DiscountCodes::ValidCodes();
						$criteria->compare('code', $code);
						$discountObj = DiscountCodes::model()->find($criteria);
						if ($discountObj && $discountObj->{$allow_type . '_allow'} && !$discountObj->userUsedStatus($userID)) {
							$disVal = $discountObj->getAmount($price);
							if ($price < 100 || $price - $disVal < 100) {
								$price = 0;
								$priceZero = true;
							} else
								$price -= $disVal;
						} else
							unset($discountCodes[$key]);
					} else
						unset($discountCodes[$key]);
				}
			} else // add single discount code in invoice
			{
				$code = $discountCodes;
				$criteria = DiscountCodes::ValidCodes();
				$criteria->compare('code', $code);
				$discountObj = DiscountCodes::model()->find($criteria);
				if ($discountObj && $discountObj->{$allow_type . '_allow'} && !$discountObj->userUsedStatus($userID)) {
					$disVal = $discountObj->getAmount($price);
					if ($price < 100 || $price - $disVal < 100) {
						$price = 0;
					} else
						$price -= $disVal;
				} else
					$discountCodes = null;
			}
		}
		return $discountCodes;
	}
	#endregion

    #region add new discount
    /**
     * @param $discount DiscountCodes
     * @return bool
     */
    public static function addDiscountCodes($discount)
    {
        // add multiple discount codes in invoice
//        $discountCodesInSession = array();
//        $discountIdsInSession = array();
//        if (Yii::app()->user->hasState('discount-codes')) {
//            $discountCodesInSession = Yii::app()->user->getState('discount-codes');
//            if ($discountCodesInSession)
//                $discountCodesInSession = CJSON::decode(base64_decode($discountCodesInSession));
//        }
//        if (Yii::app()->user->hasState('discount-ids')) {
//            $discountIdsInSession = Yii::app()->user->getState('discount-ids');
//            if ($discountIdsInSession)
//                $discountIdsInSession = CJSON::decode(base64_decode($discountIdsInSession));
//        }
//        if (in_array($discount->code, $discountCodesInSession)) {
//            return false;
//        }
//        array_push($discountCodesInSession, $discount->code);
//        array_push($discountIdsInSession, $discount->id);
//        $discountCodesInSession = array_unique($discountCodesInSession, SORT_REGULAR);
//        $discountIdsInSession = array_unique($discountIdsInSession, SORT_REGULAR);
        //

        // add single discount code
        $discountCodesInSession = $discount->code;
        $discountIdsInSession = $discount->id;
        //
        Yii::app()->user->setState('discount-codes', base64_encode(CJSON::encode($discountCodesInSession)));
        Yii::app()->user->setState('discount-ids', base64_encode(CJSON::encode($discountIdsInSession)));
        return true;
    }
    #endregion

	/**
	 * @param $user
	 * @param $amount
	 */
    public static function InsertCodes($user, $amount){
        $discountIdsInSession = $user->getDiscountIds();
        if(is_array($discountIdsInSession)){ // exists multiple discount code
            foreach($discountIdsInSession as $dis_id){
                $discountUsed = new DiscountUsed();
                $discountUsed->user_id = $user->id;
                $discountUsed->discount_id = $dis_id;
                $discountUsed->discount_amount = $amount;
                $discountUsed->date = time();
                @$discountUsed->save();
            }
        }elseif($discountIdsInSession)// exists single discount code
        {
            $discountUsed = new DiscountUsed();
            $discountUsed->user_id = $user->id;
            $discountUsed->discount_id = $discountIdsInSession;
			$discountUsed->discount_amount = $amount;
            $discountUsed->date = time();
            @$discountUsed->save();
        }
        $user->clearDiscountCodesStates();
    }

	public function getAmount($price){
		$disVal = 0;
		if($this->off_type == DiscountCodes::DISCOUNT_TYPE_AMOUNT && $this->amount)
			$disVal = (double)$this->amount;
		elseif($this->off_type == DiscountCodes::DISCOUNT_TYPE_PERCENT && $this->percent)
			$disVal = (double)($price * (double)((double)$this->percent / 100));
		return $disVal;
	}

	public function getAllow(){
		$text = [];
		if($this->shop_allow)
			$text[]='فروشگاه';
		if($this->digital_allow)
			$text[]='خرید الکترونیک';
		return $text?implode(' ، ',$text):'بدون مجوز';
	}
}
