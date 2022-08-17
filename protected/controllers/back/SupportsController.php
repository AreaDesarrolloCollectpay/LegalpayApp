<?php

class SupportsController extends GxController {

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
		$model = new Supports;
        $date = new Datetime();
		$this->performAjaxValidation($model, 'frmSupports');
		if (isset($_POST['Supports'])) {

            $model->setAttributes($_POST['Supports']);
            //Upload del archivo
            $file=CUploadedFile::getInstance($model, 'fileP');

            $model->fileType = $file->getExtensionName();
            $model->dCreation = $date->format('Y-m-d H:i:s');

            $file->saveAs(Yii::getPathOfAlias("webroot")."/uploads/".$model->fileName.".".$file->getExtensionName());
			
			if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest()){
                    Yii::app()->end();                    
                }else{
                    //Subir archivo a bucket
                    Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                    $this->redirect(array('admin'));
                }
			}
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Supports');
		$this->performAjaxValidation($model, 'supports-form');
		if (isset($_POST['Supports'])) {
			$model->setAttributes($_POST['Supports']);
			if ($model->save()) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'Supports')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new Supports('search');
		$model->unsetAttributes();
		if (isset($_GET['Supports'])){
			$model->setAttributes($_GET['Supports']);
                }
		$this->render('admin', array('model' => $model));
	}

}