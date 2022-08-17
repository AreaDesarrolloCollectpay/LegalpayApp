<?php

class ApiController extends CController {

    public $menu = array();
    public $breadcrumbs = array();

    public function init() {
        parent::init();
        Yii::app()->errorHandler->errorAction = 'default/error';
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