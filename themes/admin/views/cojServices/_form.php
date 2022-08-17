<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'coj-services-form',
	'enableAjaxValidation' => true,
        'htmlOptions' => array('class'=>'well well-sm', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

	<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-danger')); ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'img_es'); ?>
            <?php
                $this->widget('ext.elFinder.ServerFileInput', array(
                    'model' => $model,
                    'attribute' => 'img_es',
                    'popupConnectorRoute' => 'elfinder/elfinderFileInput', // relative route for file input action
                    'popupTitle' => 'Files',
                ));
            ?>
            <?php echo $form->error($model,'img_es'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'title_es'); ?>
            <?php echo $form->textField($model, 'title_es', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'title_es'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'subtitle_es'); ?>
            <?php echo $form->textField($model, 'subtitle_es', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'subtitle_es'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'des_es'); ?>
            <?php echo $form->textArea($model, 'des_es', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'des_es'); ?>
            </div>        
        </div>
        <hr> 
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'img_en'); ?>
            <?php
                $this->widget('ext.elFinder.ServerFileInput', array(
                    'model' => $model,
                    'attribute' => 'img_en',
                    'popupConnectorRoute' => 'elfinder/elfinderFileInput', // relative route for file input action
                    'popupTitle' => 'Files',
                ));
            ?>
            <?php echo $form->error($model,'img_en'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'title_en'); ?>
            <?php echo $form->textField($model, 'title_en', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'title_en'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'subtitle_en'); ?>
            <?php echo $form->textField($model, 'subtitle_en', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'subtitle_en'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'des_en'); ?>
            <?php echo $form->textArea($model, 'des_en', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'des_en'); ?>
            </div>
        </div>
        <hr/>
            <div class="row buttons text-center">
             <?php
                echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
            ?>
            </div>
        </div>
        
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->