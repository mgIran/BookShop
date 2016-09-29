<?php

/**
 * This is the model class for table "ym_book_categories".
 *
 * The followings are the available columns in table 'ym_book_categories':
 * @property string $id
 * @property string $title
 * @property string $parent_id
 * @property string $path
 *
 *
 * The followings are the available model relations:
 * @property BookCategories $parent
 * @property BookCategories[] $bookCategories
 * @property Books[] $books
 */
class BookCategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_book_categories';
	}

	/**
	 * public Filter Variables for search
	 * @property string $parentFilter
	 */
	public $parentFilter;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>50),
			array('parent_id', 'length', 'max'=>10),
            array('path', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, parent_id, parentFilter', 'safe', 'on'=>'search'),
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
			'parent' => array(self::BELONGS_TO, 'BookCategories', 'parent_id'),
			'bookCategories' => array(self::HAS_MANY, 'BookCategories', 'parent_id'),
			'books' => array(self::HAS_MANY, 'Books', 'category_id'),
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
			'parent_id' => 'والد',
            'path' => 'مسیر'
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
		$criteria->condition = 't.parent_id IS NOT NULL';
		$criteria->addSearchCondition('parent.title',$this->parentFilter);
		$criteria->with = array('parent');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' =>array(
				'pageSize' => 100
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookCategories the static model class
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

    public function adminSortList()
    {
        $parents = $this->findAll( 'parent_id IS NULL order by title' );
        $list = array();
        foreach ( $parents as $parent ) {
            array_push( $list, $parent );
            $childes = $this->getCategoryChildes($parent->id, true, 'criteria');
            foreach ( $childes as $childe ) {
                array_push( $list, $childe );
            }
        }
        return CMap::mergeArray( array( '' => '-' ), CHtml::listData( $list, 'id', 'fullTitle' ) );
    }

    public function getParents( $id = NULL )
    {
        if ( $id )
            $parents = $this->findAll( 'parent_id = :id order by title', array( ':id' => $id ) );
        else
            $parents = $this->findAll( 'parent_id IS NULL order by title' );
        $list = array();
        foreach ( $parents as $parent ) {
            array_push( $list, $parent );
        }
        return CHtml::listData( $list, 'id', 'fullTitle' );
    }

    public function getFullTitle()
    {
        $fullTitle = $this->title;
        $model = $this;
        while ( $model->parent ) {
            $model = $model->parent;
            if($model->parent)
				$fullTitle = $model->title . ' - ' . $fullTitle;
			else
				$fullTitle = $fullTitle . ' ('.$model->title.')';
        }
        return $fullTitle;
    }

	public function beforeSave()
	{
		if($this->parent_id)
		{
			$parent = $this->findByPk($this->parent_id);
			$this->path = $parent->path?$parent->path.$this->parent_id.'-':$this->parent_id.'-';
		}else
			$this->path = null;
		return parent::beforeSave(); // TODO: Change the autogenerated stub
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
}
