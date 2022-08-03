<tr id="itemSupportPWallet-<?= $model->id; ?>">
    <td class = "txt_center"><?= ($model->idUserSpending0 != null)? $model->idUserSpending0->name : '-'; ?></td>
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->dateSpending)); ?></td>
    <td class="txt_center icon_table">
        <?php if($model->support != ''){ ?>
        <a href="<?= $model->support; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
        <?php } ?>
    </td>
</tr>

