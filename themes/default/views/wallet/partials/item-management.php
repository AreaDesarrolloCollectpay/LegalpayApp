<li>
    <div class="collapsible-header">
        <table class="bordered">
            <tbody>
                <tr>
                    <td width="25%" class="txt_center"><?= $model->coordinator; ?></td>
                    <td width="30%" class="txt_center"><?= $model->adviser; ?></td>
                    <td width="15%" class="txt_center"><?= $model->date; ?></td>
                    <td width="30%" class="txt_center"><?= $model->management; ?> <a href="javascript:void(0)" class="clic_mas"><i class="fa fa-plus" aria-hidden="true"></i> <span class="inline"><?php echo Yii::t('front', 'VER MÁS'); ?></span></a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="collapsible-body padd_v">
        <div class="large-4 medium-4 small-12 columns padding formweb">
            <label><?= Yii::t('front', 'Comentarios'); ?></label>
            <p><?= $model->comments; ?></p>
        </div>
        <div class="large-4 medium-4 small-12 columns padding formweb">
            <label><?php echo Yii::t('front', 'Gestión'); ?></label>
            <p><?= $model->actionEffect; ?></p>
        </div>
        <div class="large-4 medium-4 small-12 columns padding formweb">
            <?php if ($model->countM > 1 && $viewMore) { ?>
                <label><?php echo Yii::t('front', 'Más Gestiones'); ?></label>
                <a href="#view_management_modal" class="inline padding tooltipped viewManagement modal_clic" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver más'); ?>" data-idDebtor="<?= $model->idDebtor; ?>" data-idUserAsigned="<?= $model->idUserAsigned; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
            <?php } ?>
            <?php if ($model->images > 0) { ?>
                <label><?php echo Yii::t('front', 'Ver Soportes'); ?></label>
                <a href="#view_management_images_modal" class="inline padding tooltipped viewSupportManagement modal_clic" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver más'); ?>" data-idTask="<?= $model->id; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
            <?php } ?>
        </div>
        <div class="clear"></div>
    </div>
</li>