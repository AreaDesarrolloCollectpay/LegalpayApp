<tr id="itemSupportWallet-<?= $model->id; ?>">
    <td class="txt_center"><?= $model->duedate; ?></td>
    <td class="txt_center"><?= $model->credit_number; ?></td>
    <td class="txt_center">$ <?= Yii::app()->format->formatNumber($model->capital); ?></td>
    <td class="txt_center">$ <?= Yii::app()->format->formatNumber($model->interest); ?></td>
    <td class="txt_center">$ <?= Yii::app()->format->formatNumber($model->fee); ?></td>
    <td class="txt_center">$ <?= Yii::app()->format->formatNumber(($model->capital + $model->interest + $model->fee)); ?></td>
    <td class="txt_center icon_table">
            <a href="#view_debtor_obligation_modal" class="inline padding tooltipped viewDebtorObligation modal_clic" data-id="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver Detalle') ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
    </td>
</tr>