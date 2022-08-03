<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php
            $class = 'm_t_20';
//                if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['admin'])){                                                   
                    $class = ''; 
                    $this->renderPartial('/suggestions/partials/filter-suggestions', array('active' => 2,'url' => 'customers')); 
//                }
            ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp <?php echo $class; ?>">
                <!--Tabs-->
                <!-- <div class="block">
                    <ul class="tabs tab_cartera">
                        <li class="tab"><a href="<?php echo $this->createUrl('/customers'); ?>" class="active"><i class="fa fa-user" aria-hidden="true"></i> CLIENTES</a></li>
                    </ul>
                </div>    -->
                <section class="panelBG m_b_30">
                    <div class="row"> 
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                            <!--Datos acordeon-->                                
                            <div class="clear"></div>
                            <section class="content-scroll-x">
                                <div class="clearfix content-customers">                                        
                                    <table class="bordered highlight">                                            
                                        <thead>
                                            <tr class="backgroung-table-4">
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
                                                <th width="10%" class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>
                                                <th width="70%" class="txt_center"><?php echo Yii::t('front', 'SUGERENCIA'); ?></th>
                                                <th width="10%" class="txt_center hide"><?php echo Yii::t('front', 'SOPORTES'); ?></th>
                                            </tr>
                                            <tr class="filters formweb"  data-id="suggestions" data-url="suggestions">
                                                <th class="txt_center"><input class="filter-table calendar" id="suggestions-filter-date" value="" name="date"></th>
                                                <th class="txt_center">
                                                    <select id="suggestions-filter-idProfile" name="idProfile" class="filter-table" data-closest="th">
                                                        <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                                                        <?php foreach ($profiles as $profile){ ?>
                                                            <option value="<?php echo $profile->id; ?>"><?php echo $profile->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                <th class="txt_center"><input class="filter-table" id="suggestions-filter-user" type="text" name="name" /></th>
                                                <th class="txt_center"><input class="filter-table" id="suggestions-filter-name" type="text" name="comments"  /></th>                                                
                                                <th class="txt_center hide"><input class="filter-table" id="suggestions-filter-name" type="text" name="supports" readonly /></th>                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-suggestions">
                                            <?php $this->renderPartial('/suggestions/partials/content-suggestions-table', array('model' => $model)); ?>
                                        </tbody>
                                    </table>                                        
                                </div>
                                <div class="clear"></div>
                                <div id="pagination-suggestions" class="bg-pagination">                                    
                                    <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers')); ?>                                    
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
Yii::app()->controller->renderPartial('/suggestions/partials/modal-suggestions', array(
    
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/suggestions.min.js', CClientScript::POS_END);
$js = '';

if(isset($_GET['name']) && $_GET['name'] != ''){
    $js .= '$("#form-filter-name").val("'.$_GET['name'].'");';
}

if(isset($_GET['numberDocument']) && $_GET['numberDocument'] != ''){
    $js .= '$("#form-filter-numberDocument").val("'.$_GET['numberDocument'].'");';
}

if(isset($_GET['active']) && $_GET['active'] != ''){
    $js .= '$("#form-filter-active").val('.$_GET['active'].');';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click'); console.log('filter');";
}

Yii::app()->clientScript->registerScript("payments_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);