<div class="dates_all topBarJuridico">
    <ul class="filter_views">        
        <li>
            <a href="#" data-url="business" class="tooltipped hide <?php echo (isset($active) && $active == 1) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Columnas'); ?>">
                <i class="feather feather-align-left rotate"></i> <?php echo Yii::t('front', 'Columnas'); ?>
            </a>
        </li>
        <li>
        <a href="#" data-url="business/list" class="tooltipped hide <?php echo (isset($active) && $active == 2) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>">
            <i class="feather feather-align-left"></i> <?php echo Yii::t('front', 'Fila'); ?>
            </a>
        </li>                    
        <li>
            <a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>">
                <i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?>
            </a>
        </li>  
        <li>
            <a href="#modal_user_business" class="tooltipped modal_clic" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>">
                <i class="fa fa-plus lin2"></i> <?php // echo Yii::t('front', 'Nuevo'); ?>
            </a>
        </li>                    
    </ul>                  
</div>
<div class="formweb content_filter_advance">  
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
        <form class="formweb form-filter" data-id="form-filter-" id="form-filter-business" data-url="<?php echo (isset($url) && $url != '')? $url : ''; ?>" enctype="multipart/form-data"> 
                <fieldset class="large-2 medium-2 small-6 columns padding">
                    <label><?php echo Yii::t('front', 'País'); ?></label>
                    <select name="idCountry" id="form-filter-idCountry" class="select-country">
                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                        <?php
                        foreach ($countries as $country) {
                            ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php
                        }
                        ?> 
                    </select>                
                </fieldset>
                <fieldset class="large-2 medium-2 small-6 columns padding">
                    <label><?php echo Yii::t('front', 'Departamento'); ?></label>
                    <select name="idDepartment" id="form-filter-idDepartment" class="select-department">
                        <option value=""><?php echo Yii::t('front', 'Seleccionar') ?></option>
                    </select>
                </fieldset>
                <fieldset class="large-2 medium-2 small-6 columns padding">
                    <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                    <select name="idCity" id="form-filter-idCity">
                        <option value=""><?php echo Yii::t('front', 'Ciudad') ?></option>
                    </select>
                </fieldset>
                <fieldset class="large-2 medium-2 small-6 columns padding">
                    <label><?php echo Yii::t('front', 'Nombre'); ?></label>
                    <input name="name" id="form-filter-name" type="text" class="" value="">
                </fieldset>
                <fieldset class="large-2 medium-2 small-6 columns padding">
                    <label><?php echo Yii::t('front', 'CC / NIT'); ?></label>
                    <input name="numberDocument" id="form-filter-code" type="text" class="" value="">
                </fieldset>
                <fieldset class="large-2 medium-2 small-6 columns padding">
                    <label><?php echo Yii::t('front', 'Comercial'); ?></label>
                    <select name="idBusinessAdvisor" id="form-filter-idBusinessAdvisor">
                        <option value=""><?php echo Yii::t('front', 'Seleccionar') ?></option>
                        <?php foreach ($businessAdvisors as $businessAdvisor) { ?>
                            <option value="<?= $businessAdvisor->id; ?>"><?= $businessAdvisor->name; ?></option>
                        <?php } ?>
                    </select>
                </fieldset>
                <input name="page" id="form-filter-page" type="hidden" class="filter-page" value="<?php echo $currentPage; ?>" />
                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                </fieldset> 
            </form>
    </fieldset>
</div> 