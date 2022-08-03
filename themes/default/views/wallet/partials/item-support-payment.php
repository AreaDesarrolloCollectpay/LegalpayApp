<tr id="itemSupportPWallet-<?= $model->id; ?>">
    <td class = "txt_center"><?= ($model->idUserPayments0 != null)? $model->idUserPayments0->name : '-'; ?></td>
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->datePay)); ?></td>
    <td class="txt_center icon_table">
        <?php if($model->supportPayments != ''){ ?>
        <a href="<?= $model->supportPayments; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
        <?php } ?>
    </td>
</tr>

