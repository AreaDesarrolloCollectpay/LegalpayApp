<tr id="itemPayments-<?= $model->id; ?>">
    <td class = "txt_center"><?= Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->date); ?></td>
    <td class = "txt_center"><?= $model->nameUser; ?></td>
    <td class = "txt_center"><?= $model->numberDocument; ?></td>
    <td class = "txt_center"><?= $model->businessAdvisor; ?></td>
    <td class = "txt_center"><?= $model->location; ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->value); ?></td>
    <td class="txt_center icon_table">                                  
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
    </td>
</tr>

