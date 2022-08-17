<!-- Modal New Spending-->
<section id="new_spending_business_modal" class="modal modal-m">
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
                <input id="spending-idUserBusiness" name="idUserBusiness" type="hidden" value="<?php echo (isset($business) && $business->id != '')? $business->id : ''; ?>">
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
<!-- Modal Modal SMS business -->
<section id="sms_detail_business" class="modal modal-m">
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
<section id="email_detail_business" class="modal modal-m">
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
<!-- Modal New Phone -->
<section id="new_phone_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'TELÉFONO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-userPhone" data-id="phones-">
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
                <input id="phones-idUser" name="idUser" type="hidden" value="" />                
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
<!-- Modal New Correo -->
<section id="new_correo_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'CORREO ELECTRÓNICO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-userEmail" >
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
            <input id="email-idUser" name="idUser" type="hidden" value="" />
                   <div class="clear"></div>
        </div>
        <div class="modal-footer"> 
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New Correo -->
<?php
    $this->renderPartial("/wallet/partials/phone", array('model' =>$business,'status' => $businessStates, 'phones' => $phones));    