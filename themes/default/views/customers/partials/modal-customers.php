<!-- Modal New Phone -->
<section id="new_customers_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO CLIENTE'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-customers" data-id="customers-" enctype="multipart/form-data">
        <div class="row padd_v">
            <fieldset class="large-12 medium-12 small-12 columns padding">                
                <label class="sub_title"><?php echo Yii::t('front', 'DATOS GENERALES'); ?></label>  
                <hr>
            </fieldset>
        </div>    
        <div class="row">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo Documento'); ?></label>  
                <select id="customers-idTypeDocument" name="idTypeDocument"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                    <?php foreach ($typeDocument as $type) { ?>                        
                        <option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>      
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front', 'Nombre Empresa'); ?></label>  
                <input id="customers-name" name="name" type="text">
                <label><?php echo Yii::t('front', 'Nombre Contacto'); ?></label>  
                <input id="customers-contact" name="contact" type="text">
                <label><?php echo Yii::t('front','Correo Electrónico'); ?></label>  
                <input id="customers-email" name="email" type="text">
                <label><?php echo Yii::t('front', 'País'); ?></label>                       
                <select id="customers-idCountry" name="idCountry"  class="select-country">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                    <?php foreach ($countries as $country) { ?>                        
                        <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>      
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                <select id="customers-idDepartment" name="idDepartment" class="select-department">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                <select id="customers-idCity" name="idCity" class="select-city">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Nombre Representante'); ?></label>  
                <input id="customers-legal_representative" name="legal_representative" type="text">
                <label><?php echo Yii::t('front', 'Cédula Representante'); ?></label>  
                <input id="customers-id_representative" name="id_representative" type="text">
                <label><?php echo Yii::t('front', 'Comisión'); ?></label>  
                <input id="customers-commission" name="commission" type="number">                
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Documento'); ?></label>  
                <input id="customers-numberDocument" name="numberDocument" type="text">
                <label class="hide" ><?php  echo Yii::t('front', 'Nombre Corto'); ?></label>  
                <input class="hide" id="customers-userName" name="userName" type="text">
                <label><?php echo Yii::t('front', 'Celular'); ?></label>                       
                <input id="customers-mobile" name="mobile" type="number">
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>                       
                <input id="customers-phone" name="phone" type="number">                
                <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
                <input id="customers-address" name="address" type="text">
                <label><?php echo Yii::t('front', 'Notificación'); ?></label>                       
                <select id="customers-notification" name="notification">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Pagina Web'); ?></label>  
                <input id="customers-web" name="web" type="text">
                <label><?php echo Yii::t('front', 'Correo Electrónico Representante') ?> </label>  
                <input id="customers-email_representative" name="email_representative" type="text">
                <label><?php echo Yii::t('front', 'Intereses'); ?></label>  
                <input id="customers-interests" name="interests" type="number" step="any">
                <label><?php echo Yii::t('front', 'Honorarios'); ?></label>  
                <input id="customers-fee" name="fee" type="number">                    
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="row padd_v hide">
            <fieldset class="large-12 medium-12 small-12 columns padding">              
                <label class="sub_title"><?php echo Yii::t('front', 'INFORMACIÓN FISCAL'); ?></label>  
                <hr>
            </fieldset>
        </div> 
        <div class="row hide">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Regimen Tributario'); ?></label>  
                <select id="customers-regime" name="regime"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                        <option value="1"><?php echo Yii::t('front', 'SIMPLIFICADO'); ?></option>    
                        <option value="2"><?php echo Yii::t('front', 'COMUN'); ?></option>    
                        <option value="3"><?php echo Yii::t('front', 'EXTRANJERO'); ?></option>    
                </select>                
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                               
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Regimen Especial'); ?></label>  
                <select id="customers-regime_special" name="regime_special"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>    
                </select>                
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>  
                <input id="customers-regime_special_type" name="regime_special_type" type="text">               
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Gran Retenedor'); ?></label>  
                <select id="customers-great_retainer" name="great_retainer"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Resolución'); ?></label>  
                <input id="customers-great_retainer_number" name="great_retainer_number" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Fecha Resolución'); ?></label>  
                <input id="customers-great_retainer_date" name="great_retainer_date" type="text">               
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Auto Retenedor'); ?></label>  
                <select id="customers-auto_retainer" name="auto_retainer"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>    
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Resolución'); ?></label>  
                <input id="customers-auto_retainer_number" name="auto_retainer_number" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Fecha Resolución'); ?></label>  
                <input id="customers-auto_retainer_date" name="auto_retainer_date" type="text">               
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Código Actividad ICA'); ?></label>  
                <input id="customers-code_ica" name="code_ica" type="text">                  
                <label><?php echo Yii::t('front', 'Código Actividad Económica Renta'); ?></label>  
                <input id="customers-code_rent" name="code_rent" type="text">                  
                <label><?php echo Yii::t('front', 'Concepto de Retención por Renta'); ?></label>  
                <input id="customers-concept_rent" name="concept_rent" type="text">                  
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tarifa del ICA'); ?></label>  
                <input id="customers-ica" name="ica" type="number">               
                <label><?php echo Yii::t('front', 'Tarifa del IVA'); ?></label>  
                <input id="customers-iva" name="iva" type="number">               
                <label><?php echo Yii::t('front', 'Tarifa de Renta'); ?></label>  
                <input id="customers-rent" name="rent" type="number">               
            </fieldset>
        </div>
        <div class="row padd_v hide">
            <fieldset class="large-12 medium-12 small-12 columns padding">             
                <label class="sub_title"><?php echo Yii::t('front', 'TIPO DE ACTIVIDAD'); ?></label>  
                <hr>
                
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo de Actividad'); ?></label>  
                <select id="customers-type_activity" name="type_activity"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>    
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Cual?'); ?></label>  
                <input id="customers-other_activity" name="other_activity" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Actividad Económica'); ?></label>  
                <input id="customers-number_activity" name="number_activity" type="text">               
            </fieldset>
        </div>
        <div class="row padd_v hide">
            <fieldset class="large-12 medium-12 small-12 columns padding">                
                <label class="sub_title"><?php echo Yii::t('front', 'INFORMACIÓN BANCARIA'); ?></label>  
                <hr>
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Entidad Bancaria'); ?></label>  
                <input id="customers-name_bank" name="name_bank" type="text"> 
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Cuenta'); ?></label>  
                <input id="customers-account_number" name="account_number" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo de Cuenta'); ?></label>  
                <input id="customers-account_type" name="account_type" type="text">               
            </fieldset>
            <fieldset class="large-8 medium-8 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Certificación Bancaria'); ?></label>
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                        <input class="" name="support_bank" id="customers-support_bank"  type="file" accept=".pdf">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <div class="m_t_20">                    
                    <p class="padd_all"><a href="#" class="hide" id="customers-support_bank_file" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("front", "Descargar Soporte") ?></a></p> 
                </div>
            </fieldset>
        </div>
        <div class="row padd_v hide">
            <fieldset class="large-12 medium-12 small-12 columns padding">                
                <label class="sub_title"><?php echo Yii::t('front', 'INFORMACIÓN ADICIONAL'); ?></label>  
                <hr>
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Contacto Financiero'); ?></label>  
                <input id="customers-financial_contact" name="financial_contact" type="text">                  
                <label><?php echo Yii::t('front', 'Contacto Compras'); ?></label>  
                <input id="customers-shopping_contact" name="shopping_contact" type="text">                        
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>  
                <input id="customers-financial_phone" name="financial_phone" type="number">               
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>  
                <input id="customers-shopping_phone" name="shopping_phone" type="number">               
            </fieldset>
        </div>
        <div class="modal-footer m_t_20">    
            <input type="hidden" id="customers-idUserProfile" name="idUserProfile" value="7" />
            <input id="customers-id" name="id" type="hidden" value="" />
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Modal Product Customer -->
<section id="product_customer_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'PRODUCTOS'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v" id="more-product">        
        
    </div>
</section>
<!--/ Modal Management -->


