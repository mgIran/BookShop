<div id="login-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="close-icon"></i></button>
                <h4 class="modal-title">ورود به پنل کاربری</small></h4>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('//partial-views/_loading')?>
                <?php
                /* @var $formL CActiveForm */
                Yii::import('users.models.UserLoginForm');
                $loginModel = new UserLoginForm();
                $formL=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableAjaxValidation'=>false,
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        'afterValidate' => 'js:function(form ,data ,hasError){
                                if(!hasError)
                                {
                                    var form = $("#login-form");
                                    var loading = $(".modal .loading-container");
                                    var url = \''.Yii::app()->createUrl('/login').'\';
                                    submitAjaxForm(form ,url ,loading ,"console.log(html); if(html.status){ if(typeof html.url !== \'undefined\') window.location = html.url; else location.reload(); }else $(\'#UserLoginForm_authenticate_field\').html(html.errors);");
                                }
                            }'
                    )
                ));
                echo CHtml::hiddenField('ajax','login-form'); ?>
                <div class="form-group"><p id="UserLoginForm_authenticate_field_em_" class="text-center" ></p></div>
                    <div class="form-group">
                        <?php echo $formL->emailField($loginModel,'email' ,array(
                            'placeholder' => 'پست الکترونیکی',
                            'class' => 'text-field ltr text-right'
                        ));
                        echo $formL->error($loginModel,'email'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $formL->passwordField($loginModel,'password',array(
                            'placeholder' => 'کلمه عبور',
                            'class' => 'text-field password'
                        ));
                        echo $formL->error($loginModel,'password');
                        ?>
                    </div>
                    <div class="form-group">
                        <?= $formL->checkBox($loginModel,'rememberMe',array('id'=>'remember-me')); ?>
                        <?= CHtml::label('مرا به خاطر بسپار','remember-me') ?>
                        <div class="pull-left"><?php echo CHtml::link('کلمه عبور خود را فراموش کرده اید؟',
                                $this->createUrl('/users/public/forgetPassword')) ?></div>
                    </div>
                    <div class="form-group">
                        <?= CHtml::submitButton('ورود',array('class'=>"btn-blue")); ?>
                    </div>
                    <div class="divider"></div>
                    <p class="text-center">می توانید با حساب کاربری گوگل وارد شوید...</p>
                    <button class="btn-red"><i class="google-icon"></i>ورود با گوگل</button>
                <? $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>