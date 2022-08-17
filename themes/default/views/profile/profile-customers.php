<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2><?php echo Yii::t('front', 'Mi perfil'); ?></h2>
            </div>
        </section>
        <section class="row p_t_70">
            <section class="padding">
                <section class="bg_perfil m_b_20">
                    <!--Datos iniciales-->
                    <section class="row">
                        <div class="dates_user m_t_20">
                            <form id="frmPersonalInfo" action="" class="formweb form-profile-customers" data-id="customers-" enctype="multipart/form-data">
                                <div class="row padd_v">
                                    <fieldset class="large-12 medium-12 small-12 columns padding">                
                                        <label class="sub_title"><?php echo Yii::t('front','DATOS GENERALES'); ?></label>  
                                        <hr>
                                    </fieldset>
                                </div>    
                                <fieldset class="large-6 medium-6 small-12 columns">
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Imagen perfil'); ?></label>
                                        <section class="marco_img_cargar cargar_img">                          
                                            <div class="form-item">        
                                                <div class="file-preview">
                                                    <a href="#" data-position="bottom" data-delay="50" data-tooltip="Editar" class="file-select tooltipped">
                                                        <span>
                                                            <div class="relative">
                                                                <i class="feather feather-image"></i>
                                                                <b><?php echo Yii::t('front', 'Cargar imagen'); ?></b>
                                                            </div>
                                                        </span>
                                                    </a>
                                                    <figure><img src="<?php echo $model->image; ?>" title="<?php echo $model->name; ?>"/></figure>                    
                                                </div>
                                                <input name="image" type="file" class="file2 file-preview" />
                                            </div>
                                        </section>
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Nombre Empresa'); ?></label>  
                                        <input id="customers-name" name="name" type="text" value="<?php echo $model->name; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding hide">
                                        <label><?php echo Yii::t('front', 'Nombre Corto'); ?></label>  
                                        <input id="customers-userName" name="userName" type="text" value="<?php echo $model->userName; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Tipo Documento'); ?></label>  
                                        <select id="customers-idTypeDocument" name="idTypeDocument"  class="">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                            <?php foreach ($typeDocuments as $typeDocument) { ?>                        
                                                <option value="<?php echo $typeDocument->id; ?>" <?php echo ($model->idTypeDocument == $typeDocument->id)? 'selected'  : '';?>><?php echo $typeDocument->name; ?></option>      
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Número de Documento'); ?></label>  
                                        <input id="customers-numberDocument" name="numberDocument" type="text" value="<?php echo $model->numberDocument; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Nombre Contacto'); ?></label>  
                                        <input id="customers-contact" name="contact" type="text" value="<?php echo $model->contact; ?>">
                                    </div>

                                    <div class="large-12 medium-12 small-12 columns padding hide">
                                        <label><?php echo Yii::t('front', 'Nombre Representante'); ?></label>  
                                        <input id="customers-legal_representative" name="legal_representative" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->legal_representative : ''; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding hide">
                                        <label><?php echo Yii::t('front', 'Cédula Representante'); ?></label>  
                                        <input id="customers-id_representative" name="id_representative" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->id_representative : ''; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding hide">
                                        <label><?php echo Yii::t('front', 'Correo Electrónico Email Representante'); ?></label>  
                                        <input id="customers-email_representative" name="email_representative" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->email_representative : ''; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding hide">
                                        <label><?php echo Yii::t('front', 'Pagina Web'); ?></label>  
                                        <input id="customers-web" name="web" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->web : ''; ?>">  
                                    </div> 
                                    <div class="large-12 medium-12 small-12 columns padding">                                     
                                        <label><?php echo Yii::t('front', 'Nueva Contraseña'); ?></label>
                                        <input type="password" id="user-newPassword" name="newPassword"  value="" class="clear">
                                    </div>
                                </fieldset>
                                <fieldset class="large-6 medium-6 small-12 columns">
                                    <div class="large-12 medium-12 small-12 columns padding">                                     
                                        <label><?php echo Yii::t('front', 'País'); ?></label>                                                           
                                        <select id="customers-idCountry" name="idCountry"  class="select-country">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                            <?php foreach ($countries as $country) { ?>                        
                                            <option value="<?php echo $country->id; ?>"><?php echo $country->name;    ?></option>      
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">                                     
                                        <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                                        <select id="customers-idDepartment" name="idDepartment" class="select-department">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                                        </select>
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">                                     
                                        <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                                        <select id="customers-idCity" name="idCity" class="select-city">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                                        </select>
                                    </div>                                    
                                    <div class="large-12 medium-12 small-12 columns padding">                                     
                                        <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
                                        <input id="customers-address" name="address" type="text" value="<?php echo $model->address; ?>">
                                    </div>                                    

                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Celular'); ?></label>                       
                                        <input id="customers-mobile" name="mobile" type="number" value="<?php echo $model->mobile; ?>" >
                                    </div> 
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Teléfono'); ?></label>                       
                                        <input id="customers-phone" name="phone" type="number" value="<?php echo $model->phone; ?>">                
                                    </div> 
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Email'); ?></label>  
                                        <input id="customers-email" name="email" type="text" value="<?php echo $model->email; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Repetir Nueva Contraseña'); ?></label>
                                        <input type="password" id="user-confirmPassword" name="confirmPassword"  value="" class="clear">
                                    </div> 
                                </fieldset>           
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
                                            <option value="3"><?php echo Yii::t('front', 'EXTRANJERO');?></option>    
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
                                            <option value="1"><?php echo Yii::t('front', 'SI'); ?></option>    
                                            <option value="0"><?php echo Yii::t('front', 'NO'); ?></option>    
                                        </select>                
                                    </fieldset>
                                    <fieldset class="large-6 medium-6 small-12 columns padding">                                        
                                        <label><?php echo Yii::t('front', 'Tipo'); ?></label>  
                                        <input id="customers-regime_special_type" name="regime_special_type" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->regime_special_type : ''; ?>">               
                                    </fieldset>
                                </div>
                                <div class="row hide">            
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Gran Retenedor'); ?></label>  
                                        <select id="customers-great_retainer" name="great_retainer"  class="">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                                            <option value="1"><?php echo Yii::t('front', 'SI'); ?></option>    
                                            <option value="0"><?php echo Yii::t('front', 'NO'); ?></option>    
                                        </select>                
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Número de Resolución'); ?></label>  
                                        <input id="customers-great_retainer_number" name="great_retainer_number" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->great_retainer_number : ''; ?>">               
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Fecha Resolución'); ?></label>  
                                        <input id="customers-great_retainer_date" name="great_retainer_date" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->great_retainer_number : ''; ?>">               
                                    </fieldset>
                                </div>
                                <div class="row hide">            
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Auto Retenedor'); ?></label>  
                                        <select id="customers-auto_retainer" name="auto_retainer"  class="">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                                            <option value="1"><?php echo Yii::t('front', 'SI'); ?></option>    
                                            <option value="0"><?php echo Yii::t('front', 'NO'); ?></option>    
                                        </select>                
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Número de Resolución'); ?></label>  
                                        <input id="customers-auto_retainer_number" name="auto_retainer_number" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->auto_retainer_number : ''; ?>">               
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Fecha Resolución'); ?></label>  
                                        <input id="customers-auto_retainer_date" name="auto_retainer_date" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->auto_retainer_date : ''; ?>">               
                                    </fieldset>
                                </div>
                                <div class="row hide">            
                                    <fieldset class="large-6 medium-6 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Código Actividad ICA'); ?></label>  
                                        <input id="customers-code_ica" name="code_ica" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->code_ica : ''; ?>">                  
                                        <label><?php echo Yii::t('front', 'Código Actividad Económica Renta'); ?></label>  
                                        <input id="customers-code_rent" name="code_rent" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->code_rent : ''; ?>">                  
                                        <label><?php echo Yii::t('front', 'Concepto de Retención por Renta'); ?></label>  
                                        <input id="customers-concept_rent" name="concept_rent" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->concept_rent : ''; ?>">                  
                                    </fieldset>
                                    <fieldset class="large-6 medium-6 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Tarifa del ICA'); ?></label>  
                                        <input id="customers-ica" name="ica" type="number" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->ica : ''; ?>">               
                                        <label><?php echo Yii::t('front', 'Tarifa del IVA'); ?></label>  
                                        <input id="customers-iva" name="iva" type="number" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->iva : ''; ?>">               
                                        <label><?php echo Yii::t('front', 'Tarifa de Renta'); ?></label>  
                                        <input id="customers-rent" name="rent" type="number" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->rent : ''; ?>">               
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
                                            <option value="1"><?php echo Yii::t('front', 'SI'); ?></option>    
                                            <option value="0"><?php echo Yii::t('front', 'NO'); ?></option>    
                                        </select>                
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Cual?'); ?></label>  
                                        <input id="customers-other_activity" name="other_activity" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->other_activity : ''; ?>">               
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Número de Actividad Económica'); ?></label>  
                                        <input id="customers-number_activity" name="number_activity" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->number_activity : ''; ?>">               
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
                                        <input id="customers-name_bank" name="name_bank" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->name_bank : ''; ?>"> 
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Número de Cuenta'); ?></label>  
                                        <input id="customers-account_number" name="account_number" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->account_number : ''; ?>">                
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Tipo de Cuenta'); ?></label>  
                                        <input id="customers-account_type" name="account_type" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->account_type : ''; ?>">               
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
                                        <input id="customers-financial_contact" name="financial_contact" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->financial_contact : ''; ?>">                   
                                        <label><?php echo Yii::t('front', 'Contacto Compras'); ?></label>  
                                        <input id="customers-shopping_contact" name="shopping_contact" type="text" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->shopping_contact : ''; ?>">                        
                                    </fieldset>
                                    <fieldset class="large-6 medium-6 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Teléfono'); ?></label>  
                                        <input id="customers-financial_phone" name="financial_phone" type="number" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->financial_phone : ''; ?>">              
                                        <label><?php echo Yii::t('front', 'Teléfono'); ?></label>  
                                        <input id="customers-shopping_phone" name="shopping_phone" type="number" value="<?php echo ($model->usersInfos != null)? $model->usersInfos[0]->shopping_phone : ''; ?>">               
                                    </fieldset>
                                </div>
                                <div class="clear"></div>
                                <input id="customers-is_internal" type="hidden" name="is_internal" value="0" />
                                <div class="txt_right block padding m_t_10 m_b_20">
                                    <button id="btnSaveInfo" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'Guardar'); ?></button>
                                </div>
                                <div class="clear"></div>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </section>
                </section>    
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/profile.min.js', CClientScript::POS_END);
$script = '$("#customers-idCountry").val("'.$model->idCountry.'").trigger("change");        
        setTimeout(function(){        
            $("#customers-idDepartment").val("'.$model->idDepartment.'").trigger("change");                            
            setTimeout(function(){            
                $("#customers-idCity").val("'.$model->idCity.'").trigger("change");                
            },500);
        },1000);';

if($model->usersInfos != null){
    $script .= '$("#customers-regime").val("'.$model->usersInfos[0]->regime.'").trigger("change");
                $("#customers-regime_special").val("'.$model->usersInfos[0]->regime_special.'").trigger("change");
                $("#customers-great_retainer").val("'.$model->usersInfos[0]->great_retainer.'").trigger("change");
                $("#customers-auto_retainer").val("'.$model->usersInfos[0]->auto_retainer.'").trigger("change");
                $("#customers-type_activity").val("'.$model->usersInfos[0]->type_activity.'").trigger("change");
            ';
}


    Yii::app()->clientScript->registerScript("edit_customer",'
        
    $(document).ready(function(){
        
        '.$script.'
    });
            
    ',
     CClientScript::POS_END
    );