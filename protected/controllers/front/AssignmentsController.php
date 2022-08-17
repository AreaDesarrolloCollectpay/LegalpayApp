<?php

class AssignmentsController extends Controller {

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
                
                if (Yii::app()->user->getState('rol') == 17) {
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
                    $this->render('assignments', array('customers' => $customers, 
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
    
    public function actionSaveAssignments() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true, 'lot' => '', 'count' => '', 'total' => '');
         
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

            $model->file = (CUploadedFile::getInstanceByName('file') != '') ? CUploadedFile::getInstanceByName('file') : $model->file;

            if ($model->save()) {
                $date = Date('d_m_Y_h_i_s');
                $file = CUploadedFile::getInstanceByName('file');
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

                    $location = Yii::getPathOfAlias('webroot') . "/uploads/assignments/" . $fname;
                    $file->saveAs($location);
                    //Subir archivo a bucket
                    $credentials = new Google_Auth_AssertionCredentials($configuration['login'], $configuration['scope'], $configuration['key']);
                    $client = new Google_Client();
                    $client->setAssertionCredentials($credentials);
                    if ($client->getAuth()->isAccessTokenExpired()) {
                        $client->getAuth()->refreshTokenWithAssertion();
                    }

                    # Starting Webmaster Tools Service
                    $storage = new Google_Service_Storage($client);

                    $uploadDir = 'uploads/assignments/';
                    $file_name = $model->idCustomer . "/" . $fname;
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
                                        
                    $caracterSeparator = $this->getFileDelimiter($location);
                    
                        $condition = "lot = '" . $date . "', idCustomer = " . $model->idCustomer . ", migrate = 0, idUserImport = ".$model->id;
                        $sql = "LOAD DATA INFILE '" . $location . "'
                    INTO TABLE `tbl_tempo_debtors`
                    CHARACTER SET latin1
                    FIELDS
                        TERMINATED BY '" . $caracterSeparator . "'
                        ENCLOSED BY '\"'
                    LINES
                        TERMINATED BY '\\n'
                     IGNORE 1 LINES 
                     (name,type_document,number,city,address,phone,mobile,email,support_type,credit_number,capital, @expiration_date,legal,office_legal,office_legal_location,idTypeProcess,settled_number,comments, internal_code)
                     SET ".$condition.", expiration_date = str_to_date(@expiration_date, '%d/%m/%Y')";
                      
                      /* 
                       $sql = "LOAD DATA INFILE '" . $location . "'
                    INTO TABLE `tbl_tempo_debtors`
                    CHARACTER SET latin1
                    FIELDS
                        TERMINATED BY '" . $caracterSeparator . "'
                        ENCLOSED BY '\"'
                    LINES
                        TERMINATED BY '\\n'
                     IGNORE 1 LINES 
                     (type_document,number,name,internal_code,country,department,city,address,phone,email,support_type,@expiration_date,capital,
                     interest,
                     interest_arrears,
                     interest_arrears_migrate,
                     charges,
                     others,
                     credit_number,
                     comments,
                     idCreditModality,
                     idTypeProduct,
                     origin_credit,
                     legal,
                     promissory_note_o_p,
                     promissory_note_d,
                     au_central_risk_o_p,
                     @disbursement_date,
                     approved_value,
                     @punishment_date,
                     @last_pay_date,
                     capital_subscription,
                     interest_subscription,
                     secure_subscription,
                     total_subscription,
                     total_pay_from_expiration,
                     @last_pay_capital_date,
                     @last_pay_interest_date,
                     @presentation_demand_date,
                     linking_format,
                     conditions)
                     SET ".$condition.", expiration_date = str_to_date(@expiration_date, '%d/%m/%Y'), disbursement_date = IF(@disbursement_date <> '',str_to_date(@disbursement_date, '%d/%m/%Y'),NULL),
                     punishment_date = IF(@punishment_date <> '',str_to_date(@punishment_date, '%d/%m/%Y'),NULL), last_pay_date = IF(@last_pay_date <> '', str_to_date(@last_pay_date, '%d/%m/%Y'), NULL), last_pay_capital_date = IF( @last_pay_capital_date <> '', str_to_date(@last_pay_capital_date, '%d/%m/%Y'), NULL),
                     last_pay_interest_date = IF(@last_pay_interest_date <> '', str_to_date(@last_pay_interest_date, '%d/%m/%Y'), NULL), presentation_demand_date = IF(@presentation_demand_date <> '', str_to_date(@presentation_demand_date, '%d/%m/%Y'), NULL)
                     ";
                       */
                     
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

    //=============================================================================================
    public function actionImportData() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        //log_out($_REQUEST);

        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {

            //log_out("paso if");

            $model =  new ImportData;            
            $model->setAttributes($_REQUEST);


            //log_out($_REQUEST);


            $userImport = UsersImport::model()->findByPk($_REQUEST['id']);
            

            


            if($userImport != NULL && $model->validate()){
                
		    //log_out("paso if 2");
		//var_dump($model);

                $criteria = new CDbCriteria;
                $criteria->condition = 'lot = "' . $model->lot. '" AND migrate = 0 AND idCustomer =' . $model->idCustomer;
                $userImport->state = 1 ;
                

                //log_out($criteria);
                
                //log_out(TempoDebtors::model()->updateAll(array("migrate" => 1), $criteria));
               // log_out("yi es popo");

                if(TempoDebtors::model()->updateAll(array("migrate" => 1), $criteria) && $userImport->save(false)){ 
                 //if (true){
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
                     (type_document,number,name,internal_code,country,department,city,address,phone,email,support_type,@expiration_date,capital, paid,comments)
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
