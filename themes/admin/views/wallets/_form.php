<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'wallets-form',
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
            <?php echo $form->labelEx($model,'idNumber'); ?>
            <?php echo $form->textField($model, 'idNumber', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'idNumber'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'legalName'); ?>
            <?php echo $form->textField($model, 'legalName', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'legalName'); ?>
            </div>
            
        </div>
        <hr/>
        <!-- <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'feeValue'); ?>
            <?php echo $form->textField($model, 'feeValue', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'feeValue'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'interestsValue'); ?>
            <?php echo $form->textField($model, 'interestsValue', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'interestsValue'); ?>
            </div>
        </div> -->
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'validThrough'); ?>
            <?php 
                $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'validThrough',
                    'value' => $model->dAssigment,
                    'htmlOptions' => array('class'=>'input-block-level'),
                    'options' => array(
                        'showButtonPanel' => true,
                        'changeYear' => true,
                        'dateFormat' => 'yy-mm-dd',
                        ),
                ));
            ?>
            <?php echo $form->error($model,'validThrough'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'dAssigment'); ?>
            <?php 
                $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'dAssigment',
                    'value' => $model->dAssigment,
                    'htmlOptions' => array('class'=>'input-block-level'),
                    'options' => array(
                        'showButtonPanel' => true,
                        'changeYear' => true,
                        'dateFormat' => 'yy-mm-dd',
                        ),
                ));
            ?>
            <?php echo $form->error($model,'dAssigment'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'accountNumber'); ?>
            <?php echo $form->textField($model, 'accountNumber', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'accountNumber'); ?>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'capitalValue'); ?>
            <?php echo $form->textField($model, 'capitalValue', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'capitalValue'); ?>
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
            <?php echo $form->textField($model, 'address', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'address'); ?>
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
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model, 'email', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'email'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idAdviser'); ?>
            <?php echo $form->dropDownList($model, 'idAdviser', GxHtml::listDataEx(Advisers::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idAdviser'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idStatus'); ?>
            <?php echo $form->dropDownList($model, 'idStatus', GxHtml::listDataEx(Status::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idStatus'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Campaña</label>
            <?php 
                $modelCampaign = new Campaigns;
                if($model->isNewRecord){
                    echo $form->listBox($modelCampaign, 'idCampaign', CHtml::listData(Campaigns::model()->findAll(),'idCampaign','name'));
                }else {
                    $walletsHasCampaigns = WalletsHasCampaigns::model()->findByAttributes(array('idWallet'=>$model->idWallet));
                    echo $form->listBox($modelCampaign, 'idCampaign', CHtml::listData(Campaigns::model()->findAll(),'idCampaign','name'), array('options' => array($walletsHasCampaigns->idCampaign=>array('selected'=>true))));
                }
                echo $form->error($modelCampaign,'idCampaign');
                    
            ?>


            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'product'); ?>
            <?php echo $form->textField($model, 'product', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'product'); ?>
            </div>
                
            
        </div>


        <hr/>

        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->