<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->profile; ?></td>
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->userName; ?></td>
    <td class = "txt_center"><?= $model->email; ?></td>
    <td class = "txt_center"><?= $model->location; ?></td>
    <td class = "txt_center"><?= $model->phone; ?></td>
    <td class = "txt_center"><?= $model->address; ?></td>
    <td class = "txt_center"><?= $model->state; ?></td>
    <td class="txt_center icon_table">                                  
        <a href="#new_users_modal" data-id="<?= $model->id; ?>" data-element="users-" class="inline padding tooltipped editUsers modal_clic" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Editar'); ?>"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a> 
        <a href="#new_adviser_modal" data-id="<?= $model->id; ?>" class="inline padding tooltipped getAdvisers modal_clic" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Asesores'); ?>"><i class="fa fa-users" aria-hidden="true"></i></a> 
        <a href="#" data-id="<?= $model->id; ?>" data-state="<?php echo($model->active == 1)? 2 : 1;  ?>" class="inline padding tooltipped <?php echo($model->active == 1)? 'delete' : 'success'  ?>  changeStateUsers" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', ($model->active == 1)? 'Inactivar' : 'Activar');  ?>"><i class="fa fa-<?php echo($model->active == 1)? 'times' : 'check'  ?>" aria-hidden="true"></i></a>
    </td>
</tr>

