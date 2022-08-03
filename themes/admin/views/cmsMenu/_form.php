<div class="form">


<?php 
$condition = "";
if(!$model->isNewRecord){
    $condition = "idcmsmenu<>".$model->idcmsmenu;
}
$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cms-menu-form',
	'enableAjaxValidation' => false,
        'htmlOptions' => array('class'=>'well well-sm', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

	<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-danger')); ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'cms_menu_id'); ?>
            <?php echo $form->dropDownList($model, 'cms_menu_id', GxHtml::listDataEx(CmsMenu::model()->findAll($condition)), array('empty'=>'Seleccione...')); ?>
            <?php echo $form->error($model,'cms_menu_id'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'titulo'); ?>
            <?php echo $form->textField($model, 'titulo', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'titulo'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'url'); ?>
            <?php echo $form->textField($model, 'url', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'url'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'icono'); ?>
            <?php 
                echo $form->dropDownList($model, 'icono', CHtml::listData(CmsIcono::model()->findAll() , 'icono_class', 'icono_class'));
            ?>
            <?php echo $form->error($model,'icono'); ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'visible_header'); ?>
            <?php $this->widget('booster.widgets.TbSwitch', array(
                                'model' => $model,
                                'attribute' => 'visible_header',
                                'options' => array(
                                    'onText'=>Yii::t('app', 'Si'),
                                    'offText'=>Yii::t('app', 'No'),
                                    'size' => 'normal', //null, 'mini', 'small', 'normal', 'large
                                    'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                    'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                ),
                            )); ?>
            <?php echo $form->error($model,'visible_header'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'visible'); ?>
            <?php $this->widget('booster.widgets.TbSwitch', array(
                                'model' => $model,
                                'attribute' => 'visible',
                                'options' => array(
                                    'onText'=>Yii::t('app', 'Si'),
                                    'offText'=>Yii::t('app', 'No'),
                                    'size' => 'normal', //null, 'mini', 'small', 'normal', 'large
                                    'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                    'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                ),
                            )); ?>
            <?php echo $form->error($model,'visible'); ?>
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
<script type="text/javascript">
    $(function(){
        $("#CmsMenu_icono option").each(function(){
           $(this).html('<b class="glyphicon '+$(this).text()+'"></b> ' + $(this).text());
       });
       $("#CmsMenu_icono").change(function(){
           var obj = $("#CmsMenu_icono_chosen .chosen-single span");
           $(obj).html('<b class="glyphicon '+$(obj).text()+'"></b> ' + $(obj).text());;
       });
       $("#CmsMenu_icono").trigger("chosen:updated");
       var obj = $("#CmsMenu_icono_chosen .chosen-single span");
       $(obj).html('<b class="'+$(obj).text()+'"></b> ' + $(obj).text());;
    });
</script>