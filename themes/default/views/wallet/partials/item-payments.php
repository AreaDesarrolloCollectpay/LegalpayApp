<tr id="itemPaymentWallet-<?= $model->id; ?>">
    <td class="txt_center" width="14%"><?= date("d/m/Y", strtotime($model->datePay)); ?></td>
    <td class="txt_center hide-wallet" width="14%"><?= ($model->idUserPayments0 != NULL) ? $model->idUserPayments0->userName : ''; ?></td>
    <td class="txt_center" width="14%"><?= ($model->idPaymentsMethod != NULL) ? $model->idPaymentsMethod0->name : ''; ?></td>
    <td class="txt_center hide-wallet" width="14%"><?= ($model->idPaymentsDiscrimination != NULL) ? $model->idPaymentsDiscrimination0->name : ''; ?></td>
    <td class="txt_center" width="14%"><?= '$ '.Yii::app()->format->formatNumber($model->value); ?></td>
    <td class="txt_center" width="14%"><?= ($model->idPaymentsState0 != NULL) ? $model->idPaymentsState0->name : ''; ?></td>
    <td class="txt_center icon_table" width="16%">
        <?php if ($model->supportPayments != '') { ?><a href="<?= $model->supportPayments; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
        <?php if ($model->supportPayments != '') { ?><a href="<?= $model->supportPayments; ?>" class="inline padding tooltipped hide" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
        <?php if($edit){ ?>
        <a href="#new_payment_modal" 
           class="inline padding tooltipped editWalletPayment modal_clic btn-disabled" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar"
           data-idPayment="<?= $model->id; ?>" 
           data-idWallet="<?= $model->idDebtorObligation; ?>" 
           data-idDebtorDebt="<?= $model->idDebtorDebt; ?>" 
           data-idPaymentTypeDiscrimination="<?= ($model->idPaymentsDiscrimination != null) ? $model->idPaymentsDiscrimination : ''; ?>"
           data-idPaymentTypeClass="<?= ($model->idPaymentsType != null) ? $model->idPaymentsType : ''; ?>"
           data-idPaymentTypeState="<?= ($model->idPaymentsState != null) ? $model->idPaymentsState : ''; ?>"
           data-idPaymentTypeMethod="<?= ($model->idPaymentsMethod != null) ? $model->idPaymentsMethod : ''; ?>"
           data-idPaymentTypePaidTo="<?= ($model->idPaymentsWhoPaid != null) ? $model->idPaymentsWhoPaid : ''; ?>"
           data-paymentValue="<?= $model->value; ?>"
           data-paymentDate="<?= $model->datePay; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php } ?>
    </td>
</tr>
