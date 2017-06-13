<?php
class ApiController extends ApiBaseController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            //'RestAccessControl'
        );
    }

    /**
     * Get books in a row
     */
    public function actionRow()
    {
        $request = $this->getRequest();

        if (isset($request['name'])) {
            $limit = 10;
            if (isset($request['limit']))
                $limit = $request['limit'];

            Yii::import('rows.models.*');
            Yii::import('users.models.*');
            $row = RowsHomepage::model()->findByAttributes(array('query' => $request['name']));
            $books = [];
            /* @var Books[] $books */
            if ($row && $row->status == 1)
                $books = Books::model()->findAll($row->getConstCriteria(Books::model()->getValidBooks(null, 'id DESC', $limit)));

            $list=[];
            foreach($books as $book)
                $list[]=[
                    'id'=>$book->id,
                    'title'=>$book->title,
                    'icon'=>$book->icon,
                    'publisher_name'=>$book->publisher_id?$book->publisher->userDetails->getPublisherName():$book->publisher_name,
                    'author'=>($person=$book->getPerson('نویسنده'))?$person[0]->name_family:null,
                    'rate'=>$book->rate,
                    'price'=>$book->price,
                    'hasDiscount'=>$book->hasDiscount(),
                    'offPrice'=>$book->hasDiscount()?$book->offPrice:0,
                ];

            if ($list)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'list' => $list]), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
        }
    }

    public function actionSearch()
    {
        $request = $this->getRequest();

        if (isset($request['query'])) {
            $limit = 10;
            if (isset($request['limit']))
                $limit = $request['limit'];

            Yii::import('users.models.*');

            $criteria = new CDbCriteria();

            $criteria->with = ['publisher', 'publisher.userDetails', 'persons', 'category'];

            $criteria->addCondition('t.status=:status AND t.confirm=:confirm AND t.deleted=:deleted AND (SELECT COUNT(book_packages.id) FROM ym_book_packages book_packages WHERE book_packages.book_id=t.id) != 0');
            $criteria->params[':status'] = 'enable';
            $criteria->params[':confirm'] = 'accepted';
            $criteria->params[':deleted'] = 0;
            $criteria->order = 't.confirm_date DESC';

            if (!empty($term = $request['query'])) {
                $terms = explode(' ', $term);
                $condition = '
                    ((t.title regexp :term) OR
                    (userDetails.fa_name regexp :term OR userDetails.nickname regexp :term) OR
                    (persons.name_family regexp :term) OR
                    (category.title regexp :term))';
                $criteria->params[":term"] = $term;

                foreach ($terms as $key => $term)
                    if ($term) {
                        if ($condition)
                            $condition .= " OR (";
                        $condition .= "
                            (t.title regexp :term$key) OR
                            (userDetails.fa_name regexp :term$key OR userDetails.nickname regexp :term$key) OR
                            (persons.name_family regexp :term$key) OR
                            (category.title regexp :term$key))";
                        $criteria->params[":term$key"] = $term;
                    }
                $criteria->together = true;

                $criteria->addCondition($condition);
            }
            $criteria->limit = $limit;

            /* @var Books[] $books */
            $books = Books::model()->findAll($criteria);

            $result=[];
            foreach($books as $book)
                $result[]=[
                    'id'=>$book->id,
                    'title'=>$book->title,
                    'icon'=>$book->icon,
                    'publisher_name'=>$book->publisher_id?$book->publisher->userDetails->getPublisherName():$book->publisher_name,
                    'author'=>($person=$book->getPerson('نویسنده'))?$person[0]->name_family:null,
                    'rate'=>$book->rate,
                    'price'=>$book->price,
                    'hasDiscount'=>$book->hasDiscount(),
                    'offPrice'=>$book->hasDiscount()?$book->offPrice:0,
                ];

            $this->_sendResponse(200, CJSON::encode(['status' => true, 'result' => $result]), 'application/json');
        }
    }

    /**
     * Get a specific model
     */
    public function actionFind()
    {
        $request = $this->getRequest();

        if (isset($request['entity']) && $entity = $request['entity']) {
            $criteria = new CDbCriteria();

            switch (trim($entity)) {
                case 'Book':
                    $criteria->addCondition('id = :id');
                    $criteria->params[':id']=$request['id'];
                    $criteria->together=true;
                    /* @var Books $record */
                    $record = Books::model()->find($criteria);

                    if(!$record)
                        $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');

                    Yii::import('users.models.*');
                    Yii::import('comments.models.*');

                    // Get comments
                    $criteria = new CDbCriteria;
                    $criteria->compare('owner_name', 'Books');
                    $criteria->compare('owner_id', $record->id);
                    $criteria->compare('t.status', Comment::STATUS_APPROWED);
                    $criteria->order = 'parent_comment_id, create_time ';
                    $criteria->order .= 'DESC';
                    $criteria->with = 'user';
                    /* @var Comment[] $commentsList */
                    $commentsList = Comment::model()->findAll($criteria);

                    $comments=[];
                    foreach($commentsList as $comment)
                        $comments[]=[
                            'id'=>$comment->comment_id,
                            'text'=>$comment->comment_text,
                            'username'=>$comment->userName,
                            'rate'=>$comment->userRate?$comment->userRate:false,
                            'createTime'=>$comment->create_time,
                        ];

                    // Get similar books
                    $criteria = Books::model()->getValidBooks(array($record->category_id));
                    $criteria->addCondition('id!=:id');
                    $criteria->params[':id'] = $record->id;
                    $criteria->limit = 10;
                    /* @var Books[] $similarBooks */
                    $similarBooks = Books::model()->findAll($criteria);

                    $similar=[];
                    foreach($similarBooks as $book)
                        $similar[]=[
                            'id'=>$book->id,
                            'title'=>$book->title,
                            'icon'=>$book->icon,
                            'publisher_name'=>$book->publisher_id?$book->publisher->userDetails->getPublisherName():$book->publisher_name,
                            'author'=>($person=$book->getPerson('نویسنده'))?$person[0]->name_family:null,
                            'rate'=>$book->rate,
                            'price'=>$book->price,
                            'hasDiscount'=>$book->hasDiscount(),
                            'offPrice'=>$book->hasDiscount()?$book->offPrice:0,
                        ];

                    $book=[
                        'id'=>$record->id,
                        'title'=>$record->title,
                        'icon'=>$record->icon,
                        'publisher_name'=>$record->publisher_id?$record->publisher->userDetails->getPublisherName():$record->publisher_name,
                        'author'=>($person=$record->getPerson('نویسنده'))?$person[0]->name_family:null,
                        'rate'=>$record->rate,
                        'price'=>$record->price,
                        'hasDiscount'=>$record->hasDiscount(),
                        'offPrice'=>$record->hasDiscount()?$record->offPrice:0,
                        'preview_file'=>$record->preview_file,
                        'category_id'=>$record->category_id,
                        'description'=>$record->description,
                        'seen'=>$record->seen,
                        'comments'=>$comments,
                        'similar'=>$similar,
                    ];
                    break;
                default:
                    $book = null;
                    break;
            }

            if ($book)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'book' => $book]), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
        }
    }

    /**
     * Get list of models
     */
    public function actionList()
    {
        $request = $this->getRequest();

        if (isset($request['entity']) && $entity = $request['entity']) {
            $criteria = new CDbCriteria();

            // set LIMIT and OFFSET in Query
            if (isset($request['limit']) && !empty($request['limit']) && $limit = (int)$request['limit']) {
                $criteria->limit = $limit;
                if (isset($request['offset']) && !empty($request['offset']) && $offset = (int)$request['offset'])
                    $criteria->offset = $offset;
            }

            // Execute query on model
            switch (trim($entity)) {
                case 'Category':
                    /* @var BookCategories[] $categories */
                    $categories = BookCategories::model()->findAll($criteria);

                    $list=[];
                    foreach($categories as $category)
                        $list[] = [
                            'id' => $category->id,
                            'title' => $category->title,
                            'parent_id' => $category->parent_id,
                            'path' => $category->path
                        ];
                    break;
                default:
                    $list = array();
                    break;
            }

            if ($list)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'list' => $list]), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
        }
    }
}