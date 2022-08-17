<tr>
    <td class="txt_center"><?= $model->idCustomer0->name; ?></td> 
    <td class="txt_center"><?= $model->idCustomer0->name; ?></td> 
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->dateCreated)); ?></td> 
    <td class="txt_center"><?= $model->accounts; ?></td> 
    <td class="txt_center icon_table" width="16%">
        <?php if ($model->file != '') { ?><a href="<?= $model->file; ?>" download class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>        
    </td>
</tr>