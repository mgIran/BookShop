<?php

/**
 * This is the model class for table "{{news_categories}}".
 *
 * The followings are the available columns in table '{{news_categories}}':
 * @property string $id
 * @property string $title
 * @property string $parent_id
 * @property string $path
 *
 * The followings are the available model relations:
 * @property News[] $news
 * @property NewsCategories $parent
 * @property NewsCategories[] $childes
 */
class NewsCategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news_categories}}';
	}

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
				'translated_attributes' => array('title'),
				'admin_routes' => array('news/category/admin', 'news/category/update', 'news/category/delete', 'news/category/create'),
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
			array('title', 'required'),
			array('title','unique'),
			array('title' ,'compareWithParent'),
			array('title','filter','filter' => 'strip_tags'),
			array('title, path', 'length', 'max'=>255),
			array('parent_id', 'length', 'max'=>10),
			array('parent_id', 'checkParent'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, parent_id, path', 'safe', 'on'=>'search'),
		);
	}

	public function compareWithParent($attribute ,$params)
	{
		if(!empty($this->title) && $this->parent_id){
			$record = NewsCategories::model()->findByAttributes(array('id' => $this->parent_id ,'title' => $this->title ));
			if($record)
				$this->addError($attribute ,'عنوان دسته بندی با عنوان والد یکسان است.');
		}
	}

	public function checkParent($attribute ,$params)
	{
		if(!empty($this->parent_id) && $this->id){
			if($this->parent_id == $this->id)
				$this->addError($attribute ,'دسته بندی نمی تواند زیرمجموعه خودش باشد.');
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
			'news' => array(self::HAS_MANY, 'News', 'category_id'),
			'parent' => array(self::BELONGS_TO, 'NewsCategories', 'parent_id'),
			'childes' => array(self::HAS_MANY, 'NewsCategories', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'title_en' => 'عنوان انگلیسی',
			'parent_id' => 'والد',
			'path' => 'مسیر',
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
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewsCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function sortList()
	{
		$parents = $this->findAll( 'parent_id IS NULL order by title' );
		$list = array();
		foreach ( $parents as $parent ) {
			$childes = $this->findAll($this->getCategoryChildes($parent->id ,false, 'criteria'));
			foreach ( $childes as $child ) {
				array_push( $list, $child );
			}
		}
		return CHtml::listData( $list, 'id', 'fullTitle' );
	}

	public function adminSortList($excludeId = NULL)
	{
		$parents = $this->findAll('parent_id IS NULL order by title');
		$list = array();
		foreach ($parents as $parent) {
			if ($parent->id != $excludeId) {
				array_push($list, $parent);
				$childes = $this->findAll($this->getCategoryChildes($parent->id, false, 'criteria'));
				foreach ($childes as $child) {
					if ($child->id != $excludeId && $child->parent_id != $excludeId)
						array_push($list, $child);
				}
			}
		}
		return CHtml::listData($list, 'id', 'fullTitle');
	}

	public function getParents( $id = NULL ,$title = 'fullTitle')
	{
		if ($id)
			$parents = $this->findAll('parent_id = :id order by title', array(':id' => $id));
		else
			$parents = $this->findAll('parent_id IS NULL order by title');
		$list = array();
		foreach ($parents as $parent) {
			array_push($list, $parent);
		}
		return CHtml::listData($list, 'id', $title);
	}

	public function getFullTitle()
	{
		$fullTitle = $this->title;
		$model = $this;
		while ( $model->parent ) {
			$model = $model->parent;
			if($model)
				$fullTitle = $model->title . ' / ' . $fullTitle;
		}
		return $fullTitle;
	}

	public function beforeSave()
	{
		if (empty($this->parent_id))
			$this->parent_id = NULL;
		$this->path = null;
		return parent::beforeSave(); // TODO: Change the autogenerated stub
	}

	protected function afterSave()
	{
		$this->updatePath($this->id);
		parent::afterSave();
	}

	public function getCategoryChildes($id = null, $withSelf = true, $returnType='array'){
		if($id)
			$this->id = $id;
		$criteria = new CDbCriteria();
		$criteria->addCondition('path LIKE :regex1','OR');
		$criteria->addCondition('path LIKE :regex2','OR');
		$criteria->params[':regex1'] = $this->id.'-%';
		$criteria->params[':regex2'] = '%-'.$this->id.'-%';
		if($withSelf) {
			$criteria->addCondition('id  = :id', 'OR');
			$criteria->params[':id'] = $this->id;
		}
		if($returnType==='array')
			return CHtml::listData($this->findAll($criteria),'id','id');
		elseif($returnType==='criteria')
			return $criteria;
	}

	private function updatePath($id)
	{
		/* @var $model NewsCategories */
		$model = NewsCategories::model()->findByPk($id);
		if ($model->parent) {
			$path = $model->parent->path ? $model->parent->path . $model->parent_id . '-' : $model->parent_id . '-';
			NewsCategories::model()->updateByPk($model->id,array('path' => $path));
		}
		foreach ($model->childes as $child)
			$this->updatePath($child->id);
	}


	public static function getHtmlSortList($categoryID=null,$activeID=Null)
	{
		foreach (NewsCategories::model()->getParents($categoryID,'title') as $id => $title){
			echo '<li class="'.($activeID == $id?'active':'').'" ><a href="'.Yii::app()->createUrl('/news/category/'.$id.'/'.urlencode($title)).'" >'.$title.'&nbsp;&nbsp;<small>('.self::model()->countNews($id).')</small></a></li>';
			if(NewsCategories::model()->count('parent_id = :id',array(':id'=>$id))) {
				echo '<ol>';
				self::getHtmlSortList($id, $activeID);
				echo '</ol>';
			}
		}
	}

	public function countNews($id = NULL)
	{
		$criteria = News::getValidNews();
		$criteria->addInCondition('category_id',NewsCategories::model()->getCategoryChildes($id));
		return News::model()->count($criteria);
	}
}
