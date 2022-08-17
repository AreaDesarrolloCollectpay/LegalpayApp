<?php

class CustomersController extends Controller {

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
        $this->access = array(1,11,2,5,7);
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
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            $filters = array('idProfile', 'name', 'numberDocument', 'userName', 'email', 'location', 'phone', 'address', 'idState','active');
            $coordinators = implode(',', Yii::app()->params['customers']);
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
            
            $criteria = new CDbCriteria();
            $join = ' JOIN tbl_users tu ON t.id = tu.id';
            $criteriaT = new CDbCriteria();
            $condition = '';


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
                        
            if(Yii::app()->user->getState('rol') == 11) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();                    
            } elseif ((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers']))) {
                if ($user != null) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCompany = ' . $user->idCompany; 
                }
            }

            $criteria->condition = $condition;
            $criteriaT->condition = $condition;
            $criteria->join = $join;
            $criteriaT->join = $join;
            $criteria->order = "t.id DESC";
            
            $criteriaT->select = 'SUM(t.capital) as capital, SUM(t.interest) as interest, SUM(t.payments) as payments, SUM(t.estimated) as estimated, SUM(t.pending) as pending';
            
            $total = ViewCustomers::model()->find($criteriaT);

            $count = ViewCustomers::model()->count($criteria);           

            $pages = new CPagination($count);

            $pages->pageSize = $this->pSize;
            $pages->applyLimit($criteria);
            
            $model = ViewCustomers::model()->findAll($criteria);
            
            $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
            $cProfiles  =   UsersProfile::model()->findAll(array('condition' => 'id IN ('.$coordinators.') AND active = 1' , 'order' => 'name ASC'));
            $states     =   UsersState::model()->findAll(array('condition' => 'type = 1 AND active = 1' , 'order' => 'name ASC'));
            $typeDocument = TypeDocuments::model()->findAll();
            
            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
            
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                $return['table'] = $this->renderPartial('/customers/partials/content-customers-table', array('model' => $model), true);
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                echo CJSON::encode($return);
                Yii::app()->end();
            }else{
                $this->render('customers',array(
                    'model' => $model,
                    'pages' => $pages,
                    'currentPage' => $currentPage,
                    'countries' =>  $countries,
                    'cProfiles' => $cProfiles,
                    'states'    => $states,
                    'typeDocument'    => $typeDocument,
                    'total'    => $total,
                        ));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    public function actionUpdateCustomers() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
            if (isset($_REQUEST) && $user != null) {
                $model = new Customers; 
                $model->setAttributes($_REQUEST);
                $model->is_internal = 0;
                $model->support_bank = (CUploadedFile::getInstanceByName('support_bank') != '')? CUploadedFile::getInstanceByName('support_bank') : $model->support_bank;
                $model->userName = Controller::slugUrl($model->name);
                
                if ($model->validate()) {
                    
                    if((isset($_REQUEST['id']) && $_REQUEST['id'] != '')){
                        $customers = Users::model()->findByPk($_REQUEST['id']);
                        $return['newRecord'] = false;    
                    }else{
                        $customers = new Users;
                    }
                    
                    $customers->setAttributes($_REQUEST);
                    $customers->is_internal = 0;
                    $customers->userName = Controller::slugUrl($customers->name);
                                        
                    if($return['newRecord']){
                        $password = Controller::creaPassword();
                        $customers->password = md5($password);
                        $customers->image = 'https://storage.googleapis.com/cojunal-148320.appspot.com/12/12-12032019055142.PNG';
                        $customers->active = 1;
                        $customers->idUserCreator = Yii::app()->user->getId();
                        $customers->idCompany = ($user->idCompany != '')? $user->idCompany : Yii::app()->user->getId();
                    }
                    
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
                                if($model->notification == 1){
                                    $htmlEmail = $this->renderPartial('/email/mail-create-user', array('model' => $model, 'password' => $password), true);
                                    $subject = Yii::t('front','Nueva Cuenta');                                    
                                    Controller::SendGridMail($model->email,$model->name, $subject, $htmlEmail);                                
                                }

                            }else{
                                $return['msg'] = Yii::t('front', 'Error asignando perfil !. ');
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
    public function actionGetCustomer() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'customer_info' => '', 'location' => '','profile' => '');
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = Users::model()->findByPk($_POST['id']);
                if($model != null){
                    $return['status'] = 'success';
                    $return['model'] = $model;
                    $return['location'] = ($model->idCity != '')? ViewLocation::model()->find(array('condition' => 'idCity ='.$model->idCity)) : '';
                    $return['customer_info'] = UsersInfo::model()->find(array('condition' => 'idUser ='.$model->id));
                    $return['profile'] = ViewUsers::model()->find(array('condition' => 'id ='.$model->id));
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
    
    public function actionChangeStateUser() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id'],$_POST['state']) && $_POST['id'] != '' && $_POST['state'] != '') {

                $model = Users::model()->findByPk($_POST['id']);
                
                if($model != null){
                    $model->idUserState = $_POST['state'];
                    
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
    public function actionReferrals() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access) && (isset($_GET['id']) && $_GET['id'] != '')) {
            $user = ViewUsers::model()->find(array('condition' => 'id = '.$_GET['id'].' AND idProfile = 17'));
            if($user != NULL){
                
                $filters = array('idProfile', 'name', 'userName', 'email', 'location', 'phone', 'address', 'idState');
                $coordinators = implode(',', Yii::app()->params['customers']);
                
                $criteria = new CDbCriteria();
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
                
                $condition .= ($condition != '')? ' AND' : '';
                $condition .= 'idCostumer = '.$user->id;
                
                $criteria->condition = $condition;
                $criteria->order = "name";

                $count = 0; 
//                ViewCustomers::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = 20;
                $pages->applyLimit($criteria);

                $model = array();
//                        ViewCustomers::model()->findAll($criteria);

                $countries  =   Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
                $cProfiles  =   UsersProfile::model()->findAll(array('condition' => 'id IN ('.$coordinators.') AND active = 1' , 'order' => 'name ASC'));
                $states     =   UsersState::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC'));
                $typeDocument = TypeDocuments::model()->findAll();
                                
                $this->render('referrals',array(
                    'model' => $model,
                    'pages' => $pages,
                    'countries' =>  $countries,
                    'cProfiles' => $cProfiles,
                    'states'    => $states,
                    'typeDocument'    => $typeDocument,
                        ));
                
            }else{
                throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
            }           
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    public function actionContacts() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access) && (isset($_GET['id']) && $_GET['id'] != '')) {
            $user = ViewUsers::model()->find(array('condition' => 'id = '.$_GET['id'].' AND idProfile IN (2,5,17)'));            
            if($user != NULL){                
                $criteria = new CDbCriteria();
                $condition = '';            
                $filters = array('name','phone','email');
                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {
                        if ($value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'id' && $key != 'idCity' ))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                            $i++;
                        }
                    }
                    $condition .= ($condition != '') ? ')' : '';
                }
                
                $condition .= ($condition != '')? ' AND' : '';
                $condition .= ' idUser = '.$user->id;
                $criteria->condition = $condition;
                $criteria->order = "dateCreated DESC";
                $count = UsersContacts::model()->count($criteria);           
                $pages = new CPagination($count);
                $pages->pageSize = 20;
                $pages->applyLimit($criteria);
                $model = UsersContacts::model()->findAll($criteria);
                $countries = Countries::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC')); 
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

                $this->render('contacts',array(
                   'model' => $model,
                   'pages' => $pages,
                   'countries' => $countries,
                   'idUser' => $user->id,
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
    public function actionUpdateContacts() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersContacts::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new UsersContacts;
            }
            $model->setAttributes($_POST);
            $model->idUser = $_POST['idUser'];

            if ($model->save()) {
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                /*$return['model'] = $model;
                $return['html'] = $this->renderPartial('/customers/partials/item-contracts', array('model' => $model), true);*/
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Contacts", "error", "actionSave");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
     //=============================================================================================
    public function actionGetContacts() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['location'] = '';
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {

                $model = UsersContacts::model()->findByPk($_POST['id']);
                if($model != null){
                    $return['location'] = ($model->idCity != '')? ViewLocation::model()->find(array('condition' => 'idCity ='.$model->idCity)) : '';
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

    public function actionExportCustomer() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_customers_" . Date('d_m_Y_h_i_s') . ".csv";


            $filters = array('idProfile', 'name', 'numberDocument', 'userName', 'email', 'location', 'phone', 'address', 'idState');            
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

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';


            $sql = 'SELECT 
                       \'Nombre / Razon Social\',\'CC / NIT \',\'Email\',\'Telefono\',\'Direccion\',\'Contacto\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(t.name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(t.numberDocument , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(tu.email , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(tu.phone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(tu.address , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(t.contact , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \')                                           
                       FROM view_customers t
                       JOIN tbl_users tu ON t.id = tu.id 
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
    
}
