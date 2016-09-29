<?php

/**
 * This is the model class for table "ym_books".
 *
 * The followings are the available columns in table 'ym_books':
 * @property string $id
 * @property string $title
 * @property string $publisher_id
 * @property string $category_id
 * @property string $status
 * @property double $price
 * @property string $icon
 * @property string $description
 * @property double $size
 * @property string $confirm
 * @property string $publisher_name
 * @property integer $seen
 * @property string $download
 * @property string $install
 * @property integer $deleted
 * @property integer $offPrice
 * @property integer $rate
 *
 *
 * The followings are the available model relations:
 * @property BookPackages $lastPackage
 * @property BookBuys[] $bookBuys
 * @property BookImages[] $images
 * @property BookPlatforms $platform
 * @property Users $publisher
 * @property BookCategories $category
 * @property Users[] $bookmarker
 * @property BookPackages[] $packages
 * @property BookDiscounts $discount
 */
class Books extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_books';
	}

	private $_purifier;
	public $platformsID = array(
			'1' => 'android',
			'2' => 'ios',
			'3' => 'windowsphone',
	);
	public $confirmLabels = array(
			'pending' => 'در حال بررسی',
			'refused' => 'رد شده',
			'accepted' => 'تایید شده',
			'change_required' => 'نیاز به تغییر',
	);
	public $statusLabels = array(
			'enable' => 'فعال',
			'disable' => 'غیر فعال'
	);
	public $lastPackage;

	/**
	 * @var string publisher name filter
	 */
	public $devFilter;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		$this->_purifier = new CHtmlPurifier();
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('platform_id', 'required', 'on' => 'insert'),
				array('title, category_id, price ,platform_id ,icon', 'required', 'on' => 'update'),
				array('price, size, platform_id', 'numerical'),
				array('seen, install, deleted', 'numerical', 'integerOnly' => true),
				array('description, change_log', 'filter', 'filter' => array($this->_purifier, 'purify')),
				array('title, icon, publisher_name', 'length', 'max' => 50),
				array('publisher_id, category_id, platform_id', 'length', 'max' => 10),
				array('status', 'length', 'max' => 7),
				array('download, install', 'length', 'max' => 12),
				array('price, size', 'numerical'),
				array('description, change_log, permissions ,publisher_name ,_purifier', 'safe'),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array('id, title, publisher_id, category_id, status, price, icon, description, change_log, permissions, size, confirm, platform_id, publisher_name, seen, download, install, deleted ,devFilter', 'safe', 'on' => 'search'),
				array('description, change_log', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
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
				'bookBuys' => array(self::HAS_MANY, 'BookBuys', 'book_id'),
				'images' => array(self::HAS_MANY, 'BookImages', 'book_id'),
				'platform' => array(self::BELONGS_TO, 'BookPlatforms', 'platform_id'),
				'publisher' => array(self::BELONGS_TO, 'Users', 'publisher_id'),
				'category' => array(self::BELONGS_TO, 'BookCategories', 'category_id'),
				'discount' => array(self::BELONGS_TO, 'BookDiscounts', 'id'),
				'bookmarker' => array(self::MANY_MANY, 'Users', 'ym_user_book_bookmark(book_id,user_id)'),
				'packages' => array(self::HAS_MANY, 'BookPackages', 'book_id'),
				'ratings' => array(self::HAS_MANY, 'BookRatings', 'book_id'),
				'advertise' => array(self::BELONGS_TO, 'Advertises', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'شناسه',
				'title' => 'عنوان',
				'publisher_id' => 'توسعه دهنده',
				'category_id' => 'دسته',
				'status' => 'وضعیت',
				'price' => 'قیمت',
				'icon' => 'آیکون',
				'description' => 'توضیحات',
				'change_log' => 'لیست تغییرات',
				'permissions' => 'دسترسی ها',
				'size' => 'حجم',
				'confirm' => 'وضعیت انتشار',
				'platform_id' => 'پلتفرم',
				'publisher_name' => 'تیم توسعه دهنده',
				'seen' => 'دیده شده',
				'download' => 'تعداد دریافت',
				'install' => 'تعداد نصب فعال',
				'deleted' => 'حذف شده',
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
	public function search($withFree = true)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.title', $this->title, true);
		$criteria->compare('category_id', $this->category_id);
		$criteria->compare('t.status', $this->status);
		$criteria->compare('price', $this->price);
		$criteria->compare('platform_id', $this->platform_id);
		$criteria->with = array('publisher', 'publisher.userDetails');
		$criteria->addCondition('publisher_name Like :dev_filter OR  userDetails.fa_name Like :dev_filter OR userDetails.en_name Like :dev_filter OR userDetails.publisher_id Like :dev_filter');
		$criteria->params[':dev_filter'] = '%'.$this->devFilter.'%';

		if(!$withFree)
			$criteria->addCondition('price <> 0');

		$criteria->addCondition('deleted=0');

		$criteria->addCondition('t.title != ""');
		$criteria->order = 't.id DESC';

		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Books the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Return publisher portion
	 */
	public function getPublisherPortion()
	{
		Yii::app()->getModule('setting');
		$tax = SiteSetting::model()->findByAttributes(array('name' => 'tax'))->value;
		$commission = SiteSetting::model()->findByAttributes(array('name' => 'commission'))->value;
		$price = $this->price;
		$tax = ($price * $tax) / 100;
		$commission = ($price * $commission) / 100;
		return $price - $tax - $commission;
	}

	/**
	 * Return url of book file
	 */
	public function getBookFileUrl()
	{
		if(!empty($this->packages))
			return Yii::app()->createUrl("/uploads/books/files/".strtolower($this->platformsID[$this->platform_id])."/".$this->lastPackage->file_name);
		return '';
	}

	public function afterFind()
	{
		if(!empty($this->packages))
			$this->lastPackage = $this->packages[count($this->packages) - 1];
	}

	public function getPublisherName()
	{
		if($this->publisher)
			return $this->publisher->userDetails->nickname;
		else
			return $this->publisher_name;
	}

	public function getOffPrice()
	{
		if($this->discount)
			return $this->price - $this->price * $this->discount->percent / 100;
		else
			return $this->price;
	}

	public function hasDiscount()
	{
		if($this->discount && $this->discount->percent && $this->discount->start_date < time() && $this->discount->end_date > time())
			return true;
		else
			return false;
	}

	public function calculateRating()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('book_id', $this->id);
		$result['totalCount'] = BookRatings::model()->count($criteria);
		$criteria->select = array('rate', 'avg(rate) as avgRate');
		$result['totalAvg'] = BookRatings::model()->find($criteria)->avgRate;

		$criteria->addCondition('rate = :rate');
		$criteria->params[':rate'] = 1;
		$result['oneCount'] = BookRatings::model()->count($criteria);
		$result['onePercent'] = $result['totalCount'] ? $result['oneCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 2;
		$result['twoCount'] = BookRatings::model()->count($criteria);
		$result['twoPercent'] = $result['totalCount'] ? $result['twoCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 3;
		$result['threeCount'] = BookRatings::model()->count($criteria);
		$result['threePercent'] = $result['totalCount'] ? $result['threeCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 4;
		$result['fourCount'] = BookRatings::model()->count($criteria);
		$result['fourPercent'] = $result['totalCount'] ? $result['fourCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 5;
		$result['fiveCount'] = BookRatings::model()->count($criteria);
		$result['fivePercent'] = $result['totalCount'] ? $result['fiveCount'] / $result['totalCount'] * 100 : 0;
		return $result;
	}

	public function getRate()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('book_id', $this->id);
		$criteria->select = array('rate', 'avg(rate) as avgRate');
		return BookRatings::model()->find($criteria)->avgRate;
	}

	public function userRated($user_id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('book_id', $this->id);
		$criteria->compare('user_id', $user_id);
		$result = BookRatings::model()->find($criteria);
		return $result ? $result->rate : false;
	}

	/**
	 *
	 * Get criteria for valid books
	 *
	 * @param null $platform
	 * @param array $categoryIds
	 * @return CDbCriteria
	 */
	public function getValidBooks($categoryIds = array(),$order = 'id DESC',$limit = 20)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status=:status');
		$criteria->addCondition('confirm=:confirm');
		$criteria->addCondition('deleted=:deleted');
		$criteria->addCondition('(SELECT COUNT(book_images.id) FROM ym_book_images book_images WHERE book_images.book_id=t.id) != 0');
		$criteria->addCondition('(SELECT COUNT(book_packages.id) FROM ym_book_packages book_packages WHERE book_packages.book_id=t.id) != 0');
		$criteria->params[':status'] = 'enable';
		$criteria->params[':confirm'] = 'accepted';
		$criteria->params[':deleted'] = 0;
		if($categoryIds)
			$criteria->addInCondition('category_id', $categoryIds);
		$criteria->order = $order;
		$criteria->limit = $limit;
		return $criteria;
	}
}
