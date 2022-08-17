<tr id="itemDemographicWalletReference-<?= $model->id; ?>">
    <td class="txt_center"><?= ($model->idRelationshipType0 != NULL)? $model->idRelationshipType0->name : '-'; ?></td>
    <td class="txt_center"><?= $model->name; ?></td>
    <td class="txt_center"><?= ($model->idCity0 != null) ? $model->fullDistrict: '-'; ?></td>
    <td class="txt_center"><?= $model->phone; ?></td>
    <td class="txt_center"><?= $model->address; ?></td>
    <td class="txt_center"><?= $model->email; ?></td>
    <td class="txt_center descrip"><p><?= $model->comment; ?></p></td>
    <td class="txt_center descrip"><p><?= $model->state; ?></p></td>
    <td class="txt_center icon_table">
        <?php if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){ ?>
        <a href="#new_referencia_modal" 
           class="inline padding tooltipped editReference modal_clic" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar"
           data-id="<?= $model->id; ?>"
           data-idDebtor="<?= $model->idDebtor; ?>"
           data-name="<?= $model->name; ?>"
           data-address="<?= $model->address; ?>"
           data-phone="<?= $model->phone; ?>"
           data-email="<?= $model->email; ?>"
           data-comment="<?= $model->comment; ?>"
           data-idTypeReference="<?= $model->idTypeReference; ?>"
           data-idRelationshipType="<?= $model->idRelationshipType; ?>"
           data-idCountry="<?= $model->idCountry; ?>"
           data-idDepartment="<?= $model->idDepartment; ?>"
           data-idCity="<?= ($model->idCity != null) ? $model->idCity : ''; ?>"
           data-active="<?= $model->active; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php } ?>
        <!--<a href="#" class="inline padding tooltipped delete deleteItemDemographicWallet" idDemographic="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
    </td>
</tr>
