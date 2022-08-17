<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php $this->renderPartial('/settings/partials/filter-political', array('active' => 2, 'customersF' =>  $customersF,)); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <section class="panelBG m_b_30">
                    <div class="row"> 
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                            <!--Datos acordeon-->                                
                            <div class="clear"></div>
                            <section class="">
                                <div class="clearfix">                                        
                                    <table class="bordered highlight responsive-table">                                            
                                        <thead>
                                            <tr class="backgroung-table-2">
                                                <th width="14%" class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ULTIMA ACTUALIZACIÓN'); ?></th>
                                                <th width="13%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersCustomers">
                                            <?php
                                            foreach ($model as $value) {
                                                $this->renderPartial('/settings/partials/item-political', array('model' => $value, 'edit' => $edit));
                                            }
                                            ?>
                                        </tbody>
                                    </table>                                        
                                </div>
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
                            <!--Fin Datos acordeon-->
                        </article>
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->controller->renderPartial('/settings/partials/modal-political', array(    
    'customersM' =>  $customersM,
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/political.min.js', CClientScript::POS_END);
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