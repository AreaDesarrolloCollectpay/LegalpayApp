<div class="dates_all topBarJuridico">
    <ul class="filter_views">
        <li><a href="#" data-url="users/<?php echo $type; ?>" class="tooltipped active" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-justify"></i> <?php echo Yii::t('front', 'Lista'); ?></a></li>                    
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>
        <li><a href="#" class="tooltipped btn-filter-export" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Exportar'); ?>"><i class="fa fa-download"></i> <?php echo Yii::t('front', 'Exportar'); ?></a></li>                                             
    </ul>                
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">
        <div class="padd_v m_b_10">            
            <form class="formweb form-filter" data-id="form-filter-" data-url="properties/<?php echo $type; ?>" data-export="properties/exportFilter<?php echo ucfirst($type); ?>" enctype="multipart/form-data"> 
                <fieldset class="large-4 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Cliente'); ?></label>
                    <input name="customer" id="form-filter-customer"  type="text" class="" value="">                                                                                                                                    
                </fieldset>                                                                                
                <fieldset class="large-4 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                    <input name="city" id="form-filter-city"  type="text" class="" value="">                                                                                                                                    
                </fieldset>
                <fieldset class="large-4 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'CC / NIT') ?></label>                          
                    <input name="code" id="form-filter-code"  type="text" class="" value="">                                                                                        
                </fieldset>                                                                                
                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                </fieldset> 
            </form>
        </div>
    </fieldset>
</div>