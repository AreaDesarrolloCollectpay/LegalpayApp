<?php  //advisers
if (isset($historic) && !$historic) {
    $this->renderPartial('/layouts/partials/side-nav', array('debtor' => $debtor, 'task' => in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers']), 'call' => $call, 'historic' => (isset($historic)) ? $historic : false));
}
$edit = true ; //(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) ? true : false;
?>
   
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= $debt->name; ?><?php //echo ($debt->accountNumber != '')? ' - '.$debt->accountNumber : '';  ?></h2> 
                <div class="acions_head">
                    <!--<span class="timer"><b><?php echo Yii::t('front', 'Tiempo'); ?>:</b> <span id ="timer"></span></span>-->
                    <!--<a href="#" class="back" onClick="history.go(-1); return false;"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?></a>-->
                    <div class="dates_all topBarJuridico">
                        <ul class="filter_views" style="margin: 0 0 0px !important;">
                            <li class="backSite hide">
                                <a href="#" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>"  onClick="history.go(-1);
                                        return false;">
                                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
                                </a>
                            </li>
                        </ul>                  
                    </div>
                </div>                
                <div class="right hide-ml">
                    <?php
                    foreach ($mlModels as $mlModel) {
                        $mlModelD = Controller::getModelCluster($mlModel->id, '', $debtor->id);
                        if ($mlModelD['status'] == 'success') {
                            ?>                           
                            <div class="porcent_hv hide <?php echo ($debtor->is_legal) ? '' : 'hide'; ?>">
                                <div class="relative">
                                    <div class="circle-porcent">                            
                                        <div class="" data-percent="" style="margin-top: 8px;">
                                            <span class="num">
                                                <strong class=""><?php echo $mlModelD['cluster']; ?></strong>
                                            </span>
                                            <h4 class="getChartModel" data-type="modal"><?php echo $mlModelD['model']; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                    <div class="porcent_hv">
                        <div class="relative">
                            <div class="circle-porcent">                            
                                <div class="" data-percent="" style="margin-top: 8px;">
                                    <span class="num">
                                        <strong class="counter"><?= round($demographicsPorc, 1); ?></strong><strong>%</strong>
                                    </span>
                                    <h4 class="getChartModel" data-type="modal"><?php echo Yii::t('front', 'Investigación'); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php if (!$historic) { ?>
                        <div class="porcent_hv">
                            <div class="relative">
                                <div class="circle-porcent">                            
                                    <div class="" data-percent="" style="margin-top: 8px;">
                                        <span class="num">
                                            <strong class="counter"><?= round(rand(1, 30), 1); ?></strong><strong>%</strong>
                                        </span>
                                        <h4 class="getChartModel" data-type="modal"><?php echo Yii::t('front', 'Diferenciación'); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="porcent_hv">
                            <div class="relative">
                                <div class="circle-porcent">                            
                                    <div class="" data-percent="" style="margin-top: 8px;">
                                        <span class="num">
                                            <strong class="counter"><?= round(rand(15, 60), 1); ?></strong><strong>%</strong>
                                        </span>
                                        <h4><?php echo Yii::t('front', 'Probabilidad'); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if (($debtorObli != null) && ($debtorObli->is_legal == 0 || $debtorObli->idTypeProcess == 2 )) { ?>
                        <div class="porcent_hv">
                            <div class="relative">
                                <div class="circle-porcent">
                                    <?php
                                    $recoveryPorc = (isset($othersValues['model']->capital)) ? ((((isset($othersValues['model']->payments)) ? $othersValues['model']->payments : 0) * 100) / $othersValues['model']->capital) : 0;
                                    ?>
                                    <div class="" data-percent="" style="margin-top: 8px;">
                                        <span class="num">
                                            <strong class="counter"><?= round($recoveryPorc, 1); ?></strong><strong>%</strong>
                                        </span>
                                        <h4><?php echo Yii::t('front', 'Recuperación'); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!--                    <div class="porcent_hv">
                                            <div class="relative">
                                                <div class="circle-porcent">
                                                <?php
                                                $recoveryPorc = (isset($othersValues['model']->capital)) ? ((((isset($othersValues['model']->payments)) ? $othersValues['model']->payments : 0) * 100) / $othersValues['model']->capital) : 0;
                                                ?>
                                                    <div class="chartHV" data-percent="<?= round($recoveryPorc, 1); ?>">
                                                        <span class="num">
                                                            <strong class="counter"><?= round($recoveryPorc, 1); ?></strong><strong>%</strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <h4><?php echo Yii::t('front', 'Recuperación'); ?></h4>
                                            </div>
                                        </div>-->
                </div>
                <p><?= $debtor->customer; ?></p>
            </div>
            </div>
        </section>
        <section class="row p_t_80">
            <section class="padding animated fadeInUp">
                <section class="list_dash">
                    <!-- Tareas  -->                
                    <?php
                    if (!$historic) {
                        $width = (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'], Yii::app()->params['coordinators'], Yii::app()->params['customers'],Yii::app()->params['admin']))) ? 6 : 7;
                        if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'], Yii::app()->params['coordinators'], Yii::app()->params['customers'],Yii::app()->params['admin']))) {
                            ?>
                            <div class="large-6 medium-6 small-12 columns" style="<?php echo (Yii::app()->user->getState('ml') != null && Yii::app()->user->getState('ml') == 0) ? '' : 'padding-right: 5px;'; ?>">
                                <div class="row white border-tab border_content">
                                    <div class="form_register formweb"> 
                                        <div class="clear"></div>                            
                                        <fieldset class="large-12 medium-12 small-12 columns padding m_b_10">
                                            <!-- border_form -->
                                            <fieldset class="large-12 medium-12 small-12 columns padding m_t_5">
                                                <div class="modal-header row p_b_10">
                                                    <h1><?php echo Yii::t('front', ($debtor->is_legal) ? 'GESTIÓN JURÍDICA' : 'GESTIÓN OPERATIVA'); ?></h1>
                                                </div>
                                            </fieldset>
                                        <?php  $this->renderPartial('/wallet/partials/form-tasks', array('actions' => $actions, 'debt' => $debt, 'debtor' => $debtor, 'type' => 'i', 'task' => $task, 'status' => $status, 'tree' => $tree)); ?>                                        
                                        </fieldset>
                                        <div class="m_t_10"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Tareas -->
                        <?php } ?>
                        <!--Datos iniciales-->                    
                        <div class="large-<?php echo $width; ?> medium-<?php echo $width; ?> small-12 columns" style="padding-left: 5px;">
                            <?php $this->renderPartial('/wallet/partials/state_' . $debtor->is_legal, array('creditModalities' => $creditModalities, 'status' => $status, 'ageDebts' => $ageDebts, 'debt' => $debt, 'debtor' => $debtor, 'debtorObli' => $debtorObli, 'tree' => $tree, 'officeLegals' => $officeLegals, 'categoryLegals' => $categoryLegals, 'mlModels' => $mlModels, 'typeProcess' => $typeProcess)) ?>                                                            
                        </div>
                        <!--Fin Datos iniciales-->
                        <?php } ?>
                </section>                
                <!--Tabs-->
                <div class="block m_t_10">
                    <ul class="tabs tab_cartera">
                        <?php if ($debtorObli->is_legal == 0 || $debtorObli->idTypeProcess == 2) { ?>
                            <li class="tab"><a class="tab-internal" href="#datos_financieros"><i class="feather feather-bar-chart-2"></i><?php echo Yii::t('front', 'DATOS FINANCIEROS'); ?></a></li>
                        <?php } ?>
                        <li class="tab"><a class="tab-internal" href="#datos_personales"><i class="feather feather-user"></i><?php echo Yii::t('front', ($debtor->is_legal) ? 'INFORMACIÓN DEL DEMANDADO' : 'DATOS DEMOGRÁFICOS'); ?></a></li>
                        <li class="tab"><a class="tab-internal" href="#historia_gestion"><i class="feather feather-settings"></i><?php echo Yii::t('front', 'HISTORIAL DE GESTIÓN'); ?></a></li>
                        <li class="tab"><a class="tab-internal" href="#historia_pagos"><i class="feather feather-credit-card"></i><?php echo Yii::t('front', 'HISTORIAL DE PAGOS'); ?></a></li>
                        <li class="tab"><a class="tab-internal" href="#historia_gastos"><i class="feather feather-pie-chart"></i><?php echo Yii::t('front', 'GASTOS DE GESTIÓN'); ?></a></li>
                    </ul>
                </div>                          
                <section class="panelBG m_b_20">
                    <section class="">
                        <!--Tab 1-->
                        <article id="datos_personales" class="block m_t_20">
                            <form id="frmPersonalInfo" action="" class="formweb form-debtors" data-id="debtor-">
                                <fieldset class="large-4 medium-4 small-12 columns padding">
                                    <label><?php echo Yii::t('front', 'Nombre / Razón Social'); ?></label>
                                    <input type="text" id="debtor-name" name="name" placeholder="<?= $debtor->name; ?>" value="<?= $debtor->name; ?>" readonly>                                        
                                    <label><?php echo Yii::t('front', 'País'); ?></label>
                                    <select id="debtor-idCountry" name="idCountry"  class="select-country select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($countries as $country) { ?>
                                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                        <?php } ?>
                                    </select>                                         
                                    <label><?php echo Yii::t('front', 'Dirección'); ?></label>
                                    <div class="marker-input" data-idDebtor="<?php echo $debt->id; ?>" id="btnGMaps">               
                                        <input type="text" id="debtor-address" name="address" value="<?= $debt->address; ?>" class="input-disabled">
                                    </div>
                                    <label><?php echo Yii::t('front', 'Celular'); ?></label>
                                    <div class="phone-input" data-idDebtor="<?php echo $debt->id; ?>" data-number="<?php echo $debt->mobile; ?>" data-phone="<?php echo ($isMobile) ? 'tel:+57' . $debt->mobile : '#click_to_call'; ?>">               
                                        <input type="text" id="debtor-mobile" name="mobile" value="<?= $debt->mobile; ?>" class="input-disabled">                                    
                                    </div>
                                    <label><?php echo Yii::t('front', 'Nivel de Ingresos (Cantidad en salarios mínimos)'); ?></label>
                                    <input type="number" id="debtor-idTypeIncomeLegal" name="incomeLegal" value="<?= ($debtDemographic != null ? $debtDemographic->incomeLegal : ""); ?>" class="input-disabled">
                                    <label><?php echo Yii::t('front', 'Género'); ?></label>
                                    <select id="debtor-idGender" name="idGender" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($genders as $gender) { ?>
                                            <option value="<?= $gender->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idGender == $gender->id) ? "selected" : "" ?>><?= $gender->name; ?></option>
                                        <?php } ?>
                                    </select>                                        
                                    <label><?php echo Yii::t('front', 'Nivel Educativo'); ?></label>
                                    <select id="debtor-idTypeEducationLevel" name="idTypeEducationLevel" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($educationLevels as $educationLevel) { ?>
                                            <option value="<?php echo $educationLevel->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idTypeEducationLevel == $educationLevel->id) ? "selected" : "" ?>><?php echo $educationLevel->name ?></option>
                                        <?php } ?>                                          
                                    </select>
                                    <label><?php echo Yii::t('front', 'Personas a Cargo'); ?></label>
                                    <input type="number" id="debtor-idTypeDependents" name="dependents" value="<?= ($debtDemographic != null ? $debtDemographic->dependents : ""); ?>" class="input-disabled">                                      
                                </fieldset>
                                <fieldset class="large-4 medium-4 small-12 columns padding">
                                    <label><?php echo Yii::t('front', 'Cédula / NIT'); ?></label>
                                    <input type="text" id="debtor-code" name="code" value="<?= $debt->code; ?>" readonly>
                                    <label><?php echo Yii::t('front', 'Departamento'); ?></label>
                                    <select id="debtor-idDepartment" name="idDepartment" class="select-department select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    </select> 
                                    <label><?php echo Yii::t('front', 'Barrio / Zona'); ?></label>
                                    <input type="text" id="debtor-neighborhood" name="neighborhood" value="<?= $debt->neighborhood; ?>" class="input-disabled">                                        
                                    <label><?php echo Yii::t('front', 'Ocupación'); ?></label>
                                    <select id="debtor-idOccupation" name="idOccupation" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($occupations as $occupation) { ?>
                                            <option value="<?= $occupation->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idOccupation == $occupation->id) ? "selected" : "" ?>><?= $occupation->name; ?></option>
                                        <?php } ?>
                                    </select> 
                                    <label><?php echo Yii::t('front', 'Edad'); ?></label>
                                    <input type="number" id="debtor-idTypeAge" name="age" value="<?= ($debtDemographic != null ? $debtDemographic->age : ""); ?>" class="input-disabled">                                      
                                    <label><?php echo Yii::t('front', 'Estrato Social'); ?></label>
                                    <input type="number" id="debtor-idTypeSocialStratus" name="stratus" value="<?= ($debtDemographic != null ? $debtDemographic->stratus : ""); ?>" class="input-disabled">                                      
                                    <label><?php echo Yii::t('front', 'Tipo de Vivienda'); ?></label>
                                    <select id="debtor-idTypeHousing" name="idTypeHousing" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($typeHousings as $typeHousing) { ?>
                                            <option value="<?php echo $typeHousing->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idTypeHousing == $typeHousing->id) ? "selected" : "" ?>><?php echo $typeHousing->name; ?></option>
                                        <?php } ?>                                          
                                    </select>
                                    <label><?php echo Yii::t('front', 'Capacidad de Pago (Cantidad en salarios mínimos)'); ?></label>
                                    <input type="number" id="debtor-idTypePaymentCapacity" name="paymentCapacity" value="<?= ($debtDemographic != null ? $debtDemographic->paymentCapacity : ""); ?>" class="input-disabled">                                                                            
                                </fieldset>
                                <fieldset class="large-4 medium-4 small-12 columns padding">
                                    <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>
                                    <input type="text" id="debtor-email" name="email" value="<?= $debt->email; ?>" class="input-disabled">
                                    <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                                    <select id="debtor-idCity" name="idCity" class="debtor-idCity select-disabled" >
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    </select>
                                    <label><?php echo Yii::t('front', 'Teléfono'); ?></label>
                                    <div class="phone-input" data-idDebtor="<?php echo $debt->id; ?>" data-number="<?php echo $debt->getIndicativePhone() . $debt->phone; ?>" data-phone="<?php echo ($isMobile) ? 'tel:+57' . $debt->getIndicativePhone() . $debt->mobile : '#click_to_call'; ?>">               
                                        <input type="text" id="debtor-phone" name="phone" value="<?= $debt->phone; ?>" class="input-disabled call_number" />
                                    </div>
                                    <label><?php echo Yii::t('front', 'Estado Civil'); ?></label>
                                    <select id="debtor-idMaritalState" name="idMaritalState" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($maritalStates as $maritalState) { ?>
                                            <option value="<?= $maritalState->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idMaritalState == $maritalState->id) ? "selected" : "" ?>><?= $maritalState->name; ?></option>
                                        <?php } ?>
                                    </select> 

                                    <label><?php echo Yii::t('front', 'Antigüedad Laboral (Cantidad en años)'); ?></label>
                                    <input type="number" id="debtor-idTypeLaborOld" name="laborOld" value="<?= ($debtDemographic != null ? $debtDemographic->laborOld : ""); ?>" class="input-disabled">                                                                            
                                    <label><?php echo Yii::t('front', 'Tipo Contrato'); ?></label>
                                    <select id="debtor-idTypeContract" name="idTypeContract" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($typeContracts as $typeContract) { ?>                                            
                                            <option value="<?php echo $typeContract->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idTypeContract == $typeContract->id) ? "selected" : "" ?>><?php echo $typeContract->name; ?></option>
                                        <?php } ?>                                         
                                    </select>
                                    <label><?php echo Yii::t('front', 'Plazo Contrato (Cantidad en meses)'); ?></label>
                                    <input type="number" id="debtor-contractTerm" name="contractTerm" value="<?= ($debtDemographic != null ? $debtDemographic->contractTerm : ""); ?>" class="input-disabled">                                                                            
                                    <label><?php echo Yii::t('front', 'Código Interno'); ?></label>
                                    <input type="text" id="debtor-accountNumber" name="accountNumber" value="<?= $debt->accountNumber; ?>" class="input-disabled" >
                                </fieldset>
                                <fieldset class="large-12 medium-12 small-12 columns padd_v">  
                                    <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                        <input type="hidden" name="idDebtor" value="<?= $debt->id ?>" />
                                        <div class="txt_center block padding ">
                                            <button id="btnSaveInfo" class="btnb waves-effect waves-light btn-disabled"><?php echo Yii::t('front', 'GUARDAR'); ?></button>
                                        </div>
                                    <?php //}?>
                                </fieldset>
                            </form>
                            <div class="clear"></div>
                            <!--Datos acordeon-->
                            <section class="padd_all m_t_10">
                                <ul class="tabs tab_cartera">
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_phone"><i class="feather feather-phone"></i><?php echo Yii::t('front', 'TELÉFONOS'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_address"><i class="feather feather-map-pin"></i><?php echo Yii::t('front', 'DIRECCIONES'); ?></a></li>                                        
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_email"><i class="feather feather-mail"></i><?php echo Yii::t('front', 'CORREOS'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_co-signer"><i class="feather feather-user-plus"></i><?php echo Yii::t('front', 'CODEUDORES'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_reference"><i class="feather feather-users"></i><?php echo Yii::t('front', 'REFERENCIAS'); ?></a></li>
                                </ul>
                                <section class="">
                                    <div class="row">                                             
                                        <!--Tab 0-->
                                        <article id="debtor_co-signer" class="block border-tab">
                                            <div class="clearfix">
                                                    <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_debcontact_modal" class="tooltipped modal_clic btn-disabled" id="btnNewCoSigner" data-idDebtor="<?php echo $debt->id; ?>" data-tContact="1" data-title="<?php echo Yii::t('front', 'CODEUDOR'); ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                    <?php //} ?>
                                                <!--Codeudores-->
                                                <div class="clear"></div>
                                                <ul class="bg_acordeon m_t_10" id="walletCo-signer-<?php echo $debt->id; ?>">
                                                    <?php
                                                    foreach ($demographicCoSigners as $demographicCoSigner) {
                                                        $this->renderPartial('/wallet/partials/item-contact-block', array('countries' => $countries,
                                                            'genders' => $genders,
                                                            'occupations' => $occupations,
                                                            'educationLevels' => $educationLevels,
                                                            'typeHousings' => $typeHousings,
                                                            'typeContracts' => $typeContracts,
                                                            'maritalStates' => $maritalStates,
                                                            'model' => $demographicCoSigner,
                                                            'debt' => $debt,
                                                            'typeDebtorContact' => '1'
                                                        ));
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="clear"></div>
                                                <!--Fin Codeudores-->
                                            </div>
                                        </article>
                                        <!--Tab 1-->
                                        <article id="debtor_phone" class="block border-tab">
                                            <div class="clearfix content-scroll-x">
                                                <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_phone_modal" class="tooltipped modal_clic btn-disabled " id="btnNewPhone" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php //} ?>
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
                                                    <tbody id="walletPhones-<?php echo $debt->id; ?>">
                                                        <?php
                                                        if (count($demographicPhones) > 0) {
                                                            foreach ($demographicPhones as $demographicPhone) {
                                                                $this->renderPartial('/wallet/partials/item-phone', array('model' => $demographicPhone));
                                                            }
                                                        }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div>         
                                        </article>
                                        <!--Tab 2-->
                                        <article id="debtor_reference" class="block border-tab ">
                                            <div class="clearfix">
                                                <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_debcontact_modal" class="tooltipped modal_clic btn-disabled" id="btnNewReference" data-idDebtor="<?php echo $debt->id; ?>" data-tContact="2" data-title="<?php echo Yii::t('front', 'REFERENCIA'); ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                    <?php //} ?>
                                                <!--Referencias-->
                                                <div class="clear"></div>
                                                <ul class="bg_acordeon m_t_10" id="walletReference-<?php echo $debt->id; ?>">
                                                    <?php
                                                    foreach ($demographicReferences as $demographicReference) {
                                                        $this->renderPartial('/wallet/partials/item-contact-block', array('countries' => $countries,
                                                            'genders' => $genders,
                                                            'occupations' => $occupations,
                                                            'educationLevels' => $educationLevels,
                                                            'typeHousings' => $typeHousings,
                                                            'typeContracts' => $typeContracts,
                                                            'maritalStates' => $maritalStates,
                                                            'model' => $demographicReference,
                                                            'debt' => $debt,
                                                            'typeDebtorContact' => '2'
                                                        ));
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="clear"></div>
                                                <!--Fin Referencias-->
                                            </div>
                                        </article>
                                        <!--Tab 3-->
                                        <article id="debtor_email" class="block border-tab">
                                            <div class="clearfix content-scroll-x">
                                                <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_correo_modal" class="tooltipped modal_clic btn-disabled" id="btnNewEmail" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php //} ?>
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
                                                    <tbody id="walletEmail-<?php echo $debt->id; ?>">
                                                    <?php
                                                    if (count($demographicEmail) > 0) {
                                                        foreach ($demographicEmail as $demographEmail) {
                                                            $this->renderPartial('/wallet/partials/item-email', array('model' => $demographEmail));
                                                        }
                                                    }
                                                    ?>                                  
                                                    </tbody>
                                                </table>
                                            </div>
                                        </article>
                                        <!--Tab 4-->
                                        <article id="debtor_address" class="block border-tab">
                                            <div class="clearfix content-scroll-x">
                                            <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_address_modal" class="tooltipped modal_clic btn-disabled" id="btnNewAddress" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                            <?php //} ?>
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
                                                    <tbody id="walletAddress-<?php echo $debt->id; ?>">
                                                    <?php
                                                    if (count($demographicAddresses) > 0) {
                                                        foreach ($demographicAddresses as $demographicAddress) {
                                                            $this->renderPartial('/wallet/partials/item-address', array('model' => $demographicAddress));
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
                        <!--Tab 2-->
                        <?php if ($debtorObli->is_legal == 0 || $debtorObli->idTypeProcess == 2) { ?>
                            <article id="datos_financieros" class="block m_t_20">
                                <form id="frmFinantial-" action="" class="formweb">
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Capital'); ?></label>
                                        <input type="text" value="$ <?= Yii::app()->format->formatNumber($debtor->capital); ?>"  disabled>
                                        <label><?php echo Yii::t('front', 'Abonos'); ?></label>
                                        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->payments)) ? $othersValues['model']->payments : 0)); ?>" disabled>                                        
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Intereses'); ?></label>
                                        <input type="text" value="$ <?= Yii::app()->format->formatNumber(($othersValues['model'] != null) ? ($othersValues['model']->interest) : 0); ?>"  disabled>
                                        <label><?php echo Yii::t('front', 'Saldo total'); ?></label>
                                        <input type="text" value="$ <?= Yii::app()->format->formatNumber(($othersValues['model'] != null) ? ($othersValues['model']->capital + $othersValues['model']->fee + $othersValues['model']->interest) - $othersValues['model']->payments : 0); ?>"  disabled>                                    
                                        <input type="hidden" value="<?php echo 'capi :' . $othersValues['model']->capital . '+ fee' . $othersValues['model']->fee . ' + c_i ' . $othersValues['model']->interest ?>" >
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Honorarios'); ?></label>
                                        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->fee)) ? $othersValues['model']->fee : 0)); ?>" disabled>
                                        <label><?php echo Yii::t('front', 'Días de mora'); ?></label>
                                        <input type="text" name="" value="<?= $debtor->dayDebt; ?>" disabled>
                                    </fieldset>
                                    <div class="clear"></div>
                                </form>
                                <div class="clear"></div>
                                <!--<div class="lineap"></div>-->


                                <section class="m_t_10 padding m_b_10"> 
                                    <ul class="tabs tab_cartera"> 
                                        <li class="tab" style="width: 19% !important;"><a href="#debtor_detail_debt"><i class="feather feather-list"></i><?php echo Yii::t('front', 'DETALLE DEUDA'); ?></a></li>
                                        <li class="tab" style="width: 19% !important;"><a href="#debtor_supports_debt"><i class="feather feather-folder"></i><?php echo Yii::t('front', 'SOPORTES DEUDA'); ?></a></li>
                                        <li class="tab hide" style="width: 19% !important;"><a href="#debtor_properties"><i class="feather feather-home"></i><?php echo Yii::t('front', 'MEDIDAS CAUTELARES'); ?></a></li>                              
                                        <li class="tab btn-amortization "  style="width: 19% !important;"><a href="#debtor_amortization"><i class="fas fa-calculator"></i><?php echo Yii::t('front', 'AMORTIZACIÓN'); ?></a></li>
                                    </ul>
                                    <section class="">
                                        <div class="row">                                             
                                            <!--Tab 0-->
                                            <article id="debtor_amortization" class="block  border-tab">
                                                <div class="row padd_v" id="content-form-amortization">
                                                <?php $this->renderPartial('/general/partials/form-amortization', array('model' => $debtor, 'debtor' => $debt)); ?>                                                    
                                                </div>
                                                <div class="clearfix content-scroll-x">
                                                    <div class="row padd_v" id="results-content-amortization">
                                                        <table class="bordered">
                                                            <thead>
                                                                <tr class="backgroung-table-4">
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'MES'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'PERIODO'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'DÍAS'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'TASA'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'CUOTA'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'ABONO INTERESES'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'SALDO INTERESES'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'ABONO A CAPITAL'); ?></th>
                                                                    <th class="txt_center"><?php echo Yii::t('front', 'SALDO CAPITAL'); ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="results-amortization">

                                                            </tbody>
                                                        </table>     
                                                    </div>
                                                </div>                
                                                <div class="content-scroll-x">                                                
                                                    <table class="bordered" id="item-amortization">
                                                        <thead>
                                                            <tr class="backgroung-table-4">
                                                                <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                                <th class="txt_center"><?php echo Yii::t('front', 'CUOTA'); ?></th>
                                                                <th class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                                                                <th class="txt_center"><?php echo Yii::t('front', 'ABONO A CAPITAL'); ?></th>
                                                                <th class="txt_center"><?php echo Yii::t('front', 'SALDO'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="clone-content-amortization">
                                                        </tbody>
                                                    </table> 
                                                </div>
                                            </article>
                                            <!--Tab 1-->
                                            <article id="debtor_detail_debt" class="block  border-tab">
                                                <div class="dates_all topBarJuridico hide">
                                                    <ul class="filter_views">                                                        
                                                        <li><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar');  ?></a></li>                                                                                
                                                    </ul>                  
                                                </div>
                                                <div class="formweb content_filter_advance"> 
                                                    <div class="clear"></div>                            
                                                    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
                                                        <form class="formweb form-filter-tab" id="form-filter-obligations" data-content="content-debtor-obligations" data-url="wallet/obligationsPage" enctype="multipart/form-data"> 
                                                            <fieldset class="large-6 medium-6 small-12 columns padding">
                                                                <div class="large-6 medium-6 small-6 columns" style="padding-right: 20px;">
                                                                    <label><?php echo Yii::t('front', 'Desde'); ?></label>
                                                                    <div class="fecha">
                                                                        <input name="from" id="form-filter-obligation-from" type="text" class="calendar_from" value="">
                                                                    </div>                                                                        
                                                                </div>
                                                                <div class="large-6 medium-6 small-6 columns">
                                                                    <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                                                                    <div class="fecha">
                                                                        <input name="to" id="form-filter-obligation-to" type="text" class="calendar_to" value="">
                                                                    </div>                                                                        
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="large-6 medium-6 small-12 columns padding">
                                                                <label><?php echo Yii::t('front', 'N. Obligación'); ?></label>
                                                                <input name="credit_number" id="form-filter-olbigations-credit_number" type="text" class="" value="">                    
                                                            </fieldset>
                                                            <input type="hidden" name="idDebtor" value="<?php echo $debt->id; ?>" />
                                                            <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                                                                <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                                                            </fieldset> 
                                                        </form>
                                                    </fieldset>
                                                </div> 
                                                <div class="clear"></div> 
                                                <div class="content-scroll-x" id="content-debtor-obligations">
                                                <?php
                                                $this->renderPartial('/wallet/partials/content-debtor-obligations', array('debtor' => $debtor, 'obligations' => $obligations, 'pagesObligations' => $pagesObligations));
                                                ?>
                                                </div>       
                                            </article>
                                            <!--Tab 2-->
                                            <article id="debtor_supports_debt" class="block  border-tab">
                                                <div class="clear"></div>
                                                <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                    
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views filter_left">                                                        
                                                            <li><a href="#new_sporte_modal" class="tooltipped modal_clic btn-disabled" id="btnNewSupport" data-idDebtorDebt="<?php echo $debtor->id; ?>" data-idDebtor="<?php echo $debtor->idDebtor; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php //} ?>
                                                <div class="clear"></div>
                                                <table class="bordered content-scroll-x">
                                                    <thead>
                                                        <tr class="backgroung-table-4">
                                                            <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                            <th class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                            <th class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
                                                            <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                        </tr>
                                                        <tr class="filters formweb" data-id="debtors-supports" data-url="debtors-supports">
                                                            <th class="txt_center"><input class="filter-table calendar_range" id="management-filter-date" type="text" name="date" ></th>
                                                            <th class="txt_center"><input class="filter-table" id="supports-filter-credit_number" type="text" name="type" /></th>
                                                            <th class="txt_center"><input class="filter-table" id="supports-filter-capital" type="text" name="comments" /></th>
                                                            <th class="txt_center"><input class="filter-table" id="supports-filter-actions" type="text" name="actions" readonly /></th>            
                                                        </tr>
                                                    </thead>
                                                    <tbody id="walletSupports-<?php echo $debtor->id; ?>">
                                                    <?php
                                                    if (count($supports) > 0) {
                                                        foreach ($supports as $support) {
                                                            $this->renderPartial('/wallet/partials/item-support', array('model' => $support));
                                                        }
                                                    }
                                                    ?>                                  
                                                    </tbody>
                                                </table>
                                            </article>
                                            <!--Tab 3-->
                                            <article id="debtor_properties" class="block  border-tab">

                                            </article>
                                        </div>
                                    </section>

                                </section> 
                                <!--Soportes-->
                            </article>
                        <?php } ?>
                        <!--Tab 3-->
                        <article id="historia_gestion" class="block">
                            <!--Datos acordeon-->  
                            <section>
                                <!-- -->
                                <div class="dates_all topBarJuridico hide">
                                    <ul class="filter_views">                                                        
                                        <li><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar');  ?></a></li>                                                                                
                                    </ul>                  
                                </div>
                                <div class="formweb content_filter_advance"> 
                                    <div class="clear"></div>                            
                                    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
                                        <form class="formweb form-filter-tab" id="form-filter-management" data-content="content-management" data-url="wallet/managementPage" enctype="multipart/form-data"> 
                                            <fieldset class="large-4 medium-4 small-12 columns padding">
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
                                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                                <label><?php echo Yii::t('front', 'ACCIÓN'); ?></label>
                                                <select name="idTasksAction" id="form-filter-management-idTasksAction" class="">
                                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                    <?php foreach ($actionsManagements as $actionsManagement) { ?>
                                                        <option value="<?php echo $actionsManagement->idTasksAction; ?>"><?php echo Yii::t('front', $actionsManagement->management); ?></option>
                                                    <?php } ?>
                                                </select>                                                                    
                                            </fieldset>
                                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>
                                                <input name="comments" id="form-filter-management-comments" type="text" class="" value="">                    
                                            </fieldset>
                                            <input type="hidden" name="idDebtor" value="<?php echo $debtor->id; ?>" />
                                            <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                                                <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                                            </fieldset> 
                                        </form>
                                    </fieldset>
                                </div> 
                                <div class="clear"></div> 
                                <div class="content-scroll-x" id="content-management">
                                    <?php
                                    $this->renderPartial('/wallet/partials/content-management', array('debtor' => $debtor, 'managements' => $managements, 'pagesManagement' => $pagesManagement, 'actionsManagements' => $actionsManagements, 'status' => $status,));
                                    ?>
                                </div>  
                                <!-- -->                                   
                                <ul class="bg_acordeon <?php echo ($countManagement > $this->pSize) ? '' : 'm_t_20'; ?>"> 
                                    <li class="content_acord <?php echo (count($supportsLegals) > 0) ? '' : ''; ?>" id="contentSupportsLegal">
                                        <div class="acordeon walletSupports">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'SOPORTES Y EVIDENCIAS PROCESO JURÍDICO'); ?>
                                        </div>
                                        <div class="clearfix respuesta">
                                            <div class="clear"></div>
                                            <div class="dates_all topBarJuridico">
                                                <ul class="filter_views">                                                        
                                                    <li class="hide"><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar');  ?></a></li>                    
                                                    <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                                    <li><a href="#new_soporte_legal_modal" class="tooltipped modal_clic btn-disabled" id="btnNewLegalSupport" data-idDebtorDebt="<?php echo $debtor->id; ?>" data-idDebtor="<?php echo $debtor->idDebtor; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>
                                                    <?php // } ?>
                                                </ul>                  
                                            </div>
                                            <div class="formweb content_filter_advance"> 
                                                <div class="clear"></div>                            
                                                <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
                                                    <form class="formweb form-filter-tab" id="form-filter-support-legal" data-content="content-support-legal" data-url="wallet/supportLegalPage" enctype="multipart/form-data"> 
                                                        <fieldset class="large-4 medium-4 small-12 columns padding">
                                                            <div class="large-6 medium-6 small-6 columns" style="padding-right: 20px;">
                                                                <label><?php echo Yii::t('front', 'Desde'); ?></label>
                                                                <div class="fecha">
                                                                    <input name="from" id="form-filter-from" type="text" class="calendar_from" value="">
                                                                </div>                                                                        
                                                            </div>
                                                            <div class="large-6 medium-6 small-6 columns">
                                                                <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                                                                <div class="fecha">
                                                                    <input name="to" id="form-filter-to" type="text" class="calendar_to" value="">
                                                                </div>                                                                        
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="large-4 medium-4 small-12 columns padding">
                                                            <label><?php echo Yii::t('front', 'Tipo'); ?></label>
                                                            <select name="idTypeSupport" id="form-filter-idTypeSupport" class="">
                                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                                <?php foreach ($typeLegalSupports as $typeLegalSupport) { ?>
                                                                    <option value="<?php echo $typeLegalSupport->id; ?>"><?php echo Yii::t('front', $typeLegalSupport->name); ?></option>
                                                                <?php } ?>
                                                            </select>                                                                    
                                                        </fieldset>
                                                        <fieldset class="large-4 medium-4 small-12 columns padding">
                                                            <label><?php echo Yii::t('front', 'Comentarios'); ?></label>
                                                            <input name="comments" id="form-filter-comments" type="text" class="" value="">                    
                                                        </fieldset>
                                                        <input type="hidden" name="idDebtor" value="<?php echo $debtor->id; ?>" />
                                                        <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                                                            <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                                                        </fieldset> 
                                                    </form>
                                                </fieldset>
                                            </div> 
                                            <div class="clear"></div>
                                            <!-- debtors support legal -->
                                            <div id="content-support-legal">                                                    
                                            <?php
                                            $this->renderPartial('/wallet/partials/content-support-legal', array('debtor' => $debtor, 'supportsLegals' => $supportsLegals, 'pages' => $pages, 'typeLegalSupports' => $typeLegalSupports));
                                            ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="content_acord">
                                        <div class="acordeon walletSupports">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'MEDIDAS CAUTELARES'); ?>
                                        </div>  
                                        <div class="clearfix respuesta">
                                            <div class="clear"></div>
                                                <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                                <div class="dates_all topBarJuridico">
                                                    <ul class="filter_views">                                                        
                                                        <li><a href="#new_bien_modal" class="tooltipped modal_clic btn-disabled" id="btnNewProperty" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>                                                                                
                                                    </ul>                  
                                                </div>
                                                <?php //} ?>
                                            <div class="clear"></div>
                                            <div class="content-scroll-x" id="content-properties">
                                                <?php $this->renderPartial('/wallet/partials/content-properties', array('debtor' => $debtor, 'properties' => $properties, 'pagesProperties' => $pagesProperties)); ?>                                  
                                            </div> 
                                        </div>
                                    </li>
                                    <li class="content_acord <?php echo (count($supportsLegals) > 0) ? '' : ''; ?>" id="contentSupportsLegal">
                                        <div class="acordeon walletSupports">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'INFORME JURÍDICO'); ?>
                                        </div>
                                        <div class="clearfix respuesta">
                                            <div class="clear"></div>
                                            <div class="dates_all topBarJuridico">
                                                <ul class="filter_views">                                                        
                                                    <li class="hide"><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar');   ?></a></li>                    
                                                    
                                                        <li><a href="#new_soporte_legal_modal" class="tooltipped modal_clic btn-disabled hide" id="btnNewLegalSupport" data-idDebtorDebt="<?php echo $debtor->id; ?>" data-idDebtor="<?php echo $debtor->idDebtor; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php //echo Yii::t('front', 'Nuevo');   ?></a></li>
                                                   
                                                </ul>                  
                                            </div>
                                            <div class="formweb content_filter_advance"> 
                                                <div class="clear"></div>
                                            </div> 
                                            <div class="clear"></div>
                                            <!-- debtors support legal -->
                                            <div id="content-support-legal">                                                    

                                                <table class="bordered">
                                                    <thead>
                                                        <tr class="backgroung-table-4">
                                                            <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                            <th class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                            <th class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
                                                            <th class="txt_center"><?php echo Yii::t('front', 'SOPORTES'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-management-13">
                                                        <?php foreach ($typeReports as $typeReport){
							$report = DebtorsDebtsReports::model()->find(array('condition' => 'idTypeReport ='.$typeReport->id.' AND idDebtorDebt ='.$debtor->id));
						       
							$this->renderPartial('/wallet/partials/item-report', array('typeReport' => $typeReport, 'model' => $report, 'debtor' => $debtor->id));
                                                        } ?>                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </li>                                    
                                </ul>
                                <?php if($debtor->is_legal){ ?>
                                <ul class="bg_acordeon <?php echo ($countManagement > $this->pSize) ? '' : 'm_t_20'; ?>"> 
                                    
                                </ul>
                                <?php } ?>
                            </section> 
                            <!--Fin Datos acordeon-->
                            <div class="clear"></div>
                        </article>
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                            <!--Datos acordeon-->                                  
                            <section class="">
                                <div class="dates_all topBarJuridico">
                                    <ul class="filter_views filter_left">                                                                                                                    
                                        <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                            <li><a href="#new_payment_modal" class="tooltipped modal_clic btn-payment btn-disabled" data-idDebtorDebt="<?php echo $debtor->id; ?>" data-idDebtor="<?php echo $debtor->idDebtor; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>
                                        <?php //} ?>
                                    </ul>                  
                                </div>
                                <div class="clear"></div>
                                <ul class="tabs tab_cartera">
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_payments"><i class="fa fa-usd"></i><?php echo Yii::t('front', 'PAGOS'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_agreements"><i class="fa fa-check-square-o"></i><?php echo Yii::t('front', 'ACUERDOS'); ?></a></li>
                                </ul>
                                <section class=""><!-- m_t_10 -->
                                    <div class="row"> 
                                        <!--Tab 1-->
                                        <article id="debtor_payments" class="block">
                                            <div class="clearfix content-scroll-x">                                                    
                                                <table class="bordered">                                            
                                                    <thead>
                                                        <tr class="backgroung-table-4">
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                            <th width="14%" class="txt_center "><?php echo Yii::t('front', 'ASESOR'); ?></th>
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'METODO'); ?></th>
                                                            <th width="14%" class="txt_center "><?php echo Yii::t('front', 'DISCRIMINACIÓN'); ?></th>
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                            <th width="16%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="walletPayments-<?php echo $debtor->id; ?>">
                                                    <?php
                                                    foreach ($payments as $pay) {
                                                        $this->renderPartial('/wallet/partials/item-payments', array('model' => $pay, 'edit' => $edit));
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>    
                                            </div>         
                                        </article>
                                        <article id="debtor_agreements" class="block">
                                            <div class="clearfix content-scroll-x">
                                                <table class="bordered">                                            
                                                    <thead>
                                                        <tr class="backgroung-table-4 <?php echo $debtor->id; ?>">
                                                            <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                            <th width="20%" class="txt_center "><?php echo Yii::t('front', 'ASESOR'); ?></th>
                                                            <th width="20%" class="txt_center"><?php echo Yii::t('front', 'METODO'); ?></th>
                                                            <th width="20%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                            <th width="15%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                            <th width="15%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="walletAgreements-<?php echo $debtor->id; ?>">
                                                    <?php
                                                    foreach ($agreements as $pay) {
                                                        $this->renderPartial('/wallet/partials/item-agreements', array('model' => $pay, 'edit' => $edit));
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
                        <!--Tab 5-->
                        <article id="historia_gastos" class="block">
                            <!--Datos acordeon-->                            
                            <div class="dates_all topBarJuridico">
                                <ul class="filter_views filter_left">                                                                                                                    
                                    <?php //if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                        <li><a href="#new_spending_modal" class="tooltipped modal_clic btn-spending btn-disabled" data-idDebtorDebt="<?php echo $debtor->id; ?>" data-idDebtor="<?php echo $debtor->idDebtor; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php //echo Yii::t('front', 'Nuevo');  ?></a></li>
                                    <?php // } ?>
                                </ul>                  
                            </div>
                            <div class="clear"></div>
                            <section class="">
                                <div class="clearfix content-scroll-x">                                        
                                    <table class="bordered">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'UBICACIÓN'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'COMENTARIO'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="walletSpending-<?php echo $debtor->id; ?>">
                                            <?php
                                            if (count($spendings) > 0) {
                                                foreach ($spendings as $spending) {
                                                    $this->renderPartial('/wallet/partials/item-spending', array('model' => $spending));
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
                    </section>                
                </section>
                <!--Fin Tabs--> 
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<input type="hidden" id="idDebtor" value="<?= $debt->id ?>">
<?php
$this->renderPartial("/wallet/partials/modal_debtor", array('actions' => $actions,
    'debt' => $debt,
    'model' => null,
    'typeDebtorContact' => null,
    'debtor' => $debtor,
    'typeSupports' => $typeSupports,
    'typeLegalSupports' => $typeLegalSupports,
    'status' => $status,
    'tree' => $tree,
    'countries' => $countries,
    'genders' => $genders,
    'occupations' => $occupations,
    'maritalStates' => $maritalStates,
    'officeLegals' => $officeLegals,
    'educationLevels' => $educationLevels,
    'typeHousings' => $typeHousings,
    'typeContracts' => $typeContracts,
    'paymentStates' => $paymentStates,
    'paymentClasses' => $paymentClasses,
    'paymentPaidTos' => $paymentPaidTos,
    'paymentTypeDiscriminations' => $paymentTypeDiscriminations,
    'paymentMethods' => $paymentMethods,
    'spendingTypes' => $spendingTypes,
    'assetTypes' => $assetTypes,
    'typeReferences' => $typeReferences,
    'phoneClasses' => $phoneClasses,
    'call' => $call,
    'phones' => $phones,
    'phonesSMS' => $phonesSMS,
    'emailEmails' => $emailEmails,
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery.smartselect.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/debtor.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('https://maps.google.com/maps/api/js?key=AIzaSyBzcBlS39ZkGbWVteA5CbcBiB0GBpVWCvo', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/debtor-maps.min.js', CClientScript::POS_END);
if (isset($historic) && $historic) {
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/historic.min.js', CClientScript::POS_END);
} else {
    
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-more.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);
$js = 'console.log("' . $historic . '");';
if ($debt != null && $debt->idCity0 != null) {
    $js .= '
        $("#debtor-idCountry").val(' . $debt->idCity0->idDepartment0->idCountry . ').trigger("change");
            setTimeout(function () {
                $("#debtor-idDepartment").val(' . $debt->idCity0->idDepartment . ').trigger("change");
                setTimeout(function () {
                    $("#debtorObligations-idCity").replaceWith($("#debtor-idCity").clone().attr("id","debtor-idCity-clone"));
                    console.log("clone2");
                    $(".debtor-idCity").val(' . $debt->idCity . ').trigger("change");
                }, 300);
                
            }, 700);
            ';
}

/*if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) {
    $js .= '
            $( ".select-disabled" ).prop( "disabled", true );
            $( ".input-disabled" ).prop( "readonly", true );
           ';
}*/

if ($historic) {
    $js .= '
            $( ".select-disabled" ).prop( "disabled", true );
            $( ".input-disabled" ).prop( "readonly", true );
            $( ".btn-disabled" ).addClass( "hide");            
           ';
}

Yii::app()->clientScript->registerScript("debtor_js", '
   smartSelect(); 
   $(document).ready(function(){    
    ' . $js . '
   });
   
', CClientScript::POS_END
);
?>
