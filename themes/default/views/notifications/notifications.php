<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("Notifications", "Notificaciones") ?></h2>
            </div>    
            <section class="padding animated fadeInUp m_t_60">
                <section class="all_tareas m_t_20 m_b_20">
                    <section class="panelBG m_b_20 animated">         
                        <div class="large-12 medium-12 small-12 columns">
                            <div class="bg_panel padding animated fadeInUp">
                                <table class="striped">
                                    <thead>
                                        <tr>                                        
                                            <th></th>
                                            <th></th>
                                            <th data-field="name" class="txt_right padding"><span class="animated flip"><?php echo $count; ?></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($model as $notifications) {
                                            $this->renderPartial('/notifications/partials/item-notifications', array('model' => $notifications));
                                        }
                                        ?>                    
                                    </tbody>
                                </table>
                            </div>
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
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/notifications.min.js', CClientScript::POS_END); ?>

