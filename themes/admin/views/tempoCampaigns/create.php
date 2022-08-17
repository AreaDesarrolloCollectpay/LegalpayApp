<?php
if(!isset($model)){
	$model = new TempoCampaigns;
}
$this->pageTitle = Yii::t('app', 'Crear') . ' ' . GxHtml::encode($model->label()) ;


if(isset($lote)){
	$this->renderPartial('_form', array('model' => $model, 'lote'=>$lote, 'usersUpload'=>$usersUpload));
}else {
	$this->renderPartial('_form', array('model' => $model));	
}
