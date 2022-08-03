<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <?php
                    $this->renderPartial('/users/partials/item-tabs',array('active' => $active,'id' => $id));
                ?>                  
                <section class="panelBG">
                        <?php 
                            $this->renderPartial('/users/partials/filter-users',array('active' => $active,'type' => 'coordinators','id' => $id));
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
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'PERFIL'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'NOMBRES'); ?></th>
                                                    <!--<th width="10%" class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>-->
                                                    <!--<th width="10%" class="txt_center"><?php echo Yii::t('front', 'ASIGNADO'); ?></th>-->
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ÚLTIMA CONEXIÓN'); ?></th>
<!--                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'RECAUDADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTIMADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'PENDIENTE'); ?></th>                                                    -->
                                                    <th width="13%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                </tr>
                                                <tr class="filters formweb" data-id="users" data-url="users/coordinators/1">
                                                    <th class="txt_center">
                                                        <select class="filter-table" id="users-filter-active" name="idProfile">
                                                            <option value=""><?php echo Yii::t('front', ''); ?></option>
                                                            <?php  foreach ($coodinators as $coodinator) { ?>
                                                                <option value="<?php echo $coodinator->id; ?>"><?php echo $coodinator->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </th>
                                                    <th class="txt_center"><input class="filter-table" id="users-filter-company" type="text" name="company" /></th>
                                                    <th class="txt_center"><input class="filter-table" id="users-filter-name" type="text" name="name" /></th>
                                                    <!--<th class="txt_center"><input class="filter-table" id="users-filter-userName" type="text" name="userName" /></th>-->
                                                    <!--<th class="txt_center"><input class="filter-table" id="users-filter-assigment" type="text" name="assigment" readonly /></th>-->
                                                    <th class="txt_center"><input class="filter-table" id="users-filter-last_session" type="text" name="last_session" readonly /></th>
<!--                                                    <th class="txt_center"><input class="filter-table" id="users-filter-interest" type="text" name="interest" readonly /></th>
                                                    <th class="txt_center"><input class="filter-table" id="users-filter-paymeents" type="text" name="payments" readonly /></th>
                                                    <th class="txt_center"><input class="filter-table" id="users-filter-agreement" type="text" name="agreement" readonly /></th>
                                                    <th class="txt_center"><input class="filter-table" id="users-filter-pending" type="text" name="pending" readonly /></th>-->
                                                    <th class="txt_center"><input class="filter-table" id="users-filter-" type="text" readonly /></th>
                                                    <th class="hide"><input class="filter-table" id="users-filter-page" name="page" type="hidden" value="1"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-users">
                                                <?php $this->renderPartial('/users/partials/content-users-table', array('model' => $model)); ?>                                                
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="clear"></div>
                                    <div id="pagination-users" class="bg-pagination">                                    
                                        <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'users')); ?>                                    
                                    </div>
                                </section>
                                <!--Fin Datos acordeon-->
                            </article>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/users.min.js', CClientScript::POS_END);
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