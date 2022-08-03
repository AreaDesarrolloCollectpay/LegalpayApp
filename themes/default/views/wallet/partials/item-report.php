<tr id="itemReports-<?php echo $typeReport->id; ?>"> 
    <td class="txt_center"><?php echo ($model != null) ? $model->date : ''; ?></td>
    <td class="txt_center "><?php echo $typeReport->name; ?></td>
    <td class="txt_center"><?php echo ($model != null) ? $model->comments : ''; ?></td>
    <td class="txt_center icon_table">
        <a href="#modal_reports" class="inline padding tooltipped editReport modal_clic btn-disabled" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Editar'); ?>" data-idTypeReport="<?php echo $typeReport->id; ?>" data-idDebtorDebt="<?php echo $debtor; ?>"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php if ($model != null && $model->support != '') { ?>
            <a href="<?php echo $model->support; ?>" class="inline padding" download><i class="fas fa-download" aria-hidden="true"></i></a>
            <a href="<?php echo $model->support; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="Ver"><i class="fa fa-eye" aria-hidden="true"></i></a>
        <?php } ?>
    </td>
</tr>
