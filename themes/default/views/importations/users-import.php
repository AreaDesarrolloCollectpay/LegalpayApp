<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", $data['name']) ?></h2>
            </div>
        </section>
        <section class="row p_t_80">
            <section class="padding animated fadeInUp">
                <section class="panelBG padd_all m_b_20">
                    <form enctype="multipart/form-data"  class="formweb wrapper_s form-users-import">  
                        <label><?php echo Yii::t('front', 'Seleccione Tipo de Importación'); ?></label> 
                        <select id="type-import" class="select-data-import" name="idTypeImport" required>
                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                            <?php foreach ($typeImports as $data) { ?>                        
                                <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>      
                            <?php } ?>
                        </select>        
                        <label><?php echo Yii::t('front', 'Cliente'); ?></label> 
                        <select id="customer-na" class="select-data-import" name="idCustomer">
                           <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                           <?php foreach ($customers as $customer) { ?>                        
                               <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                           <?php } ?>
                       </select>
                        <p><?= Yii::t("database", 'Descargue la plantilla, para realizar la importación respectiva') ?> <a href="#" id="download-pl" class="hide" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a></p> 
                        <a href="#" id="downloadI" class="hide" download=""><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>
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
                        </div>
                        <div class="clear"></div>
                    </form>
                </section>
                <section class="panelBG m_t_10 content-scroll-x <?php echo ($count > 0)? '' : 'hide'; ?> ">
                    <table class="bordered highlight">
                        <thead>
                            <tr class="backgroung-table-4">
                                <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'HORA'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'TIPO DE IMPORTACIÓN'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'NÚMERO DE REGISTROS'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'ARCHIVO'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="listDebtors"> 
                            <?php 
                            foreach ($model as $value) { 
                                  $this->renderPartial('/importations/partials/item-import', array('model' => $value));
                            } ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>  
                    <div class="bg-pagination">
                        <?php
                        $this->widget('CLinkPager', array(
                            'pages' => $pages,
                            'header' => '',
                            'selectedPageCssClass' => 'active',
                            'previousPageCssClass' => 'prev',
                            'nextPageCssClass' => 'next',
                            'hiddenPageCssClass' => 'disbled',
                            'internalPageCssClass' => 'pages',
                            'htmlOptions' => array(
                                'class' => 'pagination txt_center',
                                'id' => 'paginator-import')
                                )
                        );
                        ?>
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/users-import.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/importations/partials/modal-data', array());
?>
