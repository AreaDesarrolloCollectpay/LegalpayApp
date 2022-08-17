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
                    'actions'=>array('create', 'update', 'view', 'admin','delete'),
                    'expression'=>'Controller::validateAccess()',
                    ),
            array('deny', 
                    'users'=>array('*'),
                    ),
        );
}