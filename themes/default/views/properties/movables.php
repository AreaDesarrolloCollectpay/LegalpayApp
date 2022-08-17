<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
	
		<div class="dates_all topBarJuridico">
 <ul class="filter_views">      
		<li><a href="/tasks" id="m-tasks"><i class="feather feather-list "></i> Calendario</a></li>
		<li><a href="/maps" id="m-maps"><i class="feather feather-map-pin"></i> Mapa</a></li>
		<li><a href="/dashboard" id="m-dashboard"><i class="feather feather-grid"></i> Gestion</a></li>
		</ul>
	</div>
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <?php
                    $this->renderPartial('/properties/partials/item-tabs',array('active' => 1));
                ?>                  
                <section class="panelBG m_b_20">
                    <section class="">
                        <?php 
//                            $this->renderPartial('/properties/partials/filter-properties',array('type' => 'movables'));
                        ?>
                        <div class="row"> 
                            <!--Tab 4-->
                            <article id="historia_pagos" class="block">
                                <!--Datos acordeon-->                                
                                <div class="clear"></div>
                                <section class="">
                                    <div class="clearfix">                                        
                                        <table class="bordered highlight responsive-table">                                            
                                            <thead>
                                                <tr class="backgroung-table-4">
                                                    <th width="20%" class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                                    <th width="20%" class="txt_center"><?php echo Yii::t('front', 'DEUDOR'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'BIEN'); ?></th>
                                                    <th width="20%" class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
                                                </tr>
                                                <tr class="filters formweb" data-id="movables" data-url="properties/movables">
                                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-customer" type="text" name="customer" /></th>
                                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-debtor" type="text" name="name" /></th>
                                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-code" type="text" name="code" /></th>
                                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-city" type="text" name="city" /></th>
                                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-property" type="text" name="property" /></th>
                                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-spending" type="text" name="" readonly /></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-movables">
                                                <?php
                                                foreach ($model as $value) {
                                                    $this->renderPartial('/properties/partials/item-movables', array('model' => $value));
                                                }
                                                ?>
                                            </tbody>
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
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/properties-movables.min.js', CClientScript::POS_END);
$js = '';

if(isset($_GET['customer']) && $_GET['customer'] != ''){
    $js .= '$("#form-filter-customer").val("'.$_GET['customer'].'");';
}

if(isset($_GET['coordinator']) && $_GET['coordinator'] != ''){
    $js .= '$("#form-filter-coordinator").val("'.$_GET['coordinator'].'");';
}

if(isset($_GET['city']) && $_GET['city'] != ''){
    $js .= '$("#form-filter-city").val("'.$_GET['city'].'");';
}

if(isset($_GET['code']) && $_GET['code'] != ''){
    $js .= '$("#form-filter-code").val("'.$_GET['code'].'");';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click'); console.log('filter');";
}

Yii::app()->clientScript->registerScript("properties_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
