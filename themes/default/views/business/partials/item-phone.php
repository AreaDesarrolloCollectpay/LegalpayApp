<tr id="itemDemographicUserPhone-<?= $model->id; ?>">
    <td class="txt_center"><?= ($model->idTypeReference != NULL)? $model->idTypeReference0->name : '-'; ?></td>
    <td class="txt_center"><?= ($model->idPhoneClass != NULL)? $model->idPhoneClass0->name : '-'; ?></td>
    <!--<td class="txt_center"><?= ($model->idCity != NULL)? $model->fullDistrict : '-'; ?></td>-->
    <td class="txt_center"><?= $model->number; ?></td>
    <td class="txt_center descrip"><p><?= $model->comment; ?></p></td>
    <td class="txt_center descrip"><p><?= $model->state; ?></p></td>
    <td class="txt_center icon_table">
        <?php if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){ ?>
        <a href="#new_phone_modal" 
           class="inline padding tooltipped editUserPhone modal_clic btn-disabled" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Editar" 
           data-id="<?= $model->id; ?>" 
           data-idUser="<?= $model->idUser; ?>" 
           data-idTypeReference="<?= $model->idTypeReference; ?>"
           data-idPhoneClass="<?= $model->idPhoneClass; ?>"
           data-comment="<?= $model->comment; ?>"
           data-idCountry="<?= $model->idCountry; ?>"
           data-idDepartment="<?= $model->idDepartment; ?>"
           data-idCity="<?= $model->idCity; ?>"
           data-number="<?= $model->number; ?>"
           data-active="<?= $model->active; ?>"
           ><i class="fa fa-pencil-alt" aria-hidden="true"></i>
        </a>
        <?php } ?>
        <?php if($model->idPhoneClass != 3 && in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers'],Yii::app()->params['admin']))){ ?>            
        <a href="#" 
           class="inline padding tooltipped open_phone click_to_call" 
           data-position="top" 
           data-delay="50" 
           data-tooltip="Llamar"  
           data-number="<?= $model->number; ?>"
           data-indicative="<?= $model->getIndicative(); ?>"
           ><i class="fa fa-phone" aria-hidden="true"></i>
        </a>        
        <?php } ?>
        <!--<a href="#" class="inline padding tooltipped delete deleteItemDemographicWallet" idDemographic="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
    </td>
</tr>