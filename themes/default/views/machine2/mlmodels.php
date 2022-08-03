<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row m_b_10">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("front", 'Modelos'); ?></h2>                         
            </div>
        </section>
        <div class="clear"></div>  
        <section class="row p_t_50">
            <section class="row">
                <!-- filter -->            
                <?php $this->renderPartial('/machine/partials/filter-models', array()); ?>
                <!-- END filter -->
            </section>
        </section>
        <section class="m_b_20">                
            <div class="row">
                <div class="large-12 medium-12 small-12 columns padding"> 
                    <div class="padd_all white border_indicators ">
                        <!-- filter -->            
                        <?php $this->renderPartial('/machine/partials/filter-models-chart', array()); ?>
                        <!-- END filter -->
                        <div id="container" class="padd_all white" style="width: 100%; min-height: 60vh;"></div> 
                    </div>
                </div>
            </div>
        </section>
        <section class="m_t_20 padding">
            <article id="debtors_list" class="block hide">
                <?php $this->renderPartial('/wallet/partials/content-debtor-table', array('mlModels' => $mlModels, 'clustersSelect' => $clustersSelect, 'ageDebts' => $ageDebts, 'debtorState' => $debtorState,  'modelML' => $modelML)); ?>
            </article> 
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-more.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/test.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/machine.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/machine/partials/modal-machine', array());
$js = '';

if (isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
    $js .= '$("#form-filter-name").val("' . $_REQUEST['name'] . '");';
}
if (isset($_REQUEST['description']) && $_REQUEST['description'] != '') {
    $js .= '$("#form-filter-description").val("' . $_REQUEST['description'] . '");';
}
if ($js != '') {
    $js .= "$('.btn-filter-advance').trigger('click');";
}

Yii::app()->clientScript->registerScript("debtor_list_js", '
   $(document).ready(function(){    
    ' . $js . '
   });
   
', CClientScript::POS_END
);
