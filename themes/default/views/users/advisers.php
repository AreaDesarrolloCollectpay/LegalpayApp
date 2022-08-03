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
                            $this->renderPartial('/users/partials/filter-users',array('active' => $active,'type' => 'advisers','id' => $id));
                        ?>
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                                <!--Datos acordeon-->                                
                                <div class="clear"></div>
                                <section class="content-scroll-x">
                                    <div class="clearfix">                                        
                                        <table class="bordered highlights">                                            
                                            <thead>
                                                <tr class="backgroung-table-4">
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'PERFIL'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'TIPO PROCESO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'NOMBRES'); ?></th>
                                                    <!--<th width="10%" class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>-->
                                                    <!--<th width="20%" class="txt_center"><?php echo Yii::t('front', 'ASIGNADO'); ?></th>-->
                                                     <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ÚLTIMA CONEXIÓN'); ?></th>
<!--                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'RECAUDADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTIMADO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'PENDIENTE'); ?></th>-->
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                </tr>
                                                <tr class="filters formweb" data-id="advisers" data-url="users/advisers/1">
                                                    <th class="txt_center">
                                                        <select class="filter-table" id="advisers-filter-active" name="idCoordinator">
                                                            <option value=""><?php echo Yii::t('front', ''); ?></option>
                                                            <?php  foreach ($coordinators as $coordinator) { ?>
                                                                <option value="<?php echo $coordinator->id; ?>"><?php echo $coordinator->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </th>
                                                    <th class="txt_center">
                                                        <select class="filter-table" id="advisers-filter-active" name="idProfile">
                                                            <option value=""><?php echo Yii::t('front', ''); ?></option>
                                                            <?php  foreach ($advisers as $adviser) { ?>
                                                                <option value="<?php echo $adviser->id; ?>"><?php echo $adviser->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </th>
                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-company" type="text" name="company" /></th>
                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-name" type="text" name="name" /></th>
                                                    <!--<th class="txt_center"><input class="filter-table" id="users-filter-userName" type="text" name="userName" /></th>-->
                                                    <!--<th class="txt_center"><input class="filter-table" id="advisers-filter-assigment" type="text" name="assigment" readonly /></th>-->
                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-company" type="text" name="last_session" readonly /></th>
<!--                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-interest" type="text" name="interest" readonly /></th>
                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-paymeents" type="text" name="payments" readonly /></th>
                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-agreement" type="text" name="agreement" readonly /></th>
                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-pending" type="text" name="pending" readonly /></th>-->
                                                    <th class="txt_center"><input class="filter-table" id="advisers-filter-" type="text" readonly /></th>
                                                    <th class="hide"><input class="filter-table" id="advisers-filter-page" name="page" type="hidden" value="1"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-advisers">
                                                <?php $this->renderPartial('/users/partials/content-advisers-table', array('model' => $model)); ?>                                                
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="clear"></div>
                                    <div id="pagination-advisers" class="bg-pagination">                                    
                                        <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'advisers')); ?>                                    
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
Yii::app()->controller->renderPartial('/users/partials/modal-advisers', array(
    'countries' => $countries,
    'advisers' => $advisers,
    'typeProcess' => $typeProcess,
    'id' => $id
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

Yii::app()->clientScript->registerScript("advisers_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);