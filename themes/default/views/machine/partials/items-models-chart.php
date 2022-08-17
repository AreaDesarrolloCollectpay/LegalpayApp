<?php 
// Clusters  
$criteriaClusters = new CDbCriteria();   
$criteriaClusters->select = 't.*';
$criteriaClusters->condition = 't.idMLModel ='.$mlModel->id;
$criteriaClusters->order = 't.id ASC';

$countClusters = Clusters::model()->count($criteriaClusters);

$pagesClusters = new CPagination($countClusters);
$pagesClusters->pageSize = 20;
$pagesClusters->applyLimit($criteriaClusters);  

$clusters = Clusters::model()->findAll($criteriaClusters); 
                
?>
<div class="tab acordeon_cluster hide" data-id="mlModels-<?php echo $mlModel->id; ?>-" ></div>
<section class=" m_b_20 lista_all_deudor">
    <section class="row">                            
        <div id="content-mlmodels-<?php  echo $mlModel->id;  ?>" <?php echo $countClusters; ?>>
            <?php Yii::app()->controller->renderPartial('/machine/partials/form-mlmodels', array('model' => $mlModel)); ?>
        </div>
    </section>
    <?php if ($countClusters > 0) { ?>
        <section class="row content-scroll-x m_t_10" id="content-clusters-<?php //echo $mlModel->id; ?>">
            <ul class="bg_acordeon"> 
                <li class="content_acord" id="">
                    <div class="acordeon walletSupports">                          
                        <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                        <?php echo Yii::t('front', 'CLUSTERS'); ?>
                    </div>
                    <div class="clearfix respuesta">
                        <div class="clear"></div>                                                                                                  
                        <?php
                        $this->renderPartial('/machine/partials/content-clusters', array('model' => $mlModel, 'clusters' => $clusters, 'pagesClusters' => $pagesClusters));
                        ?>
                    </div>
                </li>
            </ul>
        </section> 
    <?php } ?>
</section>
<?php

Yii::app()->clientScript->registerScript("machine_js",'
   $(document).ready(function(){    
        $(".acordeon_cluster").click(); 
        console.log("click");
   });
   
',
 CClientScript::POS_END
);
