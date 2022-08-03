<section id="load_db" class="modal modal-s">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'Confirmación de Importación'); ?></h1>
    </div>
    <form class="formweb form-import-data" action="" method="" id="form-import">
    <div class="row padd_v">
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding">
                    <p><b><?php echo Yii::t('front', 'Numero total de coincidencias'); ?>:</b></p>                  
                </div>
                <div class="large-5 medium-12 small-12 columns padding">     
                    <p id="data-total"></p>
                </div>
            </fieldset>
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding">
                    <p><b><?php echo Yii::t('front', 'Numero de datos cargados'); ?>:</b></p>                       
                </div>
                <div class="large-5 medium-12 small-12 columns padding">
                    <p id="data-count"></p>
                </div>
            </fieldset>
            <div class="clear"></div>
            <input type="hidden" id="import-lot" name="lot" />
            <input type="hidden" id="import-idCustomer" name="idCustomer" />
            <input type="hidden" id="import-typeImport" name="typeImport" />
    </div>
    <div class="modal-footer">    
        <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Finalizar'); ?></button>
        <a href="#" class="btnb pop waves-effect waves-light right deleteImport" ><?php echo Yii::t('front', 'Declinar'); ?></a>
    </div>
    </form>
</section>