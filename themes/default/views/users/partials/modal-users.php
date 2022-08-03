<!-- Modal New User -->
<section id="new_coordinators_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO COORDINADOR'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-coordinators" data-id="users-">
        <div class="row padd_v">
            <fieldset class="large-12 medium-12 small-12 columns padding">                
                <label class="sub_title"><?php echo Yii::t('front', 'DATOS GENERALES'); ?></label>  
                <hr>
            </fieldset>
        </div>    
        <div class="row">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo Documento'); ?></label>  
                <select id="users-idTypeDocument" name="idTypeDocument"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                    <?php foreach ($typeDocument as $type) { ?>                        
                        <option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>      
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front', 'Nombre Empresa'); ?></label>  
                <input id="users-name" name="name" type="text">
                <label><?php echo Yii::t('front', 'Nombre Contacto'); ?></label>  
                <input id="users-contact" name="contact" type="text">
                <label><?php echo Yii::t('front','Correo Electrónico'); ?></label>  
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
                <label class="hide"><?php echo Yii::t('front', 'Nombre Representante'); ?></label>  
                <input class="hide" id="users-legal_representative" name="legal_representative" type="text">
                <label class="hide"><?php echo Yii::t('front', 'Cédula Representante'); ?></label>  
                <input class="hide" id="users-id_representative" name="id_representative" type="text">                                  
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Documento'); ?></label>  
                <input id="users-numberDocument" name="numberDocument" type="text">
                <label ><?php  echo Yii::t('front', 'Nombre Corto'); ?></label>  
                <input id="users-userName" name="userName" type="text">
                <label><?php echo Yii::t('front', 'Celular'); ?></label>                       
                <input id="users-mobile" name="mobile" type="number">
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>                       
                <input id="users-phone" name="phone" type="number">                
                <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
                <input id="users-address" name="address" type="text">
                <label><?php echo Yii::t('front', 'Notificación'); ?></label>                       
                <select id="users-notification" name="notification">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Perfil'); ?></label>                       
                <select id="users-idUserProfile" name="idUserProfile" class="select-userProfile">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option> 
                    <?php foreach ($coodinators as $coordinator) { ?>                        
                        <option value="<?php echo $coordinator->id; ?>"><?php echo $coordinator->name; ?></option>      
                    <?php } ?>
                </select> 
                <label class="hide"><?php echo Yii::t('front', 'Pagina Web'); ?></label>  
                <input class="hide" id="users-web" name="web" type="text">
                <label class="hide"><?php echo Yii::t('front', 'Correo Electrónico Representante') ?> </label>  
                <input class="hide" id="users-email_representative" name="email_representative" type="text">
                <div class="select-coordinator">
                    <label><?php echo Yii::t('front', 'Coordinador'); ?></label>                       
                    <select id="users-idCoordinator" name="idCoordinator">
                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    </select>
                </div>   
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
                <select id="users-regime" name="regime"  class="">
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
                <select id="users-regime_special" name="regime_special"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>    
                </select>                
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>  
                <input id="users-regime_special_type" name="regime_special_type" type="text">               
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Gran Retenedor'); ?></label>  
                <select id="users-great_retainer" name="great_retainer"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Resolución'); ?></label>  
                <input id="users-great_retainer_number" name="great_retainer_number" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Fecha Resolución'); ?></label>  
                <input id="users-great_retainer_date" name="great_retainer_date" type="text">               
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Auto Retenedor'); ?></label>  
                <select id="users-auto_retainer" name="auto_retainer"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>    
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Resolución'); ?></label>  
                <input id="users-auto_retainer_number" name="auto_retainer_number" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Fecha Resolución'); ?></label>  
                <input id="users-auto_retainer_date" name="auto_retainer_date" type="text">               
            </fieldset>
        </div>
        <div class="row hide">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Código Actividad ICA'); ?></label>  
                <input id="users-code_ica" name="code_ica" type="text">                  
                <label><?php echo Yii::t('front', 'Código Actividad Económica Renta'); ?></label>  
                <input id="users-code_rent" name="code_rent" type="text">                  
                <label><?php echo Yii::t('front', 'Concepto de Retención por Renta'); ?></label>  
                <input id="users-concept_rent" name="concept_rent" type="text">                  
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tarifa del ICA'); ?></label>  
                <input id="users-ica" name="ica" type="number">               
                <label><?php echo Yii::t('front', 'Tarifa del IVA'); ?></label>  
                <input id="users-iva" name="iva" type="number">               
                <label><?php echo Yii::t('front', 'Tarifa de Renta'); ?></label>  
                <input id="users-rent" name="rent" type="number">               
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
                <select id="users-type_activity" name="type_activity"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                    <option value="0"><?php echo Yii::t('front', 'No'); ?></option>            
                    <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>    
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Cual?'); ?></label>  
                <input id="users-other_activity" name="other_activity" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Actividad Económica'); ?></label>  
                <input id="users-number_activity" name="number_activity" type="text">               
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
                <input id="users-name_bank" name="name_bank" type="text"> 
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número de Cuenta'); ?></label>  
                <input id="users-account_number" name="account_number" type="text">               
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo de Cuenta'); ?></label>  
                <input id="users-account_type" name="account_type" type="text">               
            </fieldset>
            <fieldset class="large-8 medium-8 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Certificación Bancaria'); ?></label>
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                        <input class="" name="support_bank" id="users-support_bank"  type="file" accept=".pdf">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <div class="m_t_20">                    
                    <p class="padd_all"><a href="#" class="hide" id="users-support_bank_file" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("front", "Descargar Soporte") ?></a></p> 
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
                <input id="users-financial_contact" name="financial_contact" type="text">                  
                <label><?php echo Yii::t('front', 'Contacto Compras'); ?></label>  
                <input id="users-shopping_contact" name="shopping_contact" type="text">                        
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>  
                <input id="users-financial_phone" name="financial_phone" type="number">               
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>  
                <input id="users-shopping_phone" name="shopping_phone" type="number">               
            </fieldset>
        </div>
        <div class="modal-footer m_t_20">    
            <input id="users-id" name="id" type="hidden" value="" />
            <input id="users-is_internal" name="is_internal" type="hidden" value="<?php echo $id; ?>" />
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Modal List Advisers -->
<section id="new_adviser_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'ABOGADOS') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v">            
        <section class="padd_v">
            <div class="row"> 
                <article id="" class="block">                              
                    <div class="clear"></div>
                    <section class="padding m_t_20">
                        <div class="clearfix">                                        
                            <table class="bordered responsive-table">
                                <thead>
                                    <tr class="backgroung-table-4">
                                        <th class="txt_center"><?php echo Yii::t('front', 'PERFIL'); ?></th>
                                        <th class="txt_center"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
                                        <th class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>
                                        <th class="txt_center"><?php echo Yii::t('front', 'EMAIL2'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="adviserCoordinator">

                                </tbody>
                            </table>                                           
                        </div>
                        <div class="clear"></div>
                    </section>
                </article>
            </div>
        </section>            
        <div class="clear"></div>
    </div>
    <div class="modal-footer">    
        <input id="users-id" name="id" type="hidden" value="" />
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </div>
</section>

