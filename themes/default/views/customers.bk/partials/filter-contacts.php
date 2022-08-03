<div class="dates_all topBarJuridico">
    <ul class="filter_views">
        <li class="hide backSite">
            <a href="#" data-url="" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>"  onClick="history.go(-1); return false;">
                <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
            </a>
        </li>
        <li class="hide"><a href="#" data-url="customers" class="tooltipped <?php echo (isset($active) && $active == 2) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-left"></i> <?php echo Yii::t('front', 'Lista'); ?></a></li>                    
        <li class="hide"><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>                    
        <li><a href="#new_contacts_modal" class="tooltipped modal_clic createContracts" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo Contacto'); ?>"><i class="fa fa-plus lin2"></i> <?php echo Yii::t('front', ''); ?></a></li>                                                                
    </ul>                  
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
        <form class="formweb form-filter" data-id="form-filter-" data-url="<?php echo (isset($url) && $url != '') ? $url : ''; ?>" enctype="multipart/form-data"> 
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Nombre') ?></label>                          
                <input name="name" id="form-filter-name" type="text" class="" value="">
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>
                <input name="phone" id="form-filter-phone" type="text" class="" value="">                    
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Email') ?></label>                          
                <input name="email" id="form-filter-email" type="text" class="" value="">
            </fieldset>            
                                                
            <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
            </fieldset>
        </form>
    </fieldset>
</div> 