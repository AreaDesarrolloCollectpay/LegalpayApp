<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'campaigns-form',
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
            <?php echo $form->labelEx($model,'idAdviser'); ?>
            <?php echo $form->dropDownList($model, 'idAdviser', GxHtml::listDataEx(Advisers::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idAdviser'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idNumber'); ?>
            <?php echo $form->textField($model, 'idNumber', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'idNumber'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'companyName'); ?>
            <?php echo $form->textField($model, 'companyName', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'companyName'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                    <?php echo $form->labelEx($model,'idDistrict'); ?>
                    <?php echo $form->listBox($model, 'idDistrict', CHtml::listData(Treedistricts::model()->findAll(),'idDistrict','fullDistrict')); ?>
                    <?php echo $form->error($model,'idDistrict'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'address'); ?>
            <?php echo $form->textArea($model, 'address', array('class'=>'form-control input-block-level', 'maxlength'=>500)); ?>
            <?php echo $form->error($model,'address'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'contactName'); ?>
            <?php echo $form->textField($model, 'contactName', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'contactName'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?php echo $form->labelEx($model,'contactEmail'); ?>
                <?php echo $form->textField($model, 'contactEmail', array('class'=>'form-control input-block-level')); ?>
                <?php echo $form->error($model,'contactEmail'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'phone'); ?>
            <?php echo $form->textField($model, 'phone', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'phone'); ?>
            </div>
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
        <hr/>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
            <?php echo $form->labelEx($model,'comments'); ?>
            <?php echo $form->textArea($model, 'comments', array('class'=>'form-control input-block-level', 'maxlength' => 300)); ?>
            <?php echo $form->error($model,'comments'); ?>
            </div>

        </div>
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->