<?php
/* @var $this PublicController */
/* @var $bookmarked[] UserBookBookmark */
/* @var $book Books */
?>

<div class="transparent-form">
    <h3>نشان شده ها</h3>
    <p class="description">لیست کتاب هایی که نشان کرده اید.</p>

    <table class="table">
        <thead>
        <tr>
            <th>عنوان</th>
            <th>نویسنده</th>
            <th>ناشر</th>
            <th>موضوع</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($bookmarked)):?>
            <tr>
                <td colspan="4" class="text-center">نتیجه ای یافت نشد.</td>
            </tr>
        <?php else:?>
            <?php foreach($bookmarked as $book):$author=$book->getPersonsTags('نویسنده', 'fullName', true, 'a');?>
                <tr>
                    <td><a href="<?php echo $this->createUrl('/book/'.$book->id.'/'.urlencode($book->title));?>"><?php echo CHtml::encode($book->title);?></a></td>
                    <td><?php echo ($author=='')?'-':$author;?></td>
                    <td><a href="<?php echo $this->createUrl('/book/publisher?title='.($book->publisher?urlencode($book->publisher->userDetails->publisher_id).'&id='.$book->publisher_id:urlencode($book->publisher_name).'&t=1'));?>"><?php echo CHtml::encode((is_null($book->publisher_id)?$book->publisher_name:$book->publisher->userDetails->fa_name));?></a></td>
                    <td><a href="<?= $this->createUrl('/category/'.$book->category_id.'/'.urldecode($book->category->title)) ?>"><?php echo CHtml::encode($book->category->title);?></a></td>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>
</div>