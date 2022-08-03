<form id="frmFinantial" action="" class="formweb m_t_20">
    <fieldset class="large-3 medium-6 small-6 columns padding">                                                        
        <label><?php echo Yii::t('front', 'Número Crédito'); ?></label>
        <input type="text" name="" value="<?= ($model != null) ? $model->credit_number : ''; ?>"  disabled>
        <label><?php echo Yii::t('front', 'Capital'); ?></label>
        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($model != null) ? $model->capital : 0); ?>"  disabled>
        <label><?php echo Yii::t('front', 'Intereses'); ?></label>
        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($model != null) ? $model->interest : 0); ?>" disabled>                                                    
        <label><?php echo Yii::t('front', 'Intereses de Mora'); ?></label>
        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($model != null) ? $model->interest_arrears : 0); ?>" disabled>                                                    
        <label><?php echo Yii::t('front', 'Intereses de Mora Migrados'); ?></label>
        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($model != null) ? $model->interest_arrears_migrate : 0); ?>" disabled>                                                    
        <label><?php echo Yii::t('front', 'Gastos'); ?></label>
        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($model != null) ? $model->charges : 0); ?>" disabled>                                                    
        <label><?php echo Yii::t('front', 'Otros'); ?></label>
        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($model != null) ? $model->others : 0); ?>" disabled>                                                    
        <label><?php echo Yii::t('front', 'Total'); ?></label>  
        <input type="text" name="" value="$ <?= Yii::app()->format->formatNumber(($model != null) ? ($model->capital + $model->interest + $model->interest_arrears + $model->interest_arrears_migrate + $model->charges + $model->others) : 0); ?>" disabled>                                                        
        <label><?php echo Yii::t('front', 'Fecha asignación'); ?></label>
        <input type="text" name="" value="<?= date("d/m/Y", strtotime($model->dateCreated)); ?>" disabled>
        <label><?php echo Yii::t('front', 'Fecha solicitud de crédito'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? $model->debtorsObligationsInfos->conditions : ''; ?>" disabled> 
    </fieldset>                                                        
    <fieldset class="large-3 medium-6 small-6 columns padding p_b_20">
        <label><?php echo Yii::t('front', 'Dias de mora a la fecha'); ?></label>
        <input type="text" name="" value="<?= $model->dayDebt . ' ' . Yii::t('front', 'Días'); ?>" disabled>
        <label><?php echo Yii::t('front', 'Tipo de Obligación'); ?></label>
        <input type="text" name="" value="<?= ($model != null) ? (($model->idCreditModality0 != null) ? $model->idCreditModality0->name : '') : ''; ?>" disabled>
        </select>
        <label><?php echo Yii::t('front', 'Tipo de Producto'); ?></label>
        <input type="text" name="" value="<?= ($model != null) ? (($model->idTypeProduct0 != null) ? $model->idTypeProduct0->name : '') : ''; ?>" disabled>                                     
        <label><?php echo Yii::t('front', 'Originador del crédito'); ?></label>
        <input type="text" name="" value="<?php echo ($model->debtorsObligationsInfos != null) ? $model->debtorsObligationsInfos->origin_credit : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Judicializado'); ?></label>
        <input type="text" name="" value="<?php echo ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->legal == 1) ? Yii::t('front', 'Si') : (($model->debtorsObligationsInfos->legal == 0) ? 'NO' : 'MD')) : 'NO'; ?>" disabled>
        <label><?php echo Yii::t('front', 'Pagare Original y Fisico'); ?></label>
        <select id="debtor-idTypeLaborOld" name="idTypeLaborOld" class="select-disabled">
            <option selected><?php echo ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->promissory_note_o_p == 1) ? Yii::t('front', 'Si') : Yii::t('front', 'No')) : Yii::t('front', 'No'); ?></option>
        </select>                                                                                                                        
        <label><?php echo Yii::t('front', 'Pagare digitalizado'); ?></label>
        <select id="debtor-idTypeLaborOld" name="idTypeLaborOld" class="select-disabled">
            <option selected><?php echo ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->promissory_note_d == 1) ? Yii::t('front', 'Si') : Yii::t('front', 'No')) : Yii::t('front', 'No'); ?></option>
        </select>                                                                                                                        
        <label><?php echo Yii::t('front', 'Autorización centrales de riesgo original y fisíco'); ?></label>
        <select id="debtor-idTypeLaborOld" name="idTypeLaborOld" class="select-disabled">
            <option selected><?php echo ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->au_central_risk_o_p == 1) ? Yii::t('front', 'Si') : Yii::t('front', 'No')) : Yii::t('front', 'No'); ?></option>
        </select>
        <label><?php echo Yii::t('front', 'Fecha de Corte'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? $model->debtorsObligationsInfos->conditions : ''; ?>" disabled> 
        <label><?php echo Yii::t('front', 'Pago posterior de castigo'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? $model->debtorsObligationsInfos->conditions : ''; ?>" disabled> 
    </fieldset>
    <fieldset class="large-3 medium-6 small-6 columns padding p_b_20">
        <label><?php echo Yii::t('front', 'Fecha de vencimiento'); ?></label>
        <input type="text" name="" value="<?= date("d/m/Y", strtotime($model->duedate)); ?>" disabled>
        <label><?php echo Yii::t('front', 'Fecha de Desembolso'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->disbursement_date != NULL) ? date("d/m/Y", strtotime($model->debtorsObligationsInfos->disbursement_date)) : '') : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Valor aprobado y desembolsado credito inicial'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? '$' . Yii::app()->format->formatNumber($model->debtorsObligationsInfos->approved_value) : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Fecha de Castigo'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->punishment_date != NULL) ? date("d/m/Y", strtotime($model->debtorsObligationsInfos->punishment_date)) : '' ) : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Fecha del ultimo Pago'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->last_pay_date != NULL) ? date("d/m/Y", strtotime($model->debtorsObligationsInfos->last_pay_date)) : '' ) : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Abono a Capital'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? '$' . Yii::app()->format->formatNumber($model->debtorsObligationsInfos->capital_subscription) : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Abono a Intereses'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? '$' . Yii::app()->format->formatNumber($model->debtorsObligationsInfos->interest_subscription) : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Abono a Seguros'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? '$' . Yii::app()->format->formatNumber($model->debtorsObligationsInfos->secure_subscription) : ''; ?>" disabled>  
        <label><?php echo Yii::t('front', 'Ciudad Juzgado'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? $model->debtorsObligationsInfos->conditions : ''; ?>" disabled>                                                                                                                                                                                                                                  
    </fieldset>
    <fieldset class="large-3 medium-6 small-6 columns padding p_b_20">
        <label><?php echo Yii::t('front', 'Fecha de prescripción'); ?></label>
        <input type="text" name="" value="<?= date("d/m/Y", strtotime($model->prescription)); ?>" disabled>                                                            
        <label><?php echo Yii::t('front', 'Valor de recaudo total de la obligacion'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? '$' . Yii::app()->format->formatNumber($model->debtorsObligationsInfos->total_subscription) : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Valor del recuado total desde el vencimiento'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? '$' . Yii::app()->format->formatNumber($model->debtorsObligationsInfos->total_pay_from_expiration) : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Fecha ultimó pago a capital'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->last_pay_capital_date != NULL ) ? date("d/m/Y", strtotime($model->debtorsObligationsInfos->last_pay_capital_date)) : '') : ''; ?>" disabled>
        <label><?php echo Yii::t('front', 'Fecha ultimó pago a interes'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->last_pay_interest_date != NULL) ? date("d/m/Y", strtotime($model->debtorsObligationsInfos->last_pay_interest_date)) : '') : ''; ?>" disabled>                                                            
        <label><?php echo Yii::t('front', 'Fecha presentación de demanda'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->presentation_demand_date != NULL) ? date("d/m/Y", strtotime($model->debtorsObligationsInfos->presentation_demand_date)) : '') : ''; ?>" disabled>                                                            
        <label><?php echo Yii::t('front', 'Formato de vinculación'); ?></label>
        <select id="debtor-idTypeLaborOld" name="idTypeLaborOld" class="select-disabled">
            <option selected><?php echo ($model->debtorsObligationsInfos != null) ? (($model->debtorsObligationsInfos->linking_format == 1) ? Yii::t('front', 'Si') : Yii::t('front', 'No')) : Yii::t('front', 'No'); ?></option>
        </select>
        <label><?php echo Yii::t('front', 'Fecha última actualización'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? $model->debtorsObligationsInfos->conditions : ''; ?>" disabled> 
        <label><?php echo Yii::t('front', 'Otros Abonos'); ?></label>
        <input type="text" name="" value="<?= ($model->debtorsObligationsInfos != null) ? $model->debtorsObligationsInfos->conditions : ''; ?>" disabled>      
    </fieldset>
    <div class="clear"></div>
</form>