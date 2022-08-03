<div class="dates_all topBarJuridico">
    <ul class="filter_views">
        <li class="backSite">
            <a href="#" data-url="" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>"  onClick="history.go(-1); return false;">
                <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
            </a>
        </li>
        <li><a href="#" data-url="wallet/legal/<?php echo $id.'/'.$quadrant; ?>" class="tooltipped <?php echo (isset($active) && $active == 1) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Columnas'); ?>"><i class="feather feather-align-left rotate"></i> <?php echo Yii::t('front', 'Columnas'); ?></a></li>
        <li><a href="#" data-url="wallet/<?php echo $id.'/'.$quadrant; ?>" class="tooltipped <?php echo (isset($active) && $active == 2) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-justify"></i> <?php echo Yii::t('front', 'Lista'); ?></a></li>                    
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>
    </ul>                  
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
        <form class="formweb form-filter" data-id="form-filter-" data-url="<?php echo (isset($url) && $url != '') ? $url : ''; ?>" enctype="multipart/form-data"> 
            <fieldset class="large-4 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Region'); ?></label>
                <select name="idCountry" id="form-filter-idCountry">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                       
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Abogado'); ?></label>
                <select name="idDepartment" id="form-filter-idDepartment">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar') ?></option>
                </select>
            </fieldset>
            <fieldset class="large-4 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Dependiente'); ?></label>
                <select name="idCity" id="form-filter-idCity">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar') ?></option>
                </select>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
            </fieldset> 
        </form>
    </fieldset>
</div> 