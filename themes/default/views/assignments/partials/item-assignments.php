<?php
$currentUserId = Yii::app()->user->getId();
$currentIdUserCreator = $model->id;
if($currentUserId == $currentIdUserCreator OR $currentUserId == 12) {
?>
<tr>
    <td class="txt_center" aja="aja"><?= $model->idCustomer0->name; ?></td> 
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->dateCreated)); ?></td> 
    <td class="txt_center"><?= $model->accounts; ?></td> 
    <td class="txt_center">$ <?= Yii::app()->format->formatNumber($model->capital); ?></td> 
    <td class="txt_center icon_table" width="16%">
	<a class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a> 
        <?php if ($model->file != '') { ?><a href="<?= $model->file; ?>" download class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>        
    </td>
</tr>
<?php
}
?>

<!-- <tr>
    <td class="txt_center"><?= $model->idCustomer0->name; ?></td> 
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->dateCreated)); ?></td> 
    <td class="txt_center"><?= $model->accounts; ?></td> 
    <td class="txt_center">$ <?= Yii::app()->format->formatNumber($model->capital); ?></td> 
    <td class="txt_center icon_table" width="16%">
        <a href="<?php //echo $this->createUrl('/assignments/detail/'.$model->id); ?>#" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver'); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>        
        <?php if ($model->file != '') { ?><a href="<?= $model->file; ?>" download class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Descargar'); ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>        
    </td>
</tr> -->
