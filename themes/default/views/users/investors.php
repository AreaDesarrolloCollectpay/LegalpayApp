<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row m_t_10">
            <section class="padding animated fadeInUp">
                <!--Tabs-->                 
                <section class="panelBG">
                        <?php 
//                            $this->renderPartial('/users/partials/filter-users',array('active' => $active,'type' => 'coordinators','id' => $id));
                        ?>
                            <!--Tab 4-->
                            <article id="historia_pagos" class="block">
                                <!--Datos acordeon-->                                
                                <div class="clear"></div>
                                <section class="content-scroll-x">
                                    <div class="clearfix">                                        
                                        <table class="bordered highlight">                                            
                                            <thead>
                                                <tr class="backgroung-table-4">
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'NOMBRES'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'RECAUDADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTIMADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'PENDIENTE'); ?></th>                                                    
                                                    <th width="13%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                </tr>
                                                <tr class="filters formweb">
                                                    <th class="txt_center"><input type="text" name="name" /></th>
                                                    <th class="txt_center"><input type="text" name="userName" /></th>
                                                    <th class="txt_center"><input type="text" name="capital" readonly /></th>
                                                    <th class="txt_center"><input type="text" name="interest" readonly /></th>
                                                    <th class="txt_center"><input type="text" name="payments" readonly /></th>
                                                    <th class="txt_center"><input type="text" name="agreenment" readonly /></th>
                                                    <th class="txt_center"><input type="text" name="pending" readonly /></th>
                                                    <th class="txt_center"><input type="text" readonly /></th>
                                                </tr>
                                            </thead>
                                            <tbody id="usersCoordinators">
                                                <?php
                                                foreach ($model as $value) {
                                                    $this->renderPartial('/users/partials/item-investor', array('model' => $value));
                                                }
                                                ?>
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="clear"></div>
                                </section>
                                <!--Fin Datos acordeon-->
                            </article>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/investors.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/users/partials/modal-users', array(
    'countries' =>  $countries,
    'coodinators'  =>  $coodinators,
    'id' => $id,
    'typeDocument'    => $typeDocument,
));
$js = '';

if(isset($_GET['name']) && $_GET['name'] != ''){
    $js .= '$("#form-filter-name").val("'.$_GET['name'].'");';
}

if(isset($_GET['numberDocument']) && $_GET['numberDocument'] != ''){
    $js .= '$("#form-filter-numberDocument").val("'.$_GET['numberDocument'].'");';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click'); console.log('filter');";
}

$js .= "$('#business-".$id."').addClass('active');";

Yii::app()->clientScript->registerScript("users_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);