<?php
/* @var $this PublishersBooksController */
/* @var $dataProvider CActiveDataProvider */
/* @var $form CActiveForm */
?>

<div class="white-form">
    <h3>افزودن کتاب جدید</h3>
    <p class="description">جهت ثبت کتاب لطفا عنوان کتاب را جستجو کنید.</p>

    <div class="alert alert-success save-package-message hidden"></div>

    <div class="container-fluid">
        <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'search-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit' => true
            )
        ));
        ?>
            <div class="row">

                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php echo CHtml::textField('search', isset($_POST['search']) ? $_POST['search'] : '', ['placeholder'=>'عنوان کتاب را وارد کنید...','class'=>'form-control'])?>
                </div>

            </div>

            <div class="buttons">
                <?php echo CHtml::submitButton('جستجو',array('class'=>'btn btn-default')); ?>
            </div>

        <?php $this->endWidget(); ?>

        <?php if($dataProvider):?>
            <div class="buttons overflow-hidden">
                <a class="btn btn-success pull-left" href="<?php echo $this->createUrl('/sellers/books/create');?>">افزودن کتاب جدید</a>
            </div>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'books-list',
                'dataProvider' => $dataProvider,
                'template' => '{pager} {items} {pager}',
                'ajaxUpdate' => true,
                'afterAjaxUpdate' => "function(id, data){
                    $('html, body').animate({
                        scrollTop: ($('#'+id).offset().top-130)
                    },1000);
                }",
                'pager' => array(
                    'header' => '',
                    'firstPageLabel' => '<<',
                    'lastPageLabel' => '>>',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'cssFile' => false,
                    'htmlOptions' => array(
                        'class' => 'pagination pagination-sm',
                    ),
                ),
                'pagerCssClass' => 'blank',
                'itemsCssClass' => 'table',
                'columns' => array(
                    'id',
                    array(
                        'name' => 'title',
                        'value' => function($data){
                            return CHtml::link($data->title, array('/book/'.$data->id.'/'.urlencode($data->title)), ['target' => '_blank']);
                        },
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'status',
                        'value' => function($data){
                            return $data->statusLabels[$data->status];
                        },
                        'type' => 'raw',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'header'=>$this->getPageSizeDropDownTag(),
                        'template' =>'{update}',
                        'buttons'=>array(
                            'update'=>array(
                                'label'=>'',
                                'url'=>'Yii::app()->createUrl("/sellers/books/update", array("id"=>$data->id))',
                                'imageUrl'=>false,
                                'options'=>array('class'=>'icon-pencil text-info')
                            ),
                        ),
                    )
                )
            ));?>
        <?php endif;?>

        </div><!-- form -->
    </div>
</div>