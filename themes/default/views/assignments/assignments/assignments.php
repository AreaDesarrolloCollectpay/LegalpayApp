<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">

            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Asignaciones") ?></h2>
                <div class="acions_head txt_right">
                    <a href="<?php echo Yii::app()->baseUrl; ?>/assets/PlantillaDeudores.csv" class="btnb download" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>                
                </div>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_60">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
                        <form enctype="multipart/form-data"  class="formweb wrapper_s form-assignments" >
                            <p class="hide"><?= Yii::t("database", "Elige el cliente a recuperar la cartera.") ?></p> 
                            <?php if (Yii::app()->user->getState('rol') == 17) { ?>
                                <input type="hidden" id="assignments-idCustomer" name="idCustomer" value="<?php echo Yii::app()->user->getId(); ?>" />
                            <?php }else{ ?>                                
                            <label class=""><?= Yii::t("database", "Elige el cliente a recuperar la cartera.") ?></label> 
                                <select id="assignments-idCustomer" name="idCustomer">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                    <?php foreach ($customers as $customer) { ?>                        
                                        <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                                    <?php } ?>
                                </select>
                            <?php }  ?>
                            <div class="file-field input-field hide">
                                <div class="btn">
                                    <span><?php echo Yii::t('front', 'Cargar archivo'); ?></span>
                                    <input class="" name="file_" id="assignments-file" type="file" accept=".csv">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                            <input class="dropify" name="file" id="assignments-file" type="file" accept=".csv">
                            <div class="clear"></div>
                            <p class="hide">
                                <input type="checkbox" class="filled-in" id="terms" name="terms" checked="checked" />
                                <label for="terms" style="padding: 6px 0 0 34px;"><?= str_replace("::url", "</a>", str_replace("url::", "<a href='#terms-modal' class=\"modal_clic\">", Yii::t("database", "terminosCondiciones"))) ?></label>
                            </p>
                            <div class="centerbtn">
                                <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'SIGUIENTE'); ?></button>
                            </div>
                            <div class="clear"></div>
                        </form>
                    </section>
                    <section class="row">
                        <fieldset class="large-6 medium-6 small-6 columns ">
                            <a href="<?php echo Yii::app()->baseUrl.'/assignments/adviser'; ?>" class="btnb waves-effect waves-light left"><?= Yii::t("front", "Asignación Asesores") ?></a>
                        </fieldset>
                    </section>
                    <!--All assignments-->
                    <section class="panelBG m_t_10 content-scroll-x <?php echo ($count > 0)? '' : 'hide'; ?> ">
                        <table class="bordered highlight">
                            <thead>
                                <tr class="backgroung-table-2">
                                    <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'NÚMERO DE OBLIGACIONES'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                </tr>
                                <tr class="filters formweb" data-id="assignments" data-url="assignments">
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-customer" type="text" name="customer" /></th>
                                    <th class="txt_center"><input name="date" type="text" class="filter-table calendar_range" value=""></th>
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-accounts" type="text" name="accounts" /></th>
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-capital" type="text" name="capital" readonly /></th>                                    
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-" type="text" name="" readonly /></th>                                    
                                    <th class="hide"><input id="cluster-filter-page" name="page" type="hidden" class="filter-table" value="1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-assignments">
                                <?php $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model)); ?>
                            </tbody>
                        </table>
                        <div class="clear"></div>  
                        <div id="pagination-assignments" class="bg-pagination">  
                            <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'assignments')); ?>                                    
                        </div>
                    </section>
                    <!--Fin All assignments-->
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/assignments.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/assignments/partials/modal-data', array());


Yii::app()->clientScript->registerScript("dropify","
   $(document).ready(function(){    
        $('.dropify').dropify({
            messages: {
                'default': 'Arrastre y suelte un archivo aquí o haga click',
                'replace': 'Arrastre y suelte o haga click para reemplazar',
                'remove':  'Remover',
                'error':   'Sucedio un error'
            }
        });  
   });
   
",
 CClientScript::POS_END
);

