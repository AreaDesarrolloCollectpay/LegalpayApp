<?php //  $this->renderPartial('/layouts/partials/side-nav', array('task' => false)); ?>
<section class="cont_home">
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php $this->renderPartial('/wallet/partials/filter-debtors', array('active' => 2,'url' => $url, 'urlExport' => $urlExport, 'debtorState' => $debtorState, 'id' => $id, 'quadrant' => $quadrant, 'coordinators' => $coordinators, 'legal' => $legal)); ?>            
            <!-- END filter -->
        </section>
        <section class="row"><!-- dashContent p_t_25  -->

            <section class="padding animated fadeInUp">
                
                <section class="row m_t_10 m_b_20">
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

                <!--All deudores-->
                <section class="panelBG m_b_20 lista_all_deudor" style="overflow-x:auto;">
                    <table class="bordered highlight responsive-table">
                        <thead>
                            <tr class="backgroung-table-2">
                                <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'DEUDOR'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'RECAUDADO'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'ESTIMADO'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'HONORARIOS'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'SALDO'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'ULTIMA GESTIÓN'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="listDebtors"> 
                            <?php foreach ($model as $value) { 
                                $lastManagement = Controller::lastManagement($value->date);
                                $othersValues = Controller::othersValues($value->idDebtor);
                            ?>
                                <tr>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->customer; ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->name; ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->code; ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->city; ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format($value->capital, 0, ',', '.'); ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']->c_interest))? $othersValues['model']->c_interest : 0), 0, ',', '.'); ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']->payments))? $othersValues['model']->payments : 0), 0, ',', '.'); ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']->agreement))? $othersValues['model']->agreement : 0), 0, ',', '.'); ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']->fee))? $othersValues['model']->fee : 0), 0, ',', '.'); ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']))? ($othersValues['model']->capital + $othersValues['model']->c_interest + $othersValues['model']->fee - $othersValues['model']->payments ) : 0), 0, ',', '.'); ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->state; ?></td>                          
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center <?php echo $lastManagement['color']; ?>-text"><?php echo $lastManagement['date']; ?></td>                          
                                </tr>
                            <?php } ?>
                    </table>
                    <div class="clear"></div>  
                    <div class="bg-pagination">
                        <?php
                        $this->widget('CLinkPager', array(
                            'pages' => $pages,
                            'header' => '',
                            'selectedPageCssClass' => 'active',
                            'previousPageCssClass' => 'prev',
                            'nextPageCssClass' => 'next',
                            'hiddenPageCssClass' => 'disbled',
                            'internalPageCssClass' => 'pages',
                            'htmlOptions' => array(
                                'class' => 'pagination txt_center')
                                )
                        );
                        ?>
                    </div>
                </section>
                <!--Fin All deudores-->

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

