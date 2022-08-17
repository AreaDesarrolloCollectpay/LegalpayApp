<?php

class UsersController extends Controller {

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
        $this->access = array(1,2,5,11,7);
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
    public function actionCoordinators() {
                
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
                    $this->render('users',array(
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

    public function actionExportFilterCoordinators() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_coordinators_" . Date('d_m_Y_h_i_s') . ".csv";


            $filters = array('idProfile', 'name', 'userName', 'numberDocument');
                $criteria = new CDbCriteria();
                $criteria->select = 't.id as id, t.profile as profile, t.name as name, t.userName, SUM(vd.capital) as capital, SUM(vd.interest) as interest, SUM(vd.payments) as payments, SUM(vd.agreement) as estimated, SUM(vd.balance) as pending';
                $join = 'JOIN tbl_campaigns_coordinators cc ON t.id = cc.idCoordinator JOIN tbl_campaigns c ON cc.idCampaign = c.id JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
                $condition = '';


                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

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
                
                if(isset($_GET['id']) && $_GET['id'] != ''){
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'is_internal = '.$_GET['id'];                    
                }

                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'vd.idState NOT IN (SELECT id FROM tbl_debtors_state WHERE historic = 1)';

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';


            $sql = 'SELECT 
                       \'Nombre / Razon Social\',\'CC / NIT \',\'Email\',\'Telefono\',\'Direccion\',
                       \'Capital\',\'Intereses\',\'Recaudado\',\'Estimado\',\'Pendiente\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(t.name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(t.numberDocument , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(t.email , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.phone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.address , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(capital,\'.\',\',\'),
                       REPLACE(interest,\'.\',\',\'),
                       REPLACE(payments,\'.\',\',\'),
                       REPLACE(agreement,\'.\',\',\'),
                       REPLACE(balance,\'.\',\',\')
                       FROM view_coordinators t
                       '.$join.'
                       ' . $condition . '
                       GROUP BY t.id
                       INTO OUTFILE \'' . $root . $filename . '\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'';

            $connection->createCommand($sql)->execute();
            //.... other SQL executions
            $transaction->commit();

            if (file_exists($root . $filename)) {
                $return['status'] = 'success';
                $return['file'] = $filename;
                $return['msg'] = Yii::t('front', 'download !.');
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $return['msg'] = $e->getMessage();
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionInvestor() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
                
                $filters = array('idProfile', 'name', 'userName', 'numberDocument');
                $criteria = new CDbCriteria();
//                $criteriaT = new CDbCriteria();
                $criteria->select = 't.id as id, t.name as name, SUM(vd.capital) as capital, SUM(vd.interest) as interest, SUM(vd.payments) as payments, SUM(vd.agreement) as estimated, SUM(vd.balance) as pending, t.active as active';
//                $criteriaT->select = 'SUM(vd.capital) as capital, SUM(vd.interest) as interest, SUM(vd.payments) as payments, SUM(vd.agreement) as estimated, SUM(vd.balance) as pending';
                $join = 'LEFT JOIN tbl_campaigns_coordinators cc ON t.id = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
                $condition = '';


                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

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
                
                if(isset($_GET['id']) && $_GET['id'] != ''){
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'is_internal = '.$_GET['id'];                    
                }
                
                $join .= ($join != '') ? ' AND ' : '';
                $join .= 'vd.idState NOT IN (SELECT id FROM tbl_debtors_state WHERE historic = 1)';
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "name";
                $criteria->group = 't.id';
                
//                $criteriaT->condition = $condition;
//                $criteriaT->join = $join;
                
                //$total = ViewCoordinators::model()->find($criteriaT);           

                $count = ViewInvestor::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = 20;
                $pages->applyLimit($criteria);

                $model = ViewInvestor::model()->findAll($criteria);

                $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
                $coodinators = UsersProfile::model()->findAll(array('condition' =>'active = 1 AND id IN ('.implode(',', Yii::app()->params['coordinators']).')' , 'order' => 'name ASC'));
                $typeDocument = TypeDocuments::model()->findAll();
                
                $this->render('investors',array(
                    'model' => $model,
                    'pages' => $pages,
                    'countries' =>  $countries,
                    'coodinators'  =>  $coodinators,
                    'active' => 1,
                    'typeDocument'    => $typeDocument,
                    'id' => (isset($_GET['id']))? $_GET['id'] : 1,
                    //'total'  => $total
                        ));
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    

    //=============================================================================================
    public function actionAdvisers() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            $filters = array('nameCoordinator', 'idCoordinator','idProfile', 'name', 'userName', 'numberDocument');

            $criteria = new CDbCriteria();
            $criteria->select = 't.id as id, t.nameCoordinator as nameCoordinator, t.idCompany, company, t.profile as profile, t.name as name, t.userName, SUM(vd.capital) as capital, 0 as interest, 0 as payments, 0 as estimated, 0 as pending, t.active as active';
            $join = 'JOIN tbl_users tu ON t.id = tu.id LEFT JOIN tbl_campaigns_coordinators cc ON t.idCoordinator = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
            $condition = '';
            $conditionC = '';
            $joinC = 'JOIN tbl_users tu ON t.id = tu.id';

            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {

                    if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                       $condition .= (($key != 'idProfile' && $key != 'idState' ))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }
            
            if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators']))) {                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' t.idCoordinator = '. Yii::app()->user->getId();
            }
            
             if(Yii::app()->user->getState('rol') == 11) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                $conditionC .= ($conditionC != '') ? ' AND ' : '';
                $conditionC .= 'tu.idCompany = ' . Yii::app()->user->getId();
            }
            
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
//                $condition .= ($condition != '') ? ' AND ' : '';
//                $condition .= 'is_internal = ' . $_REQUEST['id'];                
            }

            $criteria->condition = $condition;
            $criteria->join = $join;
            $criteria->order = "name";
            $criteria->group = 't.id';
           
            $count = ViewAdvisers::model()->count($criteria);      
            
            $pages = new CPagination($count);

            $pages->pageSize = 20;
            $pages->applyLimit($criteria);
            
            $model = ViewAdvisers::model()->findAll($criteria);
                        
            $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
	    
	    $advisers  = UsersProfile::model()->findAll(array('condition' =>'active = 1 AND id IN ('.implode(',', Yii::app()->params['advisers']).')' , 'order' => 'name ASC'));
            
            $criteriaC = new CDbCriteria();
            $criteriaC->select = 't.*';
	    
	    $criteriaC->condition = $conditionC;
            $criteriaC->join = $joinC;
             
            $coordinators = ViewCoordinators::model()->findAll($criteriaC);
            
            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;
            $typeProcess = TypeProcess::model()->findAll(array('condition' => 't.active = 1 '));
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                $return['table'] = $this->renderPartial('/users/partials/content-advisers-table', array('model' => $model), true);
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'advisers'), true);
                echo CJSON::encode($return);
                Yii::app()->end();
            }else{
                $this->render('advisers',array(
                    'model' => $model,
                    'pages' => $pages,
                    'currentPage' => $currentPage,
                    'countries' =>  $countries,
                    'advisers' => $advisers,
                    'coordinators' => $coordinators,                
                    'active' => 2,
                    'typeProcess' => $typeProcess,
                    'id' => (isset($_REQUEST['id']))? $_REQUEST['id'] : 1,
                        ));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================
    public function actionDependent() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            $filters = array('nameCoordinator', 'idCoordinator','idProfile', 'name', 'userName', 'numberDocument');

            $criteria = new CDbCriteria();
            $criteria->select = 't.id as id, t.nameCoordinator as nameCoordinator, t.idCompany, company, t.profile as profile, t.name as name, t.userName, SUM(vd.capital) as capital, 0 as interest, 0 as payments, 0 as estimated, 0 as pending, t.active as active';
            $join = 'JOIN tbl_users tu ON t.id = tu.id LEFT JOIN tbl_campaigns_coordinators cc ON t.idCoordinator = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
            $condition = '';
            $conditionC = '';
            $joinC = 'JOIN tbl_users tu ON t.id = tu.id';

            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {

                    if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                       $condition .= (($key != 'idProfile' && $key != 'idState' ))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }
            
            if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators']))) {                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' t.idCoordinator = '. Yii::app()->user->getId();
            }
            
             if(Yii::app()->user->getState('rol') == 11) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                $conditionC .= ($conditionC != '') ? ' AND ' : '';
                $conditionC .= 'tu.idCompany = ' . Yii::app()->user->getId();
            }
            
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
//                $condition .= ($condition != '') ? ' AND ' : '';
//                $condition .= 'is_internal = ' . $_REQUEST['id'];                
            }

            $criteria->condition = $condition;
            $criteria->join = $join;
            $criteria->order = "name";
            $criteria->group = 't.id';
           
            $count = ViewDependents::model()->count($criteria);      
            
            $pages = new CPagination($count);

            $pages->pageSize = 20;
            $pages->applyLimit($criteria);
            
            $model = ViewDependents::model()->findAll($criteria);
                        
            $countries  = Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
            $advisers  = UsersProfile::model()->findAll(array('condition' =>'active = 1 AND id IN ('.implode(',', Yii::app()->params['advisers']).')' , 'order' => 'name ASC'));
            
            $criteriaC = new CDbCriteria();
            $criteriaC->select = 't.*';
            $criteriaC->condition = $conditionC;
            $criteriaC->join = $joinC;
            
            $coordinators = ViewCoordinators::model()->findAll($criteriaC);
            
            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
            
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                $return['table'] = $this->renderPartial('/users/partials/content-advisers-table', array('model' => $model), true);
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'advisers'), true);
                echo CJSON::encode($return);
                Yii::app()->end();
            }else{
                $this->render('dependents',array(
                    'model' => $model,
                    'pages' => $pages,
                    'currentPage' => $currentPage,
                    'countries' =>  $countries,
                    'advisers' => $advisers,
                    'coordinators' => $coordinators,                
                    'active' => 3,
                    'id' => (isset($_REQUEST['id']))? $_REQUEST['id'] : 1,
                        ));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================

    public function actionExportFilterAdvisers() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_advisers_" . Date('d_m_Y_h_i_s') . ".csv";

            $filters = array('nameCoordinator','idProfile', 'name', 'userName' , 'numberDocument');

            $criteria = new CDbCriteria();
            $criteria->select = 't.id as id, t.nameCoordinator as nameCoordinator, t.profile as profile, t.name as name, t.userName, SUM(vd.capital) as capital, SUM(vd.interest) as interest, SUM(vd.payments) as payments, SUM(vd.agreement) as estimated, SUM(vd.balance) as pending';
            $join = 'LEFT JOIN tbl_campaigns_coordinators cc ON t.idCoordinator = cc.idCoordinator LEFT JOIN tbl_campaigns c ON cc.idCampaign = c.id LEFT JOIN tbl_campaigns_debtors cd ON c.id = cd.idCampaigns LEFT JOIN view_debtors vd ON cd.idDebtor = vd.idDebtor';
            $condition = '';


            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idProfile' && $key != 'idState' ))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'is_internal = ' . $_GET['id'];
            }

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';


            $sql = 'SELECT 
                       \'Nombre / Razon Social\',\'CC / NIT \',\'Email\',\'Telefono\',\'Direccion\',
                       \'Capital\',\'Intereses\',\'Recaudado\',\'Estimado\',\'Pendiente\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(t.name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(t.numberDocument , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(t.email , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.phone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.address , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(capital,\'.\',\',\'),
                       REPLACE(interest,\'.\',\',\'),
                       REPLACE(payments,\'.\',\',\'),
                       REPLACE(agreement,\'.\',\',\'),
                       REPLACE(balance,\'.\',\',\')
                       FROM view_advisers t
                       '.$join.'
                       ' . $condition . '
                       GROUP BY t.id
                       INTO OUTFILE \'' . $root . $filename . '\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'';

            $connection->createCommand($sql)->execute();
            //.... other SQL executions
            $transaction->commit();

            if (file_exists($root . $filename)) {
                $return['status'] = 'success';
                $return['file'] = $filename;
                $return['msg'] = Yii::t('front', 'download !.');
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $return['msg'] = $e->getMessage();
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionBusiness() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
            
                $filters = array('idProfile', 'name', 'userName', 'numberDocument');

                $criteria = new CDbCriteria();
                $criteria->select = 't.id as id, t.name as name, t.numberDocument as numberDocument, t.userName, SUM(tub.value) as value, t.active as active';
                $join = 'LEFT JOIN tbl_users_business tub ON t.id = tub.idBusinessAdvisor';
                $condition = '';


                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

                        if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                           $condition .= (($key != 'idProfile' && $key != 'idState' ))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }

                if (isset($_GET['id']) && $_GET['id'] != '') {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'is_internal = ' . $_GET['id'];
                }

                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "name";
                $criteria->group = 't.id';

    //            $criteriaT->condition = $condition;
    //            $criteriaT->join = $join;

                $count = ViewBusinessAdvisor::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = 20;
                $pages->applyLimit($criteria);

                $model = ViewBusinessAdvisor::model()->findAll($criteria);

                $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC'));             

                $this->render('business',array(
                    'model' => $model,
                    'pages' => $pages,
                    'countries' =>  $countries,
                    'active' => 3,
                    'id' => (isset($_GET['id']))? $_GET['id'] : 1,
                        ));
            }else{
                    $this->redirect(array('/users/advisers/1'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
            
    }
    
    //=============================================================================================

    public function actionExportFilterBusiness() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_business_" . Date('d_m_Y_h_i_s') . ".csv";

            $filters = array('idProfile', 'name', 'userName', 'numberDocument');

            $criteria = new CDbCriteria();
            $criteria->select = 't.id as id, t.name as name, t.userName, SUM(tub.value) as value';
            $join = 'LEFT JOIN tbl_users_business tub ON t.id = tub.idBusinessAdvisor';
            $condition = '';


            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                       $condition .= (($key != 'idProfile' && $key != 'idState' ))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'is_internal = ' . $_GET['id'];
            }

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';


            $sql = 'SELECT 
                       \'Nombre / Razon Social\',\'CC / NIT \',\'Email\',\'Telefono\',\'Direccion\',
                       \'Protafolio\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(t.name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(t.numberDocument , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(t.email , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.phone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.address , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(value,\'.\',\',\')
                       FROM view_business_advisor t
                       '.$join.'
                       ' . $condition . '
                       GROUP BY t.id
                       INTO OUTFILE \'' . $root . $filename . '\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'';

            $connection->createCommand($sql)->execute();
            //.... other SQL executions
            $transaction->commit();

            if (file_exists($root . $filename)) {
                $return['status'] = 'success';
                $return['file'] = $filename;
                $return['msg'] = Yii::t('front', 'download !.');
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $return['msg'] = $e->getMessage();
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    public function actionUpdateUsers() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST)) {

                if(isset($_POST['id']) && $_POST['id'] != ''){
                    $model = Users::model()->findByPk($_POST['id']);
                    $return['newRecord'] = false;                    
                }else{
                   $model = new Users; 
                }

                $model->setAttributes($_POST);
                $model->setScenario('Users');               
                
                if (in_array($model->idUserProfile, Yii::app()->params['advisers'])) {
                    $model->setScenario('Advisers');
                }
                
                if($return['newRecord']){
                    $password = Controller::creaPassword();
                    $model->password = md5($password);
                    $model->image = Yii::app()->theme->baseUrl.'/assets/img/user/user.png';
                    $model->idUserCreator = Yii::app()->user->getId();
                }

                //$model->support = (CUploadedFile::getInstanceByName('support') != '')? CUploadedFile::getInstanceByName('support') : $model->support;
                    //var_dump($_POST);
                if ($model->validate()) {

                    $model->save(false);
                    
                    if($return['newRecord']){
                        $profile = new UsersProfiles;
                        $profile->idUser = $model->id;
                        $profile->idUserProfile = $model->idUserProfile;
                        $profile->is_internal = $model->is_internal;
                        
                        if($profile->save()){
                            
                            if(in_array($model->idUserProfile, Yii::app()->params['advisers']) && $model->idTypeProcess != ''){
                                $adviser = new CoordinatorAdviser;
                                $adviser->idAdviser = $model->id;
                                $adviser->idCoordinator = 12;
                                if($adviser->save()){
                                    $return['status'] = 'success';
                                    $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                                    $return['model'] = $model;                            
                                    //sendMail
                                    //var_dump($model);
                                    $htmlEmail = $this->renderPartial('/email/mail-create-user', array('model' => $model, 'password' => $password), true);
                                    $subject = Yii::t('front','Nueva Cuenta Asesor');
                                    Controller::SendGridMail($model->email,$model->name, $subject, $htmlEmail);
                                }else{
                                    $return['msg'] = Yii::t('front', 'Error asigando coordinador !. ');
                                    foreach ($adviser->getErrors() as $error) {
                                        $return['msg'] .= $error[0] . "<br/>";
                                    }
                                    $model->delete();
                                    $profile->delete();
                                }
                            }else{
                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                                $return['model'] = $model;                            
                                //sendMail
                                $htmlEmail = $this->renderPartial('/email/mail-create-user', array('model' => $model, 'password' => $password), true);
                                $subject = Yii::t('front','Nueva Cuenta Coordinador');
                                Controller::SendGridMail($model->email, $model->name, $subject, $htmlEmail);
                            }
                            
                        }else{
                            $return['msg'] = Yii::t('front', 'Error asigando perfil !. ');
                            foreach ($profile->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                            $model->delete();
                        }
                        
                    }else{
                        $profile = UsersProfiles::model()->find(array('condition' => 'idUser = '.$model->id));
                        if($profile != null){
                            $profile->idUserProfile = $_POST['idUserProfile'];
                            if($profile->save()){
                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Registro editado exitosamente !.');
                                $return['model'] = $model;
                            }else{
                                $return['msg'] = Yii::t('front', 'Error editando perfil !. ');
                                foreach ($profile->getErrors() as $error) {
                                    $return['msg'] .= $error[0] . "<br/>";
                                }
                            }
                        }else{
                            $return['msg'] = Yii::t('front', 'Error editando perfil !.');
                        }                        
                    }
                                        
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    Yii::log("Error Pagos", "error", "actionSave");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionUpdateCoordinators() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST)) {

                $model = new Customers; 
                $model->setAttributes($_POST);
                $model->support_bank = (CUploadedFile::getInstanceByName('support_bank') != '')? CUploadedFile::getInstanceByName('support_bank') : $model->support_bank;
                $model->interests = 0;
                $model->fee = 0;
                $model->commission = 0;
                                  
                if ($model->validate()) {
                    
                    if((isset($_POST['id']) && $_POST['id'] != '')){
                        $customers = Users::model()->findByPk($_POST['id']);
                        $return['newRecord'] = false;    
                    }else{
                        $customers = new Users;
                    }
                    
                    $customers->setAttributes($_POST);
                    $customers->interests = 0;
                    $customers->fee = 0;
                    $customers->commission = 0;

                    if($return['newRecord']){
                        $password = Controller::creaPassword();
                        $customers->password = md5($password);
                        $customers->image = Yii::app()->theme->baseUrl.'/assets/img/user/user-male-icon.png';
                        $customers->active = 1;
                        $customers->idUserCreator = Yii::app()->user->getId();
                    }
                    
                    //$model->image = (CUploadedFile::getInstanceByName('image') != '')? CUploadedFile::getInstanceByName('image') : $model->image;

                    
                    if($customers->validate()){
                        $customers->save(false);
                        if($return['newRecord']){
                            $profile = new UsersProfiles;
                            $profile->idUser = $customers->id;
                            $profile->idUserProfile = $model->idUserProfile;

                            if($profile->save()){
                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                                $return['model'] = $model;                            
                                
                                //sendMail
                                $htmlEmail = $this->renderPartial('/email/mail-create-user', array('model' => $model, 'password' => $password), true);
                                $subject = Yii::t('front','Nueva Cuenta');
                                Controller::SendGridMail($model->email,$model->name, $subject, $htmlEmail);                                

                            }else{
                                $return['msg'] = Yii::t('front', 'Error asigando perfil !. ');
                                foreach ($profile->getErrors() as $error) {
                                    $return['msg'] .= $error[0] . "<br/>";
                                }
                                $customers->delete();
                            }

                        }else{
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                            $return['model'] = $customers;  
                        }
                        
                        $customerInfo = UsersInfo::model()->find(array('condition' => 'idUser ='.$customers->id));
                        if($customerInfo == null){
                            $customerInfo = new UsersInfo;                                    
                        }

                        $customerInfo->setAttributes($_POST);
                        $customerInfo->idUser = $customers->id;
                        
                        $customerInfo->support_bank = (CUploadedFile::getInstanceByName('support_bank') != '')? CUploadedFile::getInstanceByName('support_bank') : $customerInfo->support_bank;

                        if(!$customerInfo->save()){
                            
                            $return['msg'] = Yii::t('front', 'Error asigando información !. ');
                            foreach ($customerInfo->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                        }else{
                            if(CUploadedFile::getInstanceByName('support_bank') != ''){
                                $upload = Controller::uploadFile($customerInfo->support_bank,'users',$customers->id,'/uploads/');
                                $customerInfo->support_bank = ($upload)? $upload['filename']:  $customerInfo->support_bank;   
                                if(!$customerInfo->save(false)){
                                    print_r($customerInfo->getErrors());
                                    exit;
                                }
                            }
                        }
                        
                    }else{
                        $return['status'] = 'error';
                        $return['msg'] = '';
                        Yii::log("Error Pagos", "error", "actionSave");
                        foreach ($customers->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }
                                        
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    Yii::log("Error Pagos", "error", "actionSave");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
    
    //=============================================================================================
    public function actionGetUsers() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {

                $model = ViewUsers::model()->find(array('condition' => 'id ='.$_POST['id']));
                
                if($model != null){
                    $info = Users::model()->find(array('condition' => 'id ='.$_POST['id']));
                    $location  = ViewLocation::model()->find(array('condition' => 'idCity ='.$info->idCity));
                    $return['status'] = 'success';
                    $return['model'] = $model;                    
                    $return['info'] = $info;                    
                    $return['location'] = $location;                    
                }else{
                    $return['msg'] = Yii::t('front', 'Error usuario noe encontrado !. ');
                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    //=============================================================================================
    public function actionGetAdvisersCoordinator() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
        
        if (!Yii::app()->user->isGuest && Yii::app()->user->getState('rol') == 1) {

            if (isset($_POST['id']) && $_POST['id'] != '') {             

                $model = ViewUsers::model()->findAll(array('condition' => 'idCoordinator ='.$_POST['id']));
                 
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                
                foreach ($model as $value){
                    $return['html'] .= $this->renderPartial('/users/partials/item-adviser-modal', array('model' => $value), true);                                                
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionChangeStateUser() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id'],$_POST['state']) && $_POST['id'] != '' && $_POST['state'] != '') {

                $model = Users::model()->findByPk($_POST['id']);
                
                if($model != null){
                    $model->active = $_POST['state'];
                    
                    if($model->save(false)){
                        $return['status'] = 'success';
                        $return['msg'] = Yii::t('front', 'Registro editado exitosamente !.');
                        $return['model'] = $model;
                    }else{
                        $return['status'] = 'error';
                        $return['msg'] = '';
                        Yii::log("Error Pagos", "error", "actionSave");
                        foreach ($model->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }
                }else{
                    $return['msg'] = Yii::t('front', 'Error usuario no encontrado !. ');
                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
     //=============================================================================================
    public function actionSupports() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access) && (isset($_GET['id']) && $_GET['id'] != '')) {
            $user = ViewUsers::model()->find(array('condition' => 'id = '.$_GET['id'].' AND idProfile IN (2,5,17)'));
            
            if($user != NULL){              
                $criteria = new CDbCriteria();
                $condition = '';            
                if (isset($_GET)) {       
                    $id = $user->id;
                    $condition = "idUser = ".$id;
                    if(isset($_GET['TypeDocument']) && is_numeric($_GET['TypeDocument'])){
                        $type = $_GET['TypeDocument'];
                        $condition .= " AND idTypeUsersDocuments = ".$type;
                    }
                }       
                $criteria->condition = $condition;
                $criteria->order = "dateCreated DESC";
                $count = UsersDocuments::model()->count($criteria);           
                $pages = new CPagination($count);
                $pages->pageSize = 20;
                $pages->applyLimit($criteria);
                $model = UsersDocuments::model()->findAll($criteria);
                $typeDocuments = TypeUsersDocuments::model()->findAll(array("condition" => "active = 1"));   
                $urlFilter = Yii::app()->request->requestUri;
                $url = Yii::app()->getBaseUrl();
                if (!strpos($urlFilter, $url) !== false) {
                    $url = str_replace($url, "", $urlFilter);
                    $url = substr($url, 1);
                    $url = parse_url($url);
                    $url = $url['path'];
                }else{
                    $url = substr($urlFilter,1);
                }
                
                $this->render('/users/documents',array(
                    'model' => $model,
                    'typeDocuments' => $typeDocuments,
                    'pages' => $pages,
                    'idUser' => $id,
                    'url' => $url
                ));        
            }else{
                throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
            }           
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    public function actionUpdateSupports() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersDocuments::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new UsersDocuments();
            }

            $model->setAttributes($_POST);
            $model->idUser = $_POST['idUser'];
            $model->idUserCreated = Yii::app()->user->getId();
            $model->file = (CUploadedFile::getInstanceByName('support') != '') ? CUploadedFile::getInstanceByName('support') : $model->file;
            
            if ($model->save()) {

                $file = CUploadedFile::getInstanceByName('support');
                if ($file != '') {
                    Yii::import('application.google.google.*');
                    require_once("protected/google/autoload.php");

                    $configuration = array(
                        'login' => 'cojunal@cojunal-148320.iam.gserviceaccount.com',
                        'key' => file_get_contents('assets/cojunal-5498ea4f2a1c.p12'),
                        'scope' => 'https://www.googleapis.com/auth/devstorage.full_control',
                        'project' => 'cojunal-148320',
                        'storage' => array(
                            'url' => 'https://storage.googleapis.com/',
                            'prefix' => ''),
                    );
                    $bucket = 'cojunal-148320.appspot.com';
                    Yii::log("GOOGLE => " . sys_get_temp_dir(), "warning", "create");

                    //Upload del archivo
                    $fname = @Controller::slugUrl($model->id . '-' . Date('d_m_Y_h_i_s')) . "." . $file->getExtensionName();

                    $file->saveAs(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                    //Subir archivo a bucket
                    $credentials = new Google_Auth_AssertionCredentials($configuration['login'], $configuration['scope'], $configuration['key']);
                    $client = new Google_Client();
                    $client->setAssertionCredentials($credentials);
                    if ($client->getAuth()->isAccessTokenExpired()) {
                        $client->getAuth()->refreshTokenWithAssertion();
                    }

                    # Starting Webmaster Tools Service
                    $storage = new Google_Service_Storage($client);

                    $uploadDir = 'uploads/';
                    $file_name = $model->idUser . "/" . $fname;
                    $obj = new Google_Service_Storage_StorageObject();
                    $obj->setName($file_name);
                    try {
                        $storage->objects->insert(
                                "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $fname), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
                        );
                        $model->file = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                        $model->save(false);
                    } catch (Exception $e) {
                        $return['status'] = 'error';
                        $return['msg'] = Yii::t('front', 'No se pudo guardar el soporte');
                    }

                    if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname)) {
                        unlink(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                    }
                }
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                //Yii::log("Error Gastos", "error", "actionSave");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
     //=============================================================================================
    public function actionGetSupports() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {

                $model = UsersDocuments::model()->findByPk($_POST['id']);
                if($model != null){
                    $return['status'] = 'success';
                    $return['model'] = $model;
                }else{
                    $return['msg'] = Yii::t('front', 'Error usuario no encontrado !. ');                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionLogSessions() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access) && (isset($_GET['id']) && $_GET['id'] != '')) {
                        
            $user = ViewUsers::model()->find(array('condition' => 'id = '.$_GET['id']));
            
            if($user != NULL){             
            
                $filters = array('from','to');

                $criteria = new CDbCriteria();
                $criteria->select = 't.id, t.idUser, t.ipAddress, t.userAgent, MAX(t.dateCreated) as dateCreated, vu.name as name';
                $join = 'JOIN view_users vu ON t.idUser = vu.id AND (vu.id = '.$_GET['id'].' OR vu.idCoordinator = '.$_GET['id'].' )';
                $condition = '';

                if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators']))) {                
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' t.idCoordinator = '. Yii::app()->user->getId();
                }

                
                
                if (isset($_GET['from']) && $_GET['from'] != '') {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                    $condition .= '(DATE_FORMAT(t.dateCreated,"%Y-%m-%d") BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
                }

                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "t.dateCreated DESC";
                $criteria->group = "DATE_FORMAT(t.dateCreated,'%Y-%m-%d')";

                $count = UsersSession::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = 20;
                $pages->applyLimit($criteria);

                $model = UsersSession::model()->findAll($criteria);

                $this->render('sessions',array(
                    'model' => $model,
                    'pages' => $pages,
                    'id' => (isset($_GET['id']))? $_GET['id'] : 1,
                        ));
            }else{
                throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
            } 
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================
    
    public function actionGetSessions() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'html' => '');
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id'],$_POST['date']) && $_POST['id'] != '' && $_POST['date'] != '') {
                $criteria = new CDbCriteria();
                $criteria->select = 't.id, t.idUser, t.ipAddress, t.userAgent, t.dateCreated, vu.name as name';
                $criteria->condition = 'DATE_FORMAT(t.dateCreated,"%Y-%m-%d") = "'.$_POST['date'].'"'; 
                $criteria->join = 'JOIN view_users vu ON t.idUser = vu.id AND (vu.id = '.$_POST['id'].' OR vu.idCoordinator = '.$_POST['id'].' )';
                $criteria->order = 't.id DESC';    
                
                $model = UsersSession::model()->findAll($criteria);
                if($model != null){
                    
                    foreach ($model as $data){
                        $return['html'] .= $this->renderPartial('/users/partials/item-session', array('model' => $data,'hide' => true),true);
                    }
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = Yii::t('front', 'Error información no encontrada !. ');                    
                }
            }else{
                $return['status'] = 'warning';
                $return['msg'] = Yii::t('front', 'Solicitud Invalida');                
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionExportSessions() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_sessions_" . Date('d_m_Y_h_i_s') . ".csv";

            $no_filters = array('page', 'from', 'to');

            $join = 'JOIN view_users vu ON t.idUser = vu.id AND (vu.id = '.$_GET['id'].' OR vu.idCoordinator = '.$_GET['id'].' )';
            $condition = '';

            if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators']))) {                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' t.idCoordinator = '. Yii::app()->user->getId();
            }

            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(DATE_FORMAT(t.dateCreated,"%Y-%m-%d") BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }


            $sql = 'SELECT 
                       \'USUARIO\',\'FECHA\',\'HORA\',\'IP\',\'DISPOSITIVO\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(vu.name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(DATE_FORMAT(t.dateCreated,"%Y-%m-%d") , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(DATE_FORMAT(t.dateCreated,"%H:%i:%s") , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.ipAddress , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(t.userAgent , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \')                                         
                       FROM tbl_users_session t
                       ' .$join. '
                       ' . $condition . '
                       INTO OUTFILE \'' . $root . $filename . '\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'';

            $connection->createCommand($sql)->execute();
            //.... other SQL executions
            $transaction->commit();

            if (file_exists($root . $filename)) {
                $return['status'] = 'success';
                $return['file'] = $filename;
                $return['msg'] = Yii::t('front', 'download !.');
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $return['msg'] = $e->getMessage();
        }
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionLicenses() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
                
            $filters = array('name', 'numberDocument', 'idPlan', 'users', 'active', 'capital');
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $join = '';
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

            $criteria->condition = $condition;
            $criteria->join = $join;
            $criteria->order = "name";
            $criteria->group = 't.id';

            $count = ViewLicenses::model()->count($criteria);           

            $pages = new CPagination($count);

            $pages->pageSize = $this->pSize;
            $pages->applyLimit($criteria);

            $model = ViewLicenses::model()->findAll($criteria);

            $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
            $typeDocument = TypeDocuments::model()->findAll();
            $plans = Plans::model()->findAll();
            $states     =   UsersState::model()->findAll(array('condition' => 'type = 1 AND active = 1' , 'order' => 'name ASC'));

            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  

            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                $return['table'] = $this->renderPartial('/users/partials/content-licenses-table', array('model' => $model), true);
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                echo CJSON::encode($return);
                Yii::app()->end();
            }else{                
                $this->render('licences',array(
                    'model' => $model,
                    'pages' => $pages,
                    'currentPage' => $currentPage,
                    'states' => $states,
                    'plans' => $plans,
                    'countries' =>  $countries,
                    'active' => 1,
                    'typeDocument'    => $typeDocument,
                    //'total'  => $total
                        ));
            }
        }else{
           throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
        }
    }
    
    //=============================================================================================
    public function actionInvoices() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
                
            $filters = array('number', 'idInvocieState', 'comments');
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $join = '';
            $condition = '';

            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {

                    if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                       $condition .= (($key != 'idInvocieState'))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            
            if(isset($_REQUEST['date_expedition']) && $_REQUEST['date_expedition'] != ''){
                $date = Controller::CleanFilterDate($_REQUEST['date_expedition']);
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.date_expedition';
                if((int)$date['count'] > 1){                        
                    $condition .= ' BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                }else{  
                    $condition .= ' = "'.$date['date'][0].'"' ;                     
                }  
            }
                        
            if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idUser ='.$_REQUEST['id'];
            }
            
            if(isset($_REQUEST['date_expiration']) && $_REQUEST['date_expiration'] != ''){
                $date = Controller::CleanFilterDate($_REQUEST['date_expiration']);
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.date_expiration';
                if((int)$date['count'] > 1){                        
                    $condition .= ' BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                }else{  
                    $condition .= ' = "'.$date['date'][0].'"' ;                     
                }  
            }
            
            if(isset($_REQUEST['date_pay']) && $_REQUEST['date_pay'] != ''){
                $date = Controller::CleanFilterDate($_REQUEST['date_pay']);
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.date_pay';
                if((int)$date['count'] > 1){                        
                    $condition .= ' BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                }else{  
                    $condition .= ' = "'.$date['date'][0].'"' ;                     
                }  
            }

            $criteria->condition = $condition;
            $criteria->join = $join;
            $criteria->order = "t.date_expedition DESC";

            $count = UsersInvoices::model()->count($criteria);           

            $pages = new CPagination($count);

            $pages->pageSize = $this->pSize;
            $pages->applyLimit($criteria);

            $model = UsersInvoices::model()->findAll($criteria);

            $states     = InvoicesState::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC'));
            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  

            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                $return['table'] = $this->renderPartial('/users/partials/content-invoices-table', array('model' => $model), true);
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'invoices'), true);
                echo CJSON::encode($return);
                Yii::app()->end();
            }else{                
                $this->render('invoices',array(
                    'model' => $model,
                    'pages' => $pages,
                    'currentPage' => $currentPage,
                    'states' => $states,
                    'id' => (isset($_REQUEST['id']))? $_REQUEST['id'] : 0,
                        ));
            }
        }else{
           throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
        }
    }
    
    //=============================================================================================
    public function actionUpdateInvoices() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
            if (isset($_REQUEST) && $user != null) {
                
                if((isset($_REQUEST['id']) && $_REQUEST['id'] != '')){
                    $model = UsersInvoices::model()->findByPk($_REQUEST['id']);
                    $return['newRecord'] = false;    
                }else{
                    $model = new UsersInvoices; 
                }
                $model->setAttributes($_REQUEST);
                $model->date_expedition = $model->date_expiration;
                $model->file = (CUploadedFile::getInstanceByName('file') != '')? CUploadedFile::getInstanceByName('file') : $model->file;
                $model->support_pay = (CUploadedFile::getInstanceByName('support_pay') != '')? CUploadedFile::getInstanceByName('support_pay') : $model->support_pay;
                
                if ($model->save()) {
                    
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Registro Exitoso!');
                    
                    if(CUploadedFile::getInstanceByName('file') != ''){
                        $upload = Controller::uploadFile($model->file,'invoices',$model->id,'/uploads/');
                        $model->file = ($upload)? $upload['filename']:  $model->file;   
                        if(!$model->save(false)){
                            Yii::log("Error Pagos", "error", "actionSave");
                            foreach ($customers->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                        }
                    }
                    
                    if(CUploadedFile::getInstanceByName('support_pay') != ''){
                        $upload = Controller::uploadFile($model->support_pay,'invoices',$model->id,'/uploads/');
                        $model->support_pay = ($upload)? $upload['filename']:  $model->support_pay;   
                        if(!$model->save(false)){
                            Yii::log("Error Pagos", "error", "actionSave");
                            foreach ($customers->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                        }
                    }
                        
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    Yii::log("Error Pagos", "error", "actionSave");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
        
    //=============================================================================================
    public function actionGetInvoice() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '');
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersInvoices::model()->findByPk($_POST['id']);
                if($model != null){
                    $return['status'] = 'success';
                    $return['model'] = $model;
                }else{
                    $return['msg'] = Yii::t('front', 'Error factura no encontrada !. ');                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }
        echo CJSON::encode($return);
    }
    
}
