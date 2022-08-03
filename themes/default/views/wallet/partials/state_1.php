<div class="row white border-tab border_content">
    <div id="frmManagement m_t_10"> 
        <div class="clear"></div> 
        <fieldset class="large-12 medium-12 small-12 columns padding" style="margin-bottom: 2px;">    

            <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">
                <div class="modal-header row p_b_10 m_t_10">
                    <h1><?php echo Yii::t('front', 'INFORMACIÓN DEL PROCESO JURÍDICO'); ?></h1>
                </div>
            </fieldset>
            <form class="form-stateLegal formweb" type="post" data-id="debtorObligations-"> 
                <fieldset class="large-12 medium-12 small-12 columns">                             
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Etapa'); ?></label>
                        <select id="debtorObligations-idDebtorStateLegal" class=" select-debtorStateLegal" name="idDebtorsState">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                            <?php foreach ($status as $stat) { ?>
                                <option value="<?= $stat->id; ?>" <?php echo ($debtor->idState == $stat->id) ? 'selected="selected"' : ''; ?> ><?php echo Yii::t('front', $stat->name); ?></option>
                            <?php } ?>                          
                        </select> 
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">   
                        <label><?php echo Yii::t('front', 'Sub-etapa'); ?></label>
                        <select id="debtorObligations-idDebtorStateLegal" class="" name="idDebtorSubstate">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                            <?php foreach ($status as $stat) { ?>
                                        <!--<option value="<?= $stat->id; ?>" <?php echo ($debtor->idState == $stat->id) ? 'selected="selected"' : ''; ?> ><?php echo Yii::t('front', $stat->name); ?></option>-->
                            <?php } ?>                          
                        </select> 
                    </fieldset>        
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                        <input type="text" name="office_legal_location" value="<?php echo $debtor->city; ?>" />
                    </fieldset>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns">
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Número Juzgado'); ?></label>
                        <select id="debtorObligations-office_legal" class="select-disabled" name="office_legal">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                            <?php for($i = 1; $i <= 100 ; $i++) { ?>
                                <option value="<?= $i; ?>" <?php echo ($debtorObli->office_legal == $i)? 'selected' : ''; ?>><?php echo Yii::t('front', $i); ?></option>
                            <?php } ?>                          
                        </select>  
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Jurisdicción'); ?></label>
                        <select id="debtorObligations-idOfficeLegal" class="select-disabled" name="idOfficeLegal">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                            <?php foreach ($officeLegals as $officeLegal) { ?>
                                <option value="<?= $officeLegal->id; ?>" <?php echo ($debtorObli->idOfficeLegal == $officeLegal->id)? 'selected' : ''; ?>><?php echo Yii::t('front', $officeLegal->name); ?></option>
                            <?php } ?>                          
                        </select>   
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Categoria'); ?></label>
                        <select id="debtorObligations-idCategoryLegal" class="select-disabled" name="idCategoryLegal">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                            <?php foreach ($categoryLegals as $categoryLegal) { ?>
                                <option value="<?= $categoryLegal->id; ?>" <?php echo ($debtorObli->idCategoryLegal == $categoryLegal->id)? 'selected' : ''; ?>><?php echo Yii::t('front', $categoryLegal->name); ?></option>
                            <?php } ?>                          
                        </select> 
                    </fieldset>
                    
<!--                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Despacho'); ?></label>
                        <select id="debtorObligations-idOfficeLegal" class="select-idOfficeLegal select-disabled" name="idOfficeLegal">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                            <?php foreach ($officeLegals as $officeLegal) { ?>
                                <option value="<?= $officeLegal->id; ?>"><?php echo Yii::t('front', $officeLegal->name); ?></option>
                            <?php } ?>                          
                        </select>   
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Número Despacho'); ?></label>
                        <input type="text" id="debtorObligations-OfficeNumber" name="OfficeNumber" value="" class="input-disabled" />     
                    </fieldset>        -->
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns"> 
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Ubicación Juzgado'); ?></label>
                        <input type="text" name="office_legal_location" value="<?php echo $debtorObli->office_legal_location ?>" />
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Tipo de Proceso'); ?></label>
                        <select id="debtorObligations-idTypeProcess" class="" name="idTypeProcess">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                            <?php foreach ($typeProcess as $typePro) { ?>
                                <option value="<?= $typePro->id; ?>" <?php echo ($debtorObli->idTypeProcess == $typePro->id) ? 'selected="selected"' : ''; ?>><?php echo Yii::t('front', $typePro->name); ?></option>
                            <?php } ?>     
                        </select>   
                    </fieldset>
