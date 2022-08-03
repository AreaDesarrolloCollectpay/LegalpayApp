<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php // $this->renderPartial('/users/partials/filter-sessions', array('id' => $id)); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <section class="panelBG m_b_20 m_t_5">
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
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'HORA'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'IP'); ?></th>
                                                <th width="20%" class="txt_center"><?php echo Yii::t('front', 'DISPOSITIVO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersCoordinators">
                                            <?php
                                            foreach ($model as $value) {
                                                $this->renderPartial('/users/partials/item-session', array('model' => $value,'hide' => false));
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/users-session.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/users/partials/modal-sessions', array());

$js = '';

if(isset($_GET['from']) && $_GET['from'] != ''){
    $js .= '$("#form-filter-sessions-from").val("'.$_GET['from'].'");';
}
if(isset($_GET['to']) && $_GET['to'] != ''){
    $js .= '$("#form-filter-sessions-to").val("'.$_GET['to'].'");';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click'); console.log('filter');";
}

Yii::app()->clientScript->registerScript("sessions_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
