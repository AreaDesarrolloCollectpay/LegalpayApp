<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php  $this->renderPartial('/customers/partials/filter-contracts', array('active' => 2,'url' => 'customers/contracts/'.$idUser)); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <!-- <div class="block">
                    <fieldset class="m_b_20 large-4 medium-6 small-12s columns padding right">
                        
                    </fieldset>
                    <ul class="tabs tab_cartera">
                        <li class="tab"><a href="<?php echo $this->createUrl('/customers'); ?>" class="active"><i class="fa fa-user" aria-hidden="true"></i> REMISIONES</a></li>
                    </ul>
                </div>    -->
                <section class="panelBG m_b_20 m_t_10">
                    <div class="row">                         
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                            <!--Datos acordeon-->                                
                            <div class="clear"></div>
                            <section class="content-scroll-x">
                                <div class="clearfix">                                        
                                    <table class="bordered highlight">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="40%" class="txt_center"><?php echo Yii::t('front', 'FECHA INICIO'); ?></th>
                                                <th width="40%" class="txt_center"><?php echo Yii::t('front', 'FECHA FIN'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersCoordinators">
                                            <?php
                                            foreach ($model as $value) {
                                                $this->renderPartial('/customers/partials/item-contracts', array('model' => $value));
                                            }
                                            ?>
                                        </tbody>
                                    </table>                                        
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
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/customers-contracts.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/customers/partials/modal-contracts', array('idUser' => $idUser));
$js = '';

if(isset($_GET['from']) && $_GET['from'] != ''){
    $js .= '$("#form-filter-from").val("'.$_GET['from'].'");';
}

if(isset($_GET['to']) && $_GET['to'] != ''){
    $js .= '$("#form-filter-to").val("'.$_GET['to'].'");';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click'); console.log('filter');";
}

Yii::app()->clientScript->registerScript("contracts_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
