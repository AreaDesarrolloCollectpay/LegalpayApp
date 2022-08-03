<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'passwd'); ?>
                    <?php echo $form->textField($model, 'passwd', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'dCreation'); ?>
                    <?php echo $form->textField($model, 'dCreation', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'dUpdate'); ?>
                    <?php echo $form->textField($model, 'dUpdate', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'active'); ?>
                    <?php echo $form->dropDownList($model, 'active', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'idAuthAssignment'); ?>
                    <?php echo $form->dropDownList($model, 'idAuthAssignment', GxHtml::listDataEx(AuthAssignment::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->