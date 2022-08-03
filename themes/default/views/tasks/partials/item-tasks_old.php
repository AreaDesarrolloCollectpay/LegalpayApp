<?php $user = Users::model()->findByPk($model->idUserAsigned); ?>
<tr style="cursor:pointer" onClick="document.location.href = '<?php echo ($model->idUserAsigned == Yii::app()->user->getId()) ? $model->url : "#"; ?>';">
    <td class="txt_center"><?php echo $model->name; ?> <br><?php echo $model->numberDocument; ?></td>
    <td class="txt_center padding"><b><?php echo date("d/m/Y", strtotime($model->date)); ?></b></td>
    <td class="txt_center padding"><b><?php echo $model->actionName; ?></b> <br> <?php //echo $model->idDebtor0->idDebtor0->idDebtorsState0->name; ?></td>    
    <td class="txt_center padding"><b><?php echo ($user != null)? $user->name : ''; ?></b></td>
</tr>