<div class="dates_all topBarJuridico">
    <ul class="filter_views">
        <li class="backSite">
            <a href="#" data-url="" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>"  onClick="history.go(-1); return false;">
                <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
            </a>
        </li>
        <li><a href="#" class="tooltipped active" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-justify"></i> <?php echo Yii::t('front', 'Lista'); ?></a></li>                    
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>
        <li><a href="#" class="tooltipped btn-filter-export" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Exportar'); ?>"><i class="fa fa-download"></i> <?php echo Yii::t('front', 'Exportar'); ?></a></li>                    
    </ul>                
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding">
        <div class="padd_v border_form">            
            <form class="formweb form-filter" data-id="form-filter-" data-url="users/logSessions/<?php echo $id; ?>" data-export="users/exportSessions/<?php echo $id; ?>" enctype="multipart/form-data"> 
                <fieldset class="large-6 medium-6 small-6 columns padding">
                    <label><?php echo Yii::t('front', 'Desde'); ?></label>
                    <div class="fecha">
                        <input name="from" id="form-filter-sessions-from" type="text" class="calendar_from" value="">
                    </div>
                </fieldset>
                <fieldset class="large-6 medium-6 small-6 columns padding">                                            
                    <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                    <div class="fecha">
                        <input name="to" id="form-filter-sessions-to" type="text" class="calendar_to" value="">
                    </div>
                </fieldset>                                                                               
                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                </fieldset> 
            </form>
        </div>
    </fieldset>
</div>