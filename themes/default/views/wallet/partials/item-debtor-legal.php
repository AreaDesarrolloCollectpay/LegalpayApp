<?php 
$lastManagement = Controller::lastManagement($model->date,$model->idDebtor);
$legal = DebtorsDebts::model()->findByPk($model->id);
$tasks = Controller::getTasksDebtor($model->id);
?>
<li class="ui-state-default border_<?php if($model->dayDebt > 0){ if($model->dayDebt > 30){echo 'red'; }else{ echo 'orange'; } }else{echo 'green';} ?>" data-id="<?php echo $model->id; ?>" <?php echo $model->ageDebt; ?>>    
    <a href="<?php echo Yii::app()->baseUrl . '/wallet/debtor/' . $model->id; ?>">
        <div class="circle"></div>
<!--        <a class="tooltipped" data-position="top" data-delay="50" style="right: 5px;width: 25px;height: 25px;line-height: 25px;position: absolute;">
            <i class="fas fa-balance-scale waves-button waves-effect waves-light"></i>            
        </a>-->
        <h4><?php echo mb_strtoupper(substr($model->name, 0, 20)); ?></h4>
        <h4><?php echo 'CC / NIT '; ?> : <?php echo $model->code; ?></h4>
        <span><?php echo Yii::t('front', 'Radicado'); ?>: <?php echo ($legal != null && $legal->settledNumber != null)? substr($legal->settledNumber, 0, 15) : ''; ?></span>
        <span><?php echo Yii::t('front', 'Tipo Proceso'); ?>: <?php echo ($legal != null && $legal->idTypeProcess0 != null)? $legal->idTypeProcess0->name : ''; ?></span>
        <span><?php echo Yii::t('front', 'Cliente'); ?>: <?php echo mb_strtoupper(substr($model->customer, 0, 20)); ?></span>
        <!--<h4><?php echo Yii::t('front', 'Capital'); ?>: $ <?php echo number_format($model->capital, 0, ',', '.'); ?></h4>-->
        <!--<span><?php echo Yii::t('front', 'Prescribe'); ?>: <?php echo Yii::app()->dateFormatter->format('dd/MM/yyyy', $model->prescription); ?></span>-->
        <span class="<?php echo $lastManagement['color']; ?>-text"><?php echo Yii::t('front', 'Última Gestión'); ?>: <?php echo $lastManagement['date']; ?></span>
        <?php if($tasks != 0){ ?>            
            <i class="feather feather-<?php echo ($tasks == 1)? 'list' : 'bell'; ?> waves-button waves-effect waves-light"></i>
        <?php } ?>
    </a>
</li>