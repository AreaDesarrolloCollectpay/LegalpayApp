<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <?php
                    $this->renderPartial('/users/partials/item-tabs',array('active' => $active,'id' => $id));
                ?> 
                <section class="panelBG m_b_20">
                    <section class="padd_v">
                        <?php 
//                            $this->renderPartial('/users/partials/filter-users',array('active' => $active,'type' => 'business','id' => $id));
                        ?>
                        <div class="row m_t_10"> 
                            <!--Tab 4-->
                            <article id="historia_pagos" class="block">
                                <!--Datos acordeon-->                                
                                <div class="clear"></div>
                                <section class="padding m_t_5 content-scroll-x">
                                    <div class="clearfix">                                        
                                        <table class="bordered highlight">                                            
                                            <thead>
                                                <tr class="backgroung-table-4">
                                                    <th width="30%" class="txt_center"><?php echo Yii::t('front', 'NOMBRES'); ?></th>
                                                    <th width="20%" class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>                                                    
                                                    <th width="40%" class="txt_center"><?php echo Yii::t('front', 'PORTAFOLIO'); ?></th>
                                                    <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                                                </tr>
<!--                                                <tr class="filters formweb">
                                                    <td>
                                                       <input type="text" class="searchAdvisers"  name="nameCoordinator" maxlength="100" value="<?php echo (isset($_GET['nameCoordinator']) && $_GET['nameCoordinator'] != '') ? $_GET['nameCoordinator'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchAdvisers"  name="name" maxlength="100" value="<?php echo (isset($_GET['name']) && $_GET['name'] != '') ? $_GET['name'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchAdvisers" name="userName" maxlength="100" value="<?php echo (isset($_GET['userName']) && $_GET['userName'] != '') ? $_GET['userName'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchAdvisers txt_center" name="capital" maxlength="100" value="<?php echo (isset($total) && $total != null) ? '$'.Yii::app()->format->formatNumber($total->capital) : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchAdvisers txt_center" name="interest" maxlength="100" value="<?php echo (isset($total) && $total != null) ? '$'.Yii::app()->format->formatNumber($total->interest) : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="searchAdvisers txt_center" name="payments" maxlength="100" value="<?php echo (isset($total) && $total != null) ? '$'.Yii::app()->format->formatNumber($total->payments) : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchAdvisers txt_center" name="estimated" maxlength="100" value="<?php echo (isset($total) && $total != null) ? '$'.Yii::app()->format->formatNumber($total->estimated) : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="searchAdvisers txt_center" name="pending" maxlength="100" value="<?php echo (isset($total) && $total != null) ? '$'.Yii::app()->format->formatNumber($total->pending) : ''; ?>">
                                                    </td>
                                                    <td>                                                        
                                                    </td>
                                                </tr>-->
                                            </thead>
                                            <tbody id="usersCoordinators">
                                                <?php
                                                foreach ($model as $value) {
                                                    $this->renderPartial('/users/partials/item-business', array('model' => $value));
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
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/users.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/users/partials/modal-business', array(
    'countries' => $countries,
    'id' => $id,
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