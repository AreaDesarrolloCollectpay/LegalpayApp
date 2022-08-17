<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'cms_rol_id'); ?>
                    <?php echo $form->dropDownList($model, 'cms_rol_id', GxHtml::listDataEx(CmsRol::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'controller'); ?>
                    <?php echo $form->textField($model, 'controller', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'action'); ?>
                    <?php echo $form->textField($model, 'action', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->