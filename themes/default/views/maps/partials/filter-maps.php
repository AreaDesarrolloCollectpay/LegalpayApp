<div class="dates_all topBarJuridico">
    <ul class="filter_views">
		<li><a href="/tasks" id="m-tasks"><i class="feather feather-list "></i> Calendario</a></li>
		<li><a href="/dashboard" id="m-dashboard"><i class="feather feather-grid"></i> Gestion</a></li>
		<li><a href="/properties/movables" id="m-properties"><i class="fa fa-home"></i> Garantías</a></li>
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
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Agencia'); ?></label>
                    <select name="idCoordinator" id="maps-idCoordinator" class="form-maps select-coordinatorsAd">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                        <?php foreach ($coodinators as $coodinator) { ?>
                            <option value="<?php echo $coodinator->id; ?>"><?php echo $coodinator->name; ?></option>
                        <?php } ?>
                    </select>                        
                </div>
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">  
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Cliente'); ?></label>
                    <select name="idCustomer" id="maps-idCustomer" class="form-maps">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                        <?php foreach ($customers as $customer) { ?>
                            <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Asesor'); ?></label>
                    <select name="idAdviser" id="maps-idAdviser" class="form-maps">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    </select>
                </div>
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding"> 
                <label><?php echo Yii::t('front', 'Etapa'); ?></label>
                <select name="ageDebt" id="maps-ageDebt" class="form-maps">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($ageDebts as $ageDebt) { ?>
                        <option value="<?php echo $ageDebt->id; ?>"><?php echo $ageDebt->name; ?></option>
                    <?php } ?>
                </select>                
            </fieldset>
        </div>
    </form>
</div>