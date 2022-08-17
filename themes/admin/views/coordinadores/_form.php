<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'advisers-form',
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
        <label>Nombre y Apellido del Usuario <span class="required">*</span></label>
        <?php echo $form->textField($model, 'name', array('class'=>'form-control input-block-level')); ?>
        <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model, 'email', array('class'=>'form-control input-block-level')); ?>
        <?php echo $form->error($model,'email'); ?>
        </div>
    </div>
    <div class="row">
        <?php 
            if($model->isNewRecord) {
        ?>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Nombre de Usuario Para ingresar a Cojunal <span class="required">*</span></label> 
                    <h4><?php echo $form->textField($model, 'idAuthAssignment', array('class'=>'form-control input-block-level', 'size'=>64,'maxlength'=>64)); ?></h4>
                    <?php echo $form->error($model,'idAuthAssignment'); ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Rol</label>
                <?php echo $form->dropDownList($model, 'status_idStatus', GxHtml::listDataEx(Status::model()->findAllAttributes(null, true))); ?>
                <?php echo $form->error($model,'status_idStatus'); ?>
                </div>
        <?php } else { ?>
                <div class="row">
                    
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Usuario</label>
                        <h4><?php echo AuthAssignment::model()->findByPk($model->idAuthAssignment)->userid; ?></h4>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Rol</label>
                    <?php echo $form->dropDownList($model, 'status_idStatus', GxHtml::listDataEx(Status::model()->findAllAttributes(null, true))); ?>
                    <?php echo $form->error($model,'status_idStatus'); ?>
                    </div>
                </div>
        <?php } ?>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'weeklyGoal'); ?>
            <?php echo $form->textField($model, 'weeklyGoal', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'weeklyGoal'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'monthlyGoal'); ?>
            <?php echo $form->textField($model, 'monthlyGoal', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'monthlyGoal'); ?>
            </div>
        </div>
       <!--  <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'passwd'); ?>
            <?php echo $form->textField($model, 'passwd', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'passwd'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'dCreation'); ?>
            <?php echo $form->textField($model, 'dCreation', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'dCreation'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'dUpdate'); ?>
            <?php echo $form->textField($model, 'dUpdate', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'dUpdate'); ?>
            </div>
        </div> -->
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'active'); ?>
            <?php $this->widget('booster.widgets.TbSwitch', array(
                                'model' => $model,
                                'attribute' => 'active',
                                'options' => array(
                                    'onText'=>Yii::t('app', 'Si'),
                                    'offText'=>Yii::t('app', 'No'),
                                    'size' => 'normal', //null, 'mini', 'small', 'normal', 'large
                                    'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                    'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                ),
                            )); ?>
            <?php echo $form->error($model,'active'); ?>
            </div>
            
        </div>
		<!-- <label><?php echo GxHtml::encode($model->getRelationLabel('agendases')); ?></label>
		<?php echo $form->checkBoxList($model, 'agendases', GxHtml::encodeEx(GxHtml::listDataEx(Agendas::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('assets')); ?></label>
		<?php echo $form->checkBoxList($model, 'assets', GxHtml::encodeEx(GxHtml::listDataEx(Assets::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('campaigns')); ?></label>
		<?php echo $form->checkBoxList($model, 'campaigns', GxHtml::encodeEx(GxHtml::listDataEx(Campaigns::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('comments')); ?></label>
		<?php echo $form->checkBoxList($model, 'comments', GxHtml::encodeEx(GxHtml::listDataEx(Comments::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('demographics')); ?></label>
		<?php echo $form->checkBoxList($model, 'demographics', GxHtml::encodeEx(GxHtml::listDataEx(Demographics::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('payments')); ?></label>
		<?php echo $form->checkBoxList($model, 'payments', GxHtml::encodeEx(GxHtml::listDataEx(Payments::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('promises')); ?></label>
		<?php echo $form->checkBoxList($model, 'promises', GxHtml::encodeEx(GxHtml::listDataEx(Promises::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('types')); ?></label>
		<?php echo $form->checkBoxList($model, 'types', GxHtml::encodeEx(GxHtml::listDataEx(Types::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('wallets')); ?></label>
		<?php echo $form->checkBoxList($model, 'wallets', GxHtml::encodeEx(GxHtml::listDataEx(Wallets::model()->findAllAttributes(null, true)), false, true)); ?> -->
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->