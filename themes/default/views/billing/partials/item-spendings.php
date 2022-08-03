<tr id="itemSpendings-<?= $model->id; ?>">
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class="txt_center"><?= Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->dateSpending); ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class="txt_center"><?= $model->customer; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class="txt_center"><?= $model->coordinator; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class="txt_center"><?= $model->coordinator; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class="txt_center"><?= $model->code; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class="txt_center"><?= $model->name; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class="txt_center">$ <?= Yii::app()->format->formatNumber($model->value); ?></td>
    <td class="txt_center icon_table">                                  
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
    </td>
</tr>

