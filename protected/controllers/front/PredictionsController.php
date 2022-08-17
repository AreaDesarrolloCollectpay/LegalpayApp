<?php

class PredictionsController extends Controller {

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
                   
                
                $filters = array('name', 'numberDocument', 'userName', 'email', 'location', 'phone', 'address', 'idState','active');
                $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
                
                //users Import
                $criteria = new CDbCriteria();
                $join = ' JOIN tbl_users tu ON t.idCustomer = tu.id';
                $condition = 't.state = 1';
                
                //list customers
                $criteriaC = new CDbCriteria();
                $joinC = ' JOIN tbl_users tu ON t.id = tu.id';
                $conditionC = '';
                
                if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != ''){
                   $condition .= ($condition != '') ? ' AND ' : '';                   
                   $condition .= 'tu.name LIKE "%'.$_REQUEST['customer'].'%"';
                }
                
                if(isset($_REQUEST['accounts']) && $_REQUEST['accounts'] != ''){
                   $condition .= ($condition != '') ? ' AND ' : '';                   
                   $condition .= 't.accounts LIKE "%'.$_REQUEST['accounts'].'%"';
                }
                
                if(isset($_REQUEST['date']) && $_REQUEST['date'] != ''){
                    $date = Controller::CleanFilterDate($_REQUEST['date']);
                    $condition .= ($condition != '') ? ' AND ' : '';                    
                    if((int)$date['count'] > 1){                        
                        $condition .= 'vml.date BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                    }else{  
                        $condition .= 'vml.date = "'.$date['date'][0].'"' ;                     
                    }  
                }
                
                if (Yii::app()->user->getState('rol') == 7) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCustomer = ' . Yii::app()->user->getId();
                    
                    $conditionC .= ($conditionC != '') ? ' AND ' : '';
                    $conditionC .= 't.id = ' . Yii::app()->user->getId();
                }elseif(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
                    
                    $conditionC .= ($conditionC != '') ? ' AND ' : '';
                    $conditionC .= 'tu.idCompany = ' . Yii::app()->user->getId();  
                }elseif((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))){
                    if($user != null){                        
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 'tu.idCompany = ' . $user->idCompany;                    

                        $conditionC .= ($conditionC != '') ? ' AND ' : '';
                        $conditionC .= 'tu.idCompany = ' . $user->idCompany;                                        
                    }
                }
                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= "idTypeImport = 5";
                
                $conditionC .= ($conditionC != '') ? ' AND ' : '';
                $conditionC .= "t.active = 1";
                                
                $criteria->select = 't.*';
                $criteria->condition =  $condition;
                $criteria->join =  $join;    
                $criteria->order = "dateCreated DESC";
                                
                $criteriaC->select = 't.id, t.name';
                $criteriaC->condition = $conditionC;
                $criteriaC->join = $joinC;
                $criteriaC->order = 'name ASC';
                                
                $count = UsersImport::model()->count($criteria);
                                
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = UsersImport::model()->findAll($criteria);
                $customers = ViewCustomers::model()->findAll($criteriaC);
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                    $this->render('predictions', array('customers' => $customers, 
                        'model' => $model, 
                        'count' => $count, 
                        'pages' => $pages,
                        'currentPage' => $currentPage,
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
    //
        
    public function actionValidateResources() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '','cant' => '', 'file' => '');

        if (isset($_REQUEST['idCustomer']) && !Yii::app()->user->isGuest) {

            $customer = ViewCustomers::model()->find(array('condition' => 'id = '.$_REQUEST['idCustomer']));
            
            if($customer != null){             
                
                set_time_limit(0);
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();

                try {
                    $root = Yii::getPathOfAlias('webroot');
                    $filename = "/uploads/bigMl/" . "export_debtors_" . Date('d_m_Y_h_i_s') . ".csv";
                    
                    $sql = 'SELECT 
                               \'idDebtorObligation\',\'portfolioName\',\'capital\',\'months\',\'city\',\'department\',\'region\',\'gender\',\'maritalState\',\'occupation\',
                               \'incomeLegal\',\'age\',\'laborOld\',\'statrus\',\'typeContract\',\'educationLevel\',\'typeHousing\',\'contractTerm\',\'dependents\',\'paymentCapacity\',\'demographics\'
                               UNION
                               SELECT 
                               tdo.id,
                               REPLACE(REPLACE(REPLACE("'.$customer->name.'", \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                               REPLACE(tdo.capital,\'.\',\',\') AS capital,
                               REPLACE(REPLACE(REPLACE(ifnull(round(datediff(tdo.dateRecovered,tdo.duedate)/30),\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                               REPLACE(REPLACE(REPLACE(ifnull(tc.name,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                               REPLACE(REPLACE(REPLACE(ifnull(tdep.name,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                               REPLACE(REPLACE(REPLACE(ifnull(tr.name,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.gender,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.maritalState,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.occupation,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.incomeLegal,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.age,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.laborOld,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.statrus,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.typeContract,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.educationLevel,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.typeHousing,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.contractTerm,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.dependents,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdd.paymentCapacity,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                               REPLACE(REPLACE(REPLACE(ifnull(vdcd.cant,\'\') , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \')
                               
                               from tbl_debtors_obligations  tdo
                                join tbl_debtors td on tdo.idDebtor = td.id
                                join tbl_cities tc on td.idCity = tc.id
                                join tbl_departments tdep on tc.idDepartment = tdep.id
                                join tbl_regions tr on tdep.idRegion = tr.id
                                join view_debtors_check_demographics vdcd on td.id = vdcd.idDebtor
                                left join view_debtors_demographics vdd on tdo.idDebtor = vdd.idDebtor
                                where tdo.idDebtorsState is not null AND td.idCustomers = ' . $customer->id . '
                               INTO OUTFILE \'' . $root . $filename . '\'
                               FIELDS TERMINATED BY \',\'
                               OPTIONALLY ENCLOSED BY \'"\'
                               LINES TERMINATED BY\'\n\'';
                    
                    $connection->createCommand($sql)->execute();
                    //.... other SQL executions
                    $transaction->commit();

                    if (file_exists($root . $filename)) {
                        $criteria = new CDbCriteria();
                        $criteria->select = 'count(t.id) as cant, SUM(t.capital)as capital';
                        $join = 'join tbl_debtors td on t.idDebtor = td.id left join tbl_debtors_state tds on t.idDebtorsState = tds.id ';
                        $condition = '(t.idDebtorsState is not null or tds.historic = 0 ) AND td.idCustomers ='.$customer->id;

                        $criteria->join = $join;
                        $criteria->condition = $condition;

                        $model = DebtorsObligations::model()->find($criteria);

                        $return['status'] = 'success';
                        $return['msg'] = 'ok';
                        $return['model'] = $model;
                        $return['cant'] = $model->cant;
                        $return['file'] = $filename;
                    }
                } catch (Exception $e) { // an exception is raised if a query fails
                    $transaction->rollback();
                    $return['msg'] = $e->getMessage();
                }                
                
            }else{
                $return['status'] = 'error';
                $return['msg'] = 'Registro no encontrado!';                
            }
        }        
        echo CJSON::encode($return);        
    }
    
    //=============================================================================================
    
     public function actionCreateSource() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {

            $model = new Predictions;
            $model->setAttributes($_REQUEST);
            $slug = @Controller::slugUrl('source_prediction_'.Date('d_m_Y_h_i_s'));
            if ($model->validate()){
                if($model->cant > 0){                    
                    $return = Controller::createSource($model->file,$slug);

                    if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                        $return['msg'] = Yii::t('front', 'OBTENIENDO FUENTE DE DATOS ...');
                        //updateModel
    //                    $return = Controller::createBatchPrediction();
                    }
                }else{                    
                    $return['status'] = 'error';
                    $return['msg'] = Yii::t('front', 'No se cuenta con obligaciones para generar la probabilidad');
                }
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
    
    public function actionGetSource() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {
            
            $return = Controller::getSource($_REQUEST['source']);
            if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                $return['msg'] = ($return['status'] == 'success')? Yii::t('front', 'GENERANDO CONJUNTO DE DATOS ...') : Yii::t('front', 'OBTENIENDO FUENTE DE DATOS ...');            
            }
            
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionCreateDataset() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {
            $slug = @Controller::slugUrl('dataset_predicction_'.Date('d_m_Y_h_i_s'));
            $return = Controller::createDataset($_REQUEST['source'],$slug);
            
            if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                 $return['msg'] = Yii::t('front', 'GENERANDO CONJUNTO DE DATOS ...');
                    //updateModel
//                    $return = Controller::createBatchPrediction();
            }

        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetDataset() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {
            
            $return = Controller::getDataset($_REQUEST['source'],$_REQUEST['dataset']);
            if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                $return['msg'] = ($return['status'] == 'success')? Yii::t('front', 'GENERANDO PREDICCIÓN   ...') : Yii::t('front', ' OBTENIENDO CONJUNTO DE DATOS ...');            
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionCreatePrediction() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {
            
            $return = Controller::createPrediction($_REQUEST['source'],$_REQUEST['dataset']);
            
            if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                $return['msg'] = Yii::t('front', 'GENERANDO PREDICCIÓN ...');
                    //updateModel
//                    $return = Controller::createBatchPrediction();
            }

        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetPrediction() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'batch_prediction' => '', 'file' => '');
         
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {            
            $return = Controller::getPrediction($_REQUEST['source'],$_REQUEST['dataset'],$_REQUEST['prediction']);
            if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                $return['msg'] = ($return['status'] == 'success')? Yii::t('front', 'IMPORTANDO PREDICCIÓN  ...') : Yii::t('front', 'OBTENIENDO PREDICCIÓN ...');            
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
     public function actionDownloadPrediction() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '','percent' => 0,'series' => '');
        $series = array();
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {
            
            $return = Controller::downloadPrediction($_REQUEST['source'],$_REQUEST['dataset'],$_REQUEST['prediction']);
            
            if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    //updateModel
//                    $return = Controller::createBatchPrediction();
                if($return['status'] == 'success'){
                    
                    $location = $return['file']; 
                    
                    if(file_exists($location)){
                
                        $caracterSeparator = $this->getFileDelimiter($location);
                        $lot = Date('d_m_Y_h_i_s');
                        $condition = "lot = '".$lot."', migrate = 0";
                        
                        $sql = "LOAD DATA INFILE '" . $location . "'
                        INTO TABLE `tbl_tempo_predictions`
                        CHARACTER SET latin1
                        FIELDS
                            TERMINATED BY '" . $caracterSeparator . "'
                            ENCLOSED BY '\"'
                        LINES
                            TERMINATED BY '\\n'
                         IGNORE 1 LINES 
                         (idDebtorObligation,agreement,percent)
                         SET ".$condition;

                            $connection = Yii::app()->db;
                            $transaction = $connection->beginTransaction();
                            try {
                                $connection->createCommand($sql)->execute();
                                $transaction->commit();

                                $count = TempoPredictions::model()->count(array('condition' => str_replace(',', ' AND ', $condition)  ));
                                $total = TempoPredictions::model()->find(array('select' => 'SUM(percent) as percent','condition' => str_replace(',', ' AND ', $condition)  ));
                                
                                $criteria = new CDbCriteria();
                                $criteria->select = 'vc.id, vc.name';
                                $join = 'join tbl_debtors_obligations tdo on t.idDebtorObligation = tdo.id join tbl_debtors td on tdo.idDebtor = td.id
                                        join view_customers vc on td.idCustomers = vc.id';

                                $criteria->join = $join;
                                $criteria->condition = str_replace(',', ' AND ', $condition);
                                
                                $portfolio = TempoPredictions::model()->find($criteria);
                                
                                if($count > 0){
                                        $return['status'] = 'success';
                                        $return['msg'] = Yii::t('front', 'Cargue exitoso!.');  
                                        $percent = ($count > 0 && $total->percent > 0)? (($total->percent / $count)*100) : 0;
                                        $return['percent'] = round($percent,2);
                                        
                                        if($portfolio != null){                                            
                                            $model = Controller::getChartComparatios($portfolio->id);        
                                            $data = array_map(function($m) {return array("x" => $m->capital, "y" => $m->dayDebt, "z" => round($m->ratio,2));}, $model);
                                            $series[] = array('name' => $portfolio->name,'data' => $data);
                                        }
                                        
                                        $return['series'] = $series;
                                     
                                }else{
                                    $return['msg'] = Yii::t('front', 'Error, Importando data, por favor validar archivo.');                                
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
        echo json_encode($return,JSON_NUMERIC_CHECK); 
    }
    
    
    //=============================================================================================
    
    public function actionSaveMlModels() {
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
    
    
    //=============================================================================================
    public function actionComparations() {
        if (!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->user->getState('rol'), $this->access)) {
                   
                
                $filters = array('name', 'numberDocument', 'userName', 'email', 'location', 'phone', 'address', 'idState','active');
                $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
                
                //users Import
                $criteria = new CDbCriteria();
                $join = ' JOIN tbl_users tu ON t.idCustomer = tu.id';
                $condition = 't.state = 1';
                
                //list customers
                $criteriaC = new CDbCriteria();
                $joinC = ' JOIN view_debtors vd ON t.id = vd.idCustomer';
                $conditionC = 't.active = 1';
                
                if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != ''){
                   $condition .= ($condition != '') ? ' AND ' : '';                   
                   $condition .= 'tu.name LIKE "%'.$_REQUEST['customer'].'%"';
                }
                
                if(isset($_REQUEST['accounts']) && $_REQUEST['accounts'] != ''){
                   $condition .= ($condition != '') ? ' AND ' : '';                   
                   $condition .= 't.accounts LIKE "%'.$_REQUEST['accounts'].'%"';
                }
                
                if(isset($_REQUEST['date']) && $_REQUEST['date'] != ''){
                    $date = Controller::CleanFilterDate($_REQUEST['date']);
                    $condition .= ($condition != '') ? ' AND ' : '';                    
                    if((int)$date['count'] > 1){                        
                        $condition .= 'vml.date BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                    }else{  
                        $condition .= 'vml.date = "'.$date['date'][0].'"' ;                     
                    }  
                }
                
                if (Yii::app()->user->getState('rol') == 7) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCustomer = ' . Yii::app()->user->getId();                    
                }elseif(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                                          
                }elseif((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))){
                    if($user != null){                        
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 'tu.idCompany = ' . $user->idCompany;                                    
                    }
                }
                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= "idTypeImport = 5";
                                                
                $criteria->select = 't.*';
                $criteria->condition =  $condition;
                $criteria->join =  $join;    
                $criteria->order = "dateCreated DESC";
                                
                                
                $count = UsersImport::model()->count($criteria);
                                
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = UsersImport::model()->findAll($criteria);
                
                $criteriaC->select = 't.id, t.name, t.userName';
                $criteriaC->condition = $conditionC;
                $criteriaC->join = $joinC;
                $criteriaC->order = 't.name ASC';
                $criteriaC->group = 't.id';
                
                $customers = Users::model()->findAll($criteriaC);
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                    $this->render('comparations', array('customers' => $customers, 
                        'model' => $model, 
                        'count' => $count, 
                        'pages' => $pages,
                        'currentPage' => $currentPage,
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
    
     public function actionGetCustomers() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'element' => '');
        $html = '';
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_REQUEST['comparation']) && $_REQUEST['comparation'] != '') {
                
                
                //list customers
                $criteriaC = new CDbCriteria();
                $joinC = ' JOIN view_debtors vd ON t.id = vd.idCustomer';
                $conditionC = 't.active = 1';
                if(isset($_REQUEST['comparation']) && $_REQUEST['comparation'] != ''){
                    $comparation = substr($_REQUEST['comparation'], 0, -1);
                    $conditionC .= ' AND t.id NOT IN('.$comparation.')';
                }
                
                $criteriaC->select = 't.id, t.name, t.userName';
                $criteriaC->condition = $conditionC;
                $criteriaC->join = $joinC;
                $criteriaC->order = 't.name ASC';
                $criteriaC->group = 't.id';
                
                $model = Users::model()->findAll($criteriaC);

                if($model != null){
                    
                    $html .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';
                    foreach ($model as $value){
                        $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                    }                    
                    $return['status'] = 'success';
                    $return['model'] = $model;                         
                    $return['html'] = $html;                         
                    $return['element'] = '#comparations-p-'.($_REQUEST['element']+1);                         
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
    
    public function actionChartComparations() {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'series' => '', 'name' => Yii::t('front', 'COMPARACIÓN DE PORTAFOLIOS') );
        
        
        $model = new ChartComparations;
        $model->setAttributes($_REQUEST);
        
//        print_r($_REQUEST);
//        exit;
        if($model->validate()){
            $model = Controller::getChartComparatios($_REQUEST['idPorfolio']);        
            $data = array_map(function($m) {return array("x" => $m->capital, "y" => $m->dayDebt, "z" => round($m->ratio,2));}, $model);
            $portfolio = ViewCustomers::model()->find(array('condition' => 'id ='.$_REQUEST['idPorfolio'] ));
            $series[] = array('name' => ($portfolio != null)? $portfolio->name : 'Portafolio' ,'data' => $data);

            $comparations = substr($_REQUEST['comparations'], 0, -1);
            $comparations = explode(',', $comparations);
            
            foreach ($comparations as $comparation){
                $model = Controller::getChartComparatios($comparation,1);
                $portfolio = ViewCustomers::model()->find(array('condition' => 'id ='.$comparation ));
                $data = array_map(function($m) {return array("x" => $m->capital, "y" => $m->dayDebt, "z" => round($m->ratio,2));}, $model);
                $series[] = array('name' => ($portfolio != null)? $portfolio->name : 'Comparación','data' => $data);

            }
            
            $return['status'] = 'success';
            $return['msg'] = 'ok';
            $return['series'] = $series;
            
        }else{
            $return['status'] = 'error';
            $return['msg'] = '';
            Yii::log("Error Gastos", "error", "actionSave");
            foreach ($model->getErrors() as $error) {
                $return['msg'] .= $error[0] . "<br/>";
            }
        }
        
        echo json_encode($return,JSON_NUMERIC_CHECK);                      
    }

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
