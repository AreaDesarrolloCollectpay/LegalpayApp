<?php
echo "<?php\n";
?>
$this->pageTitle = Yii::t('app', 'Editar') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)) ;
$this->menu = array(

);
$this->renderPartial('_form', array('model' => $model));
?>