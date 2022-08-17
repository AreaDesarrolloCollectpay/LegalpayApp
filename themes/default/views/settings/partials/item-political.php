<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= ($model->idUser0 != null)? $model->idUser0->name : Yii::t('front', 'GENERAL'); ?></td>   
    <td class = "txt_center"><?= $model->name; ?></td>   
    <td class = "txt_center"><?= date("d/m/Y H:m:s", strtotime($model->dateCreated)); ?></td>   
    <td class="txt_center icon_table">                                  
        <?php if ($model->file != '') { ?><a href="<?= $model->file; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
        <?php if ($model->file != '') { ?><a href="<?= $model->file; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
        <?php if($edit){ ?>
        <a href="#new_political_modal" 
           class="inline padding tooltipped editWalletPayment modal_clic btn-disabled" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar"
           data-id="<?= $model->id; ?>" 
           data-name="<?= $model->name; ?>" 
           data-idUser="<?= ($model->idUser0 != null) ? $model->$model->idUser : 0; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php } ?>
    </td>
</tr>

