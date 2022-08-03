<div class="dates_all topBarJuridico">
    <ul class="filter_views">        
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>                    
    </ul>                  
</div>
<div class=" formweb content_filter_advance">
    <form class="form-filter-maps form-filter" data-id="maps-">
        <div class="row padd_v">                    
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Región'); ?></label>
                <select name="idRegion" id="maps-idRegion" class="form-maps">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($regions as $region) { ?>
                        <option value="<?php echo $region->id; ?>"><?php echo $region->name; ?></option>
                    <?php } ?>
                </select> 
            </fieldset>  
            <fieldset class="large-4 medium-4 small-12 columns padding"> 
                <label><?php echo Yii::t('front', 'Etapa'); ?></label>
                <select name="idUserState" id="maps-idUserState" class="form-maps">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>                    
                    <?php foreach ($businessStates as $businessState) { ?>
                        <option value="<?php echo $businessState->id; ?>"><?php echo $businessState->name; ?></option>
                    <?php } ?>
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">                  
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Asesor'); ?></label>
                    <select name="idBusinessAdvisor" id="maps-idBusinessAdvisor" class="form-maps">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($businessAdvisers as $businessAdviser) { ?>
                        <option value="<?php echo $businessAdviser->id; ?>"><?php echo $businessAdviser->name; ?></option>
                    <?php } ?>
                    </select>
                </div>
            </fieldset>
        </div>
    </form>
</div>