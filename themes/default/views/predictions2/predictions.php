<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">

            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Probabilidades") ?></h2>
                <div class="acions_head txt_right hide">
                    <a href="<?php echo Yii::app()->baseUrl; ?>/assets/PlantillaDeudores.csv" class="btnb download" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>                
                </div>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_60">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
                        <div id="form-predictions"> 
                            <form enctype="multipart/form-data"  class="formweb wrapper_s form-predictions" >
                                <p class="hide"><?= Yii::t("database", "Elige el cliente para generar la probabilidad.") ?></p> 
                                <label class=""><?= Yii::t("front", 'Modelo de predicción') ?></label> 
                                <select id="predictions-idModel" name="idModel">
                                    <option value=""><?php echo Yii::t('front', 'Modelo predicción Demo'); ?></option>      
                                </select>
                                <?php if (Yii::app()->user->getState('rol') == 7) { ?>
                                    <input type="hidden" id="assignments-idCustomer" name="idCustomer" value="<?php echo Yii::app()->user->getId(); ?>" />
                                <?php }else{ ?>                                
                                <label class=""><?= Yii::t("database", "Elige el portafolio para generar la probabilidad") ?></label> 
                                <select id="predictions-idCustomer" name="idCustomer">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                    <?php foreach ($customers as $customer) { ?>                        
                                        <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                                    <?php } ?>
                                </select>
                                <?php }  ?>  
                                <div id="content-info-sources" class="hide">
                                    <label><?php echo Yii::t('front', 'Total de Obligaciones'); ?></label>
                                    <input type="text" id="predictions-total_debts" name="cant" value="" readonly>                                        
                                    <label><?php echo Yii::t('front', 'Total Capital'); ?></label>
                                    <input type="text" id="predictions-total_capital_debts" name="capital" value="" readonly>                                        
                                    <input type="hidden" id="predictions-file" name="file" value="" readonly>                                        
                                </div>    
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
                        </div>
                        <div id="form-predictions-status" class="row" style="display: none;">
                            <form enctype="multipart/form-data"  class="formweb wrapper_s" >                                
                                <h2 id="text-status" class="form-predictions-status" style="text-align: center; font-size: 20px; "><?php echo Yii::t('front', 'GENERANDO FUENTE DE DATOS ...') ?></h2>
                                <div class="centerbtn form-predictions-status">
                                    <div class="progress">
                                        <div class="indeterminate"></div>
                                    </div>
                                </div>
                                <div class="centerbtn">
                                    <div class="row txt-prediction" style="display: none;">     
                                        <span class="num" style="font-weight: bold; font-size: 60px; color: #48ea88;">
                                            <strong class="counter" >100</strong><strong>%</strong>
                                        </span>
                                        <p class="txt_center"><?php echo Yii::t('front', 'Probabilidad de recaudo de este portafolio'); ?></p>
                                    </div>                                    
                                </div>
                            </form>
                            <div class="large-12 medium-12 small-12 columns padding m_t_10 m_b_20">                                                                              
                                <div id="container" class="padd_all white border_indicators " style="width: 100%; min-height: 80vh; display: none;"></div> 
                            </div>
                        </div>
                    </section>
                   
                    <!--All assignments-->
                    <section class="panelBG m_t_10 content-scroll-x hide">
                        <table class="bordered highlight">
                            <thead>
                                <tr class="backgroung-table-2">
                                    <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'NÚMERO DE OBLIGACIONES'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'ARCHIVO'); ?></th>
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
                        <div id="pagination-assignments" class="bg-pagination hide">  
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/predictions.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/predictions/partials/modal-data', array());