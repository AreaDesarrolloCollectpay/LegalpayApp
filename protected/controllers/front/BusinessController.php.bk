<?php

class BusinessController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public $coordinators;
    public $coordinator;
    public $adviser;
    public $administrators;
    public $pSize;
    public $access;
    
    //=============================================================================================

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'layout_secure';
        parent::init();
        Yii::app()->errorHandler->errorAction = 'wallet/error';        
        $this->pSize = 10;
        $this->access = 7; //es 13               
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

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }
    
    //=============================================================================================
    public function actionIndex() {
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if ($access) {
          
            $filters = array('idCity', 'idDepartment', 'idBusinessAdvisor', 'name', 'numberDocument');

            $condition = '';
            $join = 'JOIN view_location vl ON t.idCity = vl.idCity
                    LEFT JOIN view_management_business_last vmbl ON t.id = vmbl.idUsersBusiness';

            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {

                    if (($key != 'page') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= ($key == 'idCity')? 't.'.$key : $key;
                        $condition .= (($key == 'name' || $key == 'numberDocument')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }

            if (Yii::app()->user->getState('rol') == 9 && (!isset($GET['idBusinessAdvisor']))) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idBusinessAdvisor = ' . Yii::app()->user->getId();
            }
            
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= ' idUserState = ';

            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 2;  
            //is ajax        
            if (Yii::app()->getRequest()->getIsAjaxRequest()){  
                $html = '';
                $userState = (isset($_REQUEST['idState']) && $_REQUEST['idState'] != '')? $_REQUEST['idState'] : 0;
                $models = BusinessController::GetBusiness($condition, $join ,$userState, $currentPage);
                foreach ($models['models'] as $model) {                        
                    $html .= $this->renderPartial('/business/partials/item-business', array('model' => $model), true);
                }

                $return = array(
                        "status" => 'success',
                        "msg" => 'ok',
                        "html" => $html,
                        "page" => ($currentPage + 1),
                        "id" => $userState,
                        "more" => $models['more'],
                    );
                    echo CJSON::encode($return);
                    Yii::app()->end(); 

            }else{

                $criteria = new CDbCriteria();
                $conditionU = 't.type = 2';
                $criteria->select = 't.id as id, t.name';            
                $criteria->group = 't.id';
                $criteria->condition = $conditionU;
                $criteria->order = "t.id ASC";

                $userStates = UsersState::model()->findAll($criteria);

                $html = $this->renderPartial('/business/business_content', array('userStates' => $userStates,'condition' => $condition,'join' => $join, 'currentPage' => $currentPage), true);

                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $businessStates = UsersState::model()->findAll(array('condition' => 'type = 2 AND active = 1'));
                $businessAdvisors = ViewBusinessAdvisor::model()->findAll(array('order' => 'name ASC'));

                $this->render('business',array('html' => $html, 
                    'countries' => $countries,
                    'businessStates' => $businessStates,
                    'businessAdvisors' => $businessAdvisors,
                    'currentPage' => $currentPage,
                        ));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================

    public static function GetBusiness($condition, $join, $idSate, $page = 0) {
    
        $criteria = new CDbCriteria();
        $criteria->select = 't.id as id, t.idUser, t.name as name, t.idBusinessAdvisor, t.numberDocument as numberDocument, t.value as value, timestampdiff(DAY,CURDATE(),date_close) as ageBusiness, date_close as date_close, vmbl.date';
        $criteria->condition = $condition.$idSate;
        $criteria->join =  ($join != '')? $join : NULL;
        
        $_REQUEST['page'] = $page;
//        $criteria->order = "t.value DESC";
        $criteria->order = "vmbl.date ASC";
        $criteria->group = 't.id';
        $count = ViewBusiness::model()->count($criteria);
        
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);        
        
        $model['models'] = ViewBusiness::model()->findAll($criteria);
        $model['more'] = $return['more'] = ($count > ($page * $pages->pageSize))? true : false;
        return $model;
    }
    
    //=============================================================================================
    public static function GetValuesBusiness($condition, $join, $idSate) {
                   
        $criteria = new CDbCriteria();
        $criteria->select = 'SUM(t.value) as value, COUNT(t.id) as cant';
        
        $criteria->condition = $condition.$idSate;
        $criteria->join = $join;
        //$criteria->group = 't.id';

        $model = ViewBusiness::model()->find($criteria);
        return $model;
    }
    
    //=============================================================================================
    public function actionUpdateBusiness() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '','newRecord' => true);
        
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if ($access) {

            if (isset($_POST)) {

                $model = new Business; 
                $model->setAttributes($_POST);
                    
                if ($model->validate()) {
                    
                    if((isset($_POST['id']) && $_POST['id'] != '')){
                        $business = Users::model()->findByPk($_POST['id']);
                        $return['newRecord'] = false;    
                    }else{
                        $business = new Users;
                    }
                    
                    $business->setAttributes($_POST);
                    
                    if($return['newRecord']){
                        $business->image = Yii::app()->theme->baseUrl.'/assets/img/user/user-male-icon.png';
                        $business->idUserCreator = Yii::app()->user->getId();
                        $business->userName = $business->name;
                        $business->notification = 0;
                        $business->is_internal = 0;
                        $business->password = MD5('123456789');
                    }
                    
                    if($business->validate()){
                        $business->save(false);
                        if($return['newRecord']){
                            $profile = new UsersProfiles;
                            $profile->idUser = $business->id;
                            $profile->idUserProfile = $model->idUserProfile;
                            $profile->is_internal = $business->is_internal;

                            if($profile->save()){
                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                                $return['model'] = $model;                            
                                
                            }else{
                                $return['msg'] = Yii::t('front', 'Error asigando perfil !. ');
                                foreach ($profile->getErrors() as $error) {
                                    $return['msg'] .= $error[0] . "<br/>";
                                }
                                $business->delete();
                            }

                        }else{
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                            $return['model'] = $business;  
                        }
                        
                        $businessInfo = UsersBusiness::model()->find(array('condition' => 'idUser ='.$business->id));
                        if($businessInfo == null){
                            $businessInfo = new UsersBusiness;                                    
                        }

                        $businessInfo->setAttributes($_POST);
                        $businessInfo->idUser = $business->id;

                        if(!$businessInfo->save(false)){
                            $return['msg'] = Yii::t('front', 'Error asigando información !. ');
                            foreach ($businessInfo->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                        }
                        
                    }else{
                        $return['status'] = 'error';
                        $return['msg'] = '';
                        Yii::log("Error Pagos", "error", "actionSave");
                        foreach ($business->getErrors() as $error) {
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

    public function actionDetail() {
        
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if ($access && isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
            
            if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
                //$idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();
                //$debtor = Yii::app()->db->createCommand("SELECT t.*  FROM `view_debtors` t  JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign WHERE t.idDebtor = " . $_GET['id'] . " AND cc.idCoordinator = " . $idCoordinator)->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
            } else {
                $condition = 'id = ' . $_REQUEST['id'];
                if (Yii::app()->user->getState('rol') == 7) {
                    //$condition .= ' AND idCustomer =' . Yii::app()->user->getId();
                }
                $business = ViewBusiness::model()->find(array('condition' => $condition));
            }
            
            if ($business != NULL) {
                $task = (isset($_REQUEST['task']) && $_REQUEST['task'] != '')? UsersBusinessTasks::model()->findByPk($_REQUEST['task']) : null;
                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $user = Users::model()->findByPk($business->idUser);
                $userBusiness = UsersBusiness::model()->find(array('condition' => 'idUser ='.$business->id));
                $businessStates = UsersState::model()->findAll(array('condition' => 'type = 2 AND active = 1'));
                $businessAdvisors = ViewBusinessAdvisor::model()->findAll(array('order' => 'name ASC'));
                $actions = TasksActions::model()->findAll(array('condition' => 'is_legal = 0 AND idTasksAction IS NULL'));
                $spendingTypes = SpendingTypes::model()->findAll(array('condition' => 'active = 1'));                               
                $spendings = UsersBusinessSpendings::model()->findAll(array('condition' => 'idUserBusiness ='.$business->id, 'order' => 'dateSpending DESC'));
                
                $criteriaManagement = new CDbCriteria();   
                $criteriaManagement->select = 't.*';
                $criteriaManagement->condition = 't.idUsersBusiness ='.$business->id.' AND t.state = 1 AND t.date <= CURDATE()';
                $criteriaManagement->order = 't.date DESC';
                
                $countManagement = ViewManagementBusiness::model()->count($criteriaManagement);
                
                $pagesManagement = new CPagination($countManagement);
                $pagesManagement->pageSize = $this->pSize;;
                $pagesManagement->applyLimit($criteriaManagement);  
                
                $managements = ViewManagementBusiness::model()->findAll($criteriaManagement);                
                                
                $criteriaManagement->select = 't.idTasksAction, t.management';
                //$criteriaManagement->group = 't.idTasksAction'; 
                $actionsManagements = ViewManagementBusiness::model()->findAll($criteriaManagement);
                
                $phones = array();
                $phonesSMS = array();
                $emailEmails = array();
                
                $demographicEmail = UsersEmails::model()->findAll(array('condition' => 'idUser ='.$business->idUser));
                $demographicPhones = UsersPhones::model()->findAll(array('condition' => 'idUser ='.$business->idUser));
                $demographicAddresses = array();
                
                $typeReferences = TypeReference::model()->findAll(array('condition' => 'active = 1'));
                $phoneClasses = PhoneClass::model()->findAll(array('condition' => 'active = 1'));
                                                
                $this->render(
                    'detail', array(
                    'user' => $user,       
                    'task' => $task,       
                    'business' => $business,                      
                    'userBusiness' => $userBusiness,
                    'countries' => $countries,
                    'actions' => $actions,
                    'spendingTypes' => $spendingTypes,    
                    'businessStates'  => $businessStates,
                    'businessAdvisors' => $businessAdvisors, 
                    'spendings' => $spendings,
                    'managements' => $managements,
                    'pagesManagement' => $pagesManagement,
                    'actionsManagements' => $actionsManagements, 
                    'isMobile' => $this->isMobile,
                    'phones' => $phones,
                    'phonesSMS' => $phonesSMS,
                    'emailEmails' => $emailEmails,
                    'demographicPhones' => $demographicPhones,
                    'demographicEmail' => $demographicEmail,
                    'demographicAddresses' => $demographicAddresses,
                    'typeReferences' => $typeReferences,
                    'phoneClasses' => $phoneClasses
                    )
                );
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionSaveTasks() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if (isset($_POST) && $access) {
            if(isset($_POST['id']) && $_POST['id'] != ''){
                $model = UsersBusinessTasks::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            }else{                
                $model = new UsersBusinessTasks;
            }
            $model->setAttributes($_POST);
            $today = date("Y-m-d");
            $model->idUserAsigned = Yii::app()->user->getId();
            $model->idUserCreated = Yii::app()->user->getId();
            $model->support = CUploadedFile::getInstancesByName('support');
            
            if(($model->date != '' && ($model->date <= $today)) ){
                $model->setScenario('complete');
                $model->state = 1;
            }
                        
            if($model->idTasksAction == 12){
                $model->setScenario('support');
                if(!$return['newRecord'] && $model->support == null){
                    $support = UsersBusinessTasksSupport::model()->find(array('condition' => 'idUserBusinessTask = '.$model->id));
                    $model->support = ($support != null)? $support->support : null;
                }
            }  
            
            if ($model->save()) {
                
                if($model->idUserState != NULL){  
                    $business = UsersBusiness::model()->find(array('condition' => 'id ='.$model->idUsersBusiness));
                    $business->idUserState = $model->idUserState;
                    $business->save(); 
                }
                      
                $images = CUploadedFile::getInstancesByName('support');
            
                if(isset($images) && count($images) > 0){
               
                    foreach ($images as $image => $pic){                                

                        $img =  new UsersBusinessTasksSupport();                                
                        $img->idUserBusinessSupport = Yii::app()->user->getId();
                        $img->idUserBusinessTask = $model->id;
                        
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
                        $fname = @Controller::slugUrl($model->id . '-' . Date('d_m_Y_h_i_s_')) . "." . $pic->getExtensionName();
                        $pic->saveAs(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                        
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
                        $file_name = $model->id . "/" . $fname;
                        $obj = new Google_Service_Storage_StorageObject();
                        $obj->setName($file_name);
                        try {
                            $storage->objects->insert(
                                    "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $fname), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
                            );
                            $img->support = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                            if(!$img->save(false)){
                                print_r($img->getErrors());
                                exit;
                            }
                        } catch (Exception $e) {
                            $return['status'] = 'error';
                            $return['msg'] = Yii::t('front', 'No se pudo guardar el soporte');
                        }

                        if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname)) {
                            unlink(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                        }                        
                        
                    }
                }
                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Gestión almacenada exitosamente !.');
                $return['model'] = $model;
                $return['html'] = '';
                
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Gestion", "error", "actionSave");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }
        
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionStateUserBusiness() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'));        
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if (isset($_POST['id'], $_POST['idUserState']) && $access){
                     
            if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin'],Yii::app()->params['advisorBusiness']))){
                
                $criteria = new CDbCriteria();
                $condition = '';
        
                if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisorBusiness'])){
                   $condition .= ($condition != '') ? ' AND ' : '';
                   $condition .= ' t.idBusinessAdvisor = '.Yii::app()->user->getId();
               }

                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' t.id = '.$_POST['id'];
                $criteria->condition = $condition;
                
                $model = UsersBusiness::model()->find($criteria);
                                
                if($model != null){
                                      
                    $model->setAttributes($_POST);                    
                    
                    if($model->save(false)){
                        $return['status'] = 'success';
                        $return['msg'] = Yii::t('front', 'Estado actualizado con éxito');
                        $return['model'] = $model;
                    }else{
                        $return['msg'] = '';
                        Yii::log($e->getMessage(), "error", "actionDelete");
                        foreach ($model->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }
                } else {
                    $return['msg'] = Yii::t('front', 'Deudor no encontrado !.');
                }
            }else{
                $return['msg'] = Yii::t('front', 'No tiene permisos para realizar esta acción');                
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionSaveDemographicPhone() {

        $return = array('status' => 'error','msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
        
        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersPhones::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new UsersPhones;
            }
            $model->setAttributes($_POST);
            $model->idUserPhone = Yii::app()->user->getId();
            
            if($model->idPhoneClass == 1){
                $model->setScenario('MOBILE');
            }elseif($model->idPhoneClass == 2){
                $model->setScenario('PHONE');
            }

            if ($model->save()) {         
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guardado exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/business/partials/item-phone', array('model' => $model), true);
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error telefono business", "error", "SaveDemographicPhone");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= str_replace('Valor', 'Número', $error[0]) . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================

    public function actionSaveDemographicEmail() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
        
        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersEmails::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new UsersEmails();
            }
            $model->setAttributes($_POST);
            $model->idUserEmail = Yii::app()->user->getId();
            
            if ($model->save()) {
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guardada exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/business/partials/item-email', array('model' => $model), true);
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error email deudor", "error", "SaveDemographicEmail");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= str_replace('Valor', 'Correo', $error[0]) . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
     public function actionList() {
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if ($access) {
            $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            if ($user != null) {

                $filters = array('idCity', 'idDepartment', 'idBusinessAdvisor');

                $criteria = new CDbCriteria();
                $criteria->select = 't.id, t.idUser, t.numberDocument, t.name, t.value, t.city, t.date_close, t.state';
                $join = 'JOIN view_location vl ON t.idCity = vl.idCity';
                $condition = '';


                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

                        if (($key != 'page') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= ($key == 'idCity')? 't.'.$key : $key;
                            $condition .= (($key == 'idState')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
//                if((isset($_GET['idCountry']) && $_GET['idCountry'] != '') || (isset($_GET['idDepartment']) && $_GET['idDepartment'] != '')){
//                    $join .= 'JOIN view_location vl ON t.idCity = vl.idCity';
//                }
//               echo $condition.'<br>';


                if (Yii::app()->user->getState('rol') == 9 && (!isset($_GET['idBusinessAdvisor']))) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idBusinessAdvisor = ' . Yii::app()->user->getId();
                }
                
//                echo $condition;
//               exit;
//                if(){
                  $criteria->join = $join;
//                    
//                }
                $criteria->condition = $condition;

                $criteria->order = "t.value DESC";
                
                $count = ViewBusiness::model()->count($criteria);
                
                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = ViewBusiness::model()->findAll($criteria);
                
                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $businessStates = UsersState::model()->findAll(array('condition' => 'type = 2'));
                $businessAdvisors = ViewBusinessAdvisor::model()->findAll(array('order' => 'name ASC'));
                
                $this->render('business_list', array('model' => $model, 'pages' => $pages, 'countries' => $countries, 'businessStates' => $businessStates, 'businessAdvisors' => $businessAdvisors));
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================

    public function actionSaveSpending() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if (isset($_POST) && $access) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersBusinessSpendings::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new UsersBusinessSpendings;
            }
            $model->setAttributes($_POST);
            $model->idUserSpending = Yii::app()->user->getId();


            $model->support = (CUploadedFile::getInstanceByName('support') != '') ? CUploadedFile::getInstanceByName('support') : $model->support;

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
                    $file_name = $model->idDebtor . "/" . $fname;
                    $obj = new Google_Service_Storage_StorageObject();
                    $obj->setName($file_name);
                    try {
                        $storage->objects->insert(
                                "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $fname), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
                        );
                        $model->support = $configuration['storage']['url'] . $bucket . '/' . $file_name;
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
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/business/partials/item-spending', array('model' => $model), true);
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
    
    public function actionManagementPage() {
        $return = array('status' => 'error',
                'msg' => Yii::t('front', 'Solicitud Invalida'),
                'html' => '',
            );
                
        if(isset($_POST['idUsersBusiness']) && $_POST['idUsersBusiness'] != ''){

            $business = ViewBusiness::model()->find(array('condition' => 'id = '.$_POST['idUsersBusiness']));
            $currentManagementPage = (isset($_POST['page']) && $_POST['page'] != '')? $_POST['page'] : 0 ;
            
            if($business != null){

                $condition = 't.idUsersBusiness ='.$_POST['idUsersBusiness'].' AND t.state = 1 AND t.date <= CURDATE()';

                $criteriaManagement = new CDbCriteria();   
                $criteriaManagement->select = 't.*';


                if(isset($_POST['idTasksAction']) && $_POST['idTasksAction'] != ''){
                   $condition .= ($condition != '') ? ' AND ' : '';
                   $condition .= 't.idTasksAction ='.$_POST['idTasksAction']; 
                }

                if (isset($_POST['from']) && $_POST['from'] != '') {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $to = (isset($_POST['to']) && $_POST['to'] != '') ? ' "' . $_POST['to'] . '"' : ' CURDATE()';
                    $condition .= '(t.date BETWEEN "' . $_POST['from'] . '"  AND' . $to . ')';
                }

                if(isset($_POST['comments']) && $_POST['comments'] != '' ){
                   $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.comments LIKE "%'.$_POST['comments'].'%"'; 
                }
                
                $criteriaManagement->condition = $condition;
                $criteriaManagement->order = 't.date DESC';
                
                $countManagement = ViewManagementBusiness::model()->count($criteriaManagement);
                                
                $pagesManagement = new CPagination($countManagement);
                $pagesManagement->pageSize = $this->pSize;
                $pagesManagement->applyLimit($criteriaManagement);  
                
                
                $criteriaManagement->offset = ($this->pSize * $currentManagementPage);
                $criteriaManagement->limit = $this->pSize;
                
                $managements = ViewManagementBusiness::model()->findAll($criteriaManagement);
                
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    

                foreach ($managements as $management) {
                   $return['table'] .= $this->renderPartial('/business/partials/item-support-task', array('model' => $management), true);
                }               
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pagesManagement,'currentPage' => $currentManagementPage, 'id' => 'management-'.$business->id), true);
                
            }
        }
        
        
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetSupportManagementBusiness() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'html' => '');
        $access = Controller::validAccess($this->access);
        $access = (Yii::app()->user->isGuest)? false : true;
        if (isset($_POST['idTasks']) && $access){                        
            
            $supports = UsersBusinessTasksSupport::model()->findAll(array('condition' => 'idUserBusinessTask ='.$_POST['idTasks']));
            
            if ($supports != null) {
                
                foreach ( $supports as $support){
                    $file = Controller::viewSupport($support->support);
                    $return['html'] .= $this->renderPartial('/business/partials/item-support-management', array('file' => $file), true);                           
                }
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                
            }else{
                $return['msg'] .= Yii::t('front', 'No se econtraron registros');
            }            
        }
        echo CJSON::encode($return);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = 'layout_secure';

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('/site/error', $error);
        }
    }
    

}
