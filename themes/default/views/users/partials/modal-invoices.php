<!-- Modal New User -->
<section id="new_invoice_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO ASESOR'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form enctype="multipart/form-data" class="formweb form-invoices" data-id="users-">
        <div class="row padd_v">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Número Factura'); ?></label>  
                <input id="invoice-number" name="number" type="text">
                <label><?php echo Yii::t('front', 'Subtotal'); ?></label>  
                <input id="invoice-subtotal" name="subtotal" type="text">                      
                <label><?php echo Yii::t('front', 'Fecha de Expiración'); ?></label>  
                <div class="fecha">
                    <input name="date_expiration" id="invoice-date_expiration" type="date" class="calendar" value="" />
                </div>
<!--                <label><?php echo Yii::t('front', 'Fecha de Expedición'); ?></label>  
                <div class="fecha">
                    <input name="date_expedition" id="invoice-date_expedition" type="date" class="calendar" value="" />
                </div>                -->
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Estado'); ?></label>                          
                <select  name="idInvocieState" id="invoice-idInvocieState" class="">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php foreach ($states as $state) { ?>
                        <option value="<?= $state->id; ?>"><?php echo Yii::t('front', $state->name); ?></option>
                    <?php } ?>  
                </select>
                <label><?php echo Yii::t('front', 'IVA'); ?></label>  
                <input id="invoice-tax" name="tax" type="text">                
                <label><?php echo Yii::t('front', 'Fecha de Pago'); ?></label>  
                <div class="fecha">
                    <input name="date_pay" id="invoice-date_pay" type="date" class="calendar" value="" />
                </div>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <div class="file-field input-field" id="file-invoice">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar factura'); ?></span>
                        <input class="" name="file" id="invoice-file" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
                <div class="file-field input-field" id="file-support_pay">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Soporte de Pago'); ?></span>
                        <input class="" name="support_pay" id="invoice-support_pay" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>                
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>
                <textarea name="comments" cols="30" rows="10" id="invoice-comments"></textarea>
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <input id="invoice-id" name="id" type="hidden" value="" />
            <input id="invoice-idUser" name="idUser" type="hidden" value="" />
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
