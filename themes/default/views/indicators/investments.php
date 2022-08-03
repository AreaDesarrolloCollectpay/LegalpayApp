<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">            
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("front", "Valoración") ?></h2>
                <div class="acions_head txt_right">
                    <a href="<?php echo Yii::app()->baseUrl; ?>/assets/PlantillaInversion.csv" class="btnb download" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>                
                </div>
            </div>
        </section>
        <section class="row p_t_80">
            <!-- filter -->            
            <?php
            $this->renderPartial('/indicators/partials/filter-investments', array('active' => 2, 'url' => 'customers', 'regions' => $regions,
                'ageDebts' => $ageDebts,
                'coodinators' => $coodinators,
                'customers' => $customers,));
            ?>            
            <!-- END filter -->
            <?php
            Yii::app()->controller->renderPartial('/layouts/partials/content-investment', array('indicators' => $indicators));
            ?>
            <section class="m_b_20">
                <section class="padd_v">
                    <div class="row">  
                        <div class="large-6 medium-6 small-6 columns padding">                                                                              
                            <div id="canvas-5" class="padd_all white border_indicators " style="width: 100%; min-height: 70vh;"></div> 
                        </div>
                        <div class="large-6 medium-6 small-6 columns padding">                                                                              
                            <div id="canvas-6" class="padd_all white border_indicators " style="width: 100%; min-height: 70vh;"></div> 
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->controller->renderPartial('/indicators/partials/modal-data', array());
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/financeJS/finance.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highstock.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/investments.min.js', CClientScript::POS_END);

