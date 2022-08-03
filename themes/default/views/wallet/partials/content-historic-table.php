<?php
foreach ($model as $value) {
    $lastManagement = Controller::lastManagement($value->date, $value->id);
    $othersValues = Controller::othersValues($value->id);
    ?>
    <tr>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/historic/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->customer; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/historic/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->name; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/historic/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->code; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/historic/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->city; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/historic/debtor/<?php echo $value->id; ?>';" class="txt_center">$<?php echo number_format($value->capital, 0, ',', '.'); ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/historic/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->state; ?></td>                          
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/historic/debtor/<?php echo $value->id; ?>';" class="txt_center <?php echo $lastManagement['color']; ?>-text"><?php echo $lastManagement['date']; ?></td>                          
    </tr>
<?php } ?>