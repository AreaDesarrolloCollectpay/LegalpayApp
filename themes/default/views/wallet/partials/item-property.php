<tr id="itemPropertyWallet-<?= $model->id; ?>">
    <td class = "txt_center"><?= ($model->idPropertyType0 != null)? $model->idPropertyType0->name : '-'; ?></td>
    <td class = "txt_center"><?= $model->number; ?></td>
    <td class = "txt_center"><?= ($model->fullDistrict != '')? $model->fullDistrict : ''; ?></td>
    <td class = "txt_center"><?= $model->address; ?></td>
    <td class="txt_center"><?= nl2br($model->comment); ?></td>
    <td class="txt_center icon_table">
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped view-support" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
        <?php if ($model->support != '') { ?><a href="<?= $model->support; ?>" class="inline padding tooltipped hide" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
        <?php if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){ ?>
        <a href="#new_bien_modal" 
           class="inline padding tooltipped editProperty modal_clic btn-disabled" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar"
           data-id="<?= $model->id; ?>"
           data-idDebtor="<?= $model->idDebtor; ?>"
           data-address="<?= $model->address; ?>"
           data-number="<?= $model->number; ?>"
           data-idPropertyType="<?= $model->idPropertyType; ?>"
           data-idCountry="<?= ($model->idCity != NULL) ?  $model->idCountry: ''; ?>"
           data-idDepartment="<?= ($model->idCity != null) ? $model->idDepartment : ''; ?>"
           data-idCity="<?= ($model->idCity != null) ? $model->idCity : ''; ?>"           
           data-comment="<?= $model->comment; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php } ?>
        <!--<a href="#" class="inline padding tooltipped delete deleteItemDemographicWallet" idAsset="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
    </td>
</tr>

