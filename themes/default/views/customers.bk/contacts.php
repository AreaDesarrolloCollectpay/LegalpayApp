<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php $this->renderPartial('/customers/partials/filter-contacts', array('active' => 2, 'url' => $url)); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp">
                <section class="panelBG m_b_20 m_t_10">
                    <div class="row">                         
                        <!--Tab 4-->
                        <article id="contacts" class="block">
                            <!--Datos acordeon-->                                
                            <div class="clear"></div>
                            <section class="content-scroll-x">
                                <div class="clearfix">                                        
                                    <table class="bordered highlight">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CELULAR'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'TELEFONO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'EMAIL'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CARGO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersContacts">
                                            <?php
                                            foreach ($model as $value) {
                                                $this->renderPartial('/customers/partials/item-contacts', array('model' => $value));
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/customers-contacts.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/customers/partials/modal-contacts', array('idUser' => $idUser,'countries' => $countries));

