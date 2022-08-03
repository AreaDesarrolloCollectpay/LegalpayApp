<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->userName; ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->capital); ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->interest); ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->payments); ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->estimated); ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->pending); ?></td>
    <td class="txt_center icon_table">                                  
        <a href="#new_coordinators_modal" data-id="<?= $model->id; ?>" data-element="users-" class="inline padding tooltipped editUsers modal_clic" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Editar'); ?>"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/users/coordinators/supports/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Documentos'); ?>"><i class="fa fa-archive" aria-hidden="true"></i></a> 
        <a href="#" data-id="<?= $model->id; ?>" data-state="<?php echo($model->active == 1)? 0 : 1;  ?>" class="inline padding tooltipped <?php echo($model->active == 1)? 'delete' : 'success'  ?>  changeStateUsers" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', ($model->active == 1)? 'Inactivar' : 'Activar');  ?>"><i class="fa fa-<?php echo($model->active == 1)? 'times' : 'check'  ?>" aria-hidden="true"></i></a>
    </td>
</tr>

