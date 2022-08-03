<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false)); ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Planes") ?></h2>
            </div>
            <div class="clear"></div> 
        </section>
        <section class="row m_t_60">
            <section class="padding animated fadeInUp m_t_20">
                <section class="drag-container">
                    <ul class="drag-list listPricing txt_center">
                        <li class="drag-column drag-column-on-hold">                            
                            <div class="scrolldash">  
                                <div class="content-pricing">
                                    <div>
                                        <h4><i class="feather feather-star" ></i> Platino</h4>                                        
                                    </div>
                                    <h4 class="price">$ 95.000 + iva</h4>
                                    <span>Valor por usuario</span>
                                    <h4><?php //echo 'CC / NIT '; ?>  <?php //echo $model->code; ?></h4>
<!--                                    <h4 class="cant"><i class="feather feather-user"></i>  1 usuario </h4>
                                    <span>Des paquete</span>-->
                                    <h4 class="cant">INCLUYE</h4>
                                    <span>Los siguientes modulos :</span>
                                    <br>
                                    <br>
                                    <span>CLIENTES</span>
                                    <br>
                                    <span>EQUIPO</span>
                                    <br>
                                    <span>ASIGNACIÓN</span>
                                    <br>
                                    <span>GESTIÓN</span>
                                    <br>
                                    <span>TAREAS</span>
                                    <br>
                                    <span>INFORMES</span>
                                    <br>
                                    <span>HISTORIAL</span>
                                    <span><?php //echo Yii::t('front', 'Prescribe'); ?> <?php //echo Yii::app()->dateFormatter->format('dd/MM/yyyy', $model->prescription); ?></span>
                                    <span class="<?php //echo $lastManagement['color']; ?>-text"><?php //echo Yii::t('front', 'Última Gestión'); ?><?php //echo $lastManagement['date']; ?></span>
                                    
                                </div>
                                <div class="btn-pricing">
                                    <a href="#!" class="btnb waves-effect waves-light "><?= Yii::t("front", "Comience Ahora") ?></a>
                                </div>
                            </div>
                        </li>
                        <li class="drag-column drag-column-on-hold">                            
                            <div class="scrolldash">  
                                <div class="content-pricing">
                                    <div class="circle"></div>
                                    <h4>Gold</h4>
                                    <h4><?php //echo 'CC / NIT '; ?>  <?php //echo $model->code; ?></h4>
                                    <h4 class="cant"><i class="feather feather-user"></i>  1 usuario </h4>
                                    <span>Des paquete</span>
                                    <h4 class="cant">INCLUYE</h4>
                                    <span>Los siguientes modulos :</span>
                                    <br>
                                    <br>
                                    <span>PORTAFOLIOS</span>
                                    <br>
                                    <span>CLIENTES</span>
                                    <br>
                                    <span>EQUIPO</span>
                                    <br>
                                    <span>ASIGNACIÓN</span>
                                    <br>
                                    <span>GESTIÓN</span>
                                    <br>
                                    <span>CAMPAÑAS</span>
                                    <br>
                                    <span>TAREAS</span>
                                    <br>
                                    <span>INFORMES</span>
                                    <br>
                                    <span>METRICAS</span>
                                    <br>
                                    <span>TRAZABILIDAD</span>
                                    <br>
                                    <span>KPI’S</span>
                                    <br>
                                    <span>GARANTIAS</span>
                                    <br>
                                    <span>FACTURACIÓN</span>
                                    <br>
                                    <span>HISTORIAL</span>
                                    <span><?php //echo Yii::t('front', 'Prescribe'); ?> <?php //echo Yii::app()->dateFormatter->format('dd/MM/yyyy', $model->prescription); ?></span>
                                    <span class="<?php //echo $lastManagement['color']; ?>-text"><?php //echo Yii::t('front', 'Última Gestión'); ?><?php //echo $lastManagement['date']; ?></span>
                                    <h4 class="price">$ 125.000 + iva</h4>
                                </div>
                                <div class="btn-pricing">
                                    <a href="#!" class="btnb waves-effect waves-light "><?= Yii::t("front", "Comience Ahora") ?></a>
                                </div>
                            </div>
                        </li>
                        <li class="drag-column drag-column-on-hold">                            
                            <div class="scrolldash">  
                                <div class="content-pricing">
                                    <div class="circle"></div>
                                    <h4>Premium</h4>
                                    <h4><?php //echo 'CC / NIT '; ?>  <?php //echo $model->code; ?></h4>
                                    <h4 class="cant"><i class="feather feather-user"></i> 1 usuario </h4>
                                    <span>Des paquete</span>
                                    <h4 class="cant">INCLUYE</h4>
                                    <span><?php //echo Yii::t('front', 'Prescribe'); ?> <?php //echo Yii::app()->dateFormatter->format('dd/MM/yyyy', $model->prescription); ?></span>
                                    <span>Los siguientes modulos :</span>
                                    <br>
                                    <br>
                                    <span>PORTAFOLIOS</span>
                                    <br>
                                    <span>CLIENTES</span>
                                    <br>
                                    <span>EQUIPO</span>
                                    <br>
                                    <span>ASIGNACIÓN</span>
                                    <br>
                                    <span>MODELOS (Clusters ML)</span>
                                    <br>
                                    <span>PROBALIDAD (Predicción ML)</span>
                                    <br>
                                    <span>PSM</span>
                                    <br>
                                    <span>VALORACIÓN</span>
                                    <br>
                                    <span>GESTIÓN</span>
                                    <br>
                                    <span>CAMPAÑAS</span>
                                    <br>
                                    <span>TAREAS</span>
                                    <br>
                                    <span>INFORMES</span>
                                    <br>
                                    <span>METRICAS</span>
                                    <br>
                                    <span>TRAZABILIDAD</span>
                                    <br>
                                    <span>KPI’S</span>
                                    <br>
                                    <span>GARANTIAS</span>
                                    <br>
                                    <span>FACTURACIÓN</span>
                                    <br>
                                    <span>HISTORIAL</span>
                                    <span class="<?php //echo $lastManagement['color']; ?>-text"><?php //echo Yii::t('front', 'Última Gestión'); ?><?php //echo $lastManagement['date']; ?></span>
                                    <h4 class="price">$ 145.000 + iva</h4>
                                </div>
                                <div class="btn-pricing">
                                    <a href="#!" class="btnb waves-effect waves-light "><?= Yii::t("front", "Comience Ahora") ?></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>

            </section>

        </section>
    </section>
</section>
<style>
    .connectedSortable {
        overflow-y: scroll;
        max-height: 300px;
    }
</style>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/wallet.legal.min.js', CClientScript::POS_END);
if(Yii::app()->user->getState('rol') != 7){
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/sortable.legal.min.js', CClientScript::POS_END);
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
?>
