<?php 
// $this->renderPartial('/layouts/partials/side-nav', array('task' => false)); ?>
<section class="cont_home">
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php
            //$this->renderPartial('/wallet/partials/filter-debtors', array('active' => 2,'url' => $url, 'urlExport' => $urlExport, 'debtorState' => $debtorState, 'id' => $id, 'quadrant' => $quadrant, 'coordinators' => $coordinators, 'legal' => $legal, 'mlModels' => $mlModels)); ?>            
            <!-- END filter -->
        </section>
        <section class="row"><!-- dashContent p_t_25  -->

            <section class="padding ">
                
                <section class="row m_t_10 m_b_20 hide">
                    <div class="large-3 medium-6 small-12 columns">
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="panel total_billing txt_center">
                                <h3><?php echo Yii::t('front', 'ASIGNACIÓN'); ?></h3>
                            </div>                            
                        </div>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="panel total_billing txt_center">
                                <h3 class="val">$ <?php echo Yii::app()->format->formatNumber((isset($total))? $total : 0); ?></h3>
                            </div>                            
                        </div>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="panel total_billing txt_center">
                                <h3><?php echo Yii::t('front', 'USUARIOS'); ?></h3>
                            </div>                            
                        </div>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="panel total_billing txt_center">
                                <h3 class="val"> <i class="fa fa-user"></i> <?php echo (isset($accounts))? $accounts : 0; ?></h3>
                            </div>                            
                        </div>
                    </div> 
                    <div class="large-9 medium-6 small-12 columns ">
                    </div> 
                </section>

                <!--Datos iniciales-->
                <?php
//                Yii::app()->controller->renderPartial('/layouts/partials/content-indicators', array('indicators' => $indicators));
                ?>
                <!--Fin Datos iniciales-->
                <div class="block m_t_10">
                    <ul class="tabs tab_cartera hide">
                        <li class="tab"><a href="#debtors_list"><?php echo Yii::t('front', 'LISTADO'); ?></a></li>
                        <li class="tab acordeon_cluster hide" data-id="mlModels-<?php //echo $mlModel->id; ?>-" ><a href="#debtors_chart"><?php echo Yii::t('front', 'MODELO'); ?></a></li>
                    </ul>
                </div>                
                <article id="debtors_list" class="block">                    
                    <!--All deudores-->
                    <?php $this->renderPartial('/wallet/partials/content-debtor-table', array('mlModels' => $mlModels, 'clusterML' => $clusterML, 'clustersSelect' => $clustersSelect, 'ageDebts' => $ageDebts, 'debtorState' => $debtorState, 'model' => $model, 'pages' => $pages, 'currentPage' => $currentPage, 'modelML' => $modelML)); ?>                    
                    <!--Fin All deudores-->
                </article>                
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/wallet.min.js', CClientScript::POS_END);
if (isset($historic) && $historic) {
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/historic.min.js', CClientScript::POS_END);
}else{
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/collect.min.js', CClientScript::POS_END);    
}

$js = '';

if(isset($_GET['customer']) && $_GET['customer'] != ''){
    $js .= '$("#form-filter-customer").val("'.$_GET['customer'].'");';
}

if(isset($_GET['name']) && $_GET['name'] != ''){
    $js .= '$("#form-filter-name").val("'.$_GET['name'].'");';
}

if(isset($_GET['code']) && $_GET['code'] != ''){
    $js .= '$("#form-filter-code").val("'.$_GET['code'].'");';
}

if(isset($_GET['investigation']) && $_GET['investigation'] != ''){
    $js .= '$("#form-filter-investigation").val("'.$_GET['investigation'].'");';
}

if(isset($_GET['city']) && $_GET['city'] != ''){
    $js .= '$("#form-filter-city").val("'.$_GET['city'].'");';
}

if(isset($_GET['idState']) && $_GET['idState'] != ''){
    $js .= '$("#form-filter-idState").val('.$_GET['idState'].').trigger("change");';
}

if(isset($_GET['idCoordinator']) && $_GET['idCoordinator'] != ''){
    $js .= '$("#form-filter-idCoordinator").val('.$_GET['idCoordinator'].').trigger("change");';
}

if(isset($_GET['order']) && $_GET['order'] != ''){
    $js .= '$("#form-filter-order").val("'.$_GET['order'].'").trigger("change");';
}

$filter = (isset($_GET['filter']))? false : true;  
if($js != '' && $filter){
    $js .= "$('.btn-filter-advance').trigger('click');";
}

Yii::app()->clientScript->registerScript("debtor_list_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);

