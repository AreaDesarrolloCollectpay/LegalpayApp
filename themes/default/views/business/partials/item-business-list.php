<?php
$lastManagement = Controller::lastManagementBusiness($value->idUser);
?>
<tr>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/business/detail/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->name; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/business/detail/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->numberDocument; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/business/detail/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->city; ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/business/detail/<?php echo $value->id; ?>';" class="txt_center">$<?php echo number_format($value->value, 0, ',', '.'); ?></td>
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/business/detail/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->state; ?></td>                          
    <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/business/detail/<?php echo $value->id; ?>';" class="txt_center <?php echo $lastManagement['color']; ?>-text"><?php echo $lastManagement['date']; ?></td>                          
</tr>