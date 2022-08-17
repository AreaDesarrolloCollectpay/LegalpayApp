<?php
$lastManagement = Controller::lastManagementBusiness($model->id);
$user = ViewUsers::model()->find(array("condition" => "id = ".$model->idBusinessAdvisor));
$model->comercial = ($user != null) ? $user->name : "";
?>
<li class="ui-state-default border_<?php if($model->ageBusiness < 30){ if($model->ageBusiness <= 0){echo 'red'; }else{ echo 'orange'; } }else{echo 'green';} ?>" data-id="<?php echo $model->id; ?>" <?php echo $model->ageBusiness; ?>>
    <a href="<?php echo Yii::app()->baseUrl . '/business/detail/' . $model->id; ?>">
    	<div class="circle"></div>
        <h4><?php echo mb_strtoupper(substr($model->name, 0, 20)); ?></h4>
        <h4><?php echo 'CC / NIT '; ?> : <?php echo $model->numberDocument; ?></h4>
        <h4><?php echo Yii::t('front', 'Valor'); ?>: $ <?php echo number_format($model->value, 0, ',', '.'); ?></h4>
        <span><?php echo Yii::t('front', 'Ejecutivo'); ?>: <?php echo $model->comercial; ?></span>
        <span><?php echo Yii::t('front', 'Cierre'); ?>: <?php echo Yii::app()->dateFormatter->format('dd/MM/yyyy', $model->date_close); ?></span>
        <span class="<?php echo $lastManagement['color']; ?>-text"><?php echo Yii::t('front', 'Última Gestión'); ?>: <?php echo $model->date; ?></span>
        <i class="feather feather-list waves-button waves-effect waves-light"></i>
    </a>
</li>