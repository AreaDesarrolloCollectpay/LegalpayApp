<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'cms_menu_id'); ?>
                    <?php echo $form->dropDownList($model, 'cms_menu_id', GxHtml::listDataEx(CmsMenu::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'titulo'); ?>
                    <?php echo $form->textField($model, 'titulo', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'url'); ?>
                    <?php echo $form->textField($model, 'url', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'icono'); ?>
                    <?php echo $form->textField($model, 'icono', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'visible_header'); ?>
                    <?php echo $form->dropDownList($model, 'visible_header', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'visible'); ?>
                    <?php echo $form->dropDownList($model, 'visible', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->