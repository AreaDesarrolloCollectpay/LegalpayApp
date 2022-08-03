<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

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
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'companyName'); ?>
                    <?php echo $form->textField($model, 'companyName', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'idNumber'); ?>
                    <?php echo $form->textField($model, 'idNumber', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'address'); ?>
                    <?php echo $form->textField($model, 'address', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'contactName'); ?>
                    <?php echo $form->textField($model, 'contactName', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'contactEmail'); ?>
                    <?php echo $form->textField($model, 'contactEmail', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>

        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->