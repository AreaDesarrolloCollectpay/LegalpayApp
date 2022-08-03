<!-- Modal New Contract -->
<section id="new_contracts_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'NUEVO DOCUMENTO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-contracts" data-id="contracts-">            
        <div class="row padd_v"> 
            <fieldset class="large-6 medium-6 small-6 columns padding">                                            
                <label><?php echo Yii::t('front', 'Tipo de Documento'); ?></label>
                <select name="idTypeUsersDocuments" id="form-contracts-TypeDocuments" class="cd-select filterType searchCustomers">
                    <option value="">Seleccionar</option>
                    <?php foreach ($type_documents as $value) { ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-6 medium-6 small-6 columns padding">
                <div class="file-field input-field">
                    <div class="btn">
                        <span><?php echo Yii::t('front', 'Cargar Documento'); ?></span>
                        <input class="" name="support" id="form-contracts-file" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" disabled="disabled">
                    </div>
                </div>
                <input type="hidden" name="idUser" id="form-contracts-idUser" value="<?php echo $idUser; ?>" />
                <input id="form-contracts-id" name="id" type="hidden" value="">
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea name="comments" id="form-contracts-comments" cols="30" rows="10" ></textarea>
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" href="" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>


