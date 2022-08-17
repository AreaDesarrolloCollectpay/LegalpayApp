<?php

class CallcenterController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public $access;
    public $pSize;
    
    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->theeFront; //set theme default front
        $this->layout = 'layout_secure';
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        $this->access = array(1,2,5,11);
        $this->pSize = 10;
    }
    
    //=============================================================================================    
    public function filters() {
        $this->setLanguageApp();
        return array(
            array(
                'application.filters.html.ECompressHtmlFilter',
                'gzip' => true,
                'doStripNewlines' => false,
                'actions' => '*'
            ),
        );
    }

    //=============================================================================================
    public function actionIndex(){
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            if(Yii::app()->user->getState('rol') == 1 || Yii::app()->user->getState('rol') == 11){
                $this->redirect(array('/users/coordinators/1'));
            }else{
                $this->redirect(array('/users/advisers/0'));
            }
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    public function actionAttend() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
                
                $filters = array('idProfile', 'name', 'userName', 'numberDocument');
                $criteria = new CDbCriteria();
                $criteria->select = 't.id as id, t.profile as profile,t.idCompany, t.company,  t.name as name, t.userName, SUM(vd.capital) as capital, t.active as active';
                $join = ' JOIN tbl_users tu ON t.id = tu.id LEFT JOIN tbl_campaigns_coordinators cc ON t.id = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
                $condition = '';
                
                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                           $condition .= (($key != 'idProfile'))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                }
                
                if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
//                    $condition .= ($condition != '') ? ' AND ' : '';
//                    $condition .= 'is_internal = '.$_REQUEST['id'];                    
                }
                
                $join .= ($join != '') ? ' AND ' : '';
                $join .= 'vd.idState NOT IN (SELECT id FROM tbl_debtors_state WHERE historic = 1)';
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "name";
                $criteria->group = 't.id';
                
                $count = ViewCoordinators::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = ViewCoordinators::model()->findAll($criteria);
                
                $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
                $coodinators = UsersProfile::model()->findAll(array('condition' =>'active = 1 AND id IN ('.implode(',', Yii::app()->params['coordinators']).')' , 'order' => 'name ASC'));
                $typeDocument = TypeDocuments::model()->findAll();
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/users/partials/content-users-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'users'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{                
                    $this->render('attend',array(
                        'model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'countries' =>  $countries,
                        'coodinators'  =>  $coodinators,
                        'active' => 1,
                        'typeDocument'    => $typeDocument,
                        'id' => (isset($_REQUEST['id']))? $_REQUEST['id'] : 1,
                        //'total'  => $total
                            ));
                }
            }else{
                $this->redirect(array('/users/advisers/1'));
            }
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionUnattended() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
                
                $filters = array('idProfile', 'name', 'userName', 'numberDocument');
                $criteria = new CDbCriteria();
                $criteria->select = 't.id as id, t.profile as profile,t.idCompany, t.company,  t.name as name, t.userName, SUM(vd.capital) as capital, t.active as active';
                $join = ' JOIN tbl_users tu ON t.id = tu.id LEFT JOIN tbl_campaigns_coordinators cc ON t.id = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
                $condition = '';
                
                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                           $condition .= (($key != 'idProfile'))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                }
                
                if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
