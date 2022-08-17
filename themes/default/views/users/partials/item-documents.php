<tr id="itemContract-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->comments; ?></td>
    <td class = "txt_center"><?= $model->dateCreated; ?></td>
    <td class="txt_center icon_table">                                  
        <a href="#new_contracts_modal" data-id="<?= $model->id; ?>" data-element="form-contracts-" class="inline padding tooltipped editContracts modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>         
        <?php if ($model->file != '') { ?><a href="<?= $model->file; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
    </td>
</tr>

