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
                    <?php echo $form->label($model, 'idDepartament'); ?>
                    <?php echo $form->dropDownList($model, 'idDepartament', GxHtml::listDataEx(Departaments::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->