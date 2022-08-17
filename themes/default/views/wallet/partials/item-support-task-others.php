<tr id="itemSupportWallet-<?= $model->id; ?>">
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->date)); ?></td>
    <td class="txt_center"><?= $model->coordinator; ?></td>
    <td class="txt_center"><?= $model->adviser; ?></td>
    <td class="txt_center"><?= $model->debtorState; ?></td>
    <td class="txt_center"><?= $model->management; ?></td>
    <td class="txt_center"><?= nl2br($model->comments); ?></td>
    <td class="txt_center icon_table">
        <?php if($model->images > 0){ ?>
        <a href="#view_management_images_modal" class="inline padding tooltipped viewSupportManagement modal_clic" data-idTask="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver Soportes') ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
        <?php } ?>
    </td>
</tr>