//                    $condition .= ($condition != '') ? ' AND ' : '';
//                    $condition .= 'is_internal = '.$_REQUEST['id'];                    
                }
                
                $join .= ($join != '') ? ' AND ' : '';
                $join .= 'vd.idState NOT IN (SELECT id FROM tbl_debtors_state WHERE historic = 1)';
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "name";
                $criteria->group = 't.id';
                
                $count = ViewCoordinators::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = ViewCoordinators::model()->findAll($criteria);
                
                $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
                $coodinators = UsersProfile::model()->findAll(array('condition' =>'active = 1 AND id IN ('.implode(',', Yii::app()->params['coordinators']).')' , 'order' => 'name ASC'));
                $typeDocument = TypeDocuments::model()->findAll();
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/users/partials/content-users-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'users'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{                
                    $this->render('unattended',array(
                        'model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'countries' =>  $countries,
                        'coodinators'  =>  $coodinators,
                        'active' => 2,
                        'typeDocument'    => $typeDocument,
                        'id' => (isset($_REQUEST['id']))? $_REQUEST['id'] : 1,
                        //'total'  => $total
                            ));
                }
            }else{
                $this->redirect(array('/users/advisers/1'));
            }
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionDistribution() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
                
                $filters = array('idProfile', 'name', 'userName', 'numberDocument');
                $criteria = new CDbCriteria();
                $criteria->select = 't.id as id, t.profile as profile,t.idCompany, t.company,  t.name as name, t.userName, SUM(vd.capital) as capital, t.active as active';
                $join = ' JOIN tbl_users tu ON t.id = tu.id LEFT JOIN tbl_campaigns_coordinators cc ON t.id = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
                $condition = '';
                
                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                           $condition .= (($key != 'idProfile'))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                }
                
                if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
//                    $condition .= ($condition != '') ? ' AND ' : '';
//                    $condition .= 'is_internal = '.$_REQUEST['id'];                    
                }
                
                $join .= ($join != '') ? ' AND ' : '';
                $join .= 'vd.idState NOT IN (SELECT id FROM tbl_debtors_state WHERE historic = 1)';
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "name";
                $criteria->group = 't.id';
                
                $count = ViewCoordinators::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = ViewCoordinators::model()->findAll($criteria);
                
                $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
                $coodinators = UsersProfile::model()->findAll(array('condition' =>'active = 1 AND id IN ('.implode(',', Yii::app()->params['coordinators']).')' , 'order' => 'name ASC'));
                $typeDocument = TypeDocuments::model()->findAll();
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/users/partials/content-users-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'users'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{                
                    $this->render('distribution',array(
                        'model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'countries' =>  $countries,
                        'coodinators'  =>  $coodinators,
                        'active' => 3,
                        'typeDocument'    => $typeDocument,
                        'id' => (isset($_REQUEST['id']))? $_REQUEST['id'] : 1,
                        //'total'  => $total
                            ));
                }
            }else{
                $this->redirect(array('/users/advisers/1'));
            }
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionRealtime() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
                
                $filters = array('idProfile', 'name', 'userName', 'numberDocument');
                $criteria = new CDbCriteria();
                $criteria->select = 't.id as id, t.profile as profile,t.idCompany, t.company,  t.name as name, t.userName, SUM(vd.capital) as capital, t.active as active';
                $join = ' JOIN tbl_users tu ON t.id = tu.id LEFT JOIN tbl_campaigns_coordinators cc ON t.id = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
                $condition = '';
                
                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                           $condition .= (($key != 'idProfile'))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                }
                
                if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
//                    $condition .= ($condition != '') ? ' AND ' : '';
//                    $condition .= 'is_internal = '.$_REQUEST['id'];                    
                }
                
                $join .= ($join != '') ? ' AND ' : '';
                $join .= 'vd.idState NOT IN (SELECT id FROM tbl_debtors_state WHERE historic = 1)';
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "name";
                $criteria->group = 't.id';
                
                $count = ViewCoordinators::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = ViewCoordinators::model()->findAll($criteria);
                
                $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
                $coodinators = UsersProfile::model()->findAll(array('condition' =>'active = 1 AND id IN ('.implode(',', Yii::app()->params['coordinators']).')' , 'order' => 'name ASC'));
                $typeDocument = TypeDocuments::model()->findAll();
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/users/partials/content-users-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'users'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{                
                    $this->render('realtime',array(
                        'model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'countries' =>  $countries,
                        'coodinators'  =>  $coodinators,
                        'active' => 4,
                        'typeDocument'    => $typeDocument,
                        'id' => (isset($_REQUEST['id']))? $_REQUEST['id'] : 1,
                        //'total'  => $total
                            ));
                }
            }else{
                $this->redirect(array('/users/advisers/1'));
            }
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    
}
