<!-- Modal New Political -->
<section id="new_political_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVA POLÍTICA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-political" data-id="customers-">        
        <div class="row m_t_20">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Tipo - Cliente'); ?></label>  
                <select id="political-idUser" name="idUser"  class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>  
                    <option value="0"><?php echo Yii::t('front', 'GENERAL'); ?></option> 
                    <?php foreach ($customersM as $customer) { ?>                        
                        <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Nombre'); ?></label>  
                <input id="political-name" name="name" type="text">
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                        <input class="" name="file" id="political-file" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
            </fieldset>
            <div class="clear"></div>
        </div>        
        <div class="modal-footer m_t_20">    
            <input id="political-id" name="id" type="hidden" value="" />
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>



