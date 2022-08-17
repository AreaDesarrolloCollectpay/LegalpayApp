<?php

class MachineController extends Controller {

    public $access;
    public $pSize;

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->theeFront; //set theme default front
        $this->layout = 'layout_secure';
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        $this->access = array(1,2,11);
        $this->pSize = 1;
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
    public function actionIndex() {
        if (!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->user->getState('rol'), $this->access)) {
                 
                $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
                $criteria = new CDbCriteria();
                //$join = '';
                $condition = '';
                $filters = array('description', 'name');
                
                if(isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if ($value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'idState' && $key != 'idTypeDocument')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }                
                //$criteria->condition = 'id < 4 ';                                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCompany = ' . Yii::app()->user->getId();                    
                } elseif ((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))) {
                    if ($user != null)  {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 't.idCompany = ' . $user->idCompany; 
                    }
                }
                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.type = 1'; 
                
                
                $criteria->condition = $condition;
                $criteria->order = "dateCreated DESC";
                   
                $mlModels = Mlmodels::model()->findAll($criteria);
                $clustersSelect = (isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] != 0)? Clusters::model()->findAll(array('condition' => 'idMLModel ='.$_REQUEST['idMLModel'],'order' => 'name')) : array();
                $ageDebts = AgeDebt::model()->findAll(array('order' => 'name ASC'));
                
                $conditionS = 'historic = 0 AND active = 1 AND idDebtorsState IS NULL ';                
                $debtorState = DebtorsState::model()->findAll(array('condition' => $conditionS, 'order' => 'name ASC'));
                $modelML = (isset($_REQUEST['idMLModel']))? $_REQUEST['idMLModel'] : 1;
                
                $this->render('mlmodels', array('mlModels' => $mlModels, 
                    'clustersSelect' => $clustersSelect,
                    'ageDebts' => $ageDebts,
                    'debtorState' => $debtorState,
                    'modelML' => $modelML,
                    ));
                
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionGetChartClusters() {
        $return = array('status'  => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array());
        
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
            $criteria = new CDbCriteria();
            //$join = '';
            $condition = '';
            $filters = array('description', 'name');

            if(isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {

                    if ($value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idState' && $key != 'idTypeDocument')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }                
            
            if(Yii::app()->user->getState('rol') == 11) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCompany = ' . Yii::app()->user->getId();                    
            } elseif ((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))) {
                if ($user != null)  {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCompany = ' . $user->idCompany; 
                }
            }

            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 't.type = 1'; 

            $criteria->condition = $condition;

            $mlModels = Mlmodels::model()->findAll($criteria);
            
           
            
            foreach ($mlModels as $mlModel){

                $clusters = Clusters::model()->findAll(array('condition' => 'idMLModel = '.$mlModel->id));
                $data = array();
                
                foreach($clusters as $cluster){                    
                    $data[] = array('name' => $cluster->name, 'value' => rand(20,300),'other' => '', 'id' => $cluster->id);                    
                }
                
                $return ['data'][] = array('name' => $mlModel->name,'data' => $data);
                
            }
                        
        echo json_encode($return, JSON_NUMERIC_CHECK);
    }

    //=============================================================================================
    public function actionIndex_() {
        if (!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->user->getState('rol'), $this->access)) {
                 
                $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
                $criteria = new CDbCriteria();
                //$join = '';
                $condition = '';
                $filters = array('description', 'name');
                
                if(isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if ($value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'idState' && $key != 'idTypeDocument')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                //$criteria->condition = 'id < 4 ';
                                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCompany = ' . Yii::app()->user->getId();                    
                } elseif ((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))) {
                    if ($user != null)  {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 't.idCompany = ' . $user->idCompany; 
                    }
                }
                
                $criteria->condition = $condition;
                $criteria->order = "dateCreated DESC";
                
                $count = Mlmodels::model()->count($criteria);
                                
                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = Mlmodels::model()->findAll($criteria);
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 
        
                $this->render('mlmodels', array('model' => $model, 'count' => $count, 'pages' => $pages,'currentPage' => $currentPage,));
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionSaveMlModels_() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = Mlmodels::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new Mlmodels();
            }
            $model->setAttributes($_POST);

            if ($model->save()) {
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                $return['model'] = $model;                 
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Gastos", "error", "actionSave");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    public function actionGetMlModels() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '');
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {

                $model = Mlmodels::model()->findByPk($_POST['id']);
                
                if($model != null){
                    $return['status'] = 'success';
                    $return['model'] = $model;                         
                }else{
                    $return['msg'] = Yii::t('front', 'Error Modelo no encontrado !. ');                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionClusters() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access) && (isset($_GET['id']) && $_GET['id'] != '')) {
            $models = Mlmodels::model()->findByPk($_GET['id']);
            
            if($models != NULL){              
                $criteria = new CDbCriteria();
                $condition = '';            
               $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','agreement', 'idTypeDocument','idCreditModality');
                                
                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

                        if (($key != 'page' && $key != 'id' && $key != 'quadrant') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'idState' && $key != 'idTypeDocument')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition = 't.idMLModel = '.$_GET['id'];
                
                $criteria->condition = $condition;
                $criteria->order = "dateCreated DESC";
                $count = Clusters::model()->count($criteria);           
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);
                $model = Clusters::model()->findAll($criteria);
                
                $this->render('clusters',array(
                    'model' => $model,
                    'pages' => $pages,
                ));        
                
            }else{
                throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
            }          
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionModelsMl() {
        if (!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->user->getState('rol'), $this->access)) {
                
                $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
                
                //list customers
                $criteriaC = new CDbCriteria();
                $joinC = ' JOIN tbl_users tu ON t.id = tu.id';
                $conditionC = '';
                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                    
                    $conditionC .= ($conditionC != '') ? ' AND ' : '';
                    $conditionC .= 'tu.idCompany = ' . Yii::app()->user->getId();  
                }elseif((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))){
                    if($user != null){                        
                        $conditionC .= ($conditionC != '') ? ' AND ' : '';
                        $conditionC .= 'tu.idCompany = ' . $user->idCompany;                                        
                    }
                }
                                
                $conditionC .= ($conditionC != '') ? ' AND ' : '';
                $conditionC .= "t.active = 1";
                                                                
                $criteriaC->select = 't.id, t.name';
                $criteriaC->condition = $conditionC;
                $criteriaC->join = $joinC;
                $criteriaC->order = 'name ASC';
                                
                $customers = ViewCustomers::model()->findAll($criteriaC);
                $fields = MlmodelsFields::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    //$return['table'] = $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model), true);
                    //$return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                    $this->render('models_ml', array('customers' => $customers, 
                            'fields' => $fields
                            ));
                }
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionSaveMlModels() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '','file' => '');
        $root = Yii::getPathOfAlias('webroot');
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {
            
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
            
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
                $model = Mlmodels::model()->findByPk($_REQUEST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new Mlmodels();
            }
            
            $model->setAttributes($_REQUEST);
            $model->idCreator = Yii::app()->user->getId();
            $fields = substr($_REQUEST['fields'], 0, -1);
            $fields = explode(',', $fields);
            $model->fields = json_encode($fields);
            
            if(Yii::app()->user->getState('rol') == 11) {
                $model->idCompany = Yii::app()->user->getId();                    
            } elseif ((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))) {
                if ($user != null)  {
                    $model->idCompany = $user->idCompany; 
                }
            }
            
            if ($model->save()) {
            
                //$model = Mlmodels::model()->findByPk(7);
                $sql = MachineController::getQuerySource($model);
                
//                print_r($sql);
//                exit;
                
                if ($sql['status'] == 'success') {

                    set_time_limit(0);
                    $connection = Yii::app()->db;
                    $transaction = $connection->beginTransaction();

                    try {                        
                        $connection->createCommand($sql['query'])->execute();
                        //.... other SQL executions
                        $transaction->commit();

                        if (file_exists($root.$sql['file'])) {
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'CREANDO MODELO ...');
                            $return['model'] = $model;
                            $return['file'] = $sql['file'];
                            $model->file = $sql['file']; 
                            $model->save(false);
                        }else{
                            $return['status'] = 'error';
                            $return['msg'] = Yii::t('front', 'Error, archivo no encontrado'); 
                            $model->delete();                            
                        }
                    } catch (Exception $e) { // an exception is raised if a query fails
                        $transaction->rollback();
                        $return['msg'] = $e->getMessage();
                        $model->delete();
                    }
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = Yii::t('front', 'Error, exportando data'); 
                    $model->delete();
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }               
            }
        }        
        echo CJSON::encode($return);        
    }
    
    //=============================================================================================
    
     public function actionSaveMlCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '','file' => '');
        $root = Yii::getPathOfAlias('webroot');
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {            
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));            
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
                $model = Centroids::model()->findByPk($_REQUEST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new Centroids;
            }            
            $model->setAttributes($_REQUEST);
            $model->idCreator = Yii::app()->user->getId();
            
            if ($model->save()) {
            
                $sql = MachineController::getQuerySource($model->idMLModel0,$model,0);
                                
                if ($sql['status'] == 'success') {

                    set_time_limit(0);
                    $connection = Yii::app()->db;
                    $transaction = $connection->beginTransaction();

                    try {                        
                        $connection->createCommand($sql['query'])->execute();
                        //.... other SQL executions
                        $transaction->commit();

                        if (file_exists($root.$sql['file'])) {
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'CREANDO MODELO ...');
                            $return['model'] = $model;
                            $return['file'] = $sql['file'];
                            $model->file = $sql['file']; 
                            $model->save(false);
                        }else{
                            $return['status'] = 'error';
                            $return['msg'] = Yii::t('front', 'Error, archivo no encontrado'); 
                            $model->delete();                            
                        }
                    } catch (Exception $e) { // an exception is raised if a query fails
                        $transaction->rollback();
                        $return['msg'] = $e->getMessage();
                        $model->delete();
                    }
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = Yii::t('front', 'Error, exportando data'); 
                    $model->delete();
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }               
            }
        }        
        echo CJSON::encode($return);        
    }
    
    //=============================================================================================
    
    public static function GetQuerySource($model,$centroid = null,$type = 1) {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'query' => '', 'file' => '');
        $names  = '';
        $select = '';
        $file = '';
        
        if($model != null){
            $model = Mlmodels::model()->findByPk($model->id);            
            if($model != null){
                $names  .= '\'idDebtorObligation\',\'portfolioName\',';
                $slug = @Controller::slugUrl($model->name);
                $slug .= ($type == 1)? '_h' : '_a';
                $file = "/uploads/bigMl/" .$slug."_" . Date('d_m_Y_h_i_s') . ".csv";
                $select = 'tdo.id,\''.$slug.'\',';
                $fields = json_decode($model->fields);
                                
                foreach ($fields as $field){
                    $fModel = MlmodelsFields::model()->findByPk($field);                    
                    if($fModel != null){                        
                        $names .= '\''.$fModel->name_export.'\',';   
                            switch ($fModel->type) {
                                case 'num':
                                    $select .= 'REPLACE('.$fModel->db.',\'.\',\',\'),';  
                                    break;
                                case 'dated':
                                    $select .= 'REPLACE(REPLACE(REPLACE(ifnull(round(datediff('.$fModel->db.')/30),\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),';  
                                    break;
                                default:
                                    $select .= 'REPLACE(REPLACE(REPLACE(ifnull('.$fModel->db.',\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),';                          
                                    break;                                    
                            }
                    }
                } 
                
                $return['status'] = 'success';
                $return['msg'] = 'ok';
                $names = substr($names, 0, -1);
                $select = substr($select, 0, -1);
            }else{
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Modelo no encontrado');
            }
        }
        $condition = 'tdo.idDebtorsState is not null ';
        
        if($type == 0 && $centroid != null){
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= ' td.idCustomers ='.$centroid->idCustomer;
        }
        $root = Yii::getPathOfAlias('webroot');
        $query = 'SELECT '.$names.' UNION SELECT '.$select.' from tbl_debtors_obligations  tdo
                                join tbl_debtors td on tdo.idDebtor = td.id
                                join tbl_cities tc on td.idCity = tc.id
                                join tbl_departments tdep on tc.idDepartment = tdep.id
                                join tbl_regions tr on tdep.idRegion = tr.id
                                join tbl_debtors_state tds on tdo.idDebtorsState = tds.id AND tds.historic = '.$type.'
                                join view_debtors_check_demographics vdcd on td.id = vdcd.idDebtor
                                left join view_debtors_demographics vdd on tdo.idDebtor = vdd.idDebtor
                                left join view_debtors_check_properties vdcp on td.id = vdcp.idDebtor
                                where '.$condition.'
                               INTO OUTFILE \''.$root.$file.'\'
                               FIELDS TERMINATED BY \',\'
                               OPTIONALLY ENCLOSED BY \'"\'
                               LINES TERMINATED BY\'\n\'';
        
        $return['query'] = $query;
        $return['file'] = $file;
        
        return $return;
    }
    
    
    //=============================================================================================
    
     public function actionCreateSource() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'file' => '', 'source' => '', 'dataset' => '', 'prediction' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);      
            
            if ($model != null){  
                $slug = @Controller::slugUrl('source_cluster_'.$model->id.'_'.$model->name);
                $return = Controller::createSource($model->file,$slug);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'GENERANDO FUENTE DE DATOS ...');
                    //updateModel
                    $model->source = $return['source'];
                    $model->save(false);
                }
            } else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }

        echo CJSON::encode($return);
    }
        
    //=============================================================================================
    
    public function actionGetSource() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){    
                $return = Controller::getSource($model->source);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'OBTENIENDO FUENTE DE DATOS ...');               
                }
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
            
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionCreateDataset() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){   
                $slug = @Controller::slugUrl('dataset_cluster_'.$model->id.'_'.$model->name);
                $return = Controller::createDataset($model->source,$slug);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'GENERANDO CONJUNTO DE DATOS ...');
                        //updateModel
                    $model->dataset = $return['dataset'];
                    $model->save(false);
    //                    $return = Controller::createBatchPrediction();
                }
           }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
           }

        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetDataset() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {
            $model = Mlmodels::model()->findByPk($_REQUEST['id']); 
            if ($model != null){  
                $return = Controller::getDataset($model->source,$model->dataset);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', ' OBTENIENDO CONJUNTO DE DATOS ...');            
                }
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionCreateCluster() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){   
                $slug = @Controller::slugUrl('cluster_'.$model->id.'_'.$model->name);
                $return = Controller::createCluster($model->source,$model->dataset,$model->fields,$slug);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'GENERANDO GRUPOS ...');
                    //updateModel
                    $model->source = $return['source'];
                    $model->dataset = $return['dataset'];
                    $model->cluster = $return['cluster'];
                    $model->urlBigML = $return['cluster'];
                    $model->urlEmbedded = $return['cluster'];
                    $model->save(false);
    //                    $return = Controller::createBatchPrediction();
                }
           }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
           }

        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetCluster() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'cluster' => '', 'clusters' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){  
                $return = Controller::getCluster($model->source,$model->dataset,$model->cluster);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', ' OBTENIENDO GRUPOS ...'); 
                    if($return['status'] == 'success'){                        
                        
                        if($return['clusters'] != ''){
                            foreach ($return['clusters'] as $value){                           
                                $clusters = Clusters::model()->find(array('condition' => 'clusterCode = "'.$value->id.'"  AND idMLModel ='.$model->id));                            
                                if($clusters == null){                                
                                    $clusters = new Clusters;
                                    $clusters->idMLModel = $model->id;
                                }                            
                                $clusters->name = $value->name;
                                $clusters->clusterCode = $value->id;
                                $clusters->json_detail = json_encode($value);

                                if(!$clusters->save()){
                                   print_r($clusters->getErrors());
                                   exit;
                                   $return['status'] = 'error';
                                   $return['msg'] = Yii::t('front', 'Error, importando grupos');
                                   $model->delete();
                                   break;
                                }
                            } 
                        }                        
//                                print_r($return['fields']);
//                                exit;
                        if($return['fields'] != ''){
                            $fields = array();
                            foreach ($return['fields'] as $key => $value) {
                                $condition = 'name_export LIKE "%'.$value->name.'%"';                                
                                $field = MlmodelsFields::model()->find(array('condition' => $condition));                                
//                                echo '---';
                                if($field != NULL){
//                                    print_r($value->summary->missing_count);
//                                    exit;
                                    $fields[$key] = array('name' => $value->name,'missing_count' => $value->summary->missing_count);
                                }
                            }     
                            $model->fieldsBigML = json_encode($fields);
                        }                        
                        $model->save(false);                                               
                    }
                }
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionUpdateCluster() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'cluster' => '', 'file' => '');
                 
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){  
                $return = Controller::updateCluster($model->source,$model->dataset,$model->cluster);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', ' ACTUALIZANDO GRUPOS...');            
                }
                
                if($return['object'] != null){
                    $model->columns = $return['object']->columns;
                    $model->size = $return['object']->size;
                    $model->instances = $return['object']->rows;
                    $model->save(false);
                }
                
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionSaveCluster() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);

        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {

            if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
                $model = Clusters::model()->findByPk($_REQUEST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new Clusters;
            }
            $model->setAttributes($_REQUEST);
            
            if ($model->save()) {                                                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/machine/partials/item-clusters', array('model' => $model), true);
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error comments", "error", "actionSave");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
        
    //=============================================================================================
    public function actionCreateBatchCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'cluster' => '', 'clusters' => '', 'file' => '');
         
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){   
                $slug = @Controller::slugUrl('batch_centroid_'.$model->id.'_'.$model->name);
                $return = Controller::createBatchCentroid($model->source,$model->dataset,$model->cluster,$slug);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'GENERANDO ANÁLISIS ...');
                    //updateModel
                    $model->batchCentroide = $return['batch'];
                    $model->save(false);
                }
           }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
           }

        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetBatchCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'cluster' => '', 'batch' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){  
                $return = Controller::getBatchCentroid($model->batchCentroide);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', ' OBTENIENDO ANÁLISIS ...'); 
                    if($return['status'] == 'success'){
                        $model->batchCentroide = $return['batch'];                    
                        $model->save(false);                                               
                    }
                }
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
     public function actionDownloadBatchCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '','percent' => 0,'series' => '','model' =>'');
        
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Mlmodels::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){ 
            
                $return = Controller::downloadBatchCentroid($model->source,$model->dataset,$model->batchCentroide);
            
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                                //updateModel
    //                    $return = Controller::createBatchPrediction();
                    if($return['status'] == 'success'){

                        $location = $return['file']; 

                        if(file_exists($location)){

                            $caracterSeparator = $this->getFileDelimiter($location);
                            $lot = Date('d_m_Y_h_i_s');
                            $condition = "idMLModel = '".$model->id."', lot = '".$lot."', migrate = 0";

                            $sql = "LOAD DATA INFILE '" . $location . "'
                            INTO TABLE `tbl_tempo_centroid`
                            CHARACTER SET latin1
                            FIELDS
                                TERMINATED BY '" . $caracterSeparator . "'
                                ENCLOSED BY '\"'
                            LINES
                                TERMINATED BY '\\n'
                             IGNORE 1 LINES 
                             (idDebtorObligation,cluster)
                             SET ".$condition;

                                $connection = Yii::app()->db;
                                $transaction = $connection->beginTransaction();
                                try {
                                    $connection->createCommand($sql)->execute();
                                    $transaction->commit();
                                    
                                    $criteria = new CDbCriteria;
                                    $criteria->condition = 'idMLModel = "'.$model->id.'" AND lot = "' . $lot. '" AND migrate = 0 ';
                
                                    if(TempoCentroid::model()->updateAll(array("migrate" => 1), $criteria)){ 
                                        $return['status'] = 'success';
                                        $return['msg'] = Yii::t('front', 'ANÁLISIS FINALIZADO!.');
                                        $return['model'] = $model;
                                    }else{
                                        $return['status'] = 'error';
                                        $return['msg'] = Yii::t('front', 'MIGRANDO ANÁSLISIS!.');                                        
                                    }
                                } catch (Exception $e) {
                                    $return['status'] = 'warning';
                                    $return['msg'] = Yii::t('front', 'Error, cargando archivo');
                                    $return['msg'] .= ' '.$e;
                                }

                            if (file_exists($location)) {
                                unlink($location);
                            }
                        }
                    }
                }
            }
        }
        echo CJSON::encode($return); 
    }
    
    //=============================================================================================
    
    //=============================================================================================
    public function actionGetClusterForm() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '');
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {

                $model = Clusters::model()->findByPk($_REQUEST['id']);
                if($model != null){
                    $return['status'] = 'success';
                    $return['model'] = $model;
                }else{
                    $return['msg'] = Yii::t('front', 'Error, cluster no encontrado !. ');                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionAnalize() {
        if (!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->user->getState('rol'), $this->access)) {
                
                if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
                    
                    $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
                    $input_fields = '';
                    //list customers
                    $criteriaC = new CDbCriteria();
                    $joinC = ' JOIN tbl_users tu ON t.id = tu.id';
                    $conditionC = '';

                    if(Yii::app()->user->getState('rol') == 11) {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    

                        $conditionC .= ($conditionC != '') ? ' AND ' : '';
                        $conditionC .= 'tu.idCompany = ' . Yii::app()->user->getId();  
                    }elseif((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))){
                        if($user != null){                        
                            $conditionC .= ($conditionC != '') ? ' AND ' : '';
                            $conditionC .= 'tu.idCompany = ' . $user->idCompany;                                        
                        }
                    }

                    $conditionC .= ($conditionC != '') ? ' AND ' : '';
                    $conditionC .= "t.active = 1";
                    $criteriaC->condition = $conditionC;
                    $criteriaC->join = $joinC;
                    
                    //cluster
                    $criteria = new CDbCriteria();
                    $condition = 't.id ='.$_REQUEST['id'];
                    if(Yii::app()->user->getState('rol') != 1){                        
                        $condition .= ($conditionC != '') ? ' AND ' : '';
                        $condition .= 't.idCompany = ' . $user->idCompany;                         
                    }                    
                    $criteria->condition = $condition;
                    
                    
                    $model = Mlmodels::model()->find($criteria);    
                    
                    if($model != null){
                        
                        $customers = ViewCustomers::model()->findAll($criteriaC);
                        $clusters = Clusters::model()->count(array('condition' => 'idMLModel = '.$model->id));
                        
                        $fields = json_decode($model->fields);
                        
                        if($fields != false){                            
                            foreach ($fields as $field){
                                $fModel = MlmodelsFields::model()->findByPk($field);                    
                                if($fModel != null){ 
                                    $input_fields .= $fModel->name.',';
                                }
                            }
                        }
                        $fields = substr($input_fields, 0, -1);
                        
                        $this->render('analize', array('customers' => $customers,
                                'model' => $model,
                                'fields' => $fields,
                                'clusters' => $clusters,
                                ));
                    }else{                        
                        throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
                    }
                }
                
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionTest(){
                
        //$this->render('test', array());
           
        require_once 'protected/extensions/bigml/Machinebigml.php';   

        $api = new BigML\BigML(["username" => "desarrollo",
                   "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                   "project" => "project/5cb08b756997fa1812000772"
               ]);
        
//        $batch = $api->get_batchcentroid('batchcentroid/5d4d8e2342129f7dff00002a');
//        print_r($batch);
//        exit;
//        $batch_centroid = $api->create_batch_centroid('cluster/5d432e7ae476847bb40065a4',
//                                                  'dataset/5d4313a25299637de00063d6',
//                                                  array("name"=>"my_batch_centroid_test",
//                                                        "all_fields"=> true,
//                                                        "header"=> true));
//        
//        print_r($batch_centroid);
//        exit;
//        
//        $model = Mlmodels::model()->findByPk(2); 
//        $input_fields = array();
//        if($model != null){
//            $fields = json_decode($model->fields); 
//            foreach ($fields as $field){
//                $fModel = MlmodelsFields::model()->findByPk($field);                    
//                if($fModel != null){ 
//                    $input_fields[] = $fModel->name_export;
//                }
//            }            
//        }
//         $cluster = $api->create_cluster(
//                        'dataset/5d6efd8b5299630409018ca8', 
//                        array("name"=> "cluster".Date('d_m_Y_h_i_s'), 
//                                 "excluded_fields" => array('000000','000001'),
//                                 //"input_fields" => array('city'),
//                        ));
//         
//         print_r($cluster);
//         exit;
        
        $dataset = $api->update_dataset('dataset/5d6efd8b5299630409018ca8', array("fields"=> array(
            "000000" => array("preferred" => false),
            
        )));
        print_r($dataset);
         exit;
               
//
        $cluster = $api->get_cluster('cluster/5d2cf2ce7811dd68a2000984'); 
        print_r($cluster->object->rows);
        exit;
        $fields = array();
        foreach ($cluster->object->clusters->fields as $key => $value) {
            $condition = 'name_export LIKE "%'.$value->name.'%"';
            $field = MlmodelsFields::model()->find(array('condition' => $condition));

            if($field != NULL){
                $fields[$key] = array('name' => $value->name,'missing_count' => $value->summary->missing_count);
            }else{
                echo $condition.'-- no';
                echo '<br>';                
            }

        }
        
        echo json_encode($fields);
        exit;
//        
//        
//        $fields = array();
//        foreach ($cluster->object->clusters->fields as $key => $value){
//            
//            $fields[$key] = array('name' => $value->name);
//            //echo $key.' - '.$value->name;
//            print_r($value);
//            //echo '<br>';
//            //echo $value->name.'<br>';
//            break;
//        }
        
        //print_r($fields);
        
//        exit;
//        echo 'sss';
//        print_r($cluster->object->clusters->clusters);
        
//        foreach($cluster->object->clusters->clusters as $value){
            
            //echo $value->name.'<br>';
//            $name = explode(' ', $value->name);
//            echo $name[1].'<br>';
//            print_r($value);
//            echo '<br>';
//            //id, name ,json_encode( value)
//            break;
//            
//        }
//        exit;
//            
    }
    
    
    //=============================================================================================
    
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('site/error', $error);
        }
    }

}
