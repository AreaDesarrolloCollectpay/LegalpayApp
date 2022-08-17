<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'auth-assignment-form',
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
            <?php echo $form->labelEx($model,'userid'); ?>
            <?php echo $form->textField($model, 'userid', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'userid'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'bizrule'); ?>
            <?php echo $form->textField($model, 'bizrule', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'bizrule'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'data'); ?>
            <?php echo $form->textField($model, 'data', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'data'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'itemname'); ?>
            <?php echo $form->dropDownList($model, 'itemname', GxHtml::listDataEx(AuthItem::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'itemname'); ?>
            </div>
        </div>
        <hr/>
		<label><?php echo GxHtml::encode($model->getRelationLabel('advisers')); ?></label>
		<?php echo $form->checkBoxList($model, 'advisers', GxHtml::encodeEx(GxHtml::listDataEx(Advisers::model()->findAllAttributes(null, true)), false, true)); ?>
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->