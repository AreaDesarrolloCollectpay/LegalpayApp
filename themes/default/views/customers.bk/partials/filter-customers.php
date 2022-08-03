<div class="dates_all topBarJuridico">
    <ul class="filter_views"> 
        <li class="hide"><a href="#" data-url="customers" class="tooltipped <?php echo (isset($active) && $active == 2) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>">
            <i class="feather feather-align-left"></i> <?php echo Yii::t('front', 'Lista'); ?>
            </a>
        </li>
        <li class="hide"><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>
		 <li><a href="/business" id="m-business"><i class="fab fa-trello"></i> Negocios</a></li>
        <li><a href="#new_customers_modal" class="tooltipped modal_clic createCustomers" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo Cliente'); ?>"><i class="fa fa-plus lin2"></i> <?php //echo Yii::t('front', 'Nuevo'); ?></a></li>
        <li class="hide"><a href="#" class="tooltipped btn-filter-export" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Exportar'); ?>"><i class="fa fa-download lin2"></i> <?php echo Yii::t('front', 'Exportar'); ?></a></li>                 
    </ul>                  
</div>
<div class="formweb content_filter_advance hide"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
        <form class="formweb form-filter" data-id="form-filter-" data-url="<?php echo (isset($url) && $url != '')? $url : ''; ?>" data-export="customers/exportCustomer" enctype="multipart/form-data"> 
                <fieldset class="large-4 medium-4 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Cliente') ?></label>                          
                    <input name="name" id="form-filter-name" type="text" class="" value="">
                </fieldset>
                <fieldset class="large-4 medium-4 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'CC / NIT'); ?></label>
                    <input name="numberDocument" id="form-filter-numberDocument" type="text" class="" value="">                    
                </fieldset>
                <fieldset class="large-4 medium-4 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'ESTADO'); ?></label>
                    <select name="active" id="form-filter-active" class="">
                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                        <option value="1"><?php echo Yii::t('front', 'ACTIVO'); ?></option>
                        <option value="0"><?php echo Yii::t('front', 'INACTIVO'); ?></option>
                    </select>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                </fieldset> 
            </form>
    </fieldset>
</div> 
