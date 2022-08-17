<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <?php
                    $this->renderPartial('/billing/partials/item-tabs',array('active' => 2));
                ?>                  
                <section class="panelBG m_b_20">
                    <section class="padd_v">
                        <section class="row">
                            <div class="large-3 medium-6 small-12 columns m_t_10">
                                <div class="panel total_billing txt_center">
                                    <h3><?php echo Yii::t('front', 'VALOR TOTAL'); ?></h3>
                                    <h4 class="val">$ <?php echo Yii::app()->format->formatNumber($total->value); ?></h4>
                                </div>
                            </div>    
                            <div class="large-9 medium-6 small-12 columns dates_all topBarJuridico">
                                <ul class="filter_views">
                                    <li class="hide"><a href="#" class="tooltipped active" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-justify"></i> <?php echo Yii::t('front', 'Lista'); ?></a></li>
                                    <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>
                                    <li class="hide"><a href="#" class="tooltipped btn-filter-export" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Exportar'); ?>"><i class="fa fa-download"></i> <?php echo Yii::t('front', 'Exportar'); ?></a></li>                    
                                </ul>                
                            </div>
                        </section>
                        <div class="formweb content_filter_advance m_t_10"> 
                            <div class="clear"></div>                            
                            <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">
                                <div class="padd_v m_b_10">
                                    <form class="formweb form-filter" data-id="form-filter-payments-" data-url="billing/spending" data-export="billing/exportFilterSpendings" enctype="multipart/form-data"> 
                                        <fieldset class="large-6 medium-12 small-12 columns padding">
                                            <label><?php echo Yii::t('front', 'Cliente'); ?></label>
                                            <select name="idCustomer" id="form-filter-payments-idCustomer" class="">
                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                <?php foreach ($customers as $customer){ ?>
                                                <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>                                                    
                                                <?php } ?>
                                            </select>
                                            <label><?php echo Yii::t('front', 'Alianza'); ?></label>
                                            <select name="idCoordinator" id="form-filter-payments-idCoordinator" class="">
                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                <?php foreach ($coodinators as $coodinator){ ?>
                                                <option value="<?php echo $coodinator->id; ?>"><?php echo $coodinator->name; ?></option>                                                    
                                                <?php } ?>
                                            </select>
                                        </fieldset>
                                        <fieldset class="large-6 medium-12 small-12 columns padding">
                                            <label><?php echo Yii::t('front', 'CC / NIT') ?></label>                          
                                            <input name="code" id="form-filter-payments-code"  type="text" class="" value="<?php echo (isset($_GET['code']) && $_GET['code'] != '') ? $_GET['code'] : ''; ?>">                                                                                        
                                        </fieldset>
                                        <fieldset class="large-3 medium-6 small-6 columns padding">
                                            <label><?php echo Yii::t('front', 'Desde'); ?></label>
                                            <div class="fecha">
                                                <input name="from" id="form-filter-payments-from" type="text" class="calendar_from" value="">
                                            </div>
                                        </fieldset>
                                        <fieldset class="large-3 medium-6 small-6 columns padding">                                            
                                            <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                                            <div class="fecha">
                                                <input name="to" id="form-filter-payments-to" type="text" class="calendar_to" value="">
                                            </div>
                                        </fieldset>                                        
                                        <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                                            <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                                        </fieldset> 
                                    </form>
                                </div>
                            </fieldset>
                        </div>
                        <div class="row m_t_10"> 
                            <!--Tab 4-->
                            <article id="historia_pagos" class="block">
                                <!--Datos acordeon-->                                
                                <div class="clear"></div>
                                <section class="padding m_t_5 lista_all_deudor">
                                    <div class="clearfix">                                        
                                        <table class="bordered highlight responsive-table">                                            
                                            <thead>
                                                <tr class="backgroung-table-2">
                                                    <th width="8%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                    <th width="12%" class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                                    <th width="12%" class="txt_center"><?php echo Yii::t('front', 'ALIANZA'); ?></th>
                                                    <th width="18%" class="txt_center"><?php echo Yii::t('front', 'UBICACIÓN'); ?></th>
                                                    <th width="12%" class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                                                    <th width="14%" class="txt_center"><?php echo Yii::t('front', 'DEUDOR'); ?></th>
                                                    <th width="12%" class="txt_center"><?php echo Yii::t('front', 'VALOR GASTO'); ?></th>
                                                    <th width="12%" class="txt_center"><?php echo Yii::t('front', 'SOPORTE'); ?></th>
                                                </tr>
<!--                                                <tr class="filters formweb">
                                                    <td>
                                                        <input type="text" class="searchSpendings txt_center calendar"  name="dateSpending" maxlength="100" value="<?php echo (isset($_GET['dateSpending']) && $_GET['dateSpending'] != '') ? $_GET['dateSpending'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchSpendings txt_center" name="customer" maxlength="100" value="<?php echo (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchSpendings txt_center" name="coordinator" maxlength="100" value="<?php echo (isset($_GET['coordinator']) && $_GET['coordinator'] != '') ? $_GET['coordinator'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchSpendings txt_center" name="code" maxlength="100"  value="<?php echo (isset($_GET['code']) && $_GET['code'] != '') ? $_GET['code'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="searchSpendings txt_center" name="value" maxlength="100" value="<?php echo (isset($_GET['value']) && $_GET['value'] != '') ? $_GET['value'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>-->
                                            </thead>
                                            <tbody id="debtorsSpendings">
                                                <?php
                                                foreach ($model as $value) {
                                                    $this->renderPartial('/billing/partials/item-spendings', array('model' => $value));
                                                }
                                                ?>
                                            </tbody>
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
                                    </div>
                                    <div class="clear"></div>
                                </section>
                                <!--Fin Datos acordeon-->
                            </article>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/spendings.min.js', CClientScript::POS_END);
$js = '';

if(isset($_GET['idCustomer']) && $_GET['idCustomer'] != ''){
    $js .= '$("#form-filter-payments-idCustomer").val('.$_GET['idCustomer'].').trigger("change");';
}

if(isset($_GET['idCoordinator']) && $_GET['idCoordinator'] != ''){
    $js .= '$("#form-filter-payments-idCoordinator").val('.$_GET['idCoordinator'].').trigger("change");';
}

if(isset($_GET['code']) && $_GET['code'] != ''){
    $js .= '$("#form-filter-payments-code").val("'.$_GET['code'].'");';
}
if(isset($_GET['from']) && $_GET['from'] != ''){
    $js .= '$("#form-filter-payments-from").val("'.$_GET['from'].'");';
}
if(isset($_GET['to']) && $_GET['to'] != ''){
    $js .= '$("#form-filter-payments-to").val("'.$_GET['to'].'");';
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