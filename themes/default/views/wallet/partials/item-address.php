<tr id="itemDemographicWalletAddress-<?= $model->id; ?>">
    <td class = "txt_center"><?= ($model->idTypeReference0 != NULL)? $model->idTypeReference0->name : '-' ; ?></td>
    <td class="txt_center"><?= ($model->idCity0 != null) ? $model->fullDistrict : '-'; ?></td>
    <td class="txt_center"><p><?= $model->neighborhood; ?></p></td>
    <td class="txt_center"><?= $model->address; ?></td>
    <td class="txt_center descrip"><p><?= $model->comment; ?></p></td>
    <td class="txt_center descrip"><p><?= $model->state; ?></p></td>
    <td class="txt_center icon_table">
        <?php if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){ ?>
        <a href="#new_address_modal" 
           class="inline padding tooltipped editWalletAddress modal_clic btn-disabled" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar"
           data-id="<?= $model->id; ?>" 
           data-idDebtor="<?= $model->idDebtor; ?>" 
           data-idTypeReference="<?= $model->idTypeReference; ?>"
           data-idCountry="<?= $model->idCountry; ?>"
           data-idCity="<?= $model->idCity; ?>"
           data-idDepartment="<?= $model->idDepartment; ?>"
           data-neighborhood="<?= $model->neighborhood; ?>"
           data-address="<?= $model->address; ?>"
           data-comment="<?= $model->comment; ?>"
           data-active="<?= $model->active; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
        <?php } ?>
        <!--<a href="#" class="inline padding tooltipped delete deleteItemDemographicWallet" idDemographic="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
    </td>
</tr>

