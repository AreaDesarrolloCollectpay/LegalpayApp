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
                        <div class="row">
                            <div class="clear"></div>
                            <div class="large-12 medium-12 small-12 columns padding m_t_20">
                                <div class="modal-header row p_b_10">
                                    <h1><?php echo Yii::t('front', 'LLAMADAS EN ESPERA'); ?></h1>
                                </div>                            
                            </div>
                            <div class="large-4 medium-4 small-12 columns padding m_t_20">
                                <section class="content-scroll-x">
                                    <div class="clearfix">                                        
                                    <div class="modal-header row p_b_10">
                                        <h1><?php echo Yii::t('front', 'INBOUND'); ?> : 0</h1>
                                    </div>
                                        <table class="bordered highlight">                                            
                                            <thead>
                                                <tr class="backgroung-table-4">
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'EXT'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'EVENTO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'DURACIÓN'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CLID'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-users">                                                                                        
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="clear"></div>
                                </section>
                                <!--Fin Datos acordeon-->
                            </div>
                            <div class="large-4 medium-4 small-12 columns padding m_t_20">
                                <section class="content-scroll-x">
                                    <div class="clearfix">                                        
                                    <div class="modal-header row p_b_10">
                                        <h1><?php echo Yii::t('front', 'OUTBOUND'); ?> : 4</h1>
                                    </div>
                                        <table class="bordered highlight"> 
                                            <thead>
                                                <tr class="backgroung-table-4">
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'EXT'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'EVENTO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'DURACIÓN'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CLID'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-users_">
                                                <tr id="itemUsers_" style="background: #e7f7ed">
                                                    <td class = "txt_center"><?= '1637'; ?></td>
                                                    <td class = "txt_center"><?= 'UP'; ?></td>
                                                    <td class = "txt_center"><?= 'DIAL'; ?></td>
                                                    <td class = "txt_center"><?= '1:26'; ?></td>
                                                    <td class = "txt_center"><?= '3167469774'; ?></td>
                                                </tr>                                             
                                                <tr id="itemUsers_1" style="background: #e7f7ed">
                                                    <td class = "txt_center"><?= '1629'; ?></td>
                                                    <td class = "txt_center"><?= 'UP'; ?></td>
                                                    <td class = "txt_center"><?= 'DIAL'; ?></td>
                                                    <td class = "txt_center"><?= '0:26'; ?></td>
                                                    <td class = "txt_center"><?= '3178078098'; ?></td>
                                                </tr>                                             
                                                <tr id="itemUsers_2" style="background: #f7e7e7">
                                                    <td class = "txt_center"><?= '1631'; ?></td>
                                                    <td class = "txt_center"><?= 'RING'; ?></td>
                                                    <td class = "txt_center"><?= 'DIAL'; ?></td>
                                                    <td class = "txt_center"><?= '0:16'; ?></td>
                                                    <td class = "txt_center"><?= '3136762121'; ?></td>
                                                </tr>                                             
                                                <tr id="itemUsers_3" style="background: #f7e7e7">
                                                    <td class = "txt_center"><?= '1621'; ?></td>
                                                    <td class = "txt_center"><?= 'RING'; ?></td>
                                                    <td class = "txt_center"><?= 'DIAL'; ?></td>
                                                    <td class = "txt_center"><?= '0:01'; ?></td>
                                                    <td class = "txt_center"><?= '3127918475'; ?></td>
                                                </tr>                                             
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="clear"></div>
                                </section>
                                <!--Fin Datos acordeon-->
                            </div>
                            <div class="large-4 medium-4 small-12 columns padding m_t_20">
                                <section class="content-scroll-x">
                                    <div class="clearfix">                                        
                                    <div class="modal-header row p_b_10">
                                        <h1><?php echo Yii::t('front', 'DISPONIBLES'); ?> : 7</h1>
                                    </div>
                                        <table class="bordered highlight"> 
                                            <thead>
                                                <tr class="backgroung-table-4">
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'EXT'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'DURACIÓN'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-users_">
                                                <tr id="itemUsers_">
                                                    <td class = "txt_center"><?= '1237'; ?></td>
                                                    <td class = "txt_center"><?= '00:00:26'; ?></td>
                                                </tr>                                          
                                                <tr id="itemUsers_">
                                                    <td class = "txt_center"><?= '1647'; ?></td>
                                                    <td class = "txt_center"><?= '00:01:03'; ?></td>
                                                </tr>                                          
                                                <tr id="itemUsers_">
                                                    <td class = "txt_center"><?= '1677'; ?></td>
                                                    <td class = "txt_center"><?= '00:01:29'; ?></td>
                                                </tr>                                          
                                                <tr id="itemUsers_">
                                                    <td class = "txt_center"><?= '1657'; ?></td>
                                                    <td class = "txt_center"><?= '00:01:46'; ?></td>
                                                </tr>                                          
                                                <tr id="itemUsers_">
                                                    <td class = "txt_center"><?= '1636'; ?></td>
                                                    <td class = "txt_center"><?= '00:02:02'; ?></td>
                                                </tr>                                          
                                                <tr id="itemUsers_">
                                                    <td class = "txt_center"><?= '1137'; ?></td>
                                                    <td class = "txt_center"><?= '00:02:26'; ?></td>
                                                </tr>                                          
                                                <tr id="itemUsers_">
                                                    <td class = "txt_center"><?= '1687'; ?></td>
                                                    <td class = "txt_center"><?= '00:02:27'; ?></td>
                                                </tr>                                          
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="clear"></div>
                                    <div class="large-12 medium-12 small-12 columns padding m_t_20"></div>                                    
                                </section>
                                <!--Fin Datos acordeon-->
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/unattended.min.js', CClientScript::POS_END);
