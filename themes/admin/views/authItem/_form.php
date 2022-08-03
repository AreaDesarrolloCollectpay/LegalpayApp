<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'auth-item-form',
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
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model, 'name', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'name'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'type'); ?>
            <?php echo $form->textField($model, 'type', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'type'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textField($model, 'description', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'description'); ?>
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
        </div>
		<label><?php echo GxHtml::encode($model->getRelationLabel('authAssignments')); ?></label>
		<?php echo $form->checkBoxList($model, 'authAssignments', GxHtml::encodeEx(GxHtml::listDataEx(AuthAssignment::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('authItemChildren')); ?></label>
		<?php echo $form->checkBoxList($model, 'authItemChildren', GxHtml::encodeEx(GxHtml::listDataEx(AuthItemChild::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('authItemChildren1')); ?></label>
		<?php echo $form->checkBoxList($model, 'authItemChildren1', GxHtml::encodeEx(GxHtml::listDataEx(AuthItemChild::model()->findAllAttributes(null, true)), false, true)); ?>
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->