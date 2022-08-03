<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php  $this->renderPartial('/users/partials/filter-documents', array('active' => 2, 'type_documents' => $typeDocuments,'url' => $url)); ?>            
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
                        <article id="documents" class="block">
                            <!--Datos acordeon-->                                
                            <div class="clear"></div>
                            <section class="content-scroll-x">
                                <div class="clearfix">                                        
                                    <table class="bordered highlight">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="40%" class="txt_center"><?php echo Yii::t('front', 'COMENTARIO'); ?></th>
                                                <th width="40%" class="txt_center"><?php echo Yii::t('front', 'FECHA CREACIÓN'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersCoordinators">
                                            <?php
                                            foreach ($model as $value) {
                                                $this->renderPartial('/users/partials/item-documents', array('model' => $value));
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/customers-documents.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/users/partials/modal-documents', array('idUser' => $idUser,'type_documents' => $typeDocuments));
