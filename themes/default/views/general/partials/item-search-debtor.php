<tr id="itemLink-<?= $model->idDebtor; ?>">
    <td class = "txt_center"><?= $model->customer; ?></td>
    <td class = "txt_center"><?= $model->code; ?></td>
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center icon_table">
        <a href="<?php echo $this->createUrl('/wallet/debtor/'.$model->idDebtor); ?>" target="_blank" 
           class="inline padding tooltipped modal_clic" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"
           ><i class="fa fa-eye" aria-hidden="true"></i></a></td>
</tr>

