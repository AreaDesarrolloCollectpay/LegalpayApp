<div class="dates_all topBarJuridico">
    <ul class="filter_views"> 
        <li><a href="#" data-url="#" class="tooltipped <?php echo (isset($active) && $active == 2) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>">
            <i class="feather feather-align-left"></i> <?php echo Yii::t('front', 'Lista'); ?>
            </a>
        </li>
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>
        <li><a href="#new_political_modal" class="tooltipped modal_clic createCustomers" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nueva Política'); ?>"><i class="fa fa-plus lin2"></i> <?php echo Yii::t('front', 'Nueva Política'); ?></a></li>
    </ul>                  
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
        <form class="formweb form-filter" data-id="form-filter-" data-url="<?php echo (isset($url) && $url != '')? $url : ''; ?>" data-export="customers/exportCustomer" enctype="multipart/form-data"> 
                <fieldset class="large-6 medium-6 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Tipo - Cliente'); ?></label>  
                    <select id="form-filter-idUser" name="idUser"  class="">
                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                        <?php foreach ($customersF as $customer) { ?>                        
                            <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                        <?php } ?>
                    </select>
                </fieldset>
                <fieldset class="large-6 medium-6 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'Nombre'); ?></label>
                    <input name="numberDocument" id="form-filter-numberDocument" type="text" class="" value="">                    
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                </fieldset> 
            </form>
    </fieldset>
</div> 