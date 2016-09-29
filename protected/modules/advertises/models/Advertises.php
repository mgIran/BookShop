<?php

/**
 * This is the model class for table "{{advertises}}".
 *
 * The followings are the available columns in table '{{advertises}}':
 * @property string $book_id
 * @property string $cover
 * @property string $fade_color
 * @property integer $status
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Books $book
 */
class Advertises extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{book_advertises}}';
	}

	/**
	 * @var $bookFilter string for search book title
	 */
	public $bookFilter;

	public $statusLabels = array(
		'0' => 'غیر فعال',
		'1' => 'فعال'
	);

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id, cover', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('book_id', 'length', 'max'=>10),
			array('create_date', 'default', 'value'=>time()),
			array('cover', 'length', 'max'=>200),
			array('fade_color', 'length', 'max'=>6),
			array('create_date', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bookFilter, book_id, cover, fade_color, status, create_date', 'safe', 'on'=>'search'),
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
			'book_id' => 'برنامه',
			'cover' => 'تصویر کاور',
			'fade_color' => 'رنگ زمینه',
			'status' => 'وضعیت',
			'create_date' => 'تاریخ ایجاد',
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
		$criteria=new CDbCriteria;

		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('t.status',$this->status);
		$criteria->with = array('book');
		$criteria->compare('book.title',$this->bookFilter,true);
		$criteria->order = 'create_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advertises the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function findActive()
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition('status = 1');
		$criteria->order = 'create_date DESC';
		$criteria->limit = 1;
		return Advertises::model()->find($criteria);
	}
}
