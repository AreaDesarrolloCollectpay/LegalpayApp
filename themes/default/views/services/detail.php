<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <?php
                Yii::app()->controller->renderPartial('/services/partials/title_head', array());
                //Yii::app()->controller->renderPartial('/services/partials/filter_services', array('url' => $this->createUrl('/services')));
            ?>
        </section>
        <section class="row m_t_60">
            <section class="padding animated fadeInUp m_t_20">                
                <!--Tabs-->
                <div class="block">
                    <ul class="tabs tab_cartera">
                        <li class="tab"><a href="#datos_financieros" class="btn-amortization"><i class="feather feather-bar-chart-2"></i><?php echo Yii::t('front', 'DATOS FINANCIEROS'); ?></a></li>
                        <li class="tab"><a href="#historia_pagos"><i class="feather feather-credit-card"></i><?php echo Yii::t('front', 'HISTORIAL DE PAGOS'); ?></a></li>
                    </ul>
                </div>                          
                <section class="panelBG m_b_20">
                    <section class="padd_v">
                        <div class="row">  
                            <!--Tab 1-->
                            <article id="datos_financieros" class="block">
                                <form id="frmFinantial-" action="" class="formweb">
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Capital'); ?></label>
                                        <input type="text" value="$ <?= Yii::app()->format->formatNumber($debtor->capital); ?>"  disabled>
                                        <label><?php echo Yii::t('front', 'Abonos'); ?></label>
                                        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->payments))? $othersValues['model']->payments : 0)); ?>" disabled>                                                                                
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Intereses'); ?></label>
                                        <input type="text" name="" placeholder="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->interest))? $othersValues['model']->interest : 0)); ?>" disabled>                                        
                                        <label><?php echo Yii::t('front', 'Saldo total'); ?></label>
                                        <input type="text" value="$ <?= Yii::app()->format->formatNumber(($othersValues['model'] != null)? ($othersValues['model']->capital + $othersValues['model']->fee + $othersValues['model']->interest) - $othersValues['model']->payments  : 0); ?>"  disabled>                                    
                                        <input type="hidden" value="<?php echo 'capi :'.$othersValues['model']->capital.'+ fee'.$othersValues['model']->fee.' + c_i '.$othersValues['model']->interest ?>" >
                                    </fieldset>
                                    <fieldset class="large-4 medium-4 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Honorarios'); ?></label>
                                        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(((isset($othersValues['model']->fee))? $othersValues['model']->fee : 0)); ?>" disabled>
                                        <label><?php echo Yii::t('front', 'Saldo Total'); ?></label>
                                        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($othersValues['model'] != null)? ($debtor->capital + $othersValues['model']->fee + $othersValues['model']->interest) - $othersValues['model']->payments  : 0); ?>" disabled>
                                    </fieldset>
                                    <div class="clear"></div>
                                </form>
                                <div class="clear"></div>                                 
                                <!--Soportes-->
                                <section class="m_t_10 padding m_b_10"> 
                                <ul class="tabs tab_cartera"> 
                                    <li class="tab" style="width: 19% !important;"><a href="#debtor_detail_debt"><i class="feather feather-list"></i><?php echo Yii::t('front', 'DETALLE DEUDA'); ?></a></li>
                                </ul>
                                <section class="">
                                    <div class="row">                                             
                                        <!--Tab 0-->
                                        <article id="debtor_detail_debt" class="block  border-tab">
                                            <div class="dates_all topBarJuridico hide">
                                                <ul class="filter_views">                                                        
                                                    <li><a href="#" class="tooltipped btn-filter-advance-tab" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?></a></li>                                                                                
                                                </ul>                  
                                            </div>
                                            <div class="formweb content_filter_advance"> 
                                                <div class="clear"></div>                            
                                                <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
                                                    <form class="formweb form-filter-tab" id="form-filter-obligations" data-content="content-debtor-obligations" data-url="wallet/obligationsPage" enctype="multipart/form-data"> 
                                                        <fieldset class="large-6 medium-6 small-12 columns padding">
                                                            <div class="large-6 medium-6 small-6 columns" style="padding-right: 20px;">
                                                                <label><?php echo Yii::t('front', 'Desde'); ?></label>
                                                                <div class="fecha">
                                                                    <input name="from" id="form-filter-obligation-from" type="text" class="calendar_from" value="">
                                                                </div>                                                                        
                                                            </div>
                                                            <div class="large-6 medium-6 small-6 columns">
                                                                <label><?php echo Yii::t('front', 'Hasta'); ?></label>
                                                                <div class="fecha">
                                                                    <input name="to" id="form-filter-obligation-to" type="text" class="calendar_to" value="">
                                                                </div>                                                                        
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="large-6 medium-6 small-12 columns padding">
                                                            <label><?php echo Yii::t('front', 'N. Obligación'); ?></label>
                                                            <input name="credit_number" id="form-filter-olbigations-credit_number" type="text" class="" value="">                    
                                                        </fieldset>
                                                        <input type="hidden" name="idDebtor" value="<?php echo $debtor->id; ?>" />
                                                        <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                                                            <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
                                                        </fieldset> 
                                                    </form>
                                                </fieldset>
                                            </div> 
                                            <div class="clear"></div> 
                                            <div class="content-scroll-x" id="content-debtor-obligations">
                                                <?php
                                                $this->renderPartial('/wallet/partials/content-debtor-obligations', array('debtor' => $debtor, 'obligations' => $obligations, 'pagesObligations' => $pagesObligations));
                                                ?>
                                            </div>       
                                        </article>                                        
                                    </div>
                                </section>
                                
                            </section> 
                                <!--Fin Soportes-->
                            </article>
                            <!--Tab 2-->
                            <article id="historia_pagos" class="block">
                                <!--Datos acordeon-->                               
                                <div class="clear"></div>
                                <section class="m_t_10">
                                    <ul class="tabs tab_cartera">
                                        <li class="tab" style="width: 19% !important;"><a href="#debtor_payments"><i class="fa fa-usd"></i><?php echo Yii::t('front', 'PAGOS'); ?></a></li>
                                        <li class="tab" style="width: 19% !important;"><a href="#debtor_agreements"><i class="fa fa-check-square-o"></i><?php echo Yii::t('front', 'ACUERDOS'); ?></a></li>
                                    </ul>
                                    <section class="m_t_10">
                                        <div class="row"> 
                                            <!--Tab 1-->
                                            <article id="debtor_payments" class="block">
                                                <div class="clearfix">                                                    
                                                    <table class="bordered responsive-table">                                            
                                                        <thead>
                                                            <tr class="backgroung-table-4">
                                                                <th width="14%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                                <th width="14%" class="txt_center hide-wallet"><?php echo Yii::t('front', 'ASESOR'); ?></th>
                                                                <th width="14%" class="txt_center"><?php echo Yii::t('front', 'METODO'); ?></th>
                                                                <th width="14%" class="txt_center hide-wallet"><?php echo Yii::t('front', 'DISCRIMINACIÓN'); ?></th>
                                                                <th width="14%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                                <th width="14%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                                <th width="16%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="walletPayments-<?php echo $debtor->id; ?>">
                                                            <?php
                                                                foreach ($payments as $pay) {
                                                                    $this->renderPartial('/wallet/partials/item-payments', array('model' => $pay, 'edit' => false));
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>    
                                                </div>         
                                            </article>
                                            <article id="debtor_agreements" class="block">
                                                <div class="clearfix">
                                                    <table class="bordered responsive-table">                                            
                                                        <thead>
                                                            <tr class="backgroung-table-4 <?php echo $debtor->id; ?>">
                                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                                <th width="20%" class="txt_center hide-wallet"><?php echo Yii::t('front', 'ASESOR'); ?></th>
                                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'METODO'); ?></th>
                                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                                <th width="15%" class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                                                <th width="15%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="walletAgreements-<?php echo $debtor->id; ?>">
                                                            <?php                                                                
                                                                foreach ($agreements as $pay) {
                                                                    $this->renderPartial('/wallet/partials/item-agreements', array('model' => $pay, 'edit' => false));
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>    
                                                </div>
                                            </article>
                                        </div>
                                    </section>
                                </section>                                                                
                                <!--Fin Datos acordeon-->
                                <div class="clear"></div>
                                
                            </article>
                        </div>
                    </section>                
                </section>
                <!--Fin Tabs--> 
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<input type="hidden" id="idDebtor" value="">
<?php 
$js = '';
if(Yii::app()->user->getState('rol') == 0){    
    $js .= 'hideWallet();
            $( ".select-disabled" ).prop( "disabled", true );
            $( ".input-disabled" ).prop( "readonly", true );
           ';
}
Yii::app()->clientScript->registerScript("debtor_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
?>
