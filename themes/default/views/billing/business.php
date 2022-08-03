<?php //$this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <?php
                    $this->renderPartial('/billing/partials/item-tabs',array('active' => 3));
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
                                    <form class="formweb form-filter" data-id="form-filter-payments-" data-url="billing/business" data-export="billing/exportFilterBusiness" enctype="multipart/form-data"> 
                                        <fieldset class="large-6 medium-12 small-12 columns padding">
                                            <label><?php echo Yii::t('front', 'Portafolio'); ?></label>
                                            <select name="idUser" id="form-filter-idUser" class="">
                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                <?php foreach ($business as $busi){ ?>
                                                <option value="<?php echo $busi->idUser; ?>"><?php echo $busi->name; ?></option>                                                    
                                                <?php } ?>
                                            </select>
                                            <label><?php echo Yii::t('front', 'Comercial'); ?></label>
                                            <select name="idBusinessAdvisor" id="form-filter-idBusinessAdvisor" class="">
                                                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                <?php foreach ($businessAdvisors as $businessAdvisor){ ?>
                                                <option value="<?php echo $businessAdvisor->id; ?>"><?php echo $businessAdvisor->name; ?></option>                                                    
                                                <?php } ?>
                                            </select>
                                        </fieldset>
                                        <fieldset class="large-6 medium-12 small-12 columns padding">
                                            <label><?php echo Yii::t('front', 'CC / NIT') ?></label>                          
                                            <input name="numberDocument" id="form-filter-numberDocument"  type="text" class="" value="">                                                                                        
                                        </fieldset>
                                        <fieldset class="large-3 medium-6 small-6 columns padding">
                                            <label><?php echo Yii::t('front', 'Desde'); ?></label>
                                            <div class="fecha">
                                                <input name="from" id="form-filter-from" type="text" class="calendar_from" value="">
                                            </div>
                                        </fieldset>
                                        <fieldset class="large-3 medium-6 small-6 columns padding">                                            
                                            <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                                            <div class="fecha">
                                                <input name="to" id="form-filter-to" type="text" class="calendar_to" value="">
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
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                    <th width="15%" class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                                    <th width="15%" class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                                                    <th width="15%" class="txt_center"><?php echo Yii::t('front', 'COMERCIAL'); ?></th>
                                                    <th width="18%" class="txt_center"><?php echo Yii::t('front', 'UBICACIÓN'); ?></th>
                                                    <th width="12%" class="txt_center"><?php echo Yii::t('front', 'VALOR GASTO'); ?></th>
                                                    <th width="15%" class="txt_center"><?php echo Yii::t('front', 'SOPORTE'); ?></th>
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
                                                    $this->renderPartial('/billing/partials/item-business-spendings', array('model' => $value));
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

if(isset($_GET['idUser']) && $_GET['idUser'] != ''){
    $js .= '$("#form-filter-idUser").val('.$_GET['idUser'].').trigger("change");';
}

if(isset($_GET['idBusinessAdvisor']) && $_GET['idBusinessAdvisor'] != ''){
    $js .= '$("#form-filter-idBusinessAdvisor").val('.$_GET['idBusinessAdvisor'].').trigger("change");';
}

if(isset($_GET['numberDocument']) && $_GET['numberDocument'] != ''){
    $js .= '$("#form-filter-numberDocument").val("'.$_GET['numberDocument'].'");';
}
if(isset($_GET['from']) && $_GET['from'] != ''){
    $js .= '$("#form-filter-from").val("'.$_GET['from'].'");';
}
if(isset($_GET['to']) && $_GET['to'] != ''){
    $js .= '$("#form-filter-to").val("'.$_GET['to'].'");';
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