<tr id="itemDemographicUserEmail-<?= $model->id; ?>">
    <td class="txt_center"><?= ($model->idTypeReference)? Yii::t('front', $model->idTypeReference0->name) : ''; ?></td>
    <td class="txt_center"><?= $model->name; ?></td>
    <td class="txt_center"><?= $model->email; ?></td>
    <td class="txt_center descrip"><p><?= $model->comment; ?></p></td>
    <td class="txt_center descrip"><p><?= $model->state; ?></p></td>
    <td class="txt_center icon_table">
        <?php if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){ ?>
        <a href="#new_correo_modal" 
           class="inline padding tooltipped editEmail modal_clic btn-disabled" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar"
           data-id="<?= $model->id; ?>"
           data-idUser="<?= $model->idUser; ?>"
           data-name="<?= $model->name; ?>"
           data-email="<?= $model->email; ?>"
           data-comment="<?= $model->comment; ?>"
           data-idTypeReference="<?= $model->idTypeReference; ?>"
           data-active="<?= $model->active; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php } ?>
        <!--<a href="#" class="inline padding tooltipped delete deleteItemDemographicWallet" idDemographic="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
    </td>
</tr>