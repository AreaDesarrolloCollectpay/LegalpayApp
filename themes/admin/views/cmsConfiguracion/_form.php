<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cms-configuracion-form',
	'enableAjaxValidation' => false,
        'htmlOptions' => array('class'=>'well', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

	<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-danger')); ?>
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'empresa'); ?>
            <?php echo $form->textField($model, 'empresa', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'empresa'); ?>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'nombre_correo'); ?>
            <?php echo $form->textField($model, 'nombre_correo', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'nombre_correo'); ?>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'encryption'); ?>
            <?php echo $form->textField($model, 'encryption', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'encryption'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'host'); ?>
            <?php echo $form->textField($model, 'host', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'host'); ?>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'username'); ?>
            <?php echo $form->textField($model, 'username', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'username'); ?>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('maxlength' => 100, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'password'); ?>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'port'); ?>
            <?php echo $form->textField($model, 'port', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'port'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'apiKey'); ?>
            <?php echo $form->textField($model, 'apiKey', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'apiKey'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'plantilla'); ?>
            <small class="text-info"><?php echo Yii::t('app', 'No olvide colocar la palabra reservada'); ?> <b>__content__</b> <?php echo Yii::t('app', 'para reemplazar el contenido'); ?>.</small>
            <?php echo CHtml::link('Ver Plantilla',array('cmsConfiguracion/previsualizaPlantilla'),array('target'=>'_blank', 'class'=>'btn btn-info')); ?>    
            <?php 
                $this->widget('ext.tinymce.TinyMce', array(
                    'model' => $model,
                    'attribute' => 'plantilla',
                    // Optional config
                    'compressorRoute' => 'elfinder/compressor',
                    'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
                    'fileManager' => array(
                        'class' => 'ext.elFinder.TinyMceElFinder',
                        'popupConnectorRoute'=>'elfinder/elfinderTinyMce',
                        'popupTitle' => $model->getAttributeLabel('plantilla'),
                    ),
                    'settings' => array('relative_urls'=>false, 'remove_script_host' => false),
                    'htmlOptions' => array(
                        'rows' => 6,
                        'cols' => 50,
                        'style'=> 'width:100%; height:350px;',
                    ),
                )); 
            ?>
            <?php echo $form->error($model,'plantilla'); ?>
            </div>
        </div>
        <hr/>
        <h2><?php echo Yii::t('app', 'Accesos api restful'); ?></h2>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'user_restful'); ?>
            <?php echo $form->textField($model, 'user_restful', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'user_restful'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'password_restful'); ?>
            <?php echo $form->textField($model, 'password_restful', array('maxlength' => 100, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'password_restful'); ?>
            </div>
        </div>
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->