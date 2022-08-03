<div class="tittle_head">
    <h2 class="inline"><?= Yii::t("database", $typeImport->name) ?></h2>
</div>
<div class="clear"></div>  
<section class="padding animated fadeInUp">
    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
        <form enctype="multipart/form-data"  class="formweb wrapper_s form-users-import">  
            <input type="hidden" name="idTypeImport" value="<?php echo $typeImport->id; ?>">
            <label><?php echo Yii::t('front', 'Seleccione Tipo de Importación'); ?></label> 
            <select id="type-import" name="type-import" required disabled>
                    <option value="0"><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                <?php foreach ($typeImports as $data) { ?>                        
                    <option value="<?php echo $data->id; ?>" <?php echo ($typeImport->id == $data->id) ? "selected":"" ?>><?php echo $data->name; ?></option>      
                <?php } ?>
            </select>        
            <p><?= Yii::t("database", $typeImport->description) ?> <a href="#" id="download-pl" class="" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>                </p> 
            <a href="#" id="downloadI" class="hide" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>
            <?php if (Yii::app()->user->getState('rol') == 1 || Yii::app()->user->getState('rol') == 3) { ?>                                
            <label><?php echo Yii::t('front', 'Cliente'); ?></label> 
                <select id="customer-na" name="idCustomer">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                             
                    <option value="<?php echo $customer->id; ?>" selected><?php echo $customer->name; ?></option>      
                </select>
            <?php } elseif (Yii::app()->user->getState('rol') == 7) { ?>
                <input type="hidden" id="assignments-idCustomer" name="idCustomer" value="<?php echo Yii::app()->user->getId(); ?>" />
            <?php } ?>
            <div class="file-field input-field">
                <div class="btn">
                    <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                    <input class="" name="file" id="assignments-file" type="file" accept=".csv">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <div class="clear"></div>
            <p class="hide">
                <input type="checkbox" class="filled-in" id="terms" name="terms" checked="checked" />
                <label for="terms" style="padding: 6px 0 0 34px;"><?= str_replace("::url", "</a>", str_replace("url::", "<a href='#terms-modal' class=\"modal_clic\">", Yii::t("database", "terminosCondiciones"))) ?></label>
            </p>
            <div class="centerbtn">
                <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'CARGAR'); ?></button>
                <a href="<?php echo Yii::app()->getBaseUrl()."/importations";?>" class="btnb pop waves-effect waves-light right"><?php echo Yii::t('front', 'VOLVER'); ?></a>
            </div>
            <div class="clear"></div>
        </form>
    </section>
    <?php $this->renderPartial('/importations/partials/data-table', array('model' => $model, 'count' => $count, 'pages' => $pages)); ?>
</section>
<!--Fin All assignments-->