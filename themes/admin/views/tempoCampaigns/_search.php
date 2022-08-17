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
        <div class="row">
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'active'); ?>
                    <?php echo $form->dropDownList($model, 'active', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'phone'); ?>
                    <?php echo $form->textField($model, 'phone', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'lote'); ?>
                    <?php echo $form->textField($model, 'lote', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->