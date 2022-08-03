<?php 
$this->renderPartial('/layouts/partials/side-nav', array('task' => in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers'])));  
$edit = (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers']))? true : false;
?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
             <div class="tittle_head">
                <h2 class="inline"><?= $debt->name; ?><?php //echo ($debt->accountNumber != '')? ' - '.$debt->accountNumber : ''; ?></h2> 
                <div class="acions_head">
                    <!--<span class="timer"><b><?php echo Yii::t('front', 'Tiempo'); ?>:</b> <span id ="timer"></span></span>-->
                    <!--<a href="#" class="back" onClick="history.go(-1); return false;"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?></a>-->
                    <div class="dates_all topBarJuridico">
                        <ul class="filter_views" style="margin: 0 0 0px !important;">
                            <li class="backSite">
                                <a href="#" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>"  onClick="history.go(-1); return false;">
                                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
                                </a>
                            </li>
                        </ul>                  
                    </div>
                </div>
                <div class="porcent_hv">
                    <div class="relative">
                        <div class="circle-porcent">                            
                            <div class="chartHV" data-percent="<?= round($demographicsPorc, 1); ?>">
                                <span class="num">
                                    <strong class="counter"><?= round($demographicsPorc, 1); ?></strong><strong>%</strong>
                                </span>
                            </div>
                        </div>
                        <h4><?php echo Yii::t('front', 'Datos <br>Demográficos'); ?></h4>
                    </div>
                </div>
                <div class="porcent_hv">
                    <div class="relative">
                        <div class="circle-porcent">
                            <?php
                                 $recoveryPorc = (isset($othersValues['model']->capital))? ((((isset($othersValues['model']->payments))? $othersValues['model']->payments : 0) * 100) / $othersValues['model']->capital) : 0;
                            ?>
                            <div class="chartHV" data-percent="<?= round($recoveryPorc, 1); ?>">
                                <span class="num">
                                    <strong class="counter"><?= round($recoveryPorc, 1); ?></strong><strong>%</strong>
                                </span>
                            </div>
                        </div>
                        <h4><?php echo Yii::t('front', 'Porcentaje de <br>Recuperación'); ?></h4>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <section class="row p_t_80">
            <section class="padding animated fadeInUp">
                <!--Datos iniciales-->
                <section class="panelBG m_b_20 indexTwo">
                    <div class="row block padd_v">
                        <div id="frmManagement"> 
                            <?php $this->renderPartial('/wallet/partials/state_'.$debtor->is_legal,array('creditModalities' => $creditModalities, 'status' => $status,'ageDebts' => $ageDebts,'debtor' => $debtor,'debtorObli' => $debtorObli, 'tree' => $tree,'officeLegals' => $officeLegals)) ?>
                            <div class="clear"></div>
                            <!--<div class="padding">
                                <div class="lineap"></div>
                            </div>-->                            
                        </div>
                    </div>
                </section>
                <!--Fin Datos iniciales-->                
                <?php if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'],Yii::app()->params['admin'])) && !$historic) { ?>
                <!-- Tareas  -->
                <section class="panelBG m_b_20 m_t_20">
                    <div class="row block padd_v">
                        <div class="form_register formweb"> 
                                <div class="clear"></div>                            
                                <fieldset class="large-12 medium-12 small-12 columns padding">
                                    <!-- border_form -->
                                    <div class="m_b_10">
                                            <fieldset class="large-12 medium-12 small-12 columns padding">
                                                <div class="modal-header row p_b_10">
                                                    <h1><?php echo Yii::t('front', 'TAREAS'); ?></h1>
                                                </div>
                                            </fieldset>
                                        <?php 
                                         $this->renderPartial('/wallet/partials/form-tasks', array('actions' => $actions,'debt' =>$debt, 'debtor' =>$debtor,'type' =>'i','task' =>$task,'status' => $status,'tree' => $tree ));
                                        ?>                                        
                                    </div>
                                </fieldset>
                                <div class="clear"></div>
                        </div>
                    </div>
                </section>                
                <!-- Fin Tareas -->
                <?php } ?>                            

                <!--Tabs-->
                <div class="block">
                    <ul class="tabs tab_cartera">
                        <li class="tab"><a href="#datos_personales"><i class="feather feather-user"></i><?php echo Yii::t('front', 'DATOS DEMOGRÁFICOS'); ?></a></li>
                        <li class="tab"><a href="#datos_financieros" class="btn-amortization"><i class="feather feather-bar-chart-2"></i><?php echo Yii::t('front', 'DATOS FINANCIEROS'); ?></a></li>
                        <li class="tab"><a href="#historia_gestion"><i class="feather feather-settings"></i><?php echo Yii::t('front', 'HISTORIAL DE GESTIÓN'); ?></a></li>
                        <li class="tab"><a href="#historia_pagos"><i class="feather feather-credit-card"></i><?php echo Yii::t('front', 'HISTORIAL DE PAGOS'); ?></a></li>
                        <li class="tab"><a href="#historia_gastos"><i class="feather feather-pie-chart"></i><?php echo Yii::t('front', 'GASTOS DE GESTIÓN'); ?></a></li>
                    </ul>
                </div>                          
                <section class="panelBG m_b_20">
                    <section class="padd_v">
                        <!--Tab 1-->
                        <article id="datos_personales" class="block">
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
                                    <label><?php echo Yii::t('front', 'Dirección'); ?> <a href="#google_maps_picker" class="tooltipped modal_clic right" id="btnGMaps" data-idDebtor="<?php echo $debt->id; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front','Ubicar'); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> Google Maps</a></label>
                                    <input type="text" id="debtor-address" name="address" value="<?= $debt->address; ?>" class="input-disabled">
                                    <label><?php echo Yii::t('front', 'Celular'); ?> <?php if($debt->mobile != ''){ ?><a href="#click_to_call" class="tooltipped modal_clic right" data-idDebtor="<?php echo $debt->id; ?>" data-number="<?php $debt->mobile; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front','Llamar'); ?>"><i class="fa fa-map-phone" aria-hidden="true"></i></a><?php } ?></label>
                                    <input type="text" id="debtor-mobile" name="mobile" value="<?= $debt->mobile; ?>" class="input-disabled">
                                    <label><?php echo Yii::t('front', 'Nivel de Ingresos (Cantidad en salarios mínimos)'); ?></label>
                                    <input type="number" id="debtor-idTypeIncomeLegal" name="incomeLegal" value="<?= ($debtDemographic != null ? $debtDemographic->incomeLegal : ""); ?>" class="input-disabled">
                                    <label><?php echo Yii::t('front', 'Género'); ?></label>
                                    <select id="debtor-idGender" name="idGender" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($genders as $gender) { ?>
                                                <option value="<?= $gender->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idGender == $gender->id) ? "selected":""?>><?= $gender->name; ?></option>
                                        <?php } ?>
                                    </select>                                        
                                    <label><?php echo Yii::t('front', 'Nivel Educativo'); ?></label>
                                    <select id="debtor-idTypeEducationLevel" name="idTypeEducationLevel" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php foreach ($educationLevels as $educationLevel){ ?>
                                        <option value="<?php echo $educationLevel->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idTypeEducationLevel == $educationLevel->id) ? "selected":""?>><?php echo $educationLevel->name ?></option>
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
                                        <option value="<?= $occupation->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idOccupation == $occupation->id) ? "selected":""?>><?= $occupation->name; ?></option>
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
                                        <option value="<?php echo $typeHousing->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idTypeHousing == $typeHousing->id) ? "selected":""?>><?php echo $typeHousing->name; ?></option>
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
                                    <label><?php echo Yii::t('front', 'Teléfono'); ?><?php if($debt->phone != ''){ ?><a href="#" class="tooltipped right click_to_call" data-idDebtor="<?php echo $debt->id; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front','Llamar'); ?>"><i class="fa fa-phone" aria-hidden="true"></i></a><?php } ?></label>
                                    <input type="text" id="debtor-phone" name="phone" value="<?= $debt->phone; ?>" class="input-disabled call_number">
                                    <label><?php echo Yii::t('front', 'Estado Civil'); ?></label>
                                    <select id="debtor-idMaritalState" name="idMaritalState" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php  foreach ($maritalStates as $maritalState) { ?>
                                                <option value="<?= $maritalState->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idMaritalState == $maritalState->id) ? "selected":""?>><?= $maritalState->name; ?></option>
                                        <?php } ?>
                                    </select> 

                                    <label><?php echo Yii::t('front', 'Antigüedad Laboral (Cantidad en años)'); ?></label>
                                    <input type="number" id="debtor-idTypeLaborOld" name="laborOld" value="<?= ($debtDemographic != null ? $debtDemographic->laborOld : ""); ?>" class="input-disabled">                                                                            
                                    <label><?php echo Yii::t('front', 'Tipo Contrato'); ?></label>
                                    <select id="debtor-idTypeContract" name="idTypeContract" class="select-disabled">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                        <?php  foreach ($typeContracts as $typeContract) { ?>                                            
                                        <option value="<?php echo $typeContract->id; ?>" <?php echo ($debtDemographic != null && $debtDemographic->idTypeContract == $typeContract->id) ? "selected":""?>><?php echo $typeContract->name; ?></option>
                                        <?php } ?>                                         
                                    </select>
                                    <label><?php echo Yii::t('front', 'Plazo Contrato (Cantidad en meses)'); ?></label>
                                    <input type="number" id="debtor-contractTerm" name="contractTerm" value="<?= ($debtDemographic != null ? $debtDemographic->contractTerm : ""); ?>" class="input-disabled">                                                                            
                                    <label><?php echo Yii::t('front', 'Código Interno'); ?></label>
                                    <input type="text" id="debtor-accountNumber" name="accountNumber" value="<?= $debt->accountNumber; ?>" class="input-disabled" >
                                </fieldset>
                                <fieldset class="large-12 medium-12 small-12 columns padd_v">  
                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                    <input type="hidden" name="idDebtor" value="<?= $debt->id ?>" />
                                    <div class="txt_center block padding ">
                                        <button id="btnSaveInfo" class="btnb waves-effect waves-light btn-disabled"><?php echo Yii::t('front', 'GUARDAR'); ?></button>
                                    </div>
                                <?php } ?>
                                </fieldset>
                            </form>
                            <div class="clear"></div>
                            <!--Datos acordeon-->
                            <section class="padd_all m_t_10">
                                <ul class="tabs tab_cartera">
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_co-signer"><i class="feather feather-user-plus"></i><?php echo Yii::t('front', 'CODEUDORES'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_reference"><i class="feather feather-users"></i><?php echo Yii::t('front', 'REFERENCIAS'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_phone"><i class="feather feather-phone"></i><?php echo Yii::t('front', 'TELÉFONOS'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_email"><i class="feather feather-mail"></i><?php echo Yii::t('front', 'CORREOS'); ?></a></li>
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_address"><i class="feather feather-map-pin"></i><?php echo Yii::t('front', 'DIRECCIONES'); ?></a></li>                                        
                                </ul>
                                <section class="m_t_10">
                                    <div class="row">                                             
                                        <!--Tab 0-->
                                        <article id="debtor_co-signer" class="block">
                                            <div class="clearfix">
                                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views">                                                        
                                                            <li><a href="#new_debcontact_modal" class="tooltipped modal_clic btn-disabled" id="btnNewCoSigner" data-idDebtor="<?php echo $debt->id; ?>" data-tContact="1" data-title="<?php echo Yii::t('front', 'CODEUDOR');?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php } ?>
                                                 <!--Codeudores-->
                                                    <div class="clear"></div>
                                                    <ul class="bg_acordeon m_t_10" id="walletCo-signer-<?php echo $debt->id; ?>">
                                                        <?php foreach ($demographicCoSigners as $demographicCoSigner) {                                                                
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
                                                        } ?>
                                                    </ul>
                                                    <div class="clear"></div>
                                                    <!--Fin Codeudores-->
                                            </div>
                                        </article>
                                        <!--Tab 1-->
                                        <article id="debtor_phone" class="block">
                                            <div class="clearfix">
                                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views">                                                        
                                                            <li><a href="#new_phone_modal" class="tooltipped modal_clic btn-disabled" id="btnNewPhone" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php } ?>
                                                <table class="bordered responsive-table">
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
                                        <article id="debtor_reference" class="block">
                                            <div class="clearfix">
                                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views">                                                        
                                                            <li><a href="#new_debcontact_modal" class="tooltipped modal_clic btn-disabled" id="btnNewReference" data-idDebtor="<?php echo $debt->id; ?>" data-tContact="2" data-title="<?php echo Yii::t('front', 'REFERENCIA'); ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php } ?>
                                                 <!--Referencias-->
                                                    <div class="clear"></div>
                                                    <ul class="bg_acordeon m_t_10" id="walletReference-<?php echo $debt->id; ?>">
                                                        <?php foreach ($demographicReferences as $demographicReference) {                                                                
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
                                                        } ?>
                                                    </ul>
                                                    <div class="clear"></div>
                                                    <!--Fin Referencias-->
                                            </div>
                                        </article>
                                        <!--Tab 3-->
                                        <article id="debtor_email" class="block">
                                            <div class="clearfix">
                                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                    <div class="dates_all topBarJuridico">
                                                        <ul class="filter_views">                                                        
                                                            <li><a href="#new_correo_modal" class="tooltipped modal_clic btn-disabled" id="btnNewEmail" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>                                                                                
                                                        </ul>                  
                                                    </div>
                                                <?php } ?>
                                                <div class="clear"></div>
                                                <table class="bordered responsive-table">
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
                                        <article id="debtor_address" class="block">
                                            <div class="clearfix">
                                                <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                        
                                                <div class="dates_all topBarJuridico">
                                                    <ul class="filter_views">                                                        
                                                        <li><a href="#new_address_modal" class="tooltipped modal_clic btn-disabled" id="btnNewAddress" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>                                                                                
                                                    </ul>                  
                                                </div>
                                                <?php } ?>
                                                <div class="clear"></div>
                                                <table class="bordered responsive-table">
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
                        <article id="datos_financieros" class="block">
                            <form id="frmFinantial-" action="" class="formweb">
                                <fieldset class="large-4 medium-4 small-12 columns padding">
                                    <label><?php echo Yii::t('front', 'Capital'); ?></label>
                                    <input type="text" value="$ <?= Yii::app()->format->formatNumber($debtor->capital); ?>"  disabled>
                                    <label><?php echo Yii::t('front', 'Intereses de mora migrado'); ?></label>
                                    <input type="text" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->interest_arrears_migrate))? $othersValues['model']->interest_arrears_migrate : 0)); ?>"  disabled>
                                    <label><?php echo Yii::t('front', 'Total'); ?></label>
                                    <input type="text" value="$ <?= Yii::app()->format->formatNumber(($othersValues['model'] != null)? ($debtor->capital + $othersValues['model']->interest + $othersValues['model']->interest_arrears + $othersValues['model']->interest_arrears_migrate + $othersValues['model']->charges + $othersValues['model']->others) : 0); ?>"  disabled>

                                </fieldset>
                                <fieldset class="large-4 medium-4 small-12 columns padding">
                                    <label><?php echo Yii::t('front', 'Intereses'); ?></label>
                                    <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->interest))? $othersValues['model']->interest : 0)); ?>" disabled>                                        
                                    <label><?php echo Yii::t('front', 'Gastos'); ?></label>
                                    <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->charges))? $othersValues['model']->charges : 0)); ?>" disabled>
                                </fieldset>
                                <fieldset class="large-4 medium-4 small-12 columns padding">
                                    <label><?php echo Yii::t('front', 'Intereses de mora'); ?></label>
                                    <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->interest_arrears))? $othersValues['model']->interest_arrears : 0)); ?>" disabled>
                                    <label><?php echo Yii::t('front', 'Otros'); ?></label>
                                    <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->others))? $othersValues['model']->others : 0)); ?>" disabled>
                                </fieldset>
                                <div class="clear"></div>
                            </form>
                            <div class="clear"></div>
                            <!--<div class="lineap"></div>-->
                            <section class="m_t_10"> 
                                <ul class="bg_acordeon">
                                    <li class="content_acord">
                                        <div class="acordeon walletSupports">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'AMORTIZACIÓN'); ?>
                                        </div>
                                        <div class="clearfix respuesta">
                                            <div class="row padd_v" id="content-form-amortization">
                                                <?php  $this->renderPartial('/general/partials/form-amortization', array('model' => $debtor,'debtor' => $debt)); ?>                                                    
                                            </div>
                                            <div class="clearfix">
                                                <div class="row padd_v" id="results-content-amortization">
                                                    <table class="bordered responsive-table">
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
                                            <table class="bordered responsive-table" id="item-amortization">
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
                                    </li>
                                </ul>
                            </section> 
                            <!--Soportes-->
                            <section class="">
                                <div class="clear"></div>
                                <ul class="bg_acordeon">
                                    <li class="content_acord">
                                        <div class="acordeon">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'DETALLE DEUDA'); ?>
                                        </div>
                                        <div class="clearfix respuesta">
                                            <div class="dates_all topBarJuridico">
                                                <ul class="filter_views">                                                        
                                                    <li><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>                                                                                
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
                                            <div id="content-debtor-obligations">
                                                <?php
                                                $this->renderPartial('/wallet/partials/content-debtor-obligations', array('debtor' => $debtor, 'obligations' => $obligations, 'pagesObligations' => $pagesObligations));
                                                ?>
                                            </div>  
                                        </div>
                                    </li>                                    
                                    <li class="content_acord">
                                        <div class="acordeon walletSupports">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'SOPORTES DE LA DEUDA'); ?>
                                        </div>
                                        <div class="clearfix respuesta">
                                            <div class="clear"></div>
                                            <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>                                                    
                                            <div class="dates_all topBarJuridico">
                                                <ul class="filter_views">                                                        
                                                    <li><a href="#new_sporte_modal" class="tooltipped modal_clic btn-disabled" id="btnNewSupport" data-idDebtor="<?php echo $debtor->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>                                                                                
                                                </ul>                  
                                            </div>
                                            <?php } ?>
                                            <div class="clear"></div>
                                            <table class="bordered responsive-table">
                                                <thead>
                                                    <tr class="backgroung-table-4">
                                                        <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                        <th class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                        <th class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
                                                        <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
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
                                        </div>
                                    </li>
                                    <li class="content_acord ">
                                        <div class="acordeon walletProperty">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'GARANTÍAS, MUEBLES E INMUEBLES'); ?>  
                                        </div>
                                        <div class="clearfix respuesta">
                                            <div class="clear"></div>
                                            <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                        <div class="dates_all topBarJuridico">
                                            <ul class="filter_views">                                                        
                                                <li><a href="#new_bien_modal" class="tooltipped modal_clic btn-disabled" id="btnNewProperty" data-idDebtor="<?php echo $debt->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>                                                                                
                                            </ul>                  
                                        </div>
                                            <?php } ?>
                                            <div class="clear"></div>
                                            <div id="content-properties">
                                                <?php $this->renderPartial('/wallet/partials/content-properties', array('debtor' => $debtor, 'properties' => $properties, 'pagesProperties' => $pagesProperties)); ?>                                  
                                            </div>                                                
                                        </div>
                                    </li>  
                                </ul>
                                <div class="clear"></div>
                            </section>
                            <!--Fin Soportes-->
                        </article>
                        <!--Tab 3-->
                        <article id="historia_gestion" class="block">
                            <!--Datos acordeon-->  
                            <section>
                                <!-- -->
                                <div class="dates_all topBarJuridico">
                                    <ul class="filter_views">                                                        
                                        <li><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>                                                                                
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
                                <div id="content-management">
                                    <?php
                                    $this->renderPartial('/wallet/partials/content-management', array('debtor' => $debtor, 'managements' => $managements, 'pagesManagement' => $pagesManagement));
                                    ?>
                                </div>  
                                <!-- -->                                   
                                <ul class="bg_acordeon <?php echo ($countManagement > $this->pSize)? '' : 'm_t_20';  ?>"> 
                                    <li class="content_acord <?php echo (count($supportsLegals) > 0) ? '' : ''; ?>" id="contentSupportsLegal">
                                        <div class="acordeon walletSupports">                          
                                            <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                            <?php echo Yii::t('front', 'SOPORTES : PROCESO JURÍDICO'); ?>
                                        </div>
                                        <div class="clearfix respuesta">
                                            <div class="clear"></div>
                                                <div class="dates_all topBarJuridico">
                                                    <ul class="filter_views">                                                        
                                                        <li><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php echo Yii::t('front', 'Filtrar'); ?></a></li>                    
                                                        <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                                        <li><a href="#new_soporte_legal_modal" class="tooltipped modal_clic btn-disabled" id="btnNewLegalSupport" data-idDebtor="<?php echo $debtor->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>
                                                        <?php } ?>
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
                                                $this->renderPartial('/wallet/partials/content-support-legal', array('debtor' => $debtor, 'supportsLegals' => $supportsLegals, 'pages' => $pages));
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </section> 

                            <!--Fin Datos acordeon-->
                            <div class="clear"></div>
                        </article>
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                            <!--Datos acordeon-->                                  
                            <section class="padd">
                            <div class="dates_all topBarJuridico">
                                <ul class="filter_views">                                                                                                                    
                                    <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                    <li><a href="#new_payment_modal" class="tooltipped modal_clic btn-payment btn-disabled" data-idDebtor="<?php echo $debtor->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>
                                    <?php } ?>
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
                                            <div class="clearfix">                                                    
                                                <table class="bordered responsive-table">                                            
                                                    <thead>
                                                        <tr class="backgroung-table-4">
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                            <th width="14%" class="txt_center hide_customer"><?php echo Yii::t('front', 'ASESOR'); ?></th>
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'METODO'); ?></th>
                                                            <th width="14%" class="txt_center hide_customer"><?php echo Yii::t('front', 'DISCRIMINACIÓN'); ?></th>
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                            <th width="14%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                            <th width="16%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="walletPayments-<?php echo $debtor->id; ?>">
                                                        <?php
                                                            foreach ($payments as $pay) {
                                                                $this->renderPartial('/wallet/partials/item-payments', array('model' => $pay,'edit' => $edit));
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>    
                                            </div>         
                                        </article>
                                        <article id="debtor_agreements" class="block">
                                            <div class="clearfix">
                                                <table class="bordered responsive-table">                                            
                                                    <thead>
                                                        <tr class="backgroung-table-4 <?php echo $debtor->id; ?>">
                                                            <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                            <th width="20%" class="txt_center hide_customer"><?php echo Yii::t('front', 'ASESOR'); ?></th>
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
                                <ul class="filter_views">                                                                                                                    
                                    <?php if (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                                    <li><a href="#new_spending_modal" class="tooltipped modal_clic btn-spending btn-disabled" data-idDebtor="<?php echo $debtor->id; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Nuevo'); ?>"><i class="fa fa-plus lin2"></i> <?php echo Yii::t('front', 'Nuevo'); ?></a></li>
                                    <?php } ?>
                                </ul>                  
                            </div>
                            <div class="clear"></div>
                            <section class="">
                                <div class="clearfix">                                        
                                    <table class="bordered responsive-table">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'UBICACIÓN'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'COMENTARIO'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead
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

<div class="content_phone">
    <div class="phone__overlay"></div>
    <div class="phone call_off">
        <a class="phone__close"></a>
        <div class="phone__bg">
            <div class="phone__logo"></div>
        </div>
        <div class="phone_skin"></div>
        <div class="phone__content">
            
            <!--Initial screen-->
            <div class="phone__content1 phone__content__inner">
                <div class="phone__container">
                    <select>
                        <option>N. de teléfono</option>
                    </select>

                    <a class="btn__call"></a>
                </div>
            </div>

            <!--main call view-->
            <div class="phone__content2 phone__content__inner">
                <div class="phone__container">
                    <h4>LLAMADA EN PROGRESO</h4>
                    <div class="phone__actions">
                        <a class="open-video"></a>
                        <a class="mute"></a>
                        <a class="open-keypad"></a>
                        <a class="open-comments"></a>
                    </div>
                    <a class="btn__call--end"></a>
                </div>
            </div>

            <!--keypad view-->
            <div class="phone__content3 phone__content__inner">
                <div class="phone__container">
                    <h4>LLAMADA EN PROGRESO</h4>
                    <div class="phone__keypad">
                        <a class="key key-1">1</a>
                        <a class="key key-2">2</a>
                        <a class="key key-3">3</a>
                        <a class="key key-4">4</a>
                        <a class="key key-5">5</a>
                        <a class="key key-6">6</a>
                        <a class="key key-7">7</a>
                        <a class="key key-8">8</a>
                        <a class="key key-9">9</a>
                        <a class="key key-hash">#</a>
                        <a class="key key-0">0</a>
                        <a class="key key-asterisk">*</a>
                    </div>
                    <div class="text-center">
                        <a class="btn btn--back btn--green">Volver</a>
                    </div>
                </div>
            </div>


            <!--Comments view-->
            <div class="phone__content4 phone__content__inner">
                <div class="phone__container">
                    <h4>LLAMADA EN PROGRESO</h4>
                    
                    <div class="phone__comments">
                        <select>
                            <option>Estado</option>
                        </select>
                        <textarea placeholder="Comentarios"></textarea>
                    </div>

                    <div class="comments__btns">
                        <a class="btn btn--back btn--green">Guardar</a>
                        <a class="btn btn--back btn--red">Cancelar</a>
                    </div>
                </div>
            </div>


            <!--End call view-->
            <div class="phone__content5 phone__content__inner">
                <div class="phone__container">
                    <h3>LLAMADA FINALIZADA</h3>
                </div>
            </div>

        </div>
    </div>
</div>



<script type="text/javascript">
    $(function(){
        $('.btn__call').click(function(){
            $('.phone__content1').hide();
            $('.phone__content2').fadeIn();
            $('.phone').removeClass('call_off').addClass('call_on');
        });
        $('.mute').click(function(){
            $(this).toggleClass('muted');
        });
        $('.open-keypad').click(function(){
            $('.phone__content__inner').hide();
            $('.phone__content3').fadeIn();
        });
        $('.btn--back').click(function(){
            $('.phone__content__inner').hide();
            $('.phone__content2').fadeIn();
        });
        $('.open-comments').click(function(){
            $('.phone__content__inner').hide();
            $('.phone__content4').fadeIn();
        });
         $('.btn__call--end').click(function(){
            $('.phone__content__inner').hide();
            $('.phone__content5').fadeIn();
            $('.phone').removeClass('call_on').addClass('call_off');
        });
        $('.phone__close, .phone__overlay').click(function(){
            $('.phone').removeClass('open');
            setTimeout(function(){
                $('.content_phone').fadeOut();
            },600);
        });
        $('.open_phone').click(function(){
            $('.content_phone').fadeIn();
            setTimeout(function(){
                $('.phone').addClass('open');
            },600);
        });
    })
</script>

<?php
$this->renderPartial("/wallet/partials/modal_debtor", array('actions' => $actions,
    'debt' =>$debt,
    'model' => null,
    'typeDebtorContact' => null,
    'debtor' =>$debtor,
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
        ));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery.smartselect.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/debtor.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('https://maps.google.com/maps/api/js?key=AIzaSyBzcBlS39ZkGbWVteA5CbcBiB0GBpVWCvo', CClientScript::POS_END);    
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/debtor-maps.min.js', CClientScript::POS_END);
if(isset($historic) && $historic){
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/historic.min.js', CClientScript::POS_END);     
}
$js = 'console.log("'.$historic.'");';
if($debt != null && $debt->idCity0  != null){
    $js .= '
        $("#debtor-idCountry").val('.$debt->idCity0->idDepartment0->idCountry.').trigger("change");
            setTimeout(function () {
                $("#debtor-idDepartment").val('.$debt->idCity0->idDepartment.').trigger("change");
                setTimeout(function () {
                    $("#debtorObligations-idCity").replaceWith($("#debtor-idCity").clone().attr("id","debtor-idCity-clone"));
                    console.log("clone2");
                    $(".debtor-idCity").val('.$debt->idCity.').trigger("change");
                }, 300);
                
            }, 700);
            ';
}

if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){    
    $js .= '$(".hide_customer").addClass("hide");
            $( ".select-disabled" ).prop( "disabled", true );
            $( ".input-disabled" ).prop( "readonly", true );
           ';
}

if($historic){
    $js .= '
            $( ".select-disabled" ).prop( "disabled", true );
            $( ".input-disabled" ).prop( "readonly", true );
            $( ".btn-disabled" ).addClass( "hide");            
           ';
}

Yii::app()->clientScript->registerScript("debtor_js",'
   smartSelect(); 
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
?>
