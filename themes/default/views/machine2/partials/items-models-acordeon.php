<?php
//              Managements  
$criteriaClusters = new CDbCriteria();   
$criteriaClusters->select = 't.*';
$criteriaClusters->condition = 't.idMLModel ='.$model->id;
$criteriaClusters->order = 't.id ASC';

$countClusters = Clusters::model()->count($criteriaClusters);

$pagesClusters = new CPagination($countClusters);
$pagesClusters->pageSize = $this->pSize;
$pagesClusters->applyLimit($criteriaClusters);  

$clusters = Clusters::model()->findAll($criteriaClusters); 

?>
<li class="content_acord">
    <div class="acordeon acordeon_cluster" data-id="mlModels-<?php echo $model->id; ?>-" id="mlModels-<?php echo $model->id; ?>-title">                          
        <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
        <?php echo $model->name; ?>
    </div>
    <div class="clearfix respuesta panelBG">
        <div class="clear"></div> 
        <div id="content-mlmodels-<?php echo $model->id; ?>">
            <?php
            $this->renderPartial('/machine/partials/form-mlmodels', array('model' => $model));
            ?>
        </div> 
        <?php if($countClusters > 0){ ?>
        <div id="content-clusters-<?php echo $model->id; ?>">
            <?php
            $this->renderPartial('/machine/partials/content-clusters', array('model' => $model, 'clusters' => $clusters, 'pagesClusters' => $pagesClusters));
            ?>
        </div> 
        <?php } ?>
    </div>
</li>  

