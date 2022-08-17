<tr id="itemPayments-<?= $model->id; ?>">
    <td onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class = "txt_center"><?= $model->customer; ?></td>
    <td onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class = "txt_center"><?= $model->name; ?></td>
    <td onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class = "txt_center"><?= $model->code; ?></td>
    <td onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class = "txt_center"><?= $model->city; ?></td>
    <td onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class = "txt_center"><?= $model->address; ?></td>
    <td onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class = "txt_center"><?= $model->number; ?></td>
    <td onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $model->idDebtor; ?>';" class = "txt_center"><?= nl2br($model->comments); ?></td>    
</tr>

