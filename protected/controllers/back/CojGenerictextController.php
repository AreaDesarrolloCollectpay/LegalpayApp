<?php

class CojGenerictextController extends GxController {

        public $defaultAction = 'index';

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
        

	public function actionIndex($id) {
		$model = CojGenerictext::model()->findByPk($id);
		$this->performAjaxValidation($model, 'coj-generictext-form');
		if (isset($_POST['CojGenerictext'])) {
			$model->setAttributes($_POST['CojGenerictext']);
			if ($model->save()) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('cms/cojGenerictext/index/'.$id));
			}
		}
                if($model != null){
                    $this->render('index', array( 'model' => $model));
                }else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

}