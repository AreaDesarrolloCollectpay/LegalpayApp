<?php

class CmsController extends CController {

    public $menu = array();
    public $breadcrumbs = array();

    public function init() {
        parent::init();
        Yii::app()->errorHandler->errorAction = 'cms/error';
    }

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'expression' => 'Controller::validateAccess(array(),"",true)',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

}

?>