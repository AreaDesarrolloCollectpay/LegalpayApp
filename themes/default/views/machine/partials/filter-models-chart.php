<div class="dates_all topBarJuridico">
    <ul class="filter_chart">        
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fas fa-bars lin2"></i> <?php //echo Yii::t('front', ''); ?></a></li>                            
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fas fa-bar lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>                    
    </ul>                
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">
        <div class="padd_v m_b_10">            
            <form class="formweb form-filter" data-id="form-filter-" data-url="machine/" data-export="users/exportFilter" enctype="multipart/form-data"> 
                <fieldset class="large-6 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Nombre'); ?></label>
                    <input name="name" id="form-filter-name"  type="text" class="" value="">                                                                                                                                    
                </fieldset>
                <fieldset class="large-6 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Descripción') ?></label>                          
                    <input name="description" id="form-filter-description"  type="text" class="" value="">                                                                                        
                </fieldset>                                                                                
                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                </fieldset> 
            </form>
        </div>
    </fieldset>
</div>