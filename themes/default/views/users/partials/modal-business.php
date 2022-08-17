<!-- Modal New User -->
<section id="new_business_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO COMERCIAL'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-users" data-id="users-">
        <div class="row padd_v">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Nombres'); ?></label>  
                <input id="users-name" name="name" type="text">
                <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>  
                <input id="users-email" name="email" type="text">
                <label><?php echo Yii::t('front', 'País'); ?></label>                       
                <select id="users-idCountry" name="idCountry"  class="select-country">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                    <?php foreach ($countries as $country) { ?>                        
                        <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>      
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                <select id="users-idDepartment" name="idDepartment" class="select-department">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                <select id="users-idCity" name="idCity" class="select-city">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Nombre de usuario'); ?></label>  
                <input id="users-userName" name="userName" type="text">
                <label><?php echo Yii::t('front', 'Celular'); ?></label>                       
                <input id="users-mobile" name="mobile" type="number">
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>                       
                <input id="users-phone" name="phone" type="number">                
                <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
                <input id="users-address" name="address" type="text">
                <label><?php echo Yii::t('front', 'Tipo de Notificación'); ?></label>                       
                <select id="users-notification" name="notification">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="15"><?php echo Yii::t('front', 'Quincenal'); ?></option>            
                    <option value="30"><?php echo Yii::t('front', 'Mensual'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'Ninguno'); ?></option>            
                </select>
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <input id="users-id" name="id" type="hidden" value="" />
            <input id="users-is_internal" name="is_internal" type="hidden" value="<?php echo $id; ?>" />
            <input id="users-idUserProfile" name="idUserProfile" type="hidden" value="9" />
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>

