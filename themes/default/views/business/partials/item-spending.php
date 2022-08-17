<tr id="itemBusinessSpending-<?= $model->id; ?>">
    <td class="txt_center" width="10%"><?= date("d/m/Y", strtotime($model->dateSpending)); ?></td>
    <td class="txt_center" width="10%"><?= ($model->idSpendingType0 != NULL) ? $model->idSpendingType0->name : ''; ?></td>
    <!--<td class="txt_center" width="10%"><?= ($model->idCity0 != NULL) ?  $model->fullDistrict: ''; ?></td>-->
    <!--<td class="txt_center" width="20%"><?= nl2br($model->comments); ?></td>-->
    <!--<td class="txt_center" width="20%"><?= '$ '.Yii::app()->format->formatNumber($model->value); ?></td>-->
    <td class="txt_center icon_table" width="10%">
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
        <?php if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){ ?>
        <a href="#new_spending_business_modal" 
           class="inline padding tooltipped editSpending modal_clic" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar"
           data-idUserBusiness="<?= $model->idUserBusiness; ?>" 
           data-id="<?= $model->id; ?>" 
           data-spendingDate="<?= $model->dateSpending; ?>"
           data-idCountry="<?= ($model->idCity0 != NULL) ?  $model->idCountry: ''; ?>"
           data-idDepartment="<?= ($model->idCity0 != null) ? $model->idDepartment : ''; ?>"
           data-idCity="<?= ($model->idCity0 != null) ? $model->idCity : ''; ?>"           
           data-spendingComments="<?= $model->comments; ?>"
           data-spendingValue="<?= $model->value; ?>"
           data-idSpendingType="<?= $model->idSpendingType; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php }  ?>
    </td>
</tr>