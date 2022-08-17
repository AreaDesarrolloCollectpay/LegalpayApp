<?php

class DashboardController extends Controller {

     public $access;
     
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
        $this->access = array_merge(Yii::app()->params['admin'],Yii::app()->params['coordinators'], Yii::app()->params['customers'], Yii::app()->params['companies']);
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
    
    //============================================================================================
    
    public function actionIndex() {
//        echo ('Admin' != 'Admin')? 'si' : 'no';
//        exit;
//        print_r(Yii::app()->user->getState('rol'));
//        echo '<br>';
//        print_r(Yii::app()->user->getState('idPlan'));
//        echo '<br>idPlan';
//        print_r(Yii::app()->user->getState('call'));
//        echo '<br>';
//        print_r(Yii::app()->user->getState('sms'));
//        echo '<br>';
//        print_r(Yii::app()->user->getState('email'));
//        echo '<br>';
//        print_r(Yii::app()->user->getState('ml'));
//        echo '<br>';
//        print_r(Yii::app()->user->getId());
//        2
//1
//idPlan0
//0
//0
//0
//531
//        
//        exit;
        if (!Yii::app()->user->isGuest){ 
            
            if(in_array(Yii::app()->user->getState('rol'), $this->access)){                
                $indicators = NULL;
                $criteria = new CDbCriteria();
                $criteria->select = 't.*';
                $criteria->limit = 3;
                $mlModels = Mlmodels::model()->findAll($criteria);
                $countModels = count($mlModels);                
                $this->render('dashboard',array('mlModels' => $mlModels,'countModels' => $countModels,  'indicators' => $indicators));
                
            }else{
                $this->redirect(Yii::app()->homeUrl);   
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
        
    }
    
    //=============================================================================================
    public function actionIndex_() {
        
        if (!Yii::app()->user->isGuest){ 
            
            if(in_array(Yii::app()->user->getState('rol'), $this->access)){
                
                $indicators = NULL;

                $regions = Regions::model()->findAll();

                $this->render('dashboard',array('regions' => $regions, 'indicators' => $indicators));

            }else{
                $this->redirect(Yii::app()->homeUrl);   
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
        
    }
    
    //=============================================================================================
    public function actionQuadrants() {
                        
        if (!Yii::app()->user->isGuest){ 
            
            if(in_array(Yii::app()->user->getState('rol'), $this->access)){
                
//                if(isset($_GET['id'])){    
                    $indicators = NULL;
                    $ageDebts = AgeDebt::model()->findAll(array('limit' => 4));
                    $this->render('dashboard_quadrants',array('id' => 0,'ageDebts' => $ageDebts, 'indicators' => $indicators));

//                }else{
//                    throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
//                }
            }else{
                $this->redirect(Yii::app()->homeUrl);   
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionRegion() {
                        
        if (!Yii::app()->user->isGuest){ 
            
            if(in_array(Yii::app()->user->getState('rol'), $this->access)){
                
                if(isset($_GET['id'])){    
                    $indicators = NULL;

                    $ageDebts = AgeDebt::model()->findAll();

                    $this->render('dashboard_quadrants',array('id' => $_GET['id'],'ageDebts' => $ageDebts, 'indicators' => $indicators));

                }else{
                    throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
                }
            }else{
                $this->redirect(Yii::app()->homeUrl);   
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    public function actionJuridico() {
        if (!Yii::app()->user->isGuest) {
            
            $legalStates = DebtorsState::model()->findAll(array('condition' => 'is_legal = 1 AND idDebtorsState IS NULL'));
            
            $this->render('juridico',array('legalStates' => $legalStates));
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //=============================================================================================
     public function actionProfile() {
        if (!Yii::app()->user->isGuest) {
            $model = Users::model()->findByPk(Yii::app()->user->getId());
            $render = '';            
            if($model != null){
                $typeDocuments = TypeDocuments::model()->findAll(array('order' => 'name ASC'));
                $countries = Countries::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));
                if(!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])){
                    $render = '/profile/profile';
                }else{
                    $render = '/profile/profile-customers';
                }
                $this->render($render, array(
                    'model' => $model,
                    'typeDocuments' => $typeDocuments,
                    'countries' => $countries
                        ));                
            }else{
                
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //=============================================================================================
    public function actionUpdateUser() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (!Yii::app()->user->isGuest) {

            if (isset($_POST)) {

                $model = Users::model()->findByPk(Yii::app()->user->getId());
                $return['newRecord'] = false;

                $model->setAttributes($_POST);

                if ($model->newPassword != '' || $model->confirmPassword != '') {
                    $model->setScenario('changePass');
                }

                $model->image = (CUploadedFile::getInstanceByName('image') != '')? CUploadedFile::getInstanceByName('image') : $model->image;

                if ($model->validate()) {

                    if ($model->newPassword != '' && $model->confirmPassword != '') {
                        $model->password = md5($model->newPassword);
                    }
                    $model->save(false);
                    
                    $file = CUploadedFile::getInstanceByName('image');
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
                            $model->image = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                            $model->save(false);
                        } catch (Exception $e) {
                            $return['status'] = 'error';
                            $return['msg'] = 'No se pudo guardar el soporte';
                        }

                        if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname)) {
                            unlink(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                        }
                    }
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                    $return['model'] = $model;
                    Yii::app()->user->setState('title', $model->name);
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
    public function actionUpdateCustomer() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (!Yii::app()->user->isGuest) {

            if (isset($_POST)) {                               

                $model = Users::model()->findByPk(Yii::app()->user->getId());
                $return['newRecord'] = false;

                $model->setAttributes($_POST);

                if ($model->newPassword != '' || $model->confirmPassword != '') {
                    $model->setScenario('changePass');
                }

                $model->image = (CUploadedFile::getInstanceByName('image') != '')? CUploadedFile::getInstanceByName('image') : $model->image;
                
                if ($model->validate()) {

                    if ($model->newPassword != '' && $model->confirmPassword != '') {
                        $model->password = md5($model->newPassword);
                    }
                    $model->save(false);
                    
                    $file = CUploadedFile::getInstanceByName('image');
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
                            $model->image = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                            $model->save(false);
                        } catch (Exception $e) {
                            $return['status'] = 'error';
                            $return['msg'] = 'No se pudo guardar el soporte';
                        }

                        if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname)) {
                            unlink(Yii::getPathOfAlias("webroot") . "/uploads/" . $fname);
                        }
                        
                    }
                    
                    if ($model->usersInfos == null) {
                        $customerInfo = new UsersInfo;
                    } else {
                        $customerInfo = UsersInfo::model()->find(array('condition' => 'idUser =' . $model->id));
                    }
                    $customerInfo->setAttributes($_POST);
                    $customerInfo->idUser = $model->id;

                    if (!$customerInfo->save()) {
                        $return['msg'] = Yii::t('front', 'Error asigando información !. ');
                        foreach ($customerInfo->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                        print_r($return['msg']);
                        exit;
                    }

                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                    $return['model'] = $model;
                    Yii::app()->user->setState('title', $model->name);
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

    public function actionTest() {
        //dsYii::app()->getComponent('booster'); 
        $model = new Users('search');
        $model->unsetAttributes();
        if (isset($_GET['Users'])) {
            $model->setAttributes($_GET['Users']);
        }
        $this->render('test', array('model' => $model));
    }

}
