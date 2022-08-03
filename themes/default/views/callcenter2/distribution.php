<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));   ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <?php
                    $this->renderPartial('/callcenter/partials/item-tabs', array('active' => $active, 'id' => $id));
                ?>                  
                <section class="panelBG">
                    <?php
//                        $this->renderPartial('/callcenter/partials/filter-attend',array('active' => $active,'type' => 'attend','id' => $id));
                    ?>
                    <!--Tab 4-->
                    <article id="historia_pagos" class="block">
                        <!--Datos acordeon-->                                
                        <div class="clear"></div>
                        <div class="large-6 medium-6 small-12 columns padding m_t_20">
                            <section class="content-scroll-x">
                                <div class="clearfix">                                        
                                <div class="modal-header row p_b_10">
                                    <h1><?php echo Yii::t('front', 'DETALLES DEL REPORTE'); ?></h1>
                                </div>
                                    <table class="bordered highlight">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CAMPAÑA'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'INICIO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FINAL'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-users">
                                            <tr id="itemUsers">
                                                <td class = "txt_center"><?= 'PRUEBA'; ?></td>
                                                <td class = "txt_center"><?= '2019-05-04'; ?></td>
                                                <td class = "txt_center"><?= '2019-05-04'; ?></td>
                                            </tr>                                             
                                        </tbody>
                                    </table>                                        
                                </div>
                                <div class="clear"></div>
                            </section>
                            <!--Fin Datos acordeon-->
                        </div>
                        <div class="large-6 medium-6 small-12 columns padding m_t_20">
                            <section class="content-scroll-x">
                                <div class="clearfix">                                        
                                <div class="modal-header row p_b_10">
                                    <h1><?php echo Yii::t('front', 'TOTALES'); ?></h1>
                                </div>
                                    <table class="bordered highlight">                                                                                    
                                        <tbody id="tbody-users_">
                                            <tr id="itemUsers_">
                                                <td class = "txt_center"><?= 'Número de llamadas atendidas'; ?></td>
                                                <td class = "txt_center"><?= '1272'; ?></td>
                                            </tr>                                             
                                            <tr id="itemUsers_1">
                                                <td class = "txt_center"><?= 'Número de llamadas sin atender en Cola'; ?></td>
                                                <td class = "txt_center"><?= '277'; ?></td>
                                            </tr>                                             
                                            <tr id="itemUsers_2">
                                                <td class = "txt_center"><?= 'Número de llamadas abandonadas'; ?></td>
                                                <td class = "txt_center"><?= ''; ?></td>
                                            </tr>                                             
                                        </tbody>
                                    </table>                                        
                                </div>
                                <div class="clear"></div>
                            </section>
                            <!--Fin Datos acordeon-->
                        </div>
                        <div class="row">
                            <div class="large-12 medium-12 small-12 columns padding m_t_20">                                                                              
                                <div id="canvas" class="padd_all white border_indicators " style="width: 100%; min-height: 70vh;"></div> 
                            </div>
                        </div>                        
                    </article>
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/distribution.min.js', CClientScript::POS_END);
