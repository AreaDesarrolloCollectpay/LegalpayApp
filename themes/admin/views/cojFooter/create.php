<?php
$this->pageTitle = Yii::t('app', 'Crear') . ' ' . GxHtml::encode($model->label()) ;

$this->menu = array(
	array('label'=>'<i class="fa fa-th"></i> '.Yii::t('app', 'Administrar') . ' ' . $model->label(2), 'url' => array('admin')),
);
$this->renderPartial('_form', array('model' => $model));