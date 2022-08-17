<?php

class CmsConfiguracionController extends GxController {

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
                'expression' => 'Controller::validateAccess()',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $model = CmsConfiguracion::model()->find();
        $password = $model->password;
        $model->password = "";
        if (isset($_POST['CmsConfiguracion'])) {
            $model->setAttributes($_POST['CmsConfiguracion']);
            if ($model->password == "") {
                $model->password = $password;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                $this->redirect(array('index'));
            }
        }
        if ($model != null) {
            $this->render('index', array('model' => $model));
        } else {
            throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
        }
    }

    public function actionPrevisualizaPlantilla() {
        $this->renderPartial('plantilla', array(
            'model' => $model = CmsConfiguracion::model()->find(),
        ));
    }

}
