<?php
/* @var $this BooksController */
/* @var $dataProvider CActiveDataProvider */
/* @var $title String */
/* @var $pageTitle String */
?>

<div class="book-box">
    <div class="top-box">
        <div class="title pull-right">
            <h2>عبارت مورد نظر: <?= $_GET['term'] ?></h2>
        </div>
    </div>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'id'=>'search',
        'itemView'=>'//site/_book_item',
        'template'=>'{items}',
        'itemsCssClass'=>'book-carousel'
    ));?>
</div>