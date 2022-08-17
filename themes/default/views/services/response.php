<section class="cont_home">
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Resultado de la operación") ?></h2>
            </div>
            <div class="clear"></div> 
            <section class="padding animated fadeInUp m_t_60">

                <section class="panelBG m_b_20 lista_all_deudor">
                    <table class="bordered highlight responsive-table">
                        <tbody id="listDebtors">
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'EMPRESA'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo Yii::app()->params['company']; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'NIT'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo Yii::app()->params['company_ID']; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'CANAL DE PAGO'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $model->idPaymentsMethod0->name; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'FECHA'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo ($model != null)? Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->dateCreated) : ''; ?> </td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'ESTADO') ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $state; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'REFERENCIA DE PEDIDO'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $referenceCode; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'REFERENCIA DE TRANSACCIÓN'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $reference_pol;  ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'NÚMERO DE TRANSACCIÓN'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $cus; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'BANCO'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $pseBank; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'VALOR'); ?> :</td>
                                <td class="txt_center" width="50%">$<?php echo Yii::app()->format->formatNumber($TX_VALUE); ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'MONEDA'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $currency; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'DESCRIPCIÓN'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $description; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'IP ORIGEN'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $pseReference1; ?></td>
                            </tr>
                            <tr>
                                <table border="0">
                                    <tbody>
                                        <tr>
                                            <td class="txt_center" width="30%"><a href="<?php echo $this->createUrl('/services'); ?>"   class="btnb pop waves-effect waves-light"><?php echo Yii::t('front', 'Finalizar'); ?></a></td>
                                            <td class="txt_center" width="30%"><?php if($model->idPaymentsState == 3){?> <a href="#" id="againPay" data-id="<?php echo $model->id; ?>" class="btnb waves-effect waves-light "><?php echo Yii::t('front', 'Reintentar Transacción'); ?></a> <?php } ?></td>                                                                                        
                                            <td class="txt_center" width="30%"><?php if($model->supportPayments != ''){?> <a href="<?php echo $model->supportPayments; ?>" download target="_blank" class="btnb waves-effect waves-light "><?php echo Yii::t('front', 'Soporte de la Transacción'); ?></a> <?php } ?></td>                                                                        
                                        </tr>
                                    </tbody>
                                </table>
                            </tr>
                        </tbody>
                    </table>                    
                </section>
            </section>
        </section>
    </section>
</section>
<?php
$js = '';
    $js .= '            
            $("body").on("click","#againPay",function(e){
                e.preventDefault();
                var _this = $(this);
                $.ajax({
                    url: SITEURL + "/services/againPSE",
                    dataType: "json",
                    type: "POST",
                    data: {id : _this.attr("data-id")},
                    beforeSend: function () {
                        $(".preload").fadeIn(300);
                    },
                    success: function (result) {
                        if (result.status == "success") {  
                            setTimeout(function(){
                                  location.href = result.url;
                            },500);
                        }else{
                            $(".preload").fadeOut(300);
                            toastr[result.status](result.msg);                            
                        }
                    }
                });
            });
           ';
    
Yii::app()->clientScript->registerScript("pay_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
?>
