<?php

class Assignments_oneController extends Controller {

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
        $this->access = array(1,2,5,7,11);
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
    public function actionIndex() {
        //var_dump(Yii::app()->user->getId());
        


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
		$countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC'));
		$departments  = Departments::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC'));
		$cities  = Cities::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC'));
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                    $this->render('assignments', array('customers' => $customers, 
                        'model' => $model, 
                        'count' => $count, 
                        'pages' => $pages,
			'countries' => $countries,
			'departments' => $departments,
			'cities' => $cities,
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
    
    public function actionSaveAssignments() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true, 'lot' => '', 'count' => '', 'total' => '');


        try {

        if(isset($_POST["expiration_date"]) && !empty($_POST["expiration_date"])){
            $expdate = explode("-", $_POST["expiration_date"]);
            $_POST["expiration_date"] = $expdate[2]."/".$expdate[1]."/".$expdate[0];



            if (isset($_POST) && !Yii::app()->user->isGuest) {

                if (isset($_POST['id']) && $_POST['id'] != '') {
                    $model = UsersImport::model()->findByPk($_POST['id']);
                    $return['newRecord'] = false;
                } else {
                    $model = new UsersImport;
                }
                $model->setAttributes($_POST);
                $model->idUserCreated = Yii::app()->user->getId();
                $model->idTypeImport = 5;


		//var_dump($model->save());
		//var_dump($model->getAttributes());

                if ($model->save()) {
                    $date = Date('d_m_Y_h_i_s');

                    foreach($_POST as $k=>$v){
                        if(empty(trim($_POST[$k]))){
                            $_POST[$k]=0;
                        }
                    }




                    $condition = "lot = '" . $date . "', idCustomer = " . $model->idCustomer . ", migrate = 0, idUserImport = ".$model->id;




                    $sql = "INSERT INTO tbl_tempo_debtors ( ".
                        "id, lot, idCustomer, idUserImport, type_document, ".
                        "number, name, internal_code, country, department, ".
                        "city, address, phone, mobile, email, ".
                        "support_type, expiration_date, capital, comments, interest, ".
                        "interest_arrears, interest_arrears_migrate, charges, others, credit_number, ".
                        "idCreditModality, idTypeProduct, origin_credit, legal, idTypeProcess, ".
                        "office_legal, office_legal_location, settled_number, promissory_note_o_p, promissory_note_d, ".
                        "au_central_risk_o_p, disbursement_date, approved_value, punishment_date, last_pay_date, ".
                        "capital_subscription, interest_subscription,secure_subscription, total_subscription, total_pay_from_expiration, ".
                        "last_pay_capital_date, last_pay_interest_date, presentation_demand_date, linking_format, conditions, ".
                        "migrate".
                        
                        ") VALUES ( ".

                        "NULL, '".$date."', " . $model->idCustomer . ", ".$model->id.", '".$_POST["type_document"]."', ".
                        "'".$_POST["number"]."', '".$_POST["name"]."', ".$_POST["internal_code"].", NULL, NULL, ".
                        "'".$_POST["city"]."', '".$_POST["address"]."', '".$_POST["phone"]."', '".$_POST["mobile"]."', '".$_POST["email"]."', ".
                        "'".$_POST["support_type"]."', str_to_date( '".$_POST["expiration_date"]."', '%d/%m/%Y'), ".$_POST["capital"].", '".$_POST["comments"]."', 0, ".
                        "0, 0, 0, 0, '".$_POST["credit_number"]."', ".
                        "NULL, NULL, NULL, '".$_POST["legal"]."', '".$_POST["idTypeProcess"]."', ".
                        "'".$_POST["office_legal"]."', '".$_POST["office_legal_location"]."', '".$_POST["settled_number"]."', '0', '0', ".
                        "'0', NULL, 0, NULL, NULL, ".
                        "0, 0, 0, 0, 0, ".
                        "NULL, NULL, NULL, '0', NULL, ".
                        "0);";
                        
                        $return['dato']=print_r($_POST,true); 
                        //$return["errores"]=print_r($_REQUEST,true);
                        //echo CJSON::encode($return);    
                        //die();
                    //var_dump($sql);

                    //die();

                    
                    $connection = Yii::app()->db;
                    $transaction = $connection->beginTransaction();
                    try {
                        $connection->createCommand($sql)->execute();
                        $transaction->commit();
                        
                        $count = TempoDebtors::model()->count(array('condition' => str_replace(',', ' AND ', $condition)  ));
                        $total = TempoDebtors::model()->find(array('select' => 'SUM(capital) as capital','condition' => str_replace(',', ' AND ', $condition)  ));
                        $total = (($total != null)? $total->capital : 0);
                        if($count > 0 && $total > 0){
                            $model->accounts = $count;
                            $model->capital = $total;
                            if(!$model->save(false)){
                                $return['msg'] = '';
                                Yii::log("Error Asignaciones", "error", "actionImport");
                                foreach ($model->getErrors() as $error) {
                                    $return['msg'] .= $error[0] . "<br/>";
                                }
                                $model->delete();
                            }else{                                    
                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Cargue exitoso!.');    
                                $return['model'] = $model;
                                $return['lot'] = $date;
                                $return['count'] = $count;
                                $return['total'] = Yii::app()->format->formatNumber($total);                                                                
                            }
                        }else{
                            $return['msg'] = Yii::t('front', 'Error, Importando data, por favor validar archivo.');                                
                        }

                    } catch (Exception $e) {
                        $return['status'] = 'warning';
                        $return['msg'] .= $e;
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
        }
        } catch(Throwable $t) {
            //throw $th;
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    public function actionImportData() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

	log_out($_REQUEST);
	//Yii::log(json_encode($_REQUEST), "error", "actionImport");

        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {

            log_out("paso if");

            $model =  new ImportData;            
            $model->setAttributes($_REQUEST);


            log_out($_REQUEST);


            $userImport = UsersImport::model()->findByPk($_REQUEST['id']);
            

            


            if($userImport != NULL && $model->validate()){
                
                log_out("paso if 2");

                $criteria = new CDbCriteria;
                $criteria->condition = 'lot = "' . $model->lot. '" AND migrate = 0 AND idCustomer =' . $model->idCustomer;
                $userImport->state = 1 ;
                

                log_out($criteria);
                
                log_out(TempoDebtors::model()->updateAll(array("migrate" => 1), $criteria));
                log_out("yi es popo");

                if(TempoDebtors::model()->updateAll(array("migrate" => 1), $criteria) && $userImport->save(false)){ 

                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Importación exitosa!.');

                }else{

                    $return['status'] = 'warning';
                    $return['msg'] = Yii::t('front', 'Error al importar información');

                }    
                
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Gastos", "error", "actionImport");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
            
            
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    
    public function actionDeleteImport() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            $model =  new ImportData;            
            $model->setAttributes($_POST);
            
            if($model->validate()){
                
                $criteria = new CDbCriteria;
                $criteria->condition = 'lot = "' . $model->lot. '" AND migrate = 0 AND idCustomer =' . $model->idCustomer;
        
                if(TempoDebtors::model()->deleteAll($criteria)){ 

                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Importación Eliminada!.');

                }else{

                    $return['status'] = 'warning';
                    $return['msg'] = Yii::t('front', 'Error al eliminar información');

                }    
                
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Gastos", "error", "actionImport");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
            
            
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    
    public function actionLoadData() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';

        if (!Yii::app()->user->isGuest){

            if (isset($_POST)) {

                $model = new Assignments;
                $model->setAttributes($_POST);
                $model->file = CUploadedFile::getInstanceByName('file');
                if ($model->validate()){
                    $date = Date('d_m_Y_h_i_s');
                    $nameFile = $date.$model->file->getExtensionName();
                    $location = Yii::getPathOfAlias('webroot') . "/uploads/assignments/" . $nameFile;
                    if($model->file->saveAs($location)){
                        
                        $caracterSeparator = ";";
                        if (strpos(file_get_contents($location), ",") !== false) {
                            $caracterSeparator = ",";
                        }
                        $sql = "LOAD DATA INFILE '" . $location . "'
                    INTO TABLE `tbl_tempo_debtors`
                    CHARACTER SET latin1
                    FIELDS
                        TERMINATED BY '" . $caracterSeparator . "'
                        ENCLOSED BY '\"'
                    LINES
                        TERMINATED BY '\\n'
                     IGNORE 1 LINES 
                     (type_document,number,name,internal_code,country,department,city,address,phone,email,support_type,@expiration_date,capital,paid,comments)
                     SET lot = '" . $date . "', idCustomer = " . $model->idCustomer . ", migrate = 0, expiration_date = str_to_date(@expiration_date, '%d/%m/%Y')";
                        $connection = Yii::app()->db;
                        $transaction = $connection->beginTransaction();
                        try {
                            $connection->createCommand($sql)->execute();
                            $transaction->commit();
                            
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'Cargue exitoso!.');
                            $return['model']['lote'] = $date;
                            $return['model']['idCustomer'] = $model->idCustomer;
                            

                        } catch (Exception $e) {
                            $return['status'] = 'warning';
                            $return['msg'] = Yii::t('front', 'Error, cargando archivo');
                            $return['msg'] .= ' '.$e;
                        }
                    }else{                        
                        $return['status'] = 'warning';
                        $return['msg'] = Yii::t('front', 'No se pudo cargar el archivo');
                    }
                    
                    
                } else {
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
    
    public function actionDetail(){
        
        if (!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->user->getState('rol'), $this->access)) {
                
                if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
                    $filters = array('name', 'numberDocument', 'userName', 'email', 'location', 'phone', 'address', 'idState','active');
                    $select = '';
                    $join = ' JOIN tbl_debtors_obligations tdo on t.id = tdo.idDebtor';
                    $condition = '';

                    
                    
                    if(isset($_REQUEST['id']) && $_REQUEST['id'] != '' ){
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 't.comments = '.$_REQUEST['id']; 
                    }
                    
                    $criteria = new CDbCriteria;

                    $criteria->select = $select;
                    $criteria->join = $join;
                    $criteria->condition = $condition;


                    $count = Debtors::model()->count($criteria);

                    $pages = new CPagination($count);
                    $pages->pageSize = $this->pSize;
                    $pages->applyLimit($criteria);

                    $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 

                    $model = Debtors::model()->findAll($criteria);

                    if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                        $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                        $return['table'] = $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model), true);
                        $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                        echo CJSON::encode($return);
                        Yii::app()->end();
                    }else{
                        $this->render('detail', array(                        
                            'model' => $model, 
                            'count' => $count, 
                            'pages' => $pages,
                            'currentPage' => $currentPage,
                                ));
                    }
                }else{                    
                    throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
                }
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }        
    }
    
    
    //=============================================================================================
    //=============================================================================================
    
    //=============================================================================================
    public function actionAdviser() {
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
                $condition .= "idTypeImport = 6";
                
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
                
                $advisers = ViewAdvisers::model()->findAll($criteriaC);
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                    $this->render('assignments_advisers', array('customers' => $customers, 
                        'model' => $model, 
                        'count' => $count, 
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'advisers' => $advisers,
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
    
    public function actionSaveAssignmentsAdvisers() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true, 'lot' => '', 'count' => '', 'total' => '');
         
        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersImport::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new UsersImport;
            }
            $model->setScenario('AsAdviser');
            $model->setAttributes($_POST);
            $model->idUserCreated = Yii::app()->user->getId();

            $model->file = (CUploadedFile::getInstanceByName('file') != '') ? CUploadedFile::getInstanceByName('file') : $model->file;

            if ($model->save()) {
                $date = Date('d_m_Y_h_i_s');
                    $path = '/uploads/';
                    $upload = Controller::uploadFile($model->file,'import',$model->id,$path, false);
                    $model->file = ($upload)? $upload['filename']:  $model->file;   
                if ($model->save(false)) {
                    
                    $location = $upload['location'];        
                    $caracterSeparator = $this->getFileDelimiter($location);
                    
                        $condition = "idAdviser = ".$model->idAdviser.", idCustomer = " . $model->idCustomer . ", migrate = 0, idUserImport = ".$model->id;
                        
                        $sql = "LOAD DATA INFILE '" . $location . "'
                    INTO TABLE `tbl_tempo_assignments`
                    CHARACTER SET latin1
                    FIELDS
                        TERMINATED BY '" . $caracterSeparator . "'
                        ENCLOSED BY '\"'
                    LINES
                        TERMINATED BY '\\n'
                     IGNORE 1 LINES 
                     (code,name)
                     SET ".$condition;
                      
                        $connection = Yii::app()->db;
                        $transaction = $connection->beginTransaction();
                        try {
                            $connection->createCommand($sql)->execute();
                            $transaction->commit();
                            
                            $count = TempoAssignments::model()->count(array('condition' => str_replace(',', ' AND ', $condition)  ));
                            if($count > 0){
                                $model->accounts = $count;
                                $condition .= ', idDebtor IS NULL';
                                $error = TempoAssignments::model()->count(array('condition' => str_replace(',', ' AND ', $condition)  ));
                                if(!$model->save(false)){
                                    $return['msg'] = '';
                                    Yii::log("Error Asignaciones", "error", "actionImport");
                                    foreach ($model->getErrors() as $error) {
                                        $return['msg'] .= $error[0] . "<br/>";
                                    }
                                    $model->delete();
                                }else{                                    
                                    $return['status'] = 'success';
                                    $return['msg'] = Yii::t('front', 'Cargue exitoso!.');    
                                    $return['model'] = $model;
                                    $return['count'] = $count;
                                    $return['error'] = $error;
                                }
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
                }else{
                    $return['status'] = 'warning';
                    $return['msg'] = Yii::t('front', 'Error, archivo no encontrado');
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
    
    //==============================================================================
    
    //=============================================================================================
    public function actionImportAssignments() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'newRecord' => true);

        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = UsersImport::model()->findByPk($_REQUEST['id']);
            
            if($model != null){
                $model->state = 1;
                
                if($model->save(false)){                    
                    $criteria = new CDbCriteria;
                    $criteria->condition = ' idUserImport = "' . $model->id. '" AND migrate = 0 AND idCustomer =' . $model->idCustomer;

                    if(TempoAssignments::model()->updateAll(array("migrate" => 1), $criteria)){ 
                        $return['status'] = 'success';
                        $return['msg'] = Yii::t('front', 'Importación exitosa!.');
                    }else{
                        $return['status'] = 'warning';
                        $return['msg'] = Yii::t('front', 'Error al importar información');
                    }                    
                }else{
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Importación no encontrada');
            }
        }
        echo CJSON::encode($return);
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
