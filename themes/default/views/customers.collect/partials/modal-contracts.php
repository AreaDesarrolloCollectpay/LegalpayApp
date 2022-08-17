<!-- Modal New Contract -->
<section id="new_contracts_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO CONTRATO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-contracts" data-id="contracts-">            
        <div class="row padd_v"> 
            <fieldset class="large-6 medium-6 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Desde'); ?></label>
                <div class="fecha">
                    <input name="from" id="form-contracts-from" type="text" class="calendar_from_m" value="">
                </div>
            </fieldset>
            <fieldset class="large-6 medium-6 small-6 columns padding">                                            
                <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                <div class="fecha">
                    <input name="to" id="form-contracts-to" type="text" class="calendar_to_m" value="">
                </div>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea name="comments" id="form-contracts-comments" cols="30" rows="10" ></textarea>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar Contrato'); ?></span>
                        <input class="" name="support" id="form-contracts-support" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
                <input type="hidden" name="idUser" id="form-contracts-idUser" value="<?php echo $idUser; ?>" />
                <input id="form-contracts-id" name="id" type="hidden" value="">
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" href="" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>


