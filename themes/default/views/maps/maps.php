<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php $this->renderPartial('/maps/partials/filter-maps', array('active' => 2,'url' => 'customers',
                'regions' => $regions,
                'customers' => $customers,
                'ageDebts' => $ageDebts,
                'coodinators' => $coodinators,
                )); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding m_b_20 contacto">
                <div class="panelBG">
                    <div id="map" class="map" style="width: 100%; min-height: 100vh;"></div>
                </div>              
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php 
Yii::app()->clientScript->registerScriptFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', CClientScript::POS_END);    
Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyC8ysVqZhWl_9A2_f7JK63zz_9HK-FvbIQ', CClientScript::POS_END,array('defer' => true));    
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/maps.min.js', CClientScript::POS_END);    
$script = '';

if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){
    $script .= '$("#maps-idCustomer").val("'.Yii::app()->user->getId().'").trigger("change");
                $(".item-customer").addClass("hide");
            ';
}
 
$idCoordinator = Yii::app()->user->getState('idCoordinator');
$hide = false;
    if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
        $idCoordinator =Yii::app()->user->getId();
        $hide = true;
    }

    if($hide){        
        $script .= '$("#maps-idCoordinator").val("'.$idCoordinator.'").trigger("change").css("pointer-events","none");';        
    }
    
    Yii::app()->clientScript->registerScript("indicators",'
        
    $(document).ready(function(){
        
        '.$script.'
    });
            
    ',
     CClientScript::POS_END
    );
?>
