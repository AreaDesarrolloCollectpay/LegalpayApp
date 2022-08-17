<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'coj-message-form',
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
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model, 'name', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'name'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model, 'email', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'email'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'affair'); ?>
            <?php echo $form->textField($model, 'affair', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'affair'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'mess'); ?>
            <?php echo $form->textField($model, 'mess', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'mess'); ?>
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
            <?php echo $form->labelEx($model,'dUpdate'); ?>
            <?php echo $form->textField($model, 'dUpdate', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'dUpdate'); ?>
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