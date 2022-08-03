<!-- Modal New Contact -->
<section id="new_contacts_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO CONTACTO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-contacts" data-id="form-contacts-">            
        <div class="row padd_v"> 
            <fieldset class="large-6 medium-6 small-6 columns padding">                                            
                <label><?php echo Yii::t('front','Nombre');?></label>  
                <input id="form-contacts-name" name="name" type="text">
                <label><?php echo Yii::t('front','Teléfono');?></label>  
                <input id="form-contacts-phone" name="phone" type="number">
                <label><?php echo Yii::t('front','Cargo');?></label>  
                <input id="form-contacts-position" name="position" type="text">
                <label><?php echo Yii::t('front','Departamento');?></label>                       
                <select id="form-contacts-idDepartment" name="idDepartment" class="select-department">
                    <option value="">Seleccionar</option>            
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-6 columns padding">
                <label><?php echo Yii::t('front','Celular');?></label>  
                <input id="form-contacts-mobile" name="mobile" type="number">
                <label><?php echo Yii::t('front','Email');?></label>                 
                <input id="form-contacts-email" name="email" type="email">
                <label><?php echo Yii::t('front','Pais');?></label>                       
                <select id="form-contacts-idCountry" name="idCountry"  class="select-country">
                    <option value="">Seleccionar</option>      
                    <?php foreach ($countries as $country) { ?>                        
                        <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>      
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front','Ciudad');?></label>                       
                <select id="form-contacts-idCity" name="idCity" class="select-city">
                    <option value=""><?php echo Yii::t('front','Seleccionar');?></option>            
                </select>
                <input type="hidden" name="idUser" id="form-contacts-idUser" value="<?php echo $idUser; ?>" />
                <input id="form-contacts-id" name="id" type="hidden" value="">
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" href="" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>




