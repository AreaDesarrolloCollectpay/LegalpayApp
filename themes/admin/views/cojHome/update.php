<?php
$this->pageTitle = Yii::t('app', 'Editar') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)) ;
$this->menu = array(
	array('label' =>'<i class="fa fa-th"></i> ' . Yii::t('app', 'Administrar') . ' ' . $model->label(2), 'url'=>array('admin')),
);
$this->renderPartial('_form', array('model' => $model));
?>