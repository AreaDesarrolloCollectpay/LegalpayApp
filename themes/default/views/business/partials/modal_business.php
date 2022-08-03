<!-- Modal New User -->
<section id="modal_user_business" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO CLIENTE'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-business" data-id="business-">
        <div class="row padd_v">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Nombre / Razón Social'); ?></label>  
                <input id="business-name" name="name" type="text">
                <label><?php echo Yii::t('front', 'CC / NIT'); ?></label>  
                <input id="business-numberDocument" name="numberDocument" type="text">
                <label><?php echo Yii::t('front', 'Nombre Contacto'); ?></label>  
                <input id="business-contact" name="contact" type="text">
                <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>  
                <input id="business-email" name="email" type="text">                         
                <label><?php echo Yii::t('front', 'Celular'); ?></label>                       
                <input id="business-mobile" name="mobile" pattern="[0-9]{1,10}" type="number">
                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>                       
                <input id="business-phone" name="phone" pattern="[0-9]{1,7}" type="number">   
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
                <input id="business-address" name="address" type="text">
                <label><?php echo Yii::t('front', 'Valor de la cartera'); ?></label>                       
                <input id="business-value" name="value" type="number">
                <label><?php echo Yii::t('front', 'Fecha de Cierre Prevista'); ?></label>    
                <div class="fecha">
                    <input type="date" class="calendar" id="business-date" name="date_close">
                </div> 
                <label><?php echo Yii::t('front', 'Ejecutivo'); ?></label>                       
                <select id="business-idBusinessAdvisor" name="idBusinessAdvisor">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                    <?php foreach ($businessAdvisors as $businessAdvisor) { ?>                        
                        <option value="<?php echo $businessAdvisor->id; ?>"><?php echo $businessAdvisor->name; ?></option>      
                    <?php } ?>
                </select>
                <input type="hidden" name="idUserProfile" value="8" />
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <input id="users-id" name="id" type="hidden" value="" />
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<?php //advisorBusiness
$js = '';
$idBusinessAdvisor = '';
$hide = false;
if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisorBusiness'])){
    $idBusinessAdvisor = Yii::app()->user->getId();
    $hide = true;
}

if($hide){        
    $js .=  '$("#business-idBusinessAdvisor").val('.$idBusinessAdvisor.').css("pointer-events","none");';        
}

Yii::app()->clientScript->registerScript("business_new_js", '
   $(document).ready(function(){    
    ' . $js . '
   });
   
', CClientScript::POS_END
);
