<tr id="itemLink-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center icon_table">
        <a href="<?php echo $model->link; ?>" target="_blank" 
           class="inline padding tooltipped" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="<?php echo Yii::t('front', ($model->type == 1)? 'Ver' : 'Descargar'); ?>"
           ><i class="fa fa-<?php echo ($model->type == 1)? 'eye' : 'download'; ?>" aria-hidden="true"></i></a>
    </td>
</tr>

