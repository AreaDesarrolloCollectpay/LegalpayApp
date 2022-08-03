<section class="cont_home">
    <section class="conten_inicial">        
        <section class="row">
            
            <?php
                Yii::app()->controller->renderPartial('/services/partials/title_head', array());
            ?>
        </section>
        <section class="row m_t_40">
            <section class="padding animated fadeInUp">
                <!--All deudores-->
                <section class="panelBG m_b_20 lista_all_deudor m_t_40">
                    <table class="bordered highlight responsive-table">
                        <thead>
                            <tr class="backgroung-table-2">
                                <th class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'NOMBRE / RAZON SOCIAL'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'TOTAL OBLIGACIÓN'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'SALDO'); ?></th>
                                <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="listDebtors">                             
                            <?php foreach ($model as $value) { 
                                $id = Controller::siteEncodeURL($value->id);
                                $othersValues = Controller::othersValues($value->id);
                            ?>
                                <tr>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl.'/services/detail/'.$id; ?>';" class="txt_center"><?php echo $value->code; ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl.'/services/detail/'.$id; ?>';" class="txt_center"><?php echo $value->name; ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl.'/services/detail/'.$id; ?>';" class="txt_center"><?php echo $value->customer; ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl.'/services/detail/'.$id; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']))? ($othersValues['model']->capital + $othersValues['model']->interest + $othersValues['model']->fee) : 0), 0, ',', '.'); ?></td>
                                    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl.'/services/detail/'.$id; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']))? ($othersValues['model']->capital + $othersValues['model']->interest + $othersValues['model']->fee - $othersValues['model']->payments) : 0), 0, ',', '.'); ?></td>
                                    <td class="txt_center"><a href="<?php echo Yii::app()->baseUrl.'/services/pay/'.$id; ?>" class="btnb waves-effect waves-light"><?= Yii::t("front", "PAGAR") ?></a></td>                                
                                </tr>
                            <?php } ?>
                    </table>
                    <div class="clear"></div>  
                    <div class="bg-pagination">
                        
                    </div>
                </section>
                <!--Fin All deudores-->

            </section>

            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/wallet.min.js', CClientScript::POS_END);
if (isset($historic) && $historic) {
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/historic.min.js', CClientScript::POS_END);
}

$js = '';

if(isset($_GET['customer']) && $_GET['customer'] != ''){
    $js .= '$("#form-filter-customer").val("'.$_GET['customer'].'");';
}

if(isset($_GET['name']) && $_GET['name'] != ''){
    $js .= '$("#form-filter-name").val("'.$_GET['name'].'");';
}

if(isset($_GET['code']) && $_GET['code'] != ''){
    $js .= '$("#form-filter-code").val("'.$_GET['code'].'");';
}

if(isset($_GET['city']) && $_GET['city'] != ''){
    $js .= '$("#form-filter-city").val("'.$_GET['city'].'");';
}

if(isset($_GET['idState']) && $_GET['idState'] != ''){
    $js .= '$("#form-filter-idState").val('.$_GET['idState'].').trigger("change");';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click');";
}

Yii::app()->clientScript->registerScript("debtor_list_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);

