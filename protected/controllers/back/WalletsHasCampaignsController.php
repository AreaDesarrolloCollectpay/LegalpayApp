<?php

class WalletsHasCampaignsController extends GxController {

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
		$model = new WalletsHasCampaigns;
		$this->performAjaxValidation($model, 'wallets-has-campaigns-form');
		if (isset($_POST['WalletsHasCampaigns'])) {
			$model->setAttributes($_POST['WalletsHasCampaigns']);
            try{
                if ($model->save()) {
                    if (Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->end();
                    }else{
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                        $this->redirect(array('admin'));
                    }
                }
            }catch(Exception $e){
                Yii::log("No se puede guardar campañas para ese wallet, es probable que ya exista", "error", "WalletsHasCampaignsController->actionCreate");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se ha asociado el deudor con la campaña ya que ya se encuentra asignado a esta campaña"));
                        $this->redirect(array('admin'));
            }
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'WalletsHasCampaigns');
		$this->performAjaxValidation($model, 'wallets-has-campaigns-form');
		if (isset($_POST['WalletsHasCampaigns'])) {
			$model->setAttributes($_POST['WalletsHasCampaigns']);
			if ($model->save()) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'WalletsHasCampaigns')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new WalletsHasCampaigns('search');
		$model->unsetAttributes();
		if (isset($_GET['WalletsHasCampaigns'])){
			$model->setAttributes($_GET['WalletsHasCampaigns']);
                }
		$this->render('admin', array('model' => $model));
	}

}