<section class="cont_home">
    <section class="conten_inicial">
            <section class="row">                
            <!-- filter -->            
            <?php $this->renderPartial('/business/partials/filter-business', array('countries' => $countries,'businessAdvisors' => $businessAdvisors,'active' => 2,'url' => 'business/list')); ?>            
            <!-- END filter -->
            </section>
        <!-- dashContent -->
        <section class="row">            
            <section class="padding">
                <!--All deudores-->                
                <section class="panelBG m_b_20 lista_all_deudor">
                    <table class="bordered highlight responsive-table">
                        <thead>
                            <tr class="backgroung-table-2">
                                <th class="txt_center"><?php echo Yii::t('front', 'EMPRESA'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'VALOR CARTERA'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'ULTIMA GESTIÓN'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="listDebtors"> 
                            <?php
                            foreach ($model as $value){
                                $this->renderPartial('/business/partials/item-business-list', array('value' => $value));
                           } ?>
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
                </section>
                <!--Fin All deudores-->
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php 
$this->renderPartial("/business/partials/modal_business", array('countries' => $countries,'businessStates' => $businessStates,'businessAdvisors' => $businessAdvisors));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/business.min.js', CClientScript::POS_END);
$this->renderPartial("/business/partials/js_filter_business", array('_GET' => $_GET));