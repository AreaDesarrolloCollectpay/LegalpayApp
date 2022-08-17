<?php

class AuthAssignmentController extends GxController {

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
		$model = new AuthAssignment;
		$this->performAjaxValidation($model, 'auth-assignment-form');
		if (isset($_POST['AuthAssignment'])) {
			$model->setAttributes($_POST['AuthAssignment']);
			if ($model->save()) {
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
		$model = $this->loadModel($id, 'AuthAssignment');
		$this->performAjaxValidation($model, 'auth-assignment-form');
		if (isset($_POST['AuthAssignment'])) {
			$model->setAttributes($_POST['AuthAssignment']);
			if ($model->save()) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'AuthAssignment')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new AuthAssignment('search');
		$model->unsetAttributes();
		if (isset($_GET['AuthAssignment'])){
			$model->setAttributes($_GET['AuthAssignment']);
                }
		$this->render('admin', array('model' => $model));
	}

}