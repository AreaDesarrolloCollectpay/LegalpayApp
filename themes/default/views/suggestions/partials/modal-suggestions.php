<!-- Modal Sugerencia -->
<section id="new_suggestions_modal" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'PQR'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-suggestions" data-id="customers-" enctype="multipart/form-data">            
        <div class="row m_t_20">            
            <fieldset class="large-12 medium-12 small-12 columns padding">                
                <label><?php echo Yii::t('front', 'Tipo'); ?></label>  
                <select id="suggestions-title" name="title">
                    <option value="PETICIÓN">PETICIÓN</option>
                    <option value="QUEJA">QUEJA</option>
                    <option value="RECLAMO">RECLAMO</option>
                </select>                
                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>                       
                <textarea name="comments" id="form-contracts-comments" cols="30" rows="10" ></textarea>                
            </fieldset>            
            <div class="clear"></div>
        </div>
        <div class="modal-footer m_t_20">    
            <input id="suggestions-id" name="id" type="hidden" value="" />
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>