<?php

class ActionController extends GxController {

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
		$model = new Action;
		$this->performAjaxValidation($model, 'action-form');
		if (isset($_POST['Action'])) {
			$model->setAttributes($_POST['Action']);
			$relatedData = array(
				'effects' => $_POST['Action']['effects'] === '' ? null : $_POST['Action']['effects'],
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
		$model = $this->loadModel($id, 'Action');
		$this->performAjaxValidation($model, 'action-form');
		if (isset($_POST['Action'])) {
			$model->setAttributes($_POST['Action']);
			$relatedData = array(
				'effects' => $_POST['Action']['effects'] === '' ? null : $_POST['Action']['effects'],
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
                    $this->loadModel($id, 'Action')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new Action('search');
		$model->unsetAttributes();
		if (isset($_GET['Action'])){
			$model->setAttributes($_GET['Action']);
                }
		$this->render('admin', array('model' => $model));
	}

}