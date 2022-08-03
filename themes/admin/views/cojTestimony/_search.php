<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'img_es'); ?>
                    <?php echo $form->textField($model, 'img_es', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'img_en'); ?>
                    <?php echo $form->textField($model, 'img_en', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'testi_es'); ?>
                    <?php echo $form->textField($model, 'testi_es', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'testi_en'); ?>
                    <?php echo $form->textField($model, 'testi_en', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'name_company_es'); ?>
                    <?php echo $form->textField($model, 'name_company_es', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'name_company_en'); ?>
                    <?php echo $form->textField($model, 'name_company_en', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'name_person_es'); ?>
                    <?php echo $form->textField($model, 'name_person_es', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'name_person_en'); ?>
                    <?php echo $form->textField($model, 'name_person_en', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'charge_person_es'); ?>
                    <?php echo $form->textField($model, 'charge_person_es', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'charge_person_en'); ?>
                    <?php echo $form->textField($model, 'charge_person_en', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'dCreation'); ?>
                    <?php echo $form->textField($model, 'dCreation', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'dUpdate'); ?>
                    <?php echo $form->textField($model, 'dUpdate', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->