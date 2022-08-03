<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false)); ?>
<section class="cont_home">       
    <section class="conten_inicial">        
        <section class="row">
            <section class="padding animated fadeInUp">                
                <section class="panelBG m_b_30 m_t_20">
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
                                                <th width="30%" class="txt_center"><?php echo Yii::t('front', 'NOMBRE-'); ?></th>
                                                <th width="30%" class="txt_center"><?php echo Yii::t('front', 'CODIGO'); ?></th>
                                                <th width="30%" class="txt_center"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersCustomers">
                                            <?php
                                            foreach ($model as $value) {
                                                $this->renderPartial('/settings/partials/item-currency', array('model' => $value));
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
Yii::app()->controller->renderPartial('/settings/partials/modal-currency'
        . '', array(
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/currency.min.js', CClientScript::POS_END);
$js = '';
