<section class="cont_home">       
    <section class="conten_inicial">
	
 <ul class="filter_views">      
		
		<li><a href="/indicators/metrics" id="m-metrics"  ><i class="feather feather-activity"></i> Métricas</a></li>
		<li><a href="/indicators/tendencies" id="m-tendencies"><i class="fa fa-chart-line"></i> Trazabilidad</a></li>
		<!--<li><a href="/indicators/performance" id="m-performance" ><i class="feather feather-target"></i> KPI's</a></li>-->
		<li><a href="/indicators" id="m-indicatorsf" class="active" ><i class="feather feather-pie-chart"></i> Informes</a></li>	
		</ul>
	</div>
        <section class="row">            
            <section class="m_t_10">                
                <?php
                Yii::app()->controller->renderPartial('/layouts/partials/content-indicators', array('indicators' => $indicators));
                ?>
            </section>
            <section class="m_b_20">                
                <div class="row">
                    <div class="large-12 medium-12 small-12 columns padding"> 
                        <div class="padd_all white border_indicators ">
                            <!-- filter -->            
                            <?php
                            $this->renderPartial('/indicators/partials/filter-indicators', array('active' => 2, 'url' => 'customers', 'regions' => $regions,
                                'ageDebts' => $ageDebts,
                                'coordinators' => $coordinators,
                                'customers' => $customers,));
                            ?>            
                            <!-- END filter -->
                            <div id="canvas" style="width: 100%; min-height: 70vh;"></div> 
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
$this->renderPartial("/indicators/partials/modal-indicators", array());
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/indicators.min.js', CClientScript::POS_END);

$script = '';

if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) {
    $script .= '$("#indicators-idCustomer").val("' . Yii::app()->user->getId() . '").trigger("change");
                $(".item-customer").addClass("hide");
            ';
}
Yii::app()->clientScript->registerScript("indicators", '
        
    $(document).ready(function(){
        
        ' . $script . '
    });
            
    ', CClientScript::POS_END
);
