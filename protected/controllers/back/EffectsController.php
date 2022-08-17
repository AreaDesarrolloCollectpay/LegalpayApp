<?php

class EffectsController extends GxController {

        public $defaultAction = 'admin';

        public function filters() {
            Yii::app()->getComponent('booster');
            return array(
                'accessControl', 
            );
        }

        public function accessRules() {
            return array(
                array('allow',
                        'expression'=>'Controller::validateAccess()',
                        ),
                array('deny', 
                        'users'=>array('*'),
                        ),
            );
        }
        

	public function actionCreate() {
		$model = new Effects;
		$this->performAjaxValidation($model, 'effects-form');
		if (isset($_POST['Effects'])) {
			$model->setAttributes($_POST['Effects']);
			$relatedData = array(
				'actions' => $_POST['Effects']['actions'] === '' ? null : $_POST['Effects']['actions'],
				);
			if ($model->saveWithRelated($relatedData)) {
                            if (Yii::app()->getRequest()->getIsAjaxRequest()){
                                Yii::app()->end();
                            }else{
                                Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                                $this->redirect(array('admin'));
                            }
			}
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Effects');
		$this->performAjaxValidation($model, 'effects-form');
		if (isset($_POST['Effects'])) {
			$model->setAttributes($_POST['Effects']);
			$relatedData = array(
				'actions' => $_POST['Effects']['actions'] === '' ? null : $_POST['Effects']['actions'],
				);
			if ($model->saveWithRelated($relatedData)) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'Effects')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new Effects('search');
		$model->unsetAttributes();
		if (isset($_GET['Effects'])){
			$model->setAttributes($_GET['Effects']);
                }
		$this->render('admin', array('model' => $model));
	}

}