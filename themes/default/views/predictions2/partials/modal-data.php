<section id="load_db" class="modal modal-s">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'Confirmación de Importación'); ?></h1>
    </div>
    <form class="formweb form-import-data" action="" method="">
    <div class="row padd_v">
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding hide">
                    <p><b><?php echo Yii::t('front', 'Total capital cargado'); ?>:</b></p>                  
                </div>
                <div class="large-5 medium-12 small-12 columns padding hide">     
                    <p id="data-total"></p>
                </div>
            </fieldset>
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding">
                    <p><b><?php echo Yii::t('front', 'Número total de registros cargados'); ?>:</b></p>                       
                </div>
                <div class="large-5 medium-12 small-12 columns padding">
                    <p id="data-count"></p>
                </div>
            </fieldset>
            <div class="clear"></div>
            <input type="hidden" id="import-lot" name="lot" />
            <input type="hidden" id="import-idCustomer" name="idCustomer" />
            <input type="hidden" id="import-id" name="id" />
            <fieldset class="large-12 medium-12 small-12 columns padding">                
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </fieldset>
    </div>
      
    <div class="modal-footer">    
        <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Finalizar'); ?></button>
        <a href="#" class="btnb pop waves-effect waves-light right deleteImport" ><?php echo Yii::t('front', 'Declinar'); ?></a>
    </div>
    </form>
</section>

<section id="load_assignments" class="modal modal-s">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'Confirmación de Asignación'); ?></h1>
    </div>
    <form class="formweb form-import-assignments" action="" method="">
    <div class="row padd_v">
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding">
                    <p><b><?php echo Yii::t('front', 'Total titulares'); ?>:</b></p>                  
                </div>
                <div class="large-5 medium-12 small-12 columns padding">     
                    <p id="assignments-count"></p>
                </div>
            </fieldset>
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding">
                    <p><b><?php echo Yii::t('front', 'Titulares no encontrados'); ?>:</b></p>                       
                </div>
                <div class="large-5 medium-12 small-12 columns padding">
                    <p id="assignments-error"></p>
                </div>
            </fieldset>
            <div class="clear"></div>
            <input type="hidden" id="assignments-id" name="id" />
    </div>
    <div class="modal-footer">    
        <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Finalizar'); ?></button>
        <a href="#" class="btnb pop waves-effect waves-light right deleteAssignments" ><?php echo Yii::t('front', 'Declinar'); ?></a>
    </div>
    </form>
</section>