<?php
foreach ($model as $value) {
    $lastManagement = Controller::lastManagement($value->date, $value->id);
    $othersValues = Controller::othersValues($value->id);
    $mlModelD = Controller::getModelCluster($modelML, $clusterML, $value->id);
    ?>
    <tr>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center hide-adviser">
            <div class="txt_center">                                                
                <img src="<?php echo $lastManagement['alliance']['image']; ?>" style="max-width: 30px; margin: auto;" />
            </div>
        </td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->customer; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->name; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->code; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->city; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center">$<?php echo number_format($value->capital, 0, ',', '.'); ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']->interest)) ? $othersValues['model']->interest : 0), 0, ',', '.'); ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center">$<?php echo number_format(((isset($othersValues['model']->interest_arrears)) ? $othersValues['model']->interest_arrears : 0), 0, ',', '.'); ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center hide-ml"><?php echo $mlModelD['model']; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center hide-ml"><?php echo $mlModelD['cluster']; ?></td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center hide-ml"><?php echo $mlModelD['percent']; ?> %</td>
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $othersValues['ageDebt']; ?></td>                          
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center"><?php echo $value->state; ?></td>                          
        <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->id; ?>';" class="txt_center <?php echo $lastManagement['color']; ?>-text"><?php echo $lastManagement['date']; ?></td>                          
    </tr>
<?php } ?>
