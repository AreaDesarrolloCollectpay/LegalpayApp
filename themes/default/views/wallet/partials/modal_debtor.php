<?php 
$session = Yii::app()->session;
?>
<section id="new_pass" class="modal modal-s">
    <div class="modal-header">
        <h1><?= Yii::t("front", "changePassword") ?></h1>
        <div class="rc-anchor-content">
            <div class="rc-inline-block">
                <div class="rc-anchor-center-container">
                    <div class="rc-anchor-center-item rc-anchor-error-message" id="errorModalChangePasswd" style="color:red; font-weight: bolder;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row padd_v">
        <form id="frmUpdatePasswd" class="formweb">
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?= Yii::t("front", "lastPassword") ?></label>                       
                <input type="password" name="lastPass" id="lastPass">
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?= Yii::t("front", "newPassword") ?></label>                       
                <input type="password" name="newPass" id="newPass">
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?= Yii::t("front", "repeatPassword") ?></label>                       
                <input type="password" name="repeatPass" id="repeatPass">
                <input type="hidden" name="YII_CSRF_TOKEN" id="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>">
            </fieldset>
            <div class="clear"></div>
        </form>
    </div>
    <div class="modal-footer">    
        <button type="submit" class="btnb waves-effect waves-light right" id="savePasswd"><?= Yii::t("front", "save") ?></button>
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?= Yii::t("front", "cancel") ?></a>
    </div>
</section>
<!-- Modal New Phone -->
<section id="new_phone_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'TELÉFONO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-walletPhone" data-id="phones-">
        <div class="row padd_v">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'País'); ?></label>                       
                <select name="idCountry" id="phones-idCountry" class="select-country">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($countries as $country) {
                            ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php
                        }
                    ?>
                </select>          
                <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                <select name="idDepartment" id="phones-idDepartment" class="select-department">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                <select name="idCity" id="phones-idCity">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea name="comment" id="phones-comment" cols="30" rows="10"></textarea>
                <input id="phones-id" name="id" type="hidden" value="" />
                <input id="phones-idDebtor" name="idDebtor" type="hidden" value="" />                
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">  
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>                       
                <select name="idTypeReference" id="phones-idTypeReference">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($typeReferences as $typeReference) {
                            ?>
                            <option value="<?= $typeReference->id; ?>"><?= $typeReference->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <label><?php echo Yii::t('front', 'Clase'); ?></label>                       
                <select name="idPhoneClass" id="phones-idPhoneClass">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($phoneClasses as $phoneClass) {
                            ?>
                            <option value="<?= $phoneClass->id; ?>"><?= $phoneClass->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <label><?php echo Yii::t('front', 'Número'); ?></label>                       
                <input id="phones-number" name="number" type="number">
                <label><?php echo Yii::t('front', 'Estado'); ?></label>                          
                <select  name="active" id="phones-active">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <option value="0"><?php echo Yii::t('front', 'Por Validar'); ?></option>
                    <option value="1"><?php echo Yii::t('front', 'Localizado'); ?></option>
                    <option value="2"><?php echo Yii::t('front', 'Ilocalizado'); ?></option>
                </select>
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Phone -->
<!-- Modal Contact -->
<section id="new_debcontact_modal" class="modal modal-l">
    <div class="modal-header">
        <h1></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <?php 
        $this->renderPartial('/wallet/partials/form-debtor-contacts', 
            array('debt' => $debt,
                'model' => $model,
                'typeDebtorContact' => null,
                'countries' => $countries,
                'genders' => $genders,
                'occupations' => $occupations,
                'maritalStates' => $maritalStates,
                'educationLevels' => $educationLevels,
                'typeHousings' => $typeHousings,
                'typeContracts' => $typeContracts
            )
        ); 
    ?>  
</section>
<!-- Fin Modal New Contact -->
<!-- Modal New Correo -->
<section id="new_correo_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'CORREO ELECTRÓNICO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-walletEmail" >
        <div class="row padd_v">
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>                       
                <select name="idTypeReference" id="email-idTypeReference">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($typeReferences as $typeReference) {
                            ?>
                            <option value="<?= $typeReference->id; ?>"><?= $typeReference->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <label><?php echo Yii::t('front', 'Correo'); ?></label>                       
                <input id="email-email" name="email" type="email">
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Nombre'); ?></label>                       
                <input id="email-name" name="name" type="text">
                <label><?php echo Yii::t('front', 'Estado'); ?></label>                       
                <select  name="active" id="email-active">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <option value="0"><?php echo Yii::t('front', 'Por Validar'); ?></option>
                    <option value="1"><?php echo Yii::t('front', 'Localizado'); ?></option>
                    <option value="2"><?php echo Yii::t('front', 'Ilocalizado'); ?></option>
                </select>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea name="comment" id="email-comment" cols="30" rows="10"></textarea>
            </fieldset>
            <input id="email-id" name="id" type="hidden" value="" />
            <input id="email-idDebtor" name="idDebtor" type="hidden" value="" />
                   <div class="clear"></div>
        </div>
        <div class="modal-footer"> 
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Correo -->
<!-- Modal New Phone -->
<section id="new_address_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'DIRECCIÓN'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-walletAddress" data-id="address-">
        <div class="row padd_v">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'País'); ?></label>                       
                <select name="idCountry" id="address-idCountry" class="select-country">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($countries as $country) {
                            ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php
                        }
                    ?>            
                </select>
                <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                <select name="idDepartment" id="address-idDepartment" class="select-department">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                <select name="idCity" id="address-idCity">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea id="address-comment" name="comment" cols="30" rows="10"></textarea>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">          
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>                       
                <select name="idTypeReference" id="address-idTypeReference">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($typeReferences as $typeReference) {
                            ?>
                            <option value="<?= $typeReference->id; ?>"><?= $typeReference->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
                <input id="address-address" name="address" type="text">
                <label><?php echo Yii::t('front', 'Barrio'); ?></label>                       
                <input id="address-neighborhood" name="neighborhood" type="text">
                <label><?php echo Yii::t('front', 'Estado'); ?></label>            
                <select  name="active" id="address-active">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <option value="0"><?php echo Yii::t('front', 'Por Validar'); ?></option>
                    <option value="1"><?php echo Yii::t('front', 'Localizado'); ?></option>
                    <option value="2"><?php echo Yii::t('front', 'Ilocalizado'); ?></option>
                </select>
            </fieldset>
            <input id="address-id" name="id" type="hidden" value="" />
            <input id="address-idDebtor" name="idDebtor" type="hidden" value="" />
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Phone -->
<!-- Modal New Bien-->
<section id="new_bien_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'MEDIDAS CAUTELARES'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-property" action="" method="" data-id="property-">
        <div class="row padd_v">
            <fieldset class="large-6 medium-6 small-12 columns padding">                
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>
                <select id="property-idPropertyType" name="idPropertyType">            
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php
                    foreach ($assetTypes as $assetType) {
                        ?>
                        <option value="<?= $assetType->id; ?>"><?= $assetType->name; ?></option> 
                        <?php
                    }
                    ?>            
                </select>
                <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
                <input id="property-address" name="address" type="text">
                <label><?php echo Yii::t('front', 'Matrícula'); ?></label>                       
                <input id="property-name" name="number" type="text">                
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">   
                <label><?php echo Yii::t('front', 'País'); ?></label>                       
                <select name="idCountry" id="property-idCountry" class="select-country">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($countries as $country) {
                            ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php
                        }
                    ?>            
                </select>
                <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                <select name="idDepartment" id="property-idDepartment" class="select-department">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                <select name="idCity" id="property-idCity">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>                 
            </fieldset>      
            <fieldset class="large-12 medium-12 small-12 columns padding">      
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea name="comment" id="property-comment" cols="30" rows="10" ></textarea>
            </fieldset>      
            <fieldset class="large-12 medium-12 small-12 columns padding">      
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                        <input class="" name="support" id="support-support" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
            </fieldset>      
            <div class="clear"></div>
            <input id="property-id" name="id" type="hidden" value="" />
            <input id="property-idDebtor" name="idDebtor" type="hidden" value="" />
        </div>
        <div class="modal-footer">    
            <button  type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Bien-->
<!-- Modal New Soporte-->
<section id="new_sporte_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'SOPORTE TITULO DEUDA'); ?> <span id="t-soporte-deuda"></span></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-supports" method="" enctype="multipart/form-data">
        
    <div class="row padd_v">    
        <fieldset class="large-6 medium-6 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Tipo'); ?></label>
            <select id="support-idTypeSupport" name="idTypeSupport">            
                <option value=""><?php echo Yii::t('front', 'Seleccione una opción'); ?></option>
                <?php
                foreach ($typeSupports as $typeSupport) {
                    ?>
                    <option value="<?= $typeSupport->id; ?>"><?= $typeSupport->name; ?></option> 
                    <?php
                }
                ?>            
            </select>            
        </fieldset>
        <fieldset class="large-6 medium-6 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Fecha'); ?></label>    
            <div class="fecha">
                <input type="date" class="calendar" id="support-date" name="dateSupport">
            </div>              
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
            <textarea name="comments" id="support-comments" cols="30" rows="10" ></textarea>
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding">
            <div class="file-field input-field">
                <div class="btn">
                    <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                    <input class="" name="support" id="support-support" type="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" disabled="disabled">
                </div>
            </div>4534564564564456
            <input type="hidden" name="idDebtor" id="support-idDebtor" value="" />
            <input type="hidden" name="idDebtorDebt" id="support-idDebtorDebt" value="" />
            <input id="support-id" name="id" type="hidden" value="">
        </fieldset>
    </div>
    <div class="modal-footer">    
        <button type="submit" href="" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </div>
    </form>
</section>
<!-- Fin Modal New Soporte-->
<!-- Modal New Legal Soporte-->
<section id="new_soporte_legal_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'SOPORTE PROCESO JURÍDICO'); ?> <span id="t-soporte-deuda"></span></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-legal-supports" method="" enctype="multipart/form-data">
        
    <div class="row padd_v">    
        <fieldset class="large-6 medium-6 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Tipo'); ?></label>
            <select id="legal-support-idTypeSupport" name="idTypeSupport">            
                <option value=""><?php echo Yii::t('front', 'Seleccione una opción'); ?></option>
                <?php
                foreach ($typeLegalSupports as $typeLegalSupport) {
                    ?>
                    <option value="<?= $typeLegalSupport->id; ?>"><?= $typeLegalSupport->name; ?></option> 
                    <?php
                }
                ?>            
            </select>
        </fieldset>
        <fieldset class="large-6 medium-6 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Fecha'); ?></label>    
            <div class="fecha">
                <input type="date" class="calendar" id="legal-support-date" name="dateSupport">
            </div>  
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
            <textarea name="comments" id="legal-support-comments" cols="30" rows="10" ></textarea>
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding">
            <div class="file-field input-field">
                <div class="btn">
                    <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                    <input class="" name="support" id="legal-support-support" type="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" disabled="disabled">
                </div>
            </div>
            <input type="hidden" name="idDebtor" id="legal-support-idDebtor" value="" />
            <input type="hidden" name="idDebtorDebt" id="legal-support-idDebtorDebt" value="" />
            <input id="legal-support-id" name="id" type="hidden" value="">
        </fieldset>
    </div>
    <div class="modal-footer">    
        <button type="submit" href="" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </div>
    </form>
</section>
<!-- Fin Modal New Legal Soporte-->
<!-- Modal New Payment-->
<section id="new_payment_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'PAGO'); ?><span id="t-pago-deuda"></span></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>    
    <form class="formweb well well-sm form-payments" enctype="multipart/form-data" >        
        <div class="row padd_v">    
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Estado'); ?></label>
                <select name="idPaymentsState" id="idPaymentTypeState">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php foreach ($paymentStates as $paymentState) { ?>
                        <option value="<?= $paymentState->id; ?>" ><?php echo Yii::t('front', $paymentState->name); ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Clase'); ?></label>
                <select name="idPaymentsType" id="idPaymentTypesClass">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php foreach ($paymentClasses as $paymentClass) { ?>
                        <option value="<?= $paymentClass->id; ?>" ><?php echo Yii::t('front', $paymentClass->name); ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'A Quien pago?'); ?></label>
                <select name="idPaymentsWhoPaid" id="idPaymentTypePaidTo">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php foreach ($paymentPaidTos as $paymentPaidTo) { ?>
                        <option value="<?= $paymentPaidTo->id; ?>" ><?php echo Yii::t('front', $paymentPaidTo->name); ?></option>
                    <?php } ?>
                </select>
            </fieldset>            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Forma'); ?></label>
                <select name="idPaymentsMethod" id="idPaymentTypeMethod">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php foreach ($paymentMethods as $paymentMethod) { ?>
                    <option value="<?= $paymentMethod->id; ?>" ><?php echo Yii::t('front', $paymentMethod->name); ?></option>
                    <?php } ?>
                </select>
            </fieldset>            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Valor'); ?></label>
                <input type="number" name="value" id="paymentValue" value="">
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Fecha'); ?></label>
                <div class="fecha">
                    <input type="date" name="datePay" id="paymentDate" class="calendar">
                </div>
                <input id="payment-idWallet" name="idDebtorObligation" type="hidden" value="">
                <input id="payment-idDebtorDebt" name="idDebtorDebt" type="hidden" value="">
                <input id="payment-idPayment" name="id" type="hidden" value="">
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Discriminación'); ?></label>
                <select name="idPaymentsDiscrimination" id="idPaymentTypeDiscrimination">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php foreach ($paymentTypeDiscriminations as $paymentTypeDiscrimination) { ?>
                    <option value="<?= $paymentTypeDiscrimination->id; ?>" ><?php echo Yii::t('front', $paymentTypeDiscrimination->name); ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                        <input class="" name="supportPayments" id="payments-support" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">    
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Payment-->
<!-- Modal New Spending-->
<section id="new_spending_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'GASTO'); ?><span id="t-pago-deuda"></span></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb well well-sm form-spending" data-id="spending-" enctype="multipart/form-data">        
        <div class="row padd_v"> 
            <fieldset class="large-6 medium-6 small-12 columns padding">                
                <label><?php echo Yii::t('front', 'País'); ?></label>                       
                <select name="idCountry" id="spending-idCountry" class="select-country">
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
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Valor'); ?></label>
                <input type="number" name="value" id="spending-value" value="">
            </fieldset>            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Departamento'); ?></label>                       
                <select name="idDepartment" id="spending-idDepartment" class="select-department">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Fecha'); ?></label>
                <div class="fecha">
                    <input type="date" name="dateSpending" id="spending-dateSpending" class="calendar">
                </div>
                <input id="spending-idDebtor" name="idDebtor" type="hidden" value="">
                <input id="spending-idDebtorDebt" name="idDebtorDebt" type="hidden" value="">
                <input id="spending-id" name="id" type="hidden" value="">
            </fieldset>            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>                       
                <select name="idCity" id="spending-idCity">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>            
                </select>
            </fieldset>           
            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>
                <select name="idSpendingType" id="spending-idSpendingType">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php
                        foreach ($spendingTypes as $spendingType) {
                            ?>
                            <option value="<?= $spendingType->id; ?>"><?php echo Yii::t('front', $spendingType->name); ?></option>
                            <?php
                        }
                    ?>               
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea name="comments" id="spending-comments" cols="30" rows="10" ></textarea>
            </fieldset>      
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar archivo');  ?></span>
                        <input class="" name="support" id="spending-support" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">    
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Spending-->
<!-- Modal New Comment -->
<section id="new_comentario_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'COMENTARIO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-comments" >
        <div class="row padd_v">
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Comentario'); ?></label>                       
                <textarea name="comment" id="comments-comment" cols="30" rows="10"></textarea>
            </fieldset>
            <input id="comments-idDebtor" name="idDebtor" type="hidden" value="" />
            <input id="comments-id" name="id" type="hidden" value="" />
            <div class="clear"></div>
        </div>
        <div class="modal-footer"> 
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Correo -->
<!-- Modal Tareas -->
<section id="new_tasks_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', ($debtor->is_legal)? 'GESTIÓN JURÍDICA' : 'GESTIÓN OPERATIVA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v">        
        <?php $this->renderPartial('/wallet/partials/form-tasks', array('actions' => $actions,'debt' =>$debt,'debtor' =>$debtor,'type' =>'m','status' => $status,'tree' => $tree)); ?>  
    </div>
</section>
<!--/ Modal Tareas -->
<!-- Modal Reportes -->
<section id="modal_reports" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', ($debtor->is_legal)? 'INFORME JURÍDICO' : 'INFORME PREJURÍDICO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v">        
        <form class="form-report formweb" enctype="multipart/form-data"> 
            <fieldset class="large-6 medium-12 small-12 columns padding">                
                <label><?php echo Yii::t('front', 'Fecha'); ?>*</label>
                <div class="fecha">
                    <input name="date" id="report-date" type="date" class="calendar" value="" />
                </div>
            </fieldset>
            <fieldset class="large-6 medium-12 small-12 columns padding">            
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>
                <textarea name="comments" cols="30" rows="10" id="report-comments"></textarea>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">            
                <div class="file-field input-field"><!-- hide id="file-task" -->
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Soporte'); ?></span>
                        <input class="" name="support" id="report-support" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
            </fieldset>  
            <input type="hidden" name="idDebtorDebt" id="report-idDebtorDebt" value="" />
            <input type="hidden" name="idTypeReport" id="report-idTypeReport" value="" />
            <input type="hidden" name="id" id="report-id" value="" /> 
            <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_5">            
                <button type="submit" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'Guardar'); ?></button>
            </fieldset> 
        </form>
    </div>
</section>
<!--/ Modal Reportes -->
<!-- Modal Management -->
<section id="view_management_modal" class="modal modal-lg">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'GESTIONES'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v" id="more-management">        
        
    </div>
</section>
<!--/ Modal Management -->
<!-- Modal support Management -->
<section id="view_management_images_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'SOPORTE'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v" >        
        <section class="padd_v">
            <div class="row"> 
                <article id="" class="block">                              
                    <div class="clear"></div>
                    <section class="padding m_t_20">
                        <div class="clearfix" id="suport-management">                                        
                                                                     
                        </div>
                        <div class="clear"></div>
                    </section>
                </article>
            </div>
        </section>            
        <div class="clear"></div>
    </div>
</section>
<!--/ Modal support Management -->
<!-- Modal detail obligation -->
<section id="view_debtor_obligation_modal" class="modal modal-lg">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'DETALLE OBLIGACIÓN'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v" id="debtor_obligation">        
        
    </div>
</section>
<!--/ Modal detail obligation -->
<!-- Modal google Maps location -->
<section id="google_maps_picker" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'Google Maps'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="formweb well well-sm form-spending" data-id="spending-" enctype="multipart/form-data">        
        <div class="row padd_v"> 
            <fieldset class="large-12 medium-12 small-12 columns padding hide">                
                <label><?php echo Yii::t('front', 'Dirección'); ?></label>                       
               <input type="text" class="form-control" id="google-maps-address" />
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <div id="map-canvas-modal" style="width: 100%; height: 400px;"></div>
            </fieldset>       
        </div>
    </div>
</section>
<!--/ Modal support Management -->
<!-- Modal call -->
<section id="modal_call" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'LLAMAR'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>    
    <?php //$this->renderPartial('/wallet/partials/call-phone', array('model' =>$debtor,'status' => $status)); ?>  
</section>
<!-- Fin Modal call -->
<!-- Modal ml chart -->
<section id="modal_mlchart" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'GRAFICA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>    
    <div id="contentModelMLChart-modal">
        
    </div>
</section>
<!-- Fin ml chart -->

<!-- Modal Modal SMS debtor -->
<section id="sms_detail_debtor" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'ENVÍO SMS'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-sms-wallets" data-id="sms-wallets-">
        <div class="row padd_v">            
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número Celular'); ?></label>                       
                <select name="number" id="sms-wallets-number" class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                    
                    <?php foreach ($phonesSMS as $phone){ ?>
                    <option value="<?php echo $phone->getIndicativeSms().$phone->number; ?>"><?php echo $phone->number. ' - '.$phone->name; ?></option>
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front', 'Mensaje'); ?></label>                       
                <textarea name="message" id="sms-wallets-message" cols="30" rows="10"></textarea>
                <input id="sms-wallets-idDebtor" name="idDebtor" type="hidden" value="" />                
            </fieldset>            
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Enviar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal SMS debtor -->
<!-- Modal Email debtor -->
<section id="email_detail_debtor" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'ENVÍO EMAIL'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-email-wallets" data-id="email-wallets-">
        <div class="row padd_v">            
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Correo'); ?></label>                       
                <select name="email" id="email-wallets-number" class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                    
                    <?php foreach ($emailEmails as $emailEmail){ ?>
                    <option value="<?php echo $emailEmail->email; ?>"><?php echo $emailEmail->email; ?></option>
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front', 'Asunto'); ?></label>   
                <input name="subject" type="text" class="form-control" id="email-wallets-subject" />
                <label><?php echo Yii::t('front', 'Mensaje'); ?></label>                       
                <textarea name="message" id="email-wallets-message" cols="30" rows="10"></textarea>
                <input id="email-wallets-idDebtor" name="idDebtor" type="hidden" value="" />                
            </fieldset>            
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Enviar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal SMS debtor -->
<?php
if(isset($call) && $call == true && (Yii::app()->user->getState('call') != null && Yii::app()->user->getState('call') == 1)){
    $this->renderPartial("/wallet/partials/phone", array('model' =>$debtor,'status' => $status, 'phones' => $phones));    
}
 
