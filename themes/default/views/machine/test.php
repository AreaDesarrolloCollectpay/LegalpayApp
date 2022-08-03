<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row m_b_10">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("front", 'Modelos'); ?></h2>    
            </div>
        </section>
        <div class="clear"></div>  
        <section class="row p_t_60">
            <section class="row">
                <!-- filter -->            
                <?php $this->renderPartial('/machine/partials/filter-models', array()); ?>
                <!-- END filter -->
            </section>
            <div class="large-12 medium-12 small-12 columns m_t_20 m_b_20">                                                                              
                <div id="container" class="padd_all white border_indicators " style="width: 100%; min-height: 60vh;"></div> 
            </div>
        </section>        
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-more.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/test.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/machine/partials/modal-machine', array());
