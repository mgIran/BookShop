<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property string $id
 * @property string $title
 * @property string $summary
 * @property string $body
 * @property string $image
 * @property string $seen
 * @property string $create_date
 * @property string $publish_date
 * @property string $status
 * @property string $category_id
 * @property string $order
 *
 * The followings are the available model relations:
 * @property NewsCategories $category
 * @property Tags[] $tags
 * @property TagRel[] $tagsRel
 */
class News extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news}}';
	}

	public $formTags=[];
	public $statusLabels=[
		'draft' => 'پیش نویس',
		'publish' => 'انتشار یافته'
	];

	/**
	 * __set
	 *
	 * Rewrite default setter, so we can dynamically add
	 * new virtual attribtues such as name_en, name_de etc.
	 *
	 * @param string $name
	 * @param string $value
	 * @return string
	 */

	public function __set($name, $value)
	{
		if (EMHelper::WinnieThePooh($name, $this->behaviors()))
			$this->{$name} = $value;
		else
			parent::__set($name, $value);
	}


	/**
	 * behaviors
	 *
	 * @return array
	 */
	public function behaviors()
	{
		return array(
			'EasyMultiLanguage'=>array(
				'class' => 'ext.EasyMultiLanguage.EasyMultiLanguageBehavior',
				// @todo Please change those attributes that should be translated.
				'translated_attributes' => array('title','summary','body'),
				'admin_routes' => array('news/manage/admin', 'news/manage/update', 'news/manage/create', 'news/manage/delete'),
				//
				'languages' => Yii::app()->params['languages'],
				'default_language' => Yii::app()->params['default_language'],
				'translations_table' => 'ym_translations',
			),
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
			array('title, body, category_id', 'required'),
			array('title, seen', 'length', 'max'=>255),
			array('summary', 'length', 'max'=>2000),
			array('title','filter','filter' => 'strip_tags'),
			array('summary, body','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('image', 'length', 'max'=>200),
			array('status', 'length', 'max'=>7),
			array('category_id, order', 'length', 'max'=>10),
			array('create_date, publish_date, formTags', 'safe'),
			array('create_date', 'default' , 'value' => time()),
			array('seen', 'default' , 'value' => 0),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, summary, body, image, seen, create_date, publish_date, status, category_id, order', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'NewsCategories', 'category_id'),
			'tagsRel' => array(self::HAS_MANY, 'NewsTagRel', 'news_id'),
			'tags' => array(self::MANY_MANY, 'Tags', '{{news_tag_rel}}(news_id,tag_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه خبر',
			'title' => 'عنوان خبر',
			'title_en' => 'عنوان انگلیسی',
			'summary' => 'خلاصه',
			'body' => 'متن خبر',
			'image' => 'تصویر',
			'seen' => 'بازدید',
			'create_date' => 'تاریخ ثبت',
			'publish_date' => 'تاریخ انتشار',
			'status' => 'وضعیت',
			'category_id' => 'دسته بندی',
			'order' => 'ترتیب',
			'formTags' => 'برچسب ها'
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
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('seen',$this->seen,true);
		$criteria->compare('publish_date',$this->publish_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('order',$this->order,true);
//		$criteria->order = 't.order';
		$criteria->order = 'create_date DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	protected function afterSave()
	{
		if($this->formTags && !empty($this->formTags)) {
			if(!$this->IsNewRecord)
				NewsTagRel::model()->deleteAll('news_id='.$this->id);
			foreach($this->formTags as $tag) {
				$tagModel = Tags::model()->findByAttributes(array('title' => $tag));
				if($tagModel) {
					$tag_rel = new NewsTagRel();
					$tag_rel->news_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				} else {
					$tagModel = new Tags;
					$tagModel->title = $tag;
					$tagModel->save(false);
					$tag_rel = new NewsTagRel();
					$tag_rel->news_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				}
			}
		}
		parent::afterSave();
	}

	public function getKeywords()
	{
		$tags = CHtml::listData($this->tags,'title','title');
		return implode(',',$tags);
	}

	public function getStatusLabel(){
		return $this->statusLabels[$this->status];
	}

	/**
	 * get Valid New to show
	 * @return CDbCriteria
	 */
	public static function getValidNews(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status = "publish"');
		$criteria->order = 't.publish_date DESC';
		return $criteria;
	}
}