<!--                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Categoria'); ?></label>
                        <select id="debtorObligations-idCategoryLegal" class="select-disabled" name="idCategoryLegal">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                        </select> 
                    </fieldset>-->
                    <fieldset class="large-4 medium-4 small-12 columns padding">   
                        <label><?php echo Yii::t('front', 'Fecha de Radicado'); ?></label>
                        <div class="fecha">
                            <input name="date_filing" id="debtorObligations-date_filing" type="date" class="calendar" value="<?php echo $debtorObli->date_filing; ?>" />
                        </div>
                    </fieldset>   
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns"> 
                    <fieldset class="large-4 medium-4 small-12 columns padding">   
                        <label><?php echo Yii::t('front', 'Número de Radicado'); ?></label>
                        <input type="text" id="debtorObligations-settledNumber" name="settledNumber" value="<?php echo $debtorObli->settledNumber; ?>" class="input-disabled" />
                    </fieldset> 
                    <fieldset class="large-4 medium-4 small-12 columns padding">   
                        <label><?php echo Yii::t('front', 'Apoderado'); ?></label>
                        <input type="text" id="debtorObligations-attorney" name="attorney" value="<?php echo $debtorObli->attorney; ?>" class="input-disabled" />
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">   
                        <label><?php echo Yii::t('front', 'Cédula'); ?></label>
                        <input type="text" id="debtorObligations-attorney" name="attorneyId" value="<?php echo $debtorObli->attorneyId;  ?>" class="input-disabled" />
                    </fieldset>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns"> 
                    <fieldset class="large-4 medium-4 small-12 columns padding">   
                        <label><?php echo Yii::t('front', 'Tarjeta Profesional'); ?></label>
                        <input type="text" id="debtorObligations-attorney" name="atorneyPC" value="<?php echo $debtorObli->atorneyPC;  ?>" class="input-disabled" />
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Código Interno'); ?></label>
                        <input type="text" value="<?php echo $debtorObli->internal_number; ?>" name="internal_number" />            
                    </fieldset>
                    <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Fecha de Asignación'); ?></label>
                        <div class="fecha">
                            <input name="date_assignment" id="debtorObligations-date_assignment" type="date" class="calendar" value="<?php echo $debtorObli->date_assignment; ?>" />
                        </div>
                    </fieldset>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns m_t_5 m_b_30">
                    <input type="hidden" name="id" value="<?php echo $debtor->id; ?>" />
                    <button type="submit" id="btn-form-state-legal" class="btnb waves-effect waves-light right m_t_20 hide"><?php echo Yii::t('front', 'Guardar'); ?></button>
                </fieldset>
            </form>
            <div class="clear"></div>
            <!--                            <div class="padding">
                                            <div class="lineap"></div>
                                        </div>-->
        </fieldset>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript("edit_task", '
        
    $(document).ready(function(){    
        //$("#debtorObligations-idOfficeLegal").val("' . $debtorObli->idOfficeLegal . '").trigger("change");        
        //$("#debtorObligations-idTypeProcess").val("' . $debtorObli->idOfficeLegal . '").trigger("change");        
        setTimeout(function(){        
            //$("#debtorObligations-idCategoryLegal").val("' . $debtorObli->idCategoryLegal . '").trigger("change");                
        },1000);
    });
            
    ', CClientScript::POS_END
);
?>