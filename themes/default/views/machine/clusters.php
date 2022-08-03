<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Clusters") ?></h2>                
            </div>
            <div class="clear"></div>  
            <section class="row p_t_80">
                <section class="padding animated fadeInUp">
                    <section class="panelBG m_t_10">
                        <table class="bordered highlight responsive-table">
                            <thead>
                                <tr class="backgroung-table-2">
                                    <th class="txt_center"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'DESCRIPCIÓN'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                </tr>
                            </thead>
                            <tbody id="listDebtors"> 
                                <?php foreach ($model as $value) { 
                                      $this->renderPartial('/machine/partials/item-clusters', array('model' => $value));
                                } ?>
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
                    <!--Fin All assignments-->
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/machine.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/machine/partials/modal-machine', array());
?>