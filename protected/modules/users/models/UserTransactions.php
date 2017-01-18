<?php

/**
 * This is the model class for table "ym_user_transactions".
 *
 * The followings are the available columns in table 'ym_user_transactions':
 * @property string $id
 * @property string $user_id
 * @property string $amount
 * @property string $date
 * @property string $status
 * @property string $token
 * @property string $authority
 * @property string $description
 * @property string $gateway_name
 * @property string $type
 * @property string $user_name
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserTransactions extends CActiveRecord
{
    public $statusLabels=array(
        'paid'=>'پرداخت کامل',
        'unpaid'=>'پرداخت ناقص',
    );

    public $typeLabels=array(
        'credit'=>'خرید اعتبار',
        'book'=>'خرید کتاب',
    );

    public $user_name;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_user_transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('authority', 'required', 'on'=>'set-authority'),
			array('user_id, amount', 'length', 'max'=>10),
			array('date, type', 'length', 'max'=>20),
			array('status', 'length', 'max'=>6),
			array('token, gateway_name', 'length', 'max'=>50),
			array('description', 'length', 'max'=>200),
			array('authority', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, amount, date, status, token, authority, description, gateway_name, type, user_name', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'user_id' => 'کاربر',
			'amount' => 'مقدار',
			'date' => 'تاریخ',
			'status' => 'وضعیت',
			'token' => 'کد رهگیری',
			'description' => 'توضیحات',
			'gateway_name' => 'نام درگاه',
			'type' => 'نوع تراکنش',
			'authority' => 'رشته احراز هویت بانک',
		);
	}

	/**
	 * @param int $pageSize
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
	public function search($pageSize=20)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('authority',$this->authority,true);
		$criteria->compare('description',$this->description,true);
        $criteria->compare('gateway_name',$this->gateway_name,true);
        $criteria->compare('type',$this->type,true);
        $criteria->order='t.id DESC';
        if($this->user_name) {
            $criteria->with=array('user','user.userDetails');
            $criteria->addSearchCondition('userDetails.fa_name', $this->user_name);
            $criteria->addSearchCondition('user.email', $this->user_name, true, 'OR');
        }

		if(isset($_GET['pageSize']))
			$pageSize = $_GET['pageSize'];
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => $pageSize)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserTransactions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
