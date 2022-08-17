<?php// $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php //$this->renderPartial('/wallet/partials/filter-debtors', array('active' => 2,'url' => $url, 'urlExport' => $urlExport, 'debtorState' => $debtorState, 'id' => $id, 'quadrant' => $quadrant, 'coordinators' => $coordinators, 'legal' => $legal, 'mlModels' => $mlModels));  ?>            
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
                                <h3 class="val">$ <?php echo Yii::app()->format->formatNumber((isset($total)) ? $total : 0); ?></h3>
                            </div>                            
                        </div>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="panel total_billing txt_center">
                                <h3><?php echo Yii::t('front', 'USUARIOS'); ?></h3>
                            </div>                            
                        </div>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="panel total_billing txt_center">
                                <h3 class="val"> <i class="fa fa-user"></i> <?php echo (isset($accounts)) ? $accounts : 0; ?></h3>
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
                        <li class="tab acordeon_cluster hide" data-id="mlModels-<?php //echo $mlModel->id;  ?>-" ><a href="#debtors_chart"><?php echo Yii::t('front', 'MODELO'); ?></a></li>
                    </ul>
                </div>                
                <article id="debtors_list" class="block">                    
                    <section class="panelBG  m_b_20 lista_all_deudor content-scroll-x">
                        <table class="bordered highlight" id="empTable" style="width: 100%;">
                            <thead>
                                <tr class="backgroung-table-4">
                                    <th class="txt_center " width="7%"><?php echo Yii::t('front', (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) ? 'ASESOR' : 'EMPRESA'); ?></th>
                                    <th class="txt_center " width="10%"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                    <th class="txt_center" width="11%"><?php echo Yii::t('front', 'DEUDOR'); ?></th>
                                    <th class="txt_center" width="8%"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                                    <th class="txt_center" width="8%"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
                                    <th class="txt_center" width="8%"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                    <th class="txt_center hide-ml" width="8%"><?php echo Yii::t('front', 'MODELO'); ?></th>
                                    <th class="txt_center hide-ml" width="8%"><?php echo Yii::t('front', 'SEGMENTO'); ?></th>
                                    <th class="txt_center hide-ml" width="8%"><?php echo Yii::t('front', 'PROBABILIDAD'); ?></th>
                                    <th class="txt_center" width="8%"><?php echo Yii::t('front', 'TIPOLOGÍA'); ?></th>
                                    <th class="txt_center" width="8%"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                    <th class="txt_center" width="8%"><?php echo Yii::t('front', 'ULTIMA GESTIÓN'); ?></th>
                                </tr> 
                                <tr class="filters formweb" data-id="cluster" data-url="wallet/0/0/0">
                                    <th class="txt_center "><input class="filter-datatable" id="cluster-filter-" type="text" readonly /></th>
                                    <th class="txt_center "><input class="filter-datatable" id="cluster-filter-customer" type="text" name="customer" /></th>
                                    <th class="txt_center"><input class="filter-datatable" id="cluster-filter-name" type="text" name="name" /></th>
                                    <th class="txt_center"><input class="filter-datatable" id="cluster-filter-code" type="text" name="code" /></th>
                                    <th class="txt_center"><input class="filter-datatable" id="cluster-filter-city" type="text" name="city" /></th>
                                    <th class="txt_center"><input class="filter-datatable" id="cluster-filter-capital" type="text" name="capital" /></th>
                                    <th class="txt_center hide-ml" data-id="cluster-filter-">
                                        <select id="cluster-filter-idMLModel" name="idMLModel" class="filter-mlModels filter-datatable" data-closest="th">
                                            <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                                            <?php foreach ($mlModels as $mModel) { ?>
                                                <option value="<?php echo $mModel->id; ?>" <?php echo (isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] == $mModel->id) ? 'selected' : ''; ?>><?php echo $mModel->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th class="txt_center hide-ml">
                                        <select id="cluster-filter-idCluster" name="idCluster" class="filter-datatable">
                                            <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                                            <?php foreach ($clustersSelect as $clusterSelect) { ?>
                                                <option value="<?php echo $clusterSelect->id; ?>"><?php echo $clusterSelect->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th class="txt_center hide-ml"><input name="impago" type="text" class="filter-datatable" value="" readonly></th>
                                    <th class="txt_center">
                                        <select id="cluster-filter-ageDebt" name="ageDebt" class="filter-datatable">
                                            <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                                            <?php foreach ($ageDebts as $ageDebt) { ?>
                                                <option value="<?php echo $ageDebt->id; ?>"><?php echo $ageDebt->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th class="txt_center">
                                        <select id="cluster-filter-idState" name="idState" class="filter-datatable">
                                            <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                                            <?php foreach ($debtorState as $value) { ?>
                                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th class="txt_center" data-id="cluster-filter-">
                                        <select id="cluster-filter-date" name="date" class="filter-datatable" data-closest="th">
                                            <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                                                <option class="gray-text" value=" IS NULL"><?php echo Yii::t('front', 'SIN GESTIÓN'); ?></option>
                                                <option class="green-text" value="<= 7"><?php echo Yii::t('front', 'RECIENTE'); ?></option>
                                                <option class="orange-text" value="BETWEEN 7 AND 20"><?php echo Yii::t('front', 'MEDIA'); ?></option>
                                                <option class="red-text" value="> 20"><?php echo Yii::t('front', 'ANTIGUA'); ?></option>
                                        </select>
                                    </th>
                                </tr>
                            </thead>        
                        </table>    
                    </section>
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
} else {
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/collect.min.js', CClientScript::POS_END);
}

$js = '';

if (isset($_GET['customer']) && $_GET['customer'] != '') {
    $js .= '$("#form-filter-customer").val("' . $_GET['customer'] . '");';
}

if (isset($_GET['name']) && $_GET['name'] != '') {
    $js .= '$("#form-filter-name").val("' . $_GET['name'] . '");';
}

if (isset($_GET['code']) && $_GET['code'] != '') {
    $js .= '$("#form-filter-code").val("' . $_GET['code'] . '");';
}

if (isset($_GET['investigation']) && $_GET['investigation'] != '') {
    $js .= '$("#form-filter-investigation").val("' . $_GET['investigation'] . '");';
}

if (isset($_GET['city']) && $_GET['city'] != '') {
    $js .= '$("#form-filter-city").val("' . $_GET['city'] . '");';
}

if (isset($_GET['idState']) && $_GET['idState'] != '') {
    $js .= '$("#form-filter-idState").val(' . $_GET['idState'] . ').trigger("change");';
}

if (isset($_GET['idCoordinator']) && $_GET['idCoordinator'] != '') {
    $js .= '$("#form-filter-idCoordinator").val(' . $_GET['idCoordinator'] . ').trigger("change");';
}

if (isset($_GET['order']) && $_GET['order'] != '') {
    $js .= '$("#form-filter-order").val("' . $_GET['order'] . '").trigger("change");';
}

$filter = (isset($_GET['filter'])) ? false : true;
if ($js != '' && $filter) {
    $js .= "$('.btn-filter-advance').trigger('click');";
}

$js .= "var dataTable = $('#empTable').DataTable({
        language: {
            paginate: {
                next: '" . Yii::t('front', 'Siguiente') . " >',
                previous: '< " . Yii::t('front', 'Anterior') . "'
            },
            'processing': '". Yii::t('front', 'Procesando') ."'
        },
        'processing': true,
        'info': false,
        'serverSide': true,
        'lengthChange': false,
        'serverMethod': 'post',
        orderCellsTop: true,
            fixedHeader: true,
        'searching': false, // Remove default Search Control
        'ajax': {
            'url': SITEURL+'/wallet/".$url."',
            'data': function(data){
              // Read values
              var customer = $('#cluster-filter-customer').val();
              var name = $('#cluster-filter-name').val();
              var code = $('#cluster-filter-code').val();
              var city = $('#cluster-filter-city').val();
              var capital = $('#cluster-filter-capital').val();
              var idMLModel = $('#cluster-filter-idMLModel').val();
              var idCluster = $('#cluster-filter-idCluster').val();
              var ageDebt = $('#cluster-filter-ageDebt').val();
              var idState = $('#cluster-filter-idState').val();
              var date = $('#cluster-filter-date').val();

              var idRegion = $('#cluster-filter-idRegion').val(); 
              var ageDebt  = $('#cluster-filter-ageDebt').val();
              var is_legal = $('#cluster-filter-is_legal').val();

              // Append to data
              data.search['customer'] = customer;
              data.search['name'] = name;
              data.search['code'] = code;
              data.search['city'] = city;
              data.search['capital'] = capital;
              data.search['idMLModel'] = idMLModel;
              data.search['idCluster'] = idCluster;
              data.search['ageDebt'] = ageDebt;
              data.search['idState'] = idState;
              data.search['date'] = date;
              data.search['idRegion'] = idRegion;
              data.search['ageDebt'] = ageDebt;
              data.search['is_legal'] = is_legal;
            },
            complete : function(data, callback, settings){
                if(callback){
                    
                }
            }
        },
        'columns': [
           { data: 'company',
             orderable: false,
             visible : ".$hideCompany."
           }, 
           { data: 'customer',
             visible : ".$hideCustomer."
           },
           { data: 'name' },
           { data: 'code' },
           { data: 'city' },
           { data: 'capital' },
           { data: 'idMLModel', 
             orderable: false,
             visible : ".$hideML."
           },
           { data: 'idCluster', 
             orderable: false,
             visible : ".$hideML."
           },
           { data: 'impago',
             orderable: false,
             visible : ".$hideML."
           },
           { data: 'ageDebt' },
           { data: 'idState' },
           { data: 'date' },
        ]
      });
  
    $('#empTable tbody').on('click', 'tr', function () {
        var data = dataTable.row( this ).data();
        location.href = SITEURL+'/wallet/debtor/'+data['id']; 
    } );

    $('.filter-datatable').change(function(){
      dataTable.draw();
    });";

Yii::app()->clientScript->registerScript("debtor_list_js", '
   $(document).ready(function(){    
    ' . $js . '
   });
   
', CClientScript::POS_END
);

