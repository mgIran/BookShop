<?php
/* @var $form CActiveForm */
/* @var $model ShopAddresses */

$model=new ShopAddresses();
?>
<div id="add-address-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="close-icon"></i></button>
                <h4 class="modal-title">افزودن آدرس جدید</small></h4>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('//partial-views/_loading')?>
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'address-form',
                    'enableAjaxValidation'=>false,
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        'afterValidate' => 'js:function(form ,data ,hasError){
                            if(!hasError)
                            {
                                var form = $("#address-form");
                                var loading = $(".modal .loading-container");
                                var url = \''.Yii::app()->createUrl('/shop/addresses/add').'\';
                                submitAjaxForm(form ,url ,loading ,"console.log(html); if(html.status){ if(typeof html.url !== \'undefined\') window.location = html.url; else location.reload(); }else $(\'#UserLoginForm_authenticate_field\').html(html.errors);");
                            }
                        }'
                    )
                ));
                echo CHtml::hiddenField('ajax','address-form');
                ?>
                <div class="form-group"><p id="UserLoginForm_authenticate_field_em_" class="text-center"></p></div>
                <div class="form-group">
                    <?php echo $form->textField($model,'transferee' ,array(
                        'placeholder' => $model->getAttributeLabel("transferee"),
                        'class' => 'text-field'
                    ));
                    echo $form->error($model,'transferee'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model,'postal_address' ,array(
                        'placeholder' => $model->getAttributeLabel("postal_address"),
                        'class' => 'text-field'
                    ));
                    echo $form->error($model,'postal_address'); ?>
                    ?>
                </div>
                <div class="form-group">
                    <?= CHtml::submitButton('ورود',array('class'=>"btn-blue")); ?>
                </div>
                <? $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>