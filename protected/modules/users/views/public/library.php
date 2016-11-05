<?php
/* @var $this PublicController */
/* @var $user Users */
/* @var $boughtBooks array */
?>

<div class="transform-form">
    <h3>دانلود شده ها</h3>
    <p class="description">کتاب هایی که دانلود کرده اید.</p>

    <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-nav="1" data-dots="1">
        <?php $this->widget('zii.widgets.CListView',array(
            'id' => 'downloaded-list',
            'dataProvider' => new CArrayDataProvider($boughtBooks),
            'itemView' => '//site/_book_item',
            'template' => '{items}',
            'viewData' => array('itemClass' => 'simple', 'buy'=>false)
        ));?>
    </div>
</div>
<div class="transparent-form">
    <h3>نشان شده ها</h3>
    <p class="description">کتاب هایی که نشان کرده اید.</p>

    <div class="is-carousel auto-width" data-item-selector="thumbnail-container" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-nav="1" data-dots="1">
        <?php $this->widget('zii.widgets.CListView',array(
            'id' => 'bookmarked-list',
            'dataProvider' => new CArrayDataProvider($user->bookmarkedBooks),
            'itemView' => '//site/_book_item',
            'template' => '{items}',
            'viewData' => array('itemClass' => 'simple', 'buy'=>false)
        )); ?>
    </div>
</div>