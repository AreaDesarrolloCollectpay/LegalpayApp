<div class="dates_all topBarJuridico">
    <ul class="filter_chart">
        <li>
            <a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>">
                <i class="fas fa-bars lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?>
            </a>
        </li>                    
    </ul>                  
</div>
<div class=" formweb content_filter_advance">
    <form class="form-filter-indicators form-filter" data-id="indicators-">
        <div class="row padd_v">
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Región'); ?></label>
                    <select name="idRegion" id="indicators-idRegion" class="form-indicators">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                        <?php foreach ($regions as $region){ ?>
                            <option value="<?php echo $region->id; ?>"><?php echo $region->name; ?></option>                        
                        <?php }?>
                    </select>
                </div>
            </fieldset>
            <fieldset class="large-3 medium-3 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Desde'); ?></label>
                <div class="fecha">
                    <input name="from" id="form-filter-payments-from" type="text" class="calendar_from" value="">
                </div>
            </fieldset>
            <fieldset class="large-3 medium-3 small-6 columns padding">                                            
                <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                <div class="fecha">
                    <input name="to" id="form-filter-payments-to" type="text" class="calendar_to" value="">
                </div>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding item-customer">
                <label><?php echo Yii::t('front', 'Agencia'); ?></label>
                <select name="idCoordinator" id="indicators-idCoordinator" class="form-indicators select-coordinatorsAd">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($coodinators as $coodinator){ ?>
                        <option value="<?php echo $coodinator->id; ?>"><?php echo $coodinator->name; ?></option>                        
                    <?php }?>
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">                        
                <label><?php echo Yii::t('front', 'Asesor'); ?></label>
                <select name="idAdviser" id="indicators-idAdviser" class="form-indicators">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                </select>
            </fieldset>            
        </div>
    </form>
</div>