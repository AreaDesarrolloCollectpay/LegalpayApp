<?php

class DefaultController extends Controller {

    public function filters() {
        Yii::app()->getComponent("booster");
        return array(
            'accessControl',
            array(
                'application.filters.html.ECompressHtmlFilter',
                'gzip' => true,
                'doStripNewlines' => true,
                'actions' => '*'
            ),
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'error'),
                'users' => array('*'),
            ),
            array('allow',
                'expression' => 'Controller::validateAccess(array(),"",true)',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
