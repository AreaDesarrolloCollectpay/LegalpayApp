<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'demographics-form',
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
            <?php echo $form->labelEx($model,'value'); ?>
            <?php echo $form->textField($model, 'value', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'value'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idDistrict'); ?>
            <?php echo $form->dropDownList($model, 'idDistrict', GxHtml::listDataEx(Districts::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idDistrict'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idAdviser'); ?>
            <?php echo $form->dropDownList($model, 'idAdviser', GxHtml::listDataEx(Advisers::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idAdviser'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idType'); ?>
            <?php echo $form->dropDownList($model, 'idType', GxHtml::listDataEx(Types::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idType'); ?>
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
            <?php echo $form->labelEx($model,'idWallet'); ?>
            <?php echo $form->dropDownList($model, 'idWallet', GxHtml::listDataEx(Wallets::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idWallet'); ?>
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