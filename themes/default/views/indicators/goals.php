<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php
            $this->renderPartial('/indicators/partials/filter-goals', array('active' => 2, 'url' => 'customers',
                'coordinators' => $coordinators,
                'customers' => $customers,));
            ?>            
            <!-- END filter -->
            <?php
            Yii::app()->controller->renderPartial('/layouts/partials/content-indicators', array('indicators' => $indicators));
            ?>
            <section class="m_b_20">
                <section class="padd_v">
                    <div class="row">
                        <div class="large-12 medium-12 small-12 columns padding">                                                                              
                            <div id="canvas" class="padd_all white border_indicators " style="width: 100%; min-height: 70vh;"></div> 
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/goals.min.js', CClientScript::POS_END);

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
