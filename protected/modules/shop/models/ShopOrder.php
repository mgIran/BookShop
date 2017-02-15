<?php

/**
 * This is the model class for table "{{shop_order}}".
 *
 * The followings are the available columns in table '{{shop_order}}':
 * @property string $id
 * @property string $user_id
 * @property string $delivery_address_id
 * @property string $billing_address_id
 * @property string $ordering_date
 * @property string $update_date
 * @property string $status
 * @property string $payment_method
 * @property string $shipping_method
 * @property double $payment_amount
 * @property double $discount_amount
 * @property double $price_amount
 * @property double $shipping_price
 * @property double $payment_price
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property ShopAddresses $deliveryAddress
 * @property ShopAddresses $billingAddress
 * @property ShopShippingMethod $shippingMethod
 * @property ShopPaymentMethod $paymentMethod
 * @property ShopOrderItems[] $items
 */
class ShopOrder extends CActiveRecord
{
	const STATUS_PENDING = 0;
	const STATUS_ACCEPTED = 1;
	const STATUS_PAID = 2;
	const STATUS_STOCK_PROCESS = 3;
	const STATUS_SEND_READY = 4;
	const STATUS_DELIVERED = 5;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_order}}';
	}

    public $statusLabels = [
//        self::STATUS_DEACTIVE => 'غیرفعال',
//        self::STATUS_ACTIVE => 'فعال',
    ];

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, ordering_date, payment_method, shipping_method', 'required'),
			array('payment_amount, discount_amount, price_amount, shipping_price, payment_price', 'numerical'),
			array('user_id, delivery_address_id, billing_address_id, payment_method, shipping_method', 'length', 'max' => 10),
			array('ordering_date, update_date', 'length', 'max' => 20),
			array('status', 'length', 'max' => 1),
			array('comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, delivery_address_id, billing_address_id, ordering_date, update_date, status, payment_method, shipping_method, payment_amount, discount_amount, price_amount, shipping_price, payment_price', 'safe', 'on' => 'search'),
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
			'deliveryAddress' => array(self::BELONGS_TO, 'ShopAddresses', 'delivery_address_id'),
			'billingAddress' => array(self::BELONGS_TO, 'ShopAddresses', 'billing_address_id'),
			'items' => array(self::HAS_MANY, 'ShopOrderItems', 'order_id'),
			'paymentMethod' => array(self::BELONGS_TO, 'ShopPaymentMethod', 'payment_method'),
			'shippingMethod' => array(self::BELONGS_TO, 'ShopShippingMethod', 'shipping_method'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه سفارش',
			'user_id' => 'کاربر',
			'delivery_address_id' => 'آدرس تحویل کالا',
			'billing_address_id' => 'آدرس تحویل فاکتور',
			'ordering_date' => 'تاریخ ثبت سفارش',
			'update_date' => 'تاریخ تغییر وضعیت',
			'status' => 'وضعیت',
			'payment_method' => 'شیوه پرداخت',
			'shipping_method' => 'شیوه تحویل',
			'payment_amount' => 'مبلغ پرداختی',
			'discount_amount' => 'تخفیف',
			'price_amount' => 'مبلغ پایه فاکتور',
			'shipping_price' => 'هزینه ارسال',
			'payment_price' => 'هزینه اضافی پرداخت',
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
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('delivery_address_id', $this->delivery_address_id, true);
		$criteria->compare('billing_address_id', $this->billing_address_id, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('payment_method', $this->payment_method);
		$criteria->compare('shipping_method', $this->shipping_method);
		$criteria->compare('payment_amount', $this->payment_amount);
		$criteria->compare('discount_amount', $this->discount_amount);
		$criteria->compare('price_amount', $this->price_amount);
		$criteria->compare('shipping_price', $this->shipping_price);
		$criteria->compare('payment_price', $this->payment_price);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopOrder the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return mixed
	 */
	public function getStatusLabel()
	{
		return $this->statusLabels[$this->status];
	}

	/**
	 * Change Payment Method Status
	 *
	 * @return $this
	 */
	public function changeStatus()
	{
//		if($this->status == self::STATUS_ACTIVE)
//			$this->status = self::STATUS_DEACTIVE;
//		else if($this->status == self::STATUS_DEACTIVE)
//			$this->status = self::STATUS_ACTIVE;
//		return $this;
	}
}