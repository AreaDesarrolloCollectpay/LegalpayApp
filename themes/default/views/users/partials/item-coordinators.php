<?php
$last_session = Controller::getLastSessionUser($model->id); 
?>
<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->company; ?></td>
    <td class = "txt_center"><?= $model->profile; ?></td>
    <td class = "txt_center"><?= $model->name; ?></td>
    <!--<td class = "txt_center"><?= $model->userName; ?></td>-->
    <!--<td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->capital); ?></td>-->
    <td class = "txt_center"><?= $last_session['last_session']; ?></td>
<!--    <td class = "txt_center">$<?= Yii::app()->format->formatNumber(0); ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber(0); ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber(0); ?></td>
    <td class = "txt_center">$<?= Yii::app()->format->formatNumber(0); ?></td>-->
    <td class="txt_center icon_table">                                  
        <a href="#new_coordinators_modal" data-id="<?= $model->id; ?>" data-element="users-" class="inline padding tooltipped editUsers modal_clic" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Editar'); ?>"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a> 
        <a href="#new_adviser_modal" data-id="<?= $model->id; ?>" class="inline padding tooltipped getAdvisers modal_clic" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Asesores'); ?>"><i class="fa fa-users" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/users/coordinators/supports/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Documentos'); ?>"><i class="fa fa-archive" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/users/coordinators/contacts/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Contactos'); ?>"><i class="fa fa-book-open" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/users/logSessions/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ingresos'); ?>"><i class="fas fa-sign-in-alt" aria-hidden="true"></i></a> 
        <a href="#" data-id="<?= $model->id; ?>" data-state="<?php echo($model->active == 1)? 0 : 1;  ?>" class="inline padding tooltipped <?php echo($model->active == 1)? 'delete' : 'success'  ?>  changeStateUsers" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', ($model->active == 1)? 'Inactivar' : 'Activar');  ?>"><i class="fa fa-<?php echo($model->active == 1)? 'times' : 'check'  ?>" aria-hidden="true"></i></a>
    </td>
</tr>

