<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php $this->renderPartial('/users/partials/filter-invoices', array('id' => $id, 'active' => 2,'url' => 'customers')); ?>            
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
                                                <th width="14%" class="txt_center"><?php echo Yii::t('front', 'NÚMERO'); ?></th>
                                                <th width="15%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                <th width="8%" class="txt_center"><?php echo Yii::t('front', 'EXPEDICIÓN'); ?></th>
                                                <th width="8%" class="txt_center"><?php echo Yii::t('front', 'VENCIMIENTO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                <th width="8%" class="txt_center"><?php echo Yii::t('front', 'FECHA DE PAGO'); ?></th>
                                                <th width="8%" class="txt_center"><?php echo Yii::t('front', 'FACTURA'); ?></th>
                                                <th width="8%" class="txt_center"><?php echo Yii::t('front', 'SOPORTE PAGO'); ?></th>
                                                <th width="8%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                            <tr class="filters formweb"  data-id="invoices" data-url="users/invoices">
                                                <th class="txt_center"><input class="filter-table" id="invoices-filter-number" type="text" name="number" /></th>
                                                <th class="txt_center"><input class="filter-table" id="invoices-filter-value" type="text" name="value" readonly/></th>
                                                <th class="txt_center"><input class="filter-table calendar_range" id="invoices-filter-date_expedition" type="text" name="date_expedition" /></th>
                                                <th class="txt_center"><input class="filter-table calendar_range" id="invoices-filter-date_expiration" type="text" name="date_expiration"  /></th>                                                
                                                <th class="txt_center">
                                                    <select class="filter-table" id="customers-filter-active" name="idInvocieState">
                                                        <option value=""><?php echo Yii::t('front', ''); ?></option>
                                                        <?php foreach ($states as $state) { ?>
                                                            <option value="<?php echo $state->id; ?>"><?php echo $state->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th class="txt_center"><input class="filter-table calendar_range" id="invoices-filter-date_pay" type="text" name="date_pay"  /></th>                                                
                                                <th class="txt_center"><input class="filter-table" id="invoices-filter-file" type="text" name="file" readonly /></th>
                                                <th class="txt_center"><input class="filter-table" id="invoices-filter-support_pay" type="text" name="support_pay" readonly /></th>
                                                <th class="txt_center"><input class="filter-table" id="invoices-filter-" type="text" name="" readonly/></th>
                                                <th class="hide"><input type="text" name="idUser" value="<?php echo (isset($id))? $id : ''; ?>" /></th>
                                                <th class="hide"><input class="filter-table" id="invoices-filter-page" name="page" type="hidden" value="1"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-invoices">
                                            <?php $this->renderPartial('/users/partials/content-invoices-table', array('model' => $model)); ?>
                                        </tbody>
                                    </table>                                        
                                </div>
                                <div class="clear"></div>
                                <div id="pagination-invoices" class="bg-pagination">                                    
                                    <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'invoices')); ?>                                    
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
Yii::app()->controller->renderPartial('/users/partials/modal-invoices', array(
    'states' => $states,
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/invoices.min.js', CClientScript::POS_END);
$js = '';

Yii::app()->clientScript->registerScript("payments_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);