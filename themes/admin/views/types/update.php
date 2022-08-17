<?php
$this->pageTitle = Yii::t('app', 'Editar') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)) ;
$this->menu = array(
	array('label' =>'<i class="fa fa-plus"></i> ' . Yii::t('app', 'Crear') . ' ' . $model->label(), 'url'=>array('create')),
	array('label' =>'<i class="fa fa-th"></i> ' . Yii::t('app', 'Administrar') . ' ' . $model->label(2), 'url'=>array('admin')),
        array('label'=>'<i class="fa fa-trash-o"></i> '. Yii::t('app', 'Eliminar') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->idType), 'confirm'=>Yii::t('app', 'Seguro que desea borrar este elemento?'))),
);
$this->renderPartial('_form', array('model' => $model));
?>