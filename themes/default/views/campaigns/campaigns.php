<section class="cont_home">       
    <section class="conten_inicial">
	<div class="dates_all topBarJuridico">
    <ul class="filter_views">    
		<li><a href="/demo/callcenter/attend" id="m-customers"><i class="fas fa-headset"></i> Call Center</a></li>	
    </ul>                  
</div>
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Campañas Masivas") ?></h2>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_80">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_v">
                        <form enctype="multipart/form-data"  class="formweb form-campaigns" data-id="campaigns-" >
                            <fieldset class="large-6 medium-6 small-6 columns padding"> 
                                <label><?php echo Yii::t('front', 'Tipo de Campaña'); ?></label> 
                                <select id="campaigns-idType" name="idType">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                    <option value=""><?php echo Yii::t('front', 'SMS'); ?></option>      
                                    <option value=""><?php echo Yii::t('front', 'Correo Electronico'); ?></option>    
                                </select>                            
                            </fieldset>
                            <fieldset class="large-6 medium-6 small-6 columns padding "> 
                                <label><?php echo Yii::t('front', 'Cliente'); ?></label> 
                                <select class="filter-mlModels" id="campaigns-idModel" name="idType" data-closest="form">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                </select>                            
                            </fieldset>
                            <!--                            <fieldset class="large-6 medium-6 small-6 columns padding "> 
                                                            <label><?php echo Yii::t('front', 'Plantilla'); ?></label> 
                                                            <select id="campaigns-idType" name="idType">
                                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                                                <option value=""><?php echo Yii::t('front', 'Plantilla 1'); ?></option>      
                                                                <option value=""><?php echo Yii::t('front', 'Plantilla 2'); ?></option>
                                                            </select>                            
                                                        </fieldset>-->
                                                        <fieldset class="large-6 medium-6 small-6 columns padding "> 
                                                            <label><?php echo Yii::t('front', 'Modelo'); ?></label> 
                                                            <select class="filter-mlModels" id="campaigns-idModel" name="idType" data-closest="form">
                                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                            <?php foreach ($mlModels as $mModel) { ?>
                                                                        <option value="<?php echo $mModel->id; ?>" <?php echo (isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] == $mModel->id) ? 'selected' : ''; ?>><?php echo $mModel->name; ?></option>
                            <?php } ?>
                                                            </select>                            
                                                        </fieldset>
                                                        <fieldset class="large-6 medium-6 small-6 columns padding "> 
                                                            <label><?php echo Yii::t('front', 'Cluster'); ?></label> 
                                                            <select id="campaigns-idCluster" name="idCluster">
                                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                                          
                                                            </select>                            
                                                        </fieldset>                            
                            <fieldset class="large-12 medium-12 small-12 columns padding">            
                                <label><?php echo Yii::t('front', 'Cuerpo del mensaje'); ?></label>
                                <textarea name="comments" cols="30" rows="10" id="ta-comment"></textarea>
                            </fieldset>
                            <fieldset class="large-12 medium-12 small-12 columns padding txt_center">
                                <button type="submit" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'CREAR'); ?></button>
                            </fieldset>
                            <div class="clear"></div>
                        </form>
                    </section>                    
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/campaigns.min.js', CClientScript::POS_END);
?>
