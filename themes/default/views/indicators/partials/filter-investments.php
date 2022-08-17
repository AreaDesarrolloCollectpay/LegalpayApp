<div class="dates_all topBarJuridico hide">
    <ul class="filter_views"> 
        <li>
            <a href="#" data-url="" class="active tooltipped btn-filter-invest <?php echo (isset($active) && $active == 1) ? 'active' : 'btn-filt'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Calcular'); ?>">
                <i class="fas fa-calculator lin2"></i> <?php echo Yii::t('front', 'Calcular'); ?>
            </a>
        </li>
    </ul>                  
</div>
<div class=" formweb content_filter_investment">
    <form class="form-investments" data-id="indicators-">
        <div class="row padd_v">                    
            <fieldset class="large-6 medium-6 small-6 columns padding">
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Valor de la Inversión'); ?></label> 
                    <input type="text" name="value" />
                </div>
            </fieldset>
            <fieldset class="large-4 medium-4 small-6 columns padding hide">
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Tasa %'); ?></label>
                    <input type="text" name="rate" value="0" />
                </div>
            </fieldset>
            <fieldset class="large-6 medium-6 small-6 columns padding">                        
                <label><?php echo Yii::t('front', 'Flujo de Caja %'); ?></label>                    
                <div class="file-field input-field" style="margin-top: 0px !important;">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                        <input class="" name="file" id="assignments-file" type="file" accept=".csv">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padd_v">  
                <div class="txt_center block padding ">
                    <button class="btnb waves-effect waves-light btn-disabled"><?php echo Yii::t('front', 'CALCULAR'); ?></button>
                </div>
            </fieldset>
        </div>
    </form>
</div>
