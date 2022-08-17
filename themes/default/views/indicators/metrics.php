<section class="cont_home">       
    <section class="conten_inicial">
<div class="dates_all topBarJuridico">
 <ul class="filter_views">      
		
		<li><a href="/indicators/metrics" id="m-metrics" class="active" ><i class="feather feather-activity"></i> Métricas</a></li>
		<li><a href="/indicators/tendencies" id="m-tendencies"><i class="fa fa-chart-line"></i> Trazabilidad</a></li>
		<!--<li><a href="/indicators/performance" id="m-performance" ><i class="feather feather-target"></i> KPI's</a></li>-->
		<li><a href="/indicators" id="m-indicatorsf"  ><i class="feather feather-pie-chart"></i> Informes</a></li>	
		</ul>
	</div>
        <section class="row">
            <?php
            $this->renderPartial('/indicators/partials/filter-goals', array('active' => 2, 'url' => 'customers',                
                
                ));
            ?>       
            <section class="padding">             
                <section class="list_dash animated fadeInUp">
                    <ul>
                        <?php 
                        $i = 1;
                        foreach ($models as $model){ ?>
                        <li class="large-6 <?php echo (($i == $count) && (($i%2) == 1))? 'medium-offset-3' : 'medium-6'; ?> small-12 columns">
                            <div class="row">
                                <div class="large-12 medium-12 small-12 columns ">                                                                              
                                    <div id="canvas<?php echo $model->id; ?>" class="padd_all white border_indicators " style="width: 100%; height: 50vh;"></div> 
                                </div>
                            </div>
                        </li>
                        <?php 
                            $i++;
                        } ?>       
                        <li class="large-12 medium-12 small-12 columns">
                            <div class="row white border_indicators">                                
                                <div class="bg-pagination">  
                                    <?php  $this->widget('CLinkPager', array(
                                     'pages' => $pages,
                                     'header' => '',
                                     'firstPageCssClass' => '',
                                     'selectedPageCssClass' => 'active ',
                                     'previousPageCssClass' => 'prev ',
                                     'nextPageCssClass' => 'next',
                                     'hiddenPageCssClass' => 'disbled',
                                     'internalPageCssClass' => '',
                                     'lastPageCssClass' => '',
                                     'htmlOptions' => array(
                                         'class' => 'pagination txt_center'),
                                         )
                                 ); ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>
                <!--Fin Global Dashboard-->
            </section>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-more.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/metrics.min.js', CClientScript::POS_END);

foreach ($models as $model){    
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/goals'.$model->id.'.min.js', CClientScript::POS_END);
}

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
