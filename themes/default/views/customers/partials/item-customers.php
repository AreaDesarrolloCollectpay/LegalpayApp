<<<<<<< HEAD
<!-- <p><?= $model->idUserCreator ?></p> -->
<!-- <p><?= Yii::app()->user->getId() ?></p> -->
<?php
$currentUserId = Yii::app()->user->getId();
$currentIdUserCreator = $model->idUserCreator;
if($currentUserId == $currentIdUserCreator OR $currentUserId == 12) {
?>
=======
>>>>>>> 572b53cf67d6f4e50cbcc69eda943c6782081dcf
<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->numberDocument; ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->capital); ?></td>
<<<<<<< HEAD
    <td class = "txt_center"><?= ($model->active == 1)? 'ACTIVO' : 'INACTIVO';?></td>
    <td class="txt_center icon_table">                                  
        <a href="#new_customers_modal" data-id="<?= $model->id; ?>" data-element="customers-" class="inline padding tooltipped editCustomers modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>         
        <a href="<?php echo $this->createUrl('/customers/referrals/'.$model->id); ?>" class="inline padding tooltipped hide" data-position="top" data-delay="50" data-tooltip="Remisiones"><i class="feather feather-file" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/customers/supports/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Documentos'); ?>"><i class="fa fa-archive" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/customers/contacts/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Contactos'); ?>"><i class="fas fa-book-open" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/users/invoices/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Facturación"><i class="fas fa-file-invoice-dollar" aria-hidden="true"></i></a> 
        <a href="#" data-id="<?= $model->id; ?>" data-state="<?php echo($model->active == 1)? 2 : 1;  ?>" class="inline padding tooltipped <?php echo($model->active == 1)? 'delete' : 'success'  ?>  changeStateUsers" data-position="top" data-delay="50" data-tooltip="<?php echo($model->active == 1)? 'Inactivar' : 'Activar'  ?>"><i class="fa fa-<?php echo($model->active == 1)? 'times' : 'check'  ?>" aria-hidden="true"></i></a>
    </td>
</tr>
<?php
}
?>
<!-- <tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->numberDocument; ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->capital); ?></td>
   <td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->interest); ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->payments); ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->estimated); ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->pending); ?></td>
=======
<!--    <td class = "txt_center">$<?= Yii::app()->format->formatNumber($model->interest); ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->payments); ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->estimated); ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->pending); ?></td>-->
>>>>>>> 572b53cf67d6f4e50cbcc69eda943c6782081dcf
    <td class = "txt_center"><?= ($model->active == 1)? 'ACTIVO' : 'INACTIVO';?></td>
    <td class="txt_center icon_table">                                  
        <a href="#new_customers_modal" data-id="<?= $model->id; ?>" data-element="customers-" class="inline padding tooltipped editCustomers modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>         
        <a href="<?php echo $this->createUrl('/customers/referrals/'.$model->id); ?>" class="inline padding tooltipped hide" data-position="top" data-delay="50" data-tooltip="Remisiones"><i class="feather feather-file" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/customers/supports/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Documentos'); ?>"><i class="fa fa-archive" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/customers/contacts/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Contactos'); ?>"><i class="fas fa-book-open" aria-hidden="true"></i></a> 
        <a href="<?php echo $this->createUrl('/users/invoices/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Facturación"><i class="fas fa-file-invoice-dollar" aria-hidden="true"></i></a> 
        <a href="#" data-id="<?= $model->id; ?>" data-state="<?php echo($model->active == 1)? 2 : 1;  ?>" class="inline padding tooltipped <?php echo($model->active == 1)? 'delete' : 'success'  ?>  changeStateUsers" data-position="top" data-delay="50" data-tooltip="<?php echo($model->active == 1)? 'Inactivar' : 'Activar'  ?>"><i class="fa fa-<?php echo($model->active == 1)? 'times' : 'check'  ?>" aria-hidden="true"></i></a>
    </td>
<<<<<<< HEAD
</tr> -->
=======
</tr>
>>>>>>> 572b53cf67d6f4e50cbcc69eda943c6782081dcf

