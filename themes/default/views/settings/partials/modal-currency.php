<!-- Modal New Currency -->
<section id="new_currency_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'MONEDA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-currency" data-id="currency-">            
        <div class="row padd_v"> 
            <fieldset class="large-6 medium-6 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Nombre'); ?></label>
                <input name="name" id="currency-name" type="text" value="">
            </fieldset>
            <fieldset class="large-6 medium-6 small-6 columns padding">                                            
                <label><?php echo Yii::t('front', 'Codigo'); ?></label>
                <input name="currency" id="currency-currency" type="text" value="" readonly>
            </fieldset>
            <fieldset class="large-6 medium-6 small-6 columns padding">                                            
                <label><?php echo Yii::t('front', 'Valor'); ?></label>
                <input name="value" id="currency-value" type="number" value="" step="0.01">
            </fieldset>
            <input id="currency-id" name="id" type="hidden" value="">
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" href="" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>


