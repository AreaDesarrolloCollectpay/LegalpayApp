<div class="dates_all topBarJuridico">
    <ul class="filter_views">
        <li class="hide"><a href="#" data-url="users/<?php echo $type.'/'.$id; ?>" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-justify"></i></a></li>                    
        <li class="hide"><a href="#" data-url="users/<?php echo $type.'/'.$id; ?>" class="tooltipped <?php echo (isset($active)) ? 'active' : ''; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-justify"></i> <?php echo Yii::t('front', 'Lista'); ?></a></li>                    
        <li class="hide"><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>
        <li class="hide"><a href="#" class="tooltipped btn-filter-export" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Exportar'); ?>"><i class="fa fa-download"></i> <?php echo Yii::t('front', 'Exportar'); ?></a></li>                    
        <li class="<?php echo ($active == 1)? 'hide' : 'hide'; ?>"><a href="<?php echo $this->createUrl('/tasks/index?is_internal='.$id.'&type='.$active); ?>" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Tareas'); ?>"><i class="fa fa-tasks"></i> <?php echo Yii::t('front', 'Tareas'); ?></a></li>                    
        <li class=""><a href="#new_<?php echo $type; ?>_modal" class="tooltipped modal_clic create<?php echo $type; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', ''); ?></a></li>                            
    </ul>                
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">
        <div class="padd_v m_b_10">            
            <form class="formweb form-filter" data-id="form-filter-" data-url="users/<?php echo $type.'/'.$id; ?>" data-export="users/exportFilter<?php echo ucfirst($type).'/'.$id; ?>" enctype="multipart/form-data"> 
                <fieldset class="large-6 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Nombre'); ?></label>
                    <input name="name" id="form-filter-name"  type="text" class="" value="">                                                                                                                                    
                </fieldset>
                <fieldset class="large-6 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'CC / NIT') ?></label>                          
                    <input name="numberDocument" id="form-filter-numberDocument"  type="text" class="" value="">                                                                                        
                </fieldset>                                                                                
                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                </fieldset> 
            </form>
        </div>
    </fieldset>
</div>