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
                                <td class="txt_center" width="50%">901.106.562 - 2</td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'CANAL DE PAGO'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $model->idPaymentsMethod0->name; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'FECHA'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->debtorsPaymentsPayers[0]->dateCreated); ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'ESTADO') ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $model->idPaymentsState0->name; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'REFERENCIA DE PEDIDO'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $model->order_id; ?></td>
                            </tr>                            
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'VALOR'); ?> :</td>
                                <td class="txt_center" width="50%">$<?php echo Yii::app()->format->formatNumber($model->value); ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><?php echo Yii::t('front', 'IP ORIGEN'); ?> :</td>
                                <td class="txt_center" width="50%"><?php echo $model->debtorsPaymentsPayers[0]->ip_address; ?></td>
                            </tr>
                            <tr>
                                <td class="txt_center" width="50%"><a href="<?php echo $this->createUrl('/services'); ?>" class="btnb pop waves-effect waves-light"><?php echo Yii::t('front', 'VOLVER'); ?></a></td>
                                <td class="txt_center" width="50%"><a href="<?php echo $model->url_html; ?>" target="_blank" class="btnb waves-effect waves-light "><?php echo Yii::t('front', 'VER RECIBO'); ?></a></td>                            
                            </tr>
                        </tbody>
                    </table>                    
                </section>
            </section>
        </section>
    </section>
</section>