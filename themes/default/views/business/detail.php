<?php 
    $call = '';
    $this->renderPartial('/layouts/partials/side-nav-business', array('business' => $business, 'call' => $call));
?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= $user->name; ?></h2> 
                <div class="acions_head">
                    <!--<span class="timer"><b><?php echo Yii::t('front', 'Tiempo'); ?>:</b> <span id ="timer"></span></span>-->
                    <div class="dates_all topBarJuridico">
                        <ul class="filter_views" style="margin: 0 0 0px !important;">
                            <li class="backSite hide">
                                <a href="#" data-url="" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>"  onClick="history.go(-1); return false;">
                                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
                                </a>
                            </li>
                        </ul>                  
                    </div>
                </div>
            </div>            
        </section>
        <section class="row p_t_80">
            <section class="padding animated fadeInUp">         
                <section class="panelBG m_b_20">
                    <div class="row block padd_v">
                        <div class="form_register formweb"> 
                            <div class="clear"></div>                            
                            <fieldset class="large-12 medium-12 small-12 columns padding">
                                <!-- border_form -->
                                <div class="padd_v m_b_10">
                                        <fieldset class="large-12 medium-12 small-12 columns padding">
                                            <div class="modal-header row p_b_20">
                                                <h1><?php echo Yii::t('front', 'GESTIÓN COMERCIAL'); ?></h1>
                                            </div>
                                        </fieldset>
                                    <?php 
                                     $this->renderPartial('/business/partials/form-tasks', array('actions' => $actions,'task' => $task,'type' =>'i','states' => $businessStates,'user' => $user,'business' => $business));
                                    ?>                                        
                                </div>
                            </fieldset>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>                       
                <!--Tabs-->
                <div class="block">
                    <ul class="tabs tab_cartera">
                        <li class="tab" style="width: 22% !important;"><a href="#datos_personales"><i class="feather feather-user"></i><?php echo Yii::t('front', 'DATOS DEL CLIENTE'); ?></a></li>
                        <li class="tab" style="width: 22% !important;"><a href="#datos_comentarios"><i class="feather feather-settings"></i><?php echo Yii::t('front', 'HISTORIAL DE GESTIÓN'); ?></a></li>
                        <li class="tab" style="width: 22% !important;"><a href="#historia_gastos"><i class="feather feather-pie-chart"></i><?php echo Yii::t('front', 'GASTOS DE GESTIÓN'); ?></a></li>
                        <li class="tab" style="width: 22% !important;"><a href="#tasks"><i class="feather feather-list"></i><?php echo Yii::t('front', 'TAREAS'); ?></a></li>
                    </ul>
                </div>                          
                <section class="panelBG m_b_20">
                    <section class="padd_v">
                        <div class="row">  
                            <!--Tab 1-->
                            <article id="datos_personales" class="block">
                                <form class="formweb form-business" data-id="business-">
                                    <fieldset class="large-6 medium-6 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Nombre / Razón Social'); ?></label>  
                                        <input id="business-name" name="name" type="text" value="<?php echo $user->name; ?>">
                                        <label><?php echo Yii::t('front', 'CC / NIT'); ?></label>  
                                        <input id="business-numberDocument" name="numberDocument" type="text" value="<?php echo $user->numberDocument; ?>">
                                        <label><?php echo Yii::t('front', 'Nombre Contacto'); ?></label>  
                                        <input id="business-contact" name="contact" type="text" value="<?php echo $user->contact; ?>">
                                        <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>  
                                        <input id="business-email" name="email" type="text" value="<?php echo $user->email; ?>">                         
                                        <label><?php echo Yii::t('front', 'Celular'); ?></label>                       
                                            <div class="phone-input" data-idUser="<?php echo $user->id; ?>" data-number="<?php echo $user->mobile; ?>" data-phone="<?php echo ($isMobile)? 'tel:+57'.$user->mobile : '#click_to_call'; ?>">               
                                                <input id="business-mobile" name="mobile" pattern="[0-9]{1,10}" type="text" value="<?php echo $user->mobile; ?>">
                                            </div>
                                        <label><?php echo Yii::t('front', 'Teléfono'); ?></label>                       
                                            <div class="phone-input" data-idUser="<?php echo $user->id; ?>" data-number="<?php echo $user->getIndicativePhone().$user->phone; ?>" data-phone="<?php echo ($isMobile)? 'tel:+57'.$user->getIndicativePhone().$user->phone : '#click_to_call'; ?>">               
                                                <input id="business-phone" name="phone" pattern="[0-9]{1,7}" type="text" value="<?php echo $user->phone; ?>">                                                   
                                            </div>
                                        <label><?php echo Yii::t('front', 'Estado'); ?></label>                       
                                        <select id="business-idUserState" name="idUserState">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                            <?php foreach ($businessStates as $businessState) { ?>                        
                                                <option value="<?php echo $businessState->id; ?>"><?php echo $businessState->name; ?></option>      
                                            <?php } ?>
                                        </select>
                                    </fieldset>
                                    <fieldset class="large-6 medium-6 small-12 columns padding">                
                                        <label><?php echo Yii::t('front', 'País'); ?></label>                       
                                        <select id="business-idCountry" name="idCountry"  class="select-country">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                            <?php foreach ($countries as $country) { ?>                        
                                                <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>      
                                            <?php } ?>
                                        </select>
                                        <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                                        <select id="business-idDepartment" name="idDepartment" class="select-department">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                                        </select>
                                        <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                                        <select id="business-idCity" name="idCity" class="select-city">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                                        </select>       
                                        <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
                                        <input id="business-address" name="address" type="text" value="<?php echo $user->address; ?>">
                                        <label><?php echo Yii::t('front', 'Valor de la cartera'); ?></label>                       
                                        <input id="business-value" name="value" type="number" value="<?php echo ($user->usersBusinesses[0]->value != null)? $user->usersBusinesses[0]->value : ''; ?>">
                                        <label><?php echo Yii::t('front', 'Fecha de Cierre Prevista'); ?></label>    
                                        <div class="fecha">
                                            <input type="date" class="calendar" id="business-date" name="date_close" value="<?php echo ($user->usersBusinesses[0]->date_close != null)? $user->usersBusinesses[0]->date_close : ''; ?>">
                                        </div> 
                                        <label><?php echo Yii::t('front', 'Ejecutivo'); ?></label>                       
                                        <select id="business-idBusinessAdvisor" name="idBusinessAdvisor">
                                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                            <?php foreach ($businessAdvisors as $businessAdvisor) { ?>                        
                                                <option value="<?php echo $businessAdvisor->id; ?>"><?php echo $businessAdvisor->name; ?></option>      
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="idUserProfile" value="8" />
                                        <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
                                        <input type="hidden" name="is_internal" value="0" />
                                    </fieldset>
                                    <fieldset class="large-12 medium-12 small-12 columns padd_v">  
                                        <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                            <div class="txt_center block padding ">
                                                <button id="btnSaveInfo" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'GUARDAR'); ?></button>
                                            </div>
                                        <?php } ?>
                                    </fieldset>
                                </form>
                                <div class="clear"></div>
                                <!--Datos acordeon-->
                            <section class="padd_all m_t_10">
                                <ul class="tabs tab_cartera">
                                    <li class="tab" style="width: 19% !important;"><a href="#user_phone"><i class="feather feather-phone"></i><?php echo Yii::t('front', 'TELÉFONOS'); ?></a></li>
                                    <li class="tab hide" style="width: 19% !important;"><a href="#user_address"><i class="feather feather-map-pin"></i><?php echo Yii::t('front', 'DIRECCIONES'); ?></a></li>                                        
                                    <li class="tab" style="width: 19% !important;"><a href="#user_email"><i class="feather feather-mail"></i><?php echo Yii::t('front', 'CORREOS'); ?></a></li>
                                </ul>
                                <section class="">
                                    <div class="row">
                                        <!--Tab 1-->
                                        <article id="user_phone" class="block border-tab">
                                            <div class="clearfix content-scroll-x">
                                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_phone_modal" class="tooltipped modal_clic btn-disabled" id="btnNewPhone" data-idUser="<?php echo $business->idUser; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php } ?>
                                                <table class="bordered">
                                                    <thead>
                                                        <tr class="backgroung-table-4">
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'CLASE'); ?></th>
                                                            <!--<th class="txt_center" width="20%"><?php echo Yii::t('front', 'UBICACIÓN'); ?></th>-->
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'NÚMERO'); ?></th>
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'COMENTARIO'); ?></th>
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                            <th class="txt_center" width="15%"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="userPhones-<?php echo $business->idUser; ?>">
                                                        <?php
                                                        if (count($demographicPhones) > 0) {
                                                            foreach ($demographicPhones as $demographicPhone) {
                                                                $this->renderPartial('/business/partials/item-phone', array('model' => $demographicPhone));
                                                            }
                                                        }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div>         
                                        </article>
                                        <!--Tab 2-->
                                        <article id="user_email" class="block border-tab">
                                            <div class="clearfix content-scroll-x">
                                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_correo_modal" class="tooltipped modal_clic btn-disabled" id="btnNewEmail" data-idUser="<?php echo $business->idUser; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php } ?>
                                                <div class="clear"></div>
                                                <table class="bordered">
                                                    <thead>
                                                        <tr class="backgroung-table-4">
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'CORREO'); ?></th>
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'COMENTARIO'); ?></th>
                                                            <th class="txt_center" width="17%"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                            <th class="txt_center" width="15%"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="userEmail-<?php echo $business->idUser; ?>">
                                                    <?php
                                                    if (count($demographicEmail) > 0) {
                                                        foreach ($demographicEmail as $demographEmail) {
                                                            $this->renderPartial('/business/partials/item-email', array('model' => $demographEmail));
                                                        }
                                                    }
                                                    ?>                                  
                                                    </tbody>
                                                </table>
                                            </div>
                                        </article>
                                        <!--Tab 3-->
                                        <article id="user_address" class="block border-tab">
                                            <div class="clearfix content-scroll-x">
                                            <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_address_modal" class="tooltipped modal_clic btn-disabled" id="btnNewAddress" data-idUser="<?php echo $business->idUser; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                            <?php } ?>
                                                <div class="clear"></div>
                                                <table class="bordered">
                                                    <thead>
                                                        <tr class="backgroung-table-4">
                                                            <th class="txt_center" width="14%"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                            <th class="txt_center" width="14%"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
                                                            <th class="txt_center" width="14%"><?php echo Yii::t('front', 'BARRIO'); ?></th>
                                                            <th class="txt_center" width="14%"><?php echo Yii::t('front', 'DIRECCIÓN'); ?></th>
                                                            <th class="txt_center" width="14%"><?php echo Yii::t('front', 'COMENTARIO'); ?></th>
                                                            <th class="txt_center" width="14%"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                            <th class="txt_center" width="16%"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="userAddress-<?php echo $business->idUser; ?>">
                                                    <?php
                                                    if (count($demographicAddresses) > 0) {
                                                        foreach ($demographicAddresses as $demographicAddress) {
                                                            $this->renderPartial('/business/partials/item-address', array('model' => $demographicAddress));
                                                        }
                                                    }
                                                    ?>                                  
                                                    </tbody>
                                                </table>
                                            </div>
                                        </article>
                                    </div>
                                </section>
                            </section>
                            <!--Fin Datos acordeon-->
                                <div class="clear"></div> 
                            </article>
                            <!--Tab 4-->
                            <article id="datos_comentarios" class="block">
                                <!--Datos acordeon-->

                                <div class="clear"></div>
                                 <section class="padding">  
                                    <div class="dates_all topBarJuridico hide">
                                        <ul class="filter_views">                                                        
                                            <li><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>                                                                                
                                        </ul>                  
                                    </div>
                                    <div class="formweb content_filter_advance"> 
                                        <div class="clear"></div>          
                                        <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
                                            <form class="formweb form-filter-tab" id="form-filter-management" data-content="content-management" data-url="business/managementPage" enctype="multipart/form-data"> 
                                                <fieldset class="large-6 medium-6 small-12 columns padding">
                                                    <label><?php echo Yii::t('front', 'ACCIÓN'); ?></label>
                                                    <select name="idTasksAction" id="form-filter-management-idTasksAction" class="">
                                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                        <?php foreach ($actionsManagements as $actionsManagement) { ?>
                                                            <option value="<?php echo $actionsManagement->idTasksAction; ?>"><?php echo Yii::t('front', $actionsManagement->management); ?></option>
                                                        <?php } ?>
                                                    </select>                                                                    
                                                </fieldset>
                                                <fieldset class="large-6 medium-6 small-12 columns padding">
                                                    <div class="large-6 medium-6 small-6 columns" style="padding-right: 20px;">
                                                        <label><?php echo Yii::t('front', 'Desde'); ?></label>
                                                        <div class="fecha">
                                                            <input name="from" id="form-filter-management-from" type="text" class="calendar_from" value="">
                                                        </div>                                                                        
                                                    </div>
                                                    <div class="large-6 medium-6 small-6 columns">
                                                        <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                                                        <div class="fecha">
                                                            <input name="to" id="form-filter-managemente-to" type="text" class="calendar_to" value="">
                                                        </div>                                                                        
                                                    </div>
                                                </fieldset>
                                                <fieldset class="large-4 medium-4 small-12 columns padding hide">
                                                    <label><?php echo Yii::t('front', 'Comentarios'); ?></label>
                                                    <input name="comments" id="form-filter-management-comments" type="text" class="" value="">                    
                                                </fieldset>
                                                <input type="hidden" name="idUsersBusiness" value="<?php echo $business->id; ?>" />
                                                <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                                                    <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                                                </fieldset> 
                                            </form>
                                        </fieldset>
                                    </div> 
                                    <div class="clear"></div> 
                                    <div id="content-management content-scroll-x">
                                        <?php
                                        $this->renderPartial('/business/partials/content-management', array('business' => $business, 'managements' => $managements, 'pagesManagement' => $pagesManagement, 'actionsManagements' => $actionsManagements));
                                        ?>
                                    </div>  
                                    <!-- -->
                                </section>                              
                            </article>
                            <!--Tab 5-->
                            <article id="historia_gastos" class="block">
                                <div class="dates_all topBarJuridico">
                                    <ul class="filter_views">                                                                                                                    
                                        <li><a href="#new_spending_business_modal" class="tooltipped modal_clic btn-spending btn-disabled" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php //echo Yii::t('front', 'Nuevo'); ?></a></li>
                                    </ul>                  
                                </div>
                                <div class="clear"></div>
                                <section class="padding m_t_20">
                                    <div class="clearfix content-scroll-x">                                        
                                        <table class="bordered border-table" style="border: 1px solid #a5a5a5 !important;">                                            
                                            <thead>
                                                <tr class="backgroung-table-4 ">
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
<!--                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'UBICACIÓN'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'COMENTARIO'); ?></th>
                                                    <th width="20%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>-->
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'SOPORTE'); ?></th>
                                                </tr>
                                            </thead
                                            <tbody id="businessSpending-<?php echo $business->id; ?>">
                                                <?php
                                                if ( isset($spendings) && count($spendings) > 0) {
                                                    foreach ($spendings as $spending) {
                                                        $this->renderPartial('/business/partials/item-spending', array('model' => $spending));
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="clear"></div>                                     
                                </section>
                                <!--Fin Datos acordeon-->
                                <div class="clear"></div>
                            </article>
                        </div>                  
                        <div class="clear"></div>
                    </section>                
                </section>
                <!--Fin Tabs--> 
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php



$js = ' $("#business-idCountry").val('.$user->idCountry.').trigger("change");
            setTimeout(function () {
                $("#business-idDepartment").val('.$user->idDepartment.').trigger("change");                
                setTimeout(function () {
                    $("#business-idCity").val('.$user->idCity.').trigger("change");
                }, 300);                
            }, 500);';

if($user->usersBusinesses[0]->idBusinessAdvisor != null){
    $js .= '$("#business-idBusinessAdvisor").val('.$user->usersBusinesses[0]->idBusinessAdvisor.').trigger("change");
            $("#business-idUserState").val('.$user->usersBusinesses[0]->idUserState.').trigger("change");        ';
    
}

$idBusinessAdvisor = '';
$hide = false;
if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisorBusiness'])){
    $idBusinessAdvisor = Yii::app()->user->getId();
    $hide = true;
}

if($hide){        
    $js .= '$("#business-idBusinessAdvisor").css("pointer-events","none");';        
}

Yii::app()->clientScript->registerScript("business_detail_js", '
   $(document).ready(function(){    
    ' . $js . '
   });
   
', CClientScript::POS_END
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/business.min.js', CClientScript::POS_END);
$this->renderPartial("/business/partials/modal_business_detail", array('countries' => $countries,
    'spendingTypes' => $spendingTypes, 
    'business' => $business,
    'businessStates' => $businessStates,
    'phones' => $phones,
    'phonesSMS' => $phonesSMS,
    'emailEmails' => $emailEmails,
    'typeReferences' => $typeReferences,
    'phoneClasses' => $phoneClasses
    ));
