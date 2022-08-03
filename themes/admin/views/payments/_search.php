<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'value'); ?>
                    <?php echo $form->textField($model, 'value', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'dPayment'); ?>
                    <?php echo $form->textField($model, 'dPayment', array('class'=>'form-control input-block-level')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'dCreation'); ?>
                    <?php echo $form->textField($model, 'dCreation', array('class'=>'form-control input-block-level')); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'idWallet'); ?>
                    <?php echo $form->dropDownList($model, 'idWallet', GxHtml::listDataEx(Wallets::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'idAdviser'); ?>
                    <?php echo $form->dropDownList($model, 'idAdviser', GxHtml::listDataEx(Advisers::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo $form->label($model, 'idPaymentType'); ?>
                    <?php echo $form->dropDownList($model, 'idPaymentType', GxHtml::listDataEx(Paymentypes::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos'))); ?>
            </div>
        </div>
        <hr/>
        <div class="row buttons text-center">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>
        </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->