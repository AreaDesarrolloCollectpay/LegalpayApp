<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php $this->renderPartial('/customers/partials/filter-customers', array('active' => 2,'url' => 'customers')); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <!-- <div class="block">
                    <ul class="tabs tab_cartera">
                        <li class="tab"><a href="<?php echo $this->createUrl('/customers'); ?>" class="active"><i class="fa fa-user" aria-hidden="true"></i> CLIENTES</a></li>
                    </ul>
                </div>    -->
                <section class="panelBG m_b_30">
                    <div class="row"> 
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                            <!--Datos acordeon-->                                
                            <div class="clear"></div>
                            <section class="content-scroll-x">
                                <div class="clearfix content-customers">                                        
                                    <table class="bordered highlight">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="14%" class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'NIT'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                <th width="13%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                            <tr class="filters formweb"  data-id="customers" data-url="customers">
                                                <th class="txt_center"><input class="filter-table" id="customers-filter-name" type="text" name="name" /></th>
                                                <th class="txt_center"><input class="filter-table" id="customers-filter-name" type="text" name="numberDocument" /></th>
                                                <th class="txt_center"><input class="filter-table" id="customers-filter-name" type="text" name="capital" readonly /></th>
                                                <th class="txt_center">
                                                    <select class="filter-table" id="customers-filter-active" name="active">
                                                        <option value=""><?php echo Yii::t('front', ''); ?></option>
                                                        <?php foreach ($states as $state) { ?>
                                                            <option value="<?php echo $state->id; ?>"><?php echo $state->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th class="txt_center"><input type="text" readonly /></th>
                                                <th class="hide"><input class="filter-table" id="customers-filter-page" name="page" type="hidden" value="1"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-customers">
                                            <?php $this->renderPartial('/customers/partials/content-customers-table', array('model' => $model)); ?>
                                        </tbody>
                                    </table>                                        
                                </div>
                                <div class="clear"></div>
                                <div id="pagination-customers" class="bg-pagination">                                    
                                    <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers')); ?>                                    
                                </div>
                            </section>
                            <!--Fin Datos acordeon-->
                        </article>
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->controller->renderPartial('/customers/partials/modal-customers', array(
    'countries' => $countries,
    'typeDocument' => $typeDocument,
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/customers.min.js', CClientScript::POS_END);
$js = '';

if(isset($_GET['name']) && $_GET['name'] != ''){
    $js .= '$("#form-filter-name").val("'.$_GET['name'].'");';
}

if(isset($_GET['numberDocument']) && $_GET['numberDocument'] != ''){
    $js .= '$("#form-filter-numberDocument").val("'.$_GET['numberDocument'].'");';
}

if(isset($_GET['active']) && $_GET['active'] != ''){
    $js .= '$("#form-filter-active").val('.$_GET['active'].');';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click'); console.log('filter');";
}

Yii::app()->clientScript->registerScript("payments_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);