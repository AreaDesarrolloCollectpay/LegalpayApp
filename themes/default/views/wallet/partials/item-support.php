<tr id="itemSupportWallet-<?= $model->id; ?>">
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->dateSupport)); ?></td>
    <td class = "txt_center"><?= ($model->idTypeSupport0  != null )? $model->idTypeSupport0->name : ''; ?></td>
    <td class = "txt_center"><?= nl2br($model->comments); ?></td>
    <td class="txt_center icon_table">                                  
<!--    <a href="#new_sporte_modal" 
            class="inline padding tooltipped editSoporte modal_clic" 
            data-position="top" 
            data-delay="50" 
            data-tooltip="Eliminar"
            data-id="<?= $model->id; ?>"
            data-fileName="<?= $model->comments; ?>"
            <i class="fa fa-trash" aria-hidden="true"></i></a>-->
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Descargar"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
        <!--<a href="javascript:preguntar(<?= $model->id ?>)" class="inline padding tooltipped delete" idDemographic="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
    </td>
</tr>

