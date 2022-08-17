<?php

class PricingController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================

    public $pSize;

    //=============================================================================================

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'layout_secure';
        parent::init();
        Yii::app()->errorHandler->errorAction = 'wallet/error';
        
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

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }
    
     //=============================================================================================
    public function actionIndex(){
        if (!Yii::app()->user->isGuest) {                             
            $this->render('pricing',array());            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================

    public static function GetDebtorsLegal($condition, $join, $idSate) {
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.id as id, t.idDebtor as idDebtor,t.customer as customer, t.name as name, t.code as code, t.capital as capital, ageDebt as ageDebt, prescription as prescription, vml.date';
        $criteria->condition =  $condition.$idSate;
        if($join != ''){
            $criteria->join =  $join;            
        }
//        $criteria->limit = 10;
//        $criteria->offset = 0;                
        $criteria->order = "t.capital DESC";
        $criteria->group = 't.id';
        $criteria->limit = 325;

        $model = ViewDebtorsLegal::model()->findAll($criteria);
        return $model;
    }
    
    //=============================================================================================
    public static function GetValuesLegal($condition, $join, $idSate) {
        
        $condition = $condition.$idSate;
        $criteria = new CDbCriteria();
        $criteria->select = 'SUM(t.capital) as capital, COUNT(t.id) as cant';        
        
        if (Yii::app()->user->getState('rol') == 7) {
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 't.idCustomer = ' . Yii::app()->user->getId();
        }
        
        if($join != ''){
            $criteria->join .=  $join;            
        }  
                        
        $criteria->condition =  $condition;
                        
        $model = ViewDebtorsLegal::model()->find($criteria);
        
        return $model;
    }
    
    //=============================================================================================


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
    
    //=============================================================================================

    public function actionGetEffects($idAction) {
        $effects = Effects::model()->with('actionsHasEffects')->findAll(array('condition' => 'actionsHasEffects.idAction =' . $idAction));
        $options = "<option value=''>Seleccionar opción</option>";
        foreach ($effects as $effect) {
            $options .= "<option value='" . $effect->idEffect . "'>" . $effect->effectName . "</option>";
        }
        echo $options;
    }
    
    //=============================================================================================

    public function actionSaveInvoice() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
                
        if (isset($_POST)) {
            if(isset($_POST['id']) && $_POST['id'] != ''){
                $model = DebtorsTasks::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            }else{                
                $model = new DebtorsTasks;
            }
            $model->setAttributes($_POST);
            $today = date("Y-m-d");
            $model->idUserAsigned = Yii::app()->user->getId();
            $model->idUserCreated = Yii::app()->user->getId();
            $model->support = CUploadedFile::getInstanceByName('support');
            
            if(($model->date != '' && ($model->date <= $today)) ){
                $model->setScenario('complete');
                $model->state = 1;
            }
            
            if($model->idDebtorState == 1){
                $model->setScenario('agreement');
            }
            
            if($model->idTasksAction == 12){
                $model->setScenario('support');
                if(!$return['newRecord'] && $model->support == null){
                    $support = DebtorsTasksSupport::model()->find(array('condition' => 'idDebtorTask = '.$model->id));
                    $model->support = ($support != null)? $support->support : null;
                }
            } 
                                    
            if ($model->save()) {
                
                if($model->idDebtorState != NULL){ 
                    $model->idDebtor0->idDebtor0->setScenario('updateD');
                    $model->idDebtor0->idDebtor0->idDebtorsState =  $model->idDebtorState; 
                    $model->idDebtor0->idDebtor0->idDebtorSubstate = $model->idDebtorSubstate;
                    
                    if(!$model->idDebtor0->idDebtor0->save()){
                        $return['status'] = 'error';
                        $return['msg'] = 'Verifique los siguientes datos del deudor';
                        Yii::log("Error Agreement", "error", "actionSave");
                        foreach ($model->idDebtor0->idDebtor0->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
//                        print_r($return);
//                        exit;
                    } 
                }
                
                
                if($model->idDebtorState == 1){
                    $agreement = new DebtorsPayments();
                    $agreement->idDebtorObligation = $model->idDebtor;
                    $agreement->idUserPayments = Yii::app()->user->getId();
                    $agreement->idPaymentsType = 7;
                    $agreement->idPaymentsState = 4;
                    $agreement->is_promise = 1;
                    $agreement->value = $model->value;
                    $agreement->datePay = $model->date;
                    
                    
                    if(!$agreement->save()){
                        $return['status'] = 'error';
                        $return['msg'] = '';
                        Yii::log("Error Agreement", "error", "actionSave");
                        foreach ($agreement->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                        print_r($return);
                        exit;
                    } 
                }
                
//                $images = CUploadedFile::getInstanceByName('support');
                
                $file = CUploadedFile::getInstanceByName('support');
                if ($file != '') {
//                    echo 'si'; exit;
                    $img =  new DebtorsTasksSupport();                                
                    $img->idUserSupport = Yii::app()->user->getId();
                    $img->idDebtorTask = $model->id;
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
                    $fname = @Controller::slugUrl($model->id . '-' . Date('d_m_Y_h_i_s_')) . "." . $file->getExtensionName();

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
                    $file_name = $model->id . "/" . $fname;
                    $obj = new Google_Service_Storage_StorageObject();
                    $obj->setName($file_name);
                    try {
                        $storage->objects->insert(
                                "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $fname), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
                        );
                        $img->support = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                        if(!$img->save(false)){
                            $return['status'] = 'error';
                            $return['msg'] = '';
                            Yii::log("Error Pagos", "error", "actionSave");
                            foreach ($model->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                        }                       
                        
                    } catch (Exception $e) {
                        $return['status'] = 'error';
                        $return['msg'] = Yii::t('front', 'No se pudo guardar el soporte');
                    }

                    if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname)) {
                        unlink(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                    }
                }
                
//                echo count($images);
//                $model->delete();
//                exit;
                
            
//                if(isset($images) && count($images) > 0){
//                    foreach ($images as $image => $pic){                                
//
//                        $img =  new DebtorsTasksSupport();                                
//                        $img->idUserSupport = Yii::app()->user->getId();
//                        $img->idDebtorTask = $model->id;
//                        
//                        Yii::import('application.google.google.*');
//                        require_once("protected/google/autoload.php");
//
//                        $configuration = array(
//                            'login' => 'cojunal@cojunal-148320.iam.gserviceaccount.com',
//                            'key' => file_get_contents('assets/cojunal-5498ea4f2a1c.p12'),
//                            'scope' => 'https://www.googleapis.com/auth/devstorage.full_control',
//                            'project' => 'cojunal-148320',
//                            'storage' => array(
//                                'url' => 'https://storage.googleapis.com/',
//                                'prefix' => ''),
//                        );
//                        $bucket = 'cojunal-148320.appspot.com';
//                        Yii::log("GOOGLE => " . sys_get_temp_dir(), "warning", "create");
//
//                        //Upload del archivo
//                        $fname = @Controller::slugUrl($model->id . '-' . Date('d_m_Y_h_i_s_')) . "." . $pic->getExtensionName();
//                        $pic->saveAs(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
//                        
//                        //Subir archivo a bucket
//                        $credentials = new Google_Auth_AssertionCredentials($configuration['login'], $configuration['scope'], $configuration['key']);
//                        $client = new Google_Client();
//                        $client->setAssertionCredentials($credentials);
//                        if ($client->getAuth()->isAccessTokenExpired()) {
//                            $client->getAuth()->refreshTokenWithAssertion();
//                        }
//
//                        # Starting Webmaster Tools Service
//                        $storage = new Google_Service_Storage($client);
//
//                        $uploadDir = 'uploads/';
//                        $file_name = $model->id . "/" . $fname;
//                        $obj = new Google_Service_Storage_StorageObject();
//                        $obj->setName($file_name);
//                        try {
//                            $storage->objects->insert(
//                                    "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $fname), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
//                            );
//                            $img->support = $configuration['storage']['url'] . $bucket . '/' . $file_name;
//                            if(!$img->save(false)){
//                                print_r($img->getErrors());
//                                exit;
//                            }
//                        } catch (Exception $e) {
//                            $return['status'] = 'error';
//                            $return['msg'] = Yii::t('front', 'No se pudo guardar el soporte');
//                        }
//
//                        if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname)) {
//                            unlink(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
//                        }                        
//                        
//                    }
//                }
                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Gestión almacenada exitosamente !.');
                $return['model'] = $model;
                $return['idDebtor'] = $model->idDebtor0->idDebtor;
                //Controller::createNotification($model,2);
                
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
    
    public function actionSaveCall() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida') ;
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;
        
        if (isset($_POST)) {
            if(isset($_POST['id']) && $_POST['id'] != ''){
                $model = DebtorsTasks::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            }else{                
                $model = new DebtorsTasks;
            }
            $model->setAttributes($_POST);
            $model->setScenario('call');
            $model->idUserAsigned = Yii::app()->user->getId();
            $model->idUserCreated = Yii::app()->user->getId();
            $model->support = $_POST['callInfo'];
            $model->date = date("Y-m-d");            
            $model->state = 1;
            $model->idTasksAction = 1;
            
            if(!$return['newRecord'] && $model->support == null){
                $support = DebtorsTasksSupport::model()->find(array('condition' => 'idDebtorTask = '.$model->id));
                $model->support = ($support != null)? $support->support : null;
            }
                                    
            if ($model->save()) {
                
                if($model->idDebtorState != NULL){ 
                    $model->idDebtor0->idDebtor0->setScenario('updateD');
                    $model->idDebtor0->idDebtor0->idDebtorsState =  $model->idDebtorState; 
                    $model->idDebtor0->idDebtor0->idDebtorSubstate = $model->idDebtorSubstate;
                    
                    if(!$model->idDebtor0->idDebtor0->save()){
                        $return['status'] = 'error';
                        $return['msg'] = 'Verifique los siguientes datos del deudor';
                        Yii::log("Error Agreement", "error", "actionSave");
                        foreach ($model->idDebtor0->idDebtor0->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
//                        print_r($return);
//                        exit;
                    } 
                }
                
                if ($model->support != '') {
                    $img =  new DebtorsTasksSupport();                                
                    $img->idUserSupport = Yii::app()->user->getId();
                    $img->idDebtorTask = $model->id;
                    
                    $img->support = $model->support;
                    if(!$img->save(false)){
                        $return['status'] = 'error';
                        $return['msg'] = '';
                        Yii::log("Error Support", "error", "actionSave");
                        foreach ($model->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }
                }
                                
                if($model->idDebtorState == 1){
                    $agreement = new DebtorsPayments();
                    $agreement->idDebtorObligation = $model->idDebtor;
                    $agreement->idUserPayments = Yii::app()->user->getId();
                    $agreement->idPaymentsType = 7;
                    $agreement->idPaymentsState = 4;
                    $agreement->is_promise = 1;
                    $agreement->value = $model->value;
                    $agreement->datePay = $model->date;                    
                    
                    if(!$agreement->save()){
                        $return['status'] = 'error';
                        $return['msg'] = '';
                        Yii::log("Error Agreement", "error", "actionSave");
                        foreach ($agreement->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                        print_r($return);
                        exit;
                    } 
                }
                
//                $images = CUploadedFile::getInstanceByName('support');
                               
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Gestión almacenada exitosamente !.');
                $return['model'] = $model;
                $return['idDebtor'] = $model->idDebtor0->idDebtor;
                $management = ViewManagement::model()->find(array('condition' => 'id ='.$model->id));
                $return['html'] = $this->renderPartial('/wallet/partials/item-support-task', array('model' => $management), true);
                
                //Controller::createNotification($model,2);
                
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

    public function actionSavePayment() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'type' => '', 'newRecord' => true);        
        
        if (isset($_POST) && !Yii::app()->user->isGuest) {
            
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsPayments::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsPayments;
            }

            $model->setAttributes($_POST);
            if($return['newRecord']){
                $model->idUserPayments = Yii::app()->user->getId();                
            }

            if ($model->idPaymentsState == 5) {
                $model->setScenario('validacion');
            } elseif ($model->idPaymentsState == 6) {
                $model->setScenario('validado');
            }
            
            $model->is_promise = ($model->idPaymentsState == 4)? 1 : 0;

            $model->supportPayments = (CUploadedFile::getInstanceByName('supportPayments') != '') ? CUploadedFile::getInstanceByName('supportPayments') : $model->supportPayments;
          
            if ($model->save()) {

                $file = CUploadedFile::getInstanceByName('supportPayments');
                if ($file != '') {
//                    echo 'si'; exit;
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
                    $fname = @Controller::slugUrl($model->id . '-' . Date('d_m_Y_h_i_s_')) . "." . $file->getExtensionName();

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
                    $file_name = $model->id . "/" . $fname;
                    $obj = new Google_Service_Storage_StorageObject();
                    $obj->setName($file_name);
                    try {
                        $storage->objects->insert(
                                "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $fname), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
                        );
                        $model->supportPayments = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                        if(!$model->save(false)){
                            $return['status'] = 'error';
                            $return['msg'] = '';
                            Yii::log("Error Pagos", "error", "actionSave");
                            foreach ($model->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                        }                       
                        
                    } catch (Exception $e) {
                        $return['status'] = 'error';
                        $return['msg'] = Yii::t('front', 'No se pudo guardar el soporte');
                    }

                    if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname)) {
                        unlink(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                    }
                }
                $edit = (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers']))? true : false;
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                $return['model'] = $model;
                $return['type'] = ($model->idPaymentsState == 4)? 'Agreements' : 'Payments';
                $return['html'] = $this->renderPartial('/wallet/partials/item-'.mb_strtolower($return['type']), array('model' => $model,'edit' => $edit), true);
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Pagos", "error", "actionSave");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================

    public function actionSaveSpending() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsSpendings::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsSpendings;
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
                $return['html'] = $this->renderPartial('/wallet/partials/item-spending', array('model' => $model), true);
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
    
    public function actionSaveComment() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsComments::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsComments;
            }
            $model->setAttributes($_POST);
            $model->idUserComment = Yii::app()->user->getId();
            
            if ($model->save()) {
                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/wallet/partials/item-comment', array('model' => $model), true);
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
    
    public function actionSaveProperty() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsProperty::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsProperty;
            }
            $model->setAttributes($_POST);
            $model->idUserProperty = Yii::app()->user->getId();
            $model->support = (CUploadedFile::getInstanceByName('support') != '')? CUploadedFile::getInstanceByName('support') : $model->support;
            
            if ($model->save()) {
                
                if(CUploadedFile::getInstanceByName('support') != ''){
                    $upload = Controller::uploadFile($model->support,'supports',$model->idDebtor,'/uploads/');
                    $model->support = ($upload)? $upload['filename']:  $model->support_bank;   
                    if(!$customerInfo->save(false)){
                        print_r($customerInfo->getErrors());
                        exit;
                    }
                }
                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/wallet/partials/item-property', array('model' => $model), true);
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
    
    public function actionSaveSupport() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsSupports::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsSupports;
            }
            $model->setAttributes($_POST);
            $model->idUserSupport = Yii::app()->user->getId();


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
                $return['html'] = $this->renderPartial('/wallet/partials/item-support', array('model' => $model), true);
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

    public function actionDelete() {
        Yii::log("Entre Delete", "error", "actionSave");
        $idSupport = $_REQUEST['idSupport'];

        //Instancia Support
        //$model = Supports::model()->deleteByPk($idSupport);

        $transaction = Yii::app()->db->beginTransaction();

        try {

            if (!$model = Supports::model()->deleteByPk($idSupport)) {
                Yii::log("Error Support", "error", "actionSave");
            }

            $transaction->commit();
            Yii::app()->user->setFlash('success', "Soporte Eliminado Con exito");
        } catch (Exception $e) {
            Yii::log($e->getMessage(), "error", "actionDelete");
            $transaction->rollBack();
            Yii::app()->user->setFlash('error', "{$e->getMessage()}");
            print_r($e->getMessage());
            die();
            //$this->refresh();
        }
    }
    
    //=============================================================================================

    public function actionSaveInfo() {
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $infoName = $_REQUEST['infoName'];
        $infoId = $_REQUEST['infoId'];
        $infoAddress = $_REQUEST['infoAddress'];
        $infoDistricts = $_REQUEST['infoDistricts'];
        $infoPhone = $_REQUEST['infoPhone'];
        $infoEmail = $_REQUEST['infoEmail'];

        $date = new Datetime();

        $model = Wallets::model()->findByPk($idWallet);
        $model->legalName = $infoName;
        $model->idNumber = $infoId;
        $model->address = $infoAddress;
        $model->phone = $infoPhone;
        $model->email = $infoEmail;
        $model->idDistrict = $infoDistricts;
        $model->idAdviser = $idAdviser;
        $model->dUpdate = $date->format('Y-m-d H:i:s');

        if (!$model->save()) {
            Yii::log("Error Wallet", "error", "actionSave");
        } else {
            Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
        }
    }
    
    //=============================================================================================
    
    public function actionSaveDemographicPhone() {

        $return = array('status' => 'error','msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
        
        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsPhones::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsPhones;
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
                $return['html'] = $this->renderPartial('/wallet/partials/item-phone', array('model' => $model), true);
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error telefono deudor", "error", "SaveDemographicPhone");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= str_replace('Valor', 'Número', $error[0]) . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================

    public function actionSaveDemographicReference() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsReference::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsReference;
            }
            $model->setAttributes($_POST);
            $model->idUserReference = Yii::app()->user->getId();
            
            if ($model->save()) {
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Referencia guardada exitosamente !.');
                $return['model'] = $model;
                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $genders = Genders::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $occupations = Occupations::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $maritalStates = MaritalStates::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $return['html'] = $this->renderPartial('/wallet/partials/item-reference-block', array(
                    'model' => $model,
                    'countries' => $countries,
                    'genders' => $genders,
                    'occupations' => $occupations,
                    'maritalStates' => $maritalStates,
                        ), true);
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error referencia deudor", "error", "saveDemographicReference");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= str_replace('Valor', 'Nombre', $error[0]) . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionSaveDemographicContact() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;
              

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsContacts::model()->findByPk($_POST['id']);
                $modelDemo = DebtorsContactsDemographics::model()->find(array("condition"=>"idDebtorContact = ".$_POST['id']));
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsContacts();
                $modelDemo = new DebtorsContactsDemographics();
            }
            $model->setAttributes($_POST);
            $modelDemo->setAttributes($_POST);
            $model->idUserCreated = Yii::app()->user->getId();
            
            if ($model->save()) {
                $modelDemo->idDebtorContact = $model->id;
                if ($modelDemo->save()){
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Registro guardado exitosamente !.');
                    $return['model'] = $model;
                    $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                    $genders = Genders::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                    $occupations = Occupations::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                    $maritalStates = MaritalStates::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                    $educationLevels = TypeEducationLevels::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                    $typeHousings = TypeHousing::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                    $typeContracts = TypeContract::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                    $location = array(
                        'idCountry'=>$model->idCountry,
                        'idDepartment'=>$model->idDepartment,
                        'idCity'=>$model->idCity);
                    $return['location'] = $location;
                    $return['html'] = $this->renderPartial('/wallet/partials/item-contact-block', array(
                        'model' => $model,
                        'debt' => null,
                        'countries' => $countries,
                        'typeDebtorContact' => $model->idTypeDebtorContact,
                        'genders' => $genders,
                        'occupations' => $occupations,
                        'maritalStates' => $maritalStates,
                        'educationLevels' => $educationLevels,
                        'typeHousings' => $typeHousings,
                        'typeContracts' => $typeContracts
                            ), true);
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    Yii::log("Error al guardar información", "error", "saveDemographicContact");
                    foreach ($modelDemo->getErrors() as $error) {
                        $return['msg'] .= str_replace('Valor', 'Nombre', $error[0]) . "<br/>";
                    }
                }
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error al guardar información", "error", "saveDemographicContact");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= str_replace('Valor', 'Nombre', $error[0]) . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================

    public function actionSaveDemographicEmail() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

       if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsEmails::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsEmails;
            }
            $model->setAttributes($_POST);
            $model->idUserEmail = Yii::app()->user->getId();
            
            if ($model->save()) {
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guardada exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/wallet/partials/item-email', array('model' => $model), true);
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

    public function actionSaveDemographicAddress() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

         if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = DebtorsAddresses::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsAddresses;
            }
            $model->setAttributes($_POST);
            $model->idUserAddress = Yii::app()->user->getId();
            
            if ($model->save()) {
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guardado exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/wallet/partials/item-address', array('model' => $model), true);
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error direccion deudor", "error", "saveDemographicAddress");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= str_replace('Valor', 'Dirección', $error[0]) . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================

    public function actionDeleteDemographic() {

        $return = array();
        $return['status'] = 'error';
        $return['msg'] = 'Solicitud Invalida';
        $return['data'] = '';

        if (isset($_POST['idDemographic']) && $_POST['idDemographic'] != '') {

            $model = Demographics::model()->findByPk($_POST['idDemographic']);

            if ($model->delete()) {
                $return['status'] = 'success';
                $return['msg'] = 'Registro eliminado con éxito';
                $return['model'] = $model;
            } else {
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("No Entra Delete:", "error", "Delete");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }

        echo CJSON::encode($return);
    }

    public function actionUpdateComment() {
        $idComment = $_REQUEST['idComment'];
        $model = Comments::model()->findByPk($idComment);
        if ($model->status) {
            Yii::app()->user->setFlash('error', "El comentario ya fué atendido y no se puede cambiar su etado");
        } else {
            $model->status = true;
            if (!$model->save()) {
                Yii::log("Error Campaign", "error", "actionSaveComment");
            } else {
                Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
            }
        }
    }

    public function actionStateLegalDebtor() {

        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');

        if (isset($_POST['id'], $_POST['idDebtorsState']) && !Yii::app()->user->isGuest){
                     
            if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['admin'],Yii::app()->params['advisers']))){
                
                $criteria = new CDbCriteria();
                $condition = '';
        
                if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
       //            $criteria->join = ' JOIN tbl_campaigns c ON t.idCustomer = c.idCustomer  JOIN tbl_campaigns_debtors cb ON cb.idDebtor = t.idDebtor';
       //            $condition .= ($condition != '') ? ' AND ' : '';
       //            $condition .= ' c.idCoordinator = ';
       //            $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
               }

                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idDebtorsState NOT IN (6,7,11) AND is_legal = 1 AND id = '.$_POST['id'];
                $criteria->condition = $condition;
                
                $state = DebtorsState::model()->find(array('condition' => 'id ='.$_POST['idDebtorsState'].' AND active = 1'));                               
                $model = Debtors::model()->find($criteria);
                
                if(($model != null && $state != null)){
                    
                    if($state->order >= $model->idDebtorsState0->order){
                        
                        $model->setAttributes($_POST); 
                        $model->idDebtorSubstate = NULL;
                        
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
                    }else{
                        $return['msg'] = Yii::t('front', 'No se puede realizar el cambio de estado');
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
    
    public function actionStateWallet() {

        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['data'] = '';
        $date = new Datetime();

        if (isset($_POST['idDebtor'], $_POST['idState']) && $_POST['idDebtor'] != '' && $_POST['idState'] != '') {

            $model = Debtors::model()->findByPk($_POST['idDebtor']);

            if ($model != null) {
                $model->idDebtorsState = $_POST['idState'];
                
                if ($model->save(false)){
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front','Estado actualizado con éxito');
                    $return['model'] = $model;
                } else {
                    $return['msg'] = '';
                    Yii::log($e->getMessage(), "error", "actionDelete");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            } else {
                $return['msg'] = 'Deudor no encontrado !.';
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionOfficeLegalDebtor() {

        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');

        if (isset($_POST['id']) && !Yii::app()->user->isGuest){
                     
            //if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['admin'],Yii::app()->params['advisers']))){
                
                $criteria = new CDbCriteria();
                $condition = '';
        
                if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
       //            $criteria->join = ' JOIN tbl_campaigns c ON t.idCustomer = c.idCustomer  JOIN tbl_campaigns_debtors cb ON cb.idDebtor = t.idDebtor';
       //            $condition .= ($condition != '') ? ' AND ' : '';
       //            $condition .= ' c.idCoordinator = ';
       //            $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
               }

                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' id = '.$_POST['id'];
                $criteria->condition = $condition;
                
                $model = DebtorsObligations::model()->find($criteria);
                
                if($model != null){
                    
                    $model->setAttributes($_POST);                    
                    
                    if($model->save(false)){
                        $return['status'] = 'success';
                        $return['msg'] = Yii::t('front', 'Información actualizado con éxito');
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
//            }else{
//                $return['msg'] = Yii::t('front', 'No tiene permisos para realizar esta acción');                
//            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetSubstate() {

        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['data'] = '';

        if (isset($_POST['idState']) && $_POST['idState'] != '') {
            
            $nodes = Yii::app()->db->createCommand("select  id, name, idDebtorsState AS parent from  (select * from tbl_debtors_state where active = 1 order by idDebtorsState, id) tbl_debtors_state,(select @pv := ".$_POST['idState'].") initialisation where   find_in_set(idDebtorsState, @pv) > 0 and @pv := concat(@pv, ',', id)")->queryAll();
            $tree = Controller::buildTree($nodes,$_POST['idState']);
                        
            $return['html'] = '<select id="debtorObligations-idDebtorSubState" class="debtorObligations-idDebtorSubState" name="idDebtorSubstate">';            
            $return['html'] .= '<option value="" enabled="true">'.Yii::t('front', 'NINGUNO').'</option>';            
            $return['html'] .= Controller::printTree($tree, 1, null, '');            
            $return['html'] .= '</select>';            
            $return['status'] = 'success';
            $return['msg'] = Yii::t('front','Estado actualizado con éxito');
            
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionUpdateDebtor() {

        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['data'] = '';
        

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            $model = Debtors::model()->findByPk($_POST['idDebtor']);
            
            if ($model != null){
                $model->setAttributes($_POST);
                $model->setScenario('updateD');
                
                if ($model->save(false)){
                    $count = DebtorsDemographics::model()->count(array("condition"=>"idDebtor = ".$model->id));
                    if($count > 0){
                        $modelDemo = DebtorsDemographics::model()->find(array("condition"=>"idDebtor = ".$model->id));
                    }else{
                        $modelDemo = new DebtorsDemographics();
                    }
                    $modelDemo->setAttributes($_POST);
                    if($modelDemo->save()){
                        $return['status'] = 'success';
                        $return['msg'] = Yii::t('front','Datos actualizados con éxito');
                        $return['model'] = $model;
                    }else{
                        $return['msg'] = '';
                        foreach ($modelDemo->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }

                } else {
                    $return['msg'] = '';
                    Yii::log($e->getMessage(), "error", "actionDelete");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            } else {
                $return['msg'] = 'Deudor no encontrado !.';
            }
        }

        echo CJSON::encode($return);
    }
        
    //=============================================================================================
    public function actionGetMoreManagementDebtor() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
                
        if (isset($_POST['idDebtor'],$_POST['idUserAsigned']) && !Yii::app()->user->isGuest){
                        
            
            $managements = ViewManagement::model()->findAll(array('condition' => 'idDebtor ='.$_POST['idDebtor'].' AND idUserAsigned='.$_POST['idUserAsigned']));
            
            if ($managements != null) {
                
                $return['html'] = $this->renderPartial('/wallet/more-management-debtor', array('managements' => $managements), true);       
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                
            }else{
                    
                $return['msg'] .= Yii::t('front', 'No se econtraron registros');

            }
            
        }
        

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionGetSupportManagementDebtor() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
                
        if (isset($_POST['idTasks']) && !Yii::app()->user->isGuest){                        
            
            $supports = DebtorsTasksSupport::model()->findAll(array('condition' => 'idDebtorTask ='.$_POST['idTasks']));
            
            if ($supports != null) {
                
                foreach ( $supports as $support){
//                    if($support->idDebtorTask0->idTasksAction == 1){
//                        $return['html'] = $this->renderPartial('/wallet/partials/item-support-management-call', array('model' => $support), true);                                                   
//                    }else{                        
                        $file = Controller::viewSupport($support->support);
                        $return['html'] .= $this->renderPartial('/wallet/partials/item-support-management', array('file' => $file), true);                           
                    //}
                }
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                
            }else{
                    
                $return['msg'] .= Yii::t('front', 'No se econtraron registros');

            }
            
        }
        

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionGetDebtorObligation() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
                
        if (isset($_POST['id']) && !Yii::app()->user->isGuest){                        
            
            $model = DebtorsObligations::model()->findByPk($_POST['id']);
            
            if ($model != null) {
                
                $return['html'] .= $this->renderPartial('/wallet/partials/form-debtor-obligation', array('model' => $model), true);                           
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                
            }else{
                    
                $return['msg'] .= Yii::t('front', 'No se econtraron registros');

            }
            
        }
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionGetDebtorMarker() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'model' => '',
            );
                
        if (isset($_POST['id']) && !Yii::app()->user->isGuest){                        
            
            $model = Debtors::model()->findByPk($_POST['id']);
            
            if ($model != null && ($model->address_lat != '' && $model->address_lng != '')) {
                                
                $return['status'] = 'success';
                $return['model'] = $model;
                $return['msg'] = Yii::t('front', 'Marker!.');
                
            }else{
                    
                $return['msg'] .= Yii::t('front', 'No se econtraron registros');

            }
            
        }
        

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetChartModel() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'html' => '',
            );
                
        if (isset($_POST['id']) && !Yii::app()->user->isGuest){                        
            $return['status'] = 'success';
            $return['msg'] = 'ok';
            $return['html'] = $this->renderPartial('/wallet/partials/item-model-chart', array('id' => $_POST['id']), true);        
        }
        

        echo CJSON::encode($return);
    }


}
