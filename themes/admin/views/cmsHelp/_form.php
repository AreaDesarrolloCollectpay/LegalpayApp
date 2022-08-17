<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cms-help-form',
	'enableAjaxValidation' => false,
        'htmlOptions' => array('class'=>'well well-sm', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

	<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-danger')); ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'titulo'); ?>
            <?php echo $form->textField($model, 'titulo', array('maxlength' => 255, 'class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'titulo'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'contenido'); ?>
            <?php 
                $this->widget('ext.tinymce.TinyMce', array(
                    'model' => $model,
                    'attribute' => 'contenido',
                    // Optional config
                    'compressorRoute' => 'elfinder/compressor',
                    'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
                    'fileManager' => array(
                        'class' => 'ext.elFinder.TinyMceElFinder',
                        'popupConnectorRoute'=>'elfinder/elfinderTinyMce',
                        'popupTitle' => $model->getAttributeLabel('contenido'),
                    ),
                    'htmlOptions' => array(
                        'rows' => 6,
                        'cols' => 50,
                        'style'=> 'width:100%; height:350px;',
                    ),
                )); 
            ?>
            <?php echo $form->error($model,'contenido'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'link'); ?>
            <?php echo $form->textArea($model, 'link', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'link'); ?>
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