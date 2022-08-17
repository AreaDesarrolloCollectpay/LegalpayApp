<tr id="itemSession-<?= $model->id; ?>">
    <td class = "txt_center"><?= Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->dateCreated); ?></td>
    <td class = "txt_center"><?= Yii::app()->dateFormatter->format('hh:mm:ss a',$model->dateCreated); ?></td>
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->ipAddress; ?></td>
    <td class = "txt_center"><?= $model->userAgent; ?></td>
    <?php if(!$hide){ ?>
    <td class="txt_center icon_table">                                           
        <a href="#" class="inline padding tooltipped view-sessions" data-date="<?= Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->dateCreated); ?>" data-user="<?php echo $model->idUser; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver detalle'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
    </td>
    <?php } ?>
</tr>

