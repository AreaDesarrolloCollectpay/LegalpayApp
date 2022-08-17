<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'effects-form',
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
            <?php echo $form->labelEx($model,'effectName'); ?>
            <?php echo $form->textField($model, 'effectName', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'effectName'); ?>
            </div>
        </div>
		<label><?php echo GxHtml::encode($model->getRelationLabel('actions')); ?></label>
		<?php echo $form->checkBoxList($model, 'actions', GxHtml::encodeEx(GxHtml::listDataEx(Action::model()->findAllAttributes(null, true)), false, true)); ?>
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->