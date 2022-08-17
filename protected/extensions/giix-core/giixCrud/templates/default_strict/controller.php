<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass; ?> {

<?php 
	$authpath = 'ext.giix-core.giixCrud.templates.default.auth.';
	Yii::app()->controller->renderPartial($authpath . $this->authtype);
?>


	public function actionIndex() {
		$model = <?php echo $this->modelClass; ?>::model()->find();
<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidation($model, '<?php echo $this->class2id($this->modelClass)?>-form');
<?php endif; ?>
		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->setAttributes($_POST['<?php echo $this->modelClass; ?>']);
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			$relatedData = <?php echo $this->generateGetPostRelatedData($this->modelClass, 4); ?>;
<?php endif; ?>
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			if ($model->saveWithRelated($relatedData)) {
<?php else: ?>
			if ($model->save()) {
<?php endif; ?>
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('index'));
			}
		}
                if($model != null){
                    $this->render('index', array( 'model' => $model));
                }else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

}