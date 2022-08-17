<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'coj-testimony-form',
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
            <?php echo $form->labelEx($model,'name_company_es'); ?>
            <?php echo $form->textField($model, 'name_company_es', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'name_company_es'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'testi_es'); ?>
            <?php echo $form->textField($model, 'testi_es', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'testi_es'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'name_person_es'); ?>
            <?php echo $form->textField($model, 'name_person_es', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'name_person_es'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'charge_person_es'); ?>
            <?php echo $form->textField($model, 'charge_person_es', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'charge_person_es'); ?>
            </div>
        </div>
        <hr/>
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
            <?php echo $form->labelEx($model,'name_company_en'); ?>
            <?php echo $form->textField($model, 'name_company_en', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'name_company_en'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'testi_en'); ?>
            <?php echo $form->textField($model, 'testi_en', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'testi_en'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'name_person_en'); ?>
            <?php echo $form->textField($model, 'name_person_en', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'name_person_en'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'charge_person_en'); ?>
            <?php echo $form->textField($model, 'charge_person_en', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'charge_person_en'); ?>
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