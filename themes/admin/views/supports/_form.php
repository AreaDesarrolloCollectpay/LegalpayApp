<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'supports-form',
	'enableAjaxValidation' => true,    
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'class'=>'well well-sm', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

	<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-danger')); ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idWallet'); ?>
            <?php echo $form->dropDownList($model, 'idWallet', GxHtml::listDataEx(Wallets::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idWallet'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'fileName'); ?>
            <?php echo $form->textField($model, 'fileName', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'fileName'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'fileType'); ?>
            <?php echo $form->textField($model, 'fileType', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'fileType'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'dFile'); ?>
            <?php echo $form->textField($model, 'dFile', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'dFile'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'dCreation'); ?>
            <?php echo $form->textField($model, 'dCreation', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'dCreation'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'file'); ?>
            <?php echo $form->textField($model, 'file', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'file'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?php echo $form->labelEx($model,'fileP'); ?>
                <?php echo $form->fileField($model, 'fileP', array('class'=>'form-control input-block-level')); ?>
                <?php echo $form->error($model,'fileP'); ?>
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