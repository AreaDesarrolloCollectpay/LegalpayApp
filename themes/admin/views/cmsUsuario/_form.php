<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cms-usuario-form',
	'enableAjaxValidation' => false,
        'htmlOptions' => array('class'=>'well well-sm', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

	<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-danger')); ?>
        <?php if($model->isNewRecord): ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo Yii::t('app', 'Contraseña opcional'); ?>!</strong><br/><?php echo Yii::t('app', 'Si desea que el sistema genere una contraseña automática, por favor deje en blanco el campo, contraseña y confirmar contraseña'); ?>.<br/><i><?php echo Yii::t('app', 'Nota: se le enviara la contraseña al correo ingresado'); ?>.</i>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'usuario'); ?>
            <?php echo $form->textField($model, 'usuario', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'usuario'); ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
            <?php echo $form->labelEx($model,'contrasena'); ?>
            <?php echo $form->passwordField($model, 'contrasena', array('maxlength' => 100, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'contrasena'); ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
            <?php echo $form->labelEx($model,'contrasena_confirm'); ?>
            <?php echo $form->passwordField($model, 'contrasena_confirm', array('maxlength' => 100, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'contrasena_confirm'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'nombres'); ?>
            <?php echo $form->textField($model, 'nombres', array('maxlength' => 50, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'nombres'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'apellidos'); ?>
            <?php echo $form->textField($model, 'apellidos', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'apellidos'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->emailField($model, 'email', array('maxlength' => 50, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'email'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'empresa'); ?>
            <?php echo $form->textField($model, 'empresa', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'empresa'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'telefono'); ?>
            <?php echo $form->textField($model, 'telefono', array('maxlength' => 150, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'telefono'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'descripcion'); ?>
            <?php echo $form->textArea($model, 'descripcion', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'descripcion'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'ciudad'); ?>
            <?php echo $form->textField($model, 'ciudad', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'ciudad'); ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
            <?php echo $form->labelEx($model,'cms_rol_id'); ?>
            <?php echo $form->dropDownList($model, 'cms_rol_id', GxHtml::listDataEx(CmsRol::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'cms_rol_id'); ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
            <?php echo $form->labelEx($model,'activo'); ?>
            <?php $this->widget('booster.widgets.TbSwitch', array(
                                'model' => $model,
                                'attribute' => 'activo',
                                'options' => array(
                                    'onText'=>Yii::t('app', 'Si'),
                                    'offText'=>Yii::t('app', 'No'),
                                    'size' => 'normal', //null, 'mini', 'small', 'normal', 'large
                                    'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                    'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                ),
                            )); ?>
            <?php echo $form->error($model,'activo'); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->