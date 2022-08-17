<?php

class SiteController extends Controller {

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'layout_secure';
        $this->isLogin = true;
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
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
    
     public function actionBigml(){
         
         require_once 'protected/extensions/bigml/Machinebigml.php';   
         
         $api = new BigML\BigML([ "username" => "desarrollo",
                        "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                        "project" => "project/5cb08b756997fa1812000772"
             ]);         
//     print_r($api->list_fusions("order_by=name"));
     
     $model = $api->get_fusion('fusion/5d07d184eba31d5157004a8c');
     
     $file = Yii::getPathOfAlias('webroot').'/uploads/bigMl/crear_pais_base_predicctions_17-06-2019.csv' ;
//     $api->download_batch_prediction('batchprediction/5d0820a17811dd794e006944',
//                                   Yii::getPathOfAlias('webroot').'/uploads/bigMl/my_predictions.csv');
//                echo 'download';
//     echo 'asdf';
//     exit;
     if (file_exists($file)) {
//        $source = $api->create_source($file);
        //$dataset = $api->create_dataset($source);
        $dataset = $api->get_dataset('dataset/5d080c3b5299637f2b007db9');
        //if($dataset->code == 201){  
            $batch_prediction = $api->create_batch_prediction(
                    $model, 
                    $dataset, 
                    array("name" => "my_batch_prediction".Date('d_m_Y_h_i_s'),
                    //"all_fields" => true,
                    "output_fields" => array("idDebtorObligation"),
                    "header" => true,
                    "confidence" => true));
            //$api->get_batch_prediction
            if($batch_prediction->code == 201){                
//                $batch = $api->get_batch_prediction('batchprediction/5d0820a17811dd794e006944');
                // $batch->resource =  batchprediction/5d08ea337811dd794e006f4d 
                $batch = $api->get_batch_prediction($batch_prediction);     
                 print_r($batch);     
                if($batch->code == 200 ||  $batch->code == 201){
                    $prediction = $batch_prediction->resource;
                    if($batch->object->status->code == 5){
                        $api->download_batch_prediction($prediction,
                                           Yii::getPathOfAlias('webroot').'/uploads/bigMl/my_predictions'.Date('d_m_Y_h_i_s').'.csv');
                        echo 'download';
                    }elseif($batch->object->status->code == 2 || $batch->object->status->code == 3 || $batch->object->status->code == 4 ){
                        echo $batch->object->status->code;
                    }else{
                        echo 'error status  batch';
                        print_r($batch);
                    }
                }else{
                    echo 'error get batch prediction';
                }
            }else{                
                echo 'error batch prediction';
            }
           //$api->get_batch_prediction($batch_prediction);
            //exit;
//        }else{
//            
//            print_r($dataset);
//            $api->delete_dataset($dataset);
//            exit;            
//        }
     }else{
         echo 'no';
     }
     exit;

//$model = $api->create_model($dataset);
     
         print_r($api->get_ensemble('5cfa84aec9841724bf0127eb'));
//         print_r($api->list_ensembles());
         print_r($api->list_models());
//         5cfa846e3514cd52eb013ef9
//         5cfa7747eba31d515700170e
         exit;
         
     }
     
     public function actionMail(){
         
         $model = Users::model()->findByPk(42);
         //$this->render('/email/mail-confirm-account',array('model' => $model, 'url' => ''));
         
         
         
        $htmlEmail = $this->renderPartial('/email/mail-confirm-account', array('model' => $model, 'password' =>'' ), true);
         //require_once 'protected/extensions/sendgrid-php/vendor/autoload.php';
         
         require "protected/extensions/sendgrid-php-master/sendgrid-php.php";
//         
         $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("desarrollo@collectpay.co", "Example User");
        $email->setSubject("Sending with Twilio SendGrid is Fun");
        $email->addTo("john@collectpay.co", "Example User");
        $email->addContent(
            "text/html", $htmlEmail
        );
        $sendgrid = new \SendGrid('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');
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
         
         exit;
         
     }
    
    public function actionTest(){
        
        if ( $this->isMobile ) {
            echo 'si';
        }else{
            echo 'no';
        }
        exit;
        $string = '{"-*numbers*-":"2","-*idL*-":"43249/5701"}';
        
       $json = Controller::isJSON($string);
        $obj = CJSON::decode($string,TRUE);
        $model = UsersNotifications::model()->find();
        if($model != null){
            print_r($model->getParams());
            echo '*--<br>';
        }
        print_r($obj);
        echo '<br>';
        echo ($json)? 'true' : 'false';
        exit;
        //Yii::app()->language = 'en';
        
        echo Yii::app()->language.'<br>';
        echo Yii::t('app', 'Menú Dependiente').'<br>';
        //exit;
        Yii::app()->language = 'es';
        echo Yii::t('front', 'Usuarios').'<br>';
        exit;
        
    }
    
    public function  actionTestCall(){
        
        
        $debtor = ViewDebtors::model()->find(array('condition' => 'id = 44921'));
        
        $state = DebtorsState::model()->findByPk($debtor->idState);                   
        $conditionStatus = ($state != null)? 't.order >='.$state->order : '';
        $conditionStatus .= ($conditionStatus != '') ? ' AND ' : '';
        $conditionStatus .= 't.active = 1 AND t.idDebtorsState IS NULL AND t.is_legal ='.$debtor->is_legal;
        $conditionStatus .= ($debtor->is_legal)? ' OR t.historic = 1 ' : '';                
        $orderStatus = ($debtor->is_legal)? 't.order ASC' : 't.name ASC';
        $status = DebtorsState::model()->findAll(array('condition' => $conditionStatus , 'order' => $orderStatus)); 
        $this->render('/wallet/partials/call-phone',array('model' => $debtor, 'status' => $status));
        
    }
    
    public function  actionTestCall_(){
        
        $this->layout = '';
        $this->render('/wallet/partials/call-phone_1',array());
        
    }
    
    public function actionMailNotification(){
                
        $criteria = new CDbCriteria();
        
        $criteria->select = 't.idUser, t.number, t.name, vu.email, t.total';
        $criteria->join = ' JOIN view_users vu ON t.idUser = vu.id AND vu.active = 1';
        $criteria->group = ' t.idUser';
        
        $model = ViewNotificationInvoiceCustomer::model()->findAll($criteria);
        
        
        foreach ($model as $value){
            $htmlEmail = $this->renderPartial('/email/partials/layout-mail', array('render' => '/email/invoice-customer','vars' => array('model' => $value)),true);  
            $subject = Yii::t('front','Factura '.$value->company);
            Controller::SendGridMail($value->email,$value->name, $subject, $htmlEmail);
        }
        
        echo 'send';
        
        exit;
        
    }

    public function actionTestMail(){
        
        //$this->render('/email/mail-cron-management', array());
        
        
        
        $model = Users::model()->findByPk(42);
        $url = Yii::app()->getBaseUrl(true);
        if(1 != null){            
            $htmlEmail = $this->renderPartial('/email/mail-cron-management', array('model' => $model,'url' => $url), true);
            $subject = Yii::t('front','Resumen Gestion');
            if(Controller::SendGridMail('desarrollo@collectpay.co','test', $subject, $htmlEmail)){
                echo 'si-----';
            }else{
                echo 'no-----';
            }    
        }else{
            echo 'no find';
        }
        
        
    }
    
    public function actionTestSession(){
        

        $val = (3600 * 24 * 30) . 'log';
        echo '<br>';
        echo time() . ' time';
        echo '<br>';
        echo(date("Y-m-d h:i:s",time()));
        echo '<br>';
        echo date("Y-m-d h:i:s",(time() - 120));
        echo '<br>';
        echo $val;
        exit;
        
        $active_sess = User::findOne($getUser->id);

    if($active_sess->conc_login == '' or count(json_decode($active_sess->conc_login)) == 0) {
        $login_json = json_encode([[Yii::$app->session->getId() => Yii::$app->session->getId(), 'session_key' => Yii::$app->session->getId(), 'time' => time()]]);
        $active_sess->conc_login = $login_json;
        $active_sess->save();
    }elseif(count(json_decode($active_sess->conc_login)) > 0 and count(json_decode($active_sess->conc_login)) && count(json_decode($active_sess->conc_login)) < $login_limit){
        $login_json = json_decode($active_sess->conc_login);
        $login_json[] = [Yii::$app->session->getId() => Yii::$app->session->getId(), 'session_key' => Yii::$app->session->getId(), 'time' => time()];
        $login_json = json_encode($login_json);
        //print_r($login_json); exit;                
        $active_sess->conc_login = $login_json;
        $active_sess->save();
    }elseif(count(json_decode($active_sess->conc_login)) >= $login_limit) {

        $logins = json_decode($active_sess->conc_login);


        foreach ($logins as $key => $login) {
            if ($login->time < time() - 120) {
                //this checks if the iterated login is greater than the current time -120seconds and if found to be true then the user is inactive
                //then set this current login to null by using the below statement
                //$logins[$key] = null; // or unset($logins[$key]) either should work;
                unset($logins[$key]);
            }
        }

        //after iteration we check if the count of logins is still greater than the limit
        if (count($logins) >= $login_limit) {
            //then return a login error that maximum logins reached
            //echo 'you are not allowed to login as you have breeched the maximum session limit.';
            //exit;
            $login_json = json_encode($logins);
            $active_sess->conc_login = $login_json;
            $active_sess->save();

            $this->addError($attribute, 'you are not allowed to login as you have breeched the maximum session limit.');

        } else {
        //then login is successsfull
            $login_json = [];
            foreach ($logins as $key => $val) {
            $login_json[] = [$val->session_key => $val->session_key, 'session_key' => $val->session_key, 'time' => $val->time];
            }
            $login_json[] = [Yii::$app->session->getId() => Yii::$app->session->getId(), 'session_key' => Yii::$app->session->getId(), 'time' => time()];
            $login_json = json_encode($login_json);

            $active_sess->conc_login = $login_json;
            $active_sess->save();
        }
    }
}


//=============================================================================================

    public function actionChangeIdioma() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        
        if (isset($_POST['lang']) && $_POST['lang'] != '') {
            if ($_POST['lang'] == '1' || $_POST['lang'] == '2') {
                $session = Yii::app()->session;
                $session['idioma'] = $_POST['lang'];
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'ok');
            }
        }
        
        echo CJSON::encode($return);
    }

    //=============================================================================================

    public function actionIndex() {
        $this->render('/auth/login');
    }
    
    //=============================================================================================
    
    public function actionAuth() {
        if(Yii::app()->user->isGuest){            
            $this->render('/auth/login');
        }else{
            $url = UsersProfile::model()->findByPk(Yii::app()->user->getState('rol'));
            if($url != null){                
                $this->redirect(array($url->dashboard));
            }else{
                if(Yii::app()->user->getState('rol') == 0){
                    Yii::app()->user->logout();
                }
                $this->redirect(array('/dashboard'));
            }
        }
    }
    
    //=============================================================================================
    public function actionConfirm() {
        
        if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
            $id = Controller::siteDecodeURL($_REQUEST['id']);            
            $model = Users::model()->find(array('condition' => 'email ="'.$id.'"'));
            
            if($model != null){
                if($model->active == 0){                                        
                    $typeDocuments = TypeDocuments::model()->findAll();
                    $sectors = Sectors::model()->findAll();                    
                    $this->render('/auth/confirm-account',array('model' => $model, 'typeDocuments' => $typeDocuments, 'sectors' => $sectors));                
                }else{
                    throw new CHttpException(404,'La solicitud es inválida, la cuenta ya se encuentra confirmada');                    
                }
            }else{                
                throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
            }
        }else{
            throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
        }
    }
    
    //=============================================================================================
    
    public function actionConfirmAccount() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true, 'url' => '');
        
        if (Yii::app()->user->isGuest) {

            if (isset($_REQUEST)) {
                $model = new Register; 
                $model->setAttributes($_REQUEST);
                $model->setScenario('confirm');
                
                if ($model->validate()) {
                    if((isset($_REQUEST['id']) && $_REQUEST['id'] != '')){
                        $customers = Users::model()->findByPk($_REQUEST['id']);
                        $return['newRecord'] = false;    
                    }else{
                        $customers = new Users;
                    }                    
                    $customers->setAttributes($_REQUEST);
                    $customers->name = $model->company;
                    $customers->userName = Controller::slugUrl($model->company);
                    $customers->active = 1;
                    $customers->check_terms = 1;
                    $customers->date_check_terms = date("Y-m-d H:i:s");
                    
                    if($customers->save(false)){                        
                        $return['status'] = 'success';
                        $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                        $return['model'] = $customers;                         
                        $return['url'] = '/assignments';
            
                        $message['status'] = $this->validateUserFront('', $customers->email, $customers->password, false, true,'internal');
                        if ($return['status'] == "success") {
                            $return['msg'] = "Ingreso Correcto";
                        } else {
                            $return['msg'] = $message['status'];
                            $return['status'] = 'error';
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
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    //=============================================================================================
    //login con user and password
    public function actionLogin() {
        $message = array();
        if (isset($_POST['user'], $_POST['passwd'], $_POST['g-recaptcha-response'])) {
            $message['url'] = $this->createUrl('/dashboard');
            $message['status'] = $this->validateUserFront($_POST['g-recaptcha-response'], $_POST['user'], $_POST['passwd'], ( isset($_POST['recordar']) && $_POST['recordar'] == "on" ? true : false));
            if ($message['status'] == "success") {
                $message['msg'] = "Ingreso Correcto";
            } else {
                $message['msg'] = $message['status'];
                $message['status'] = 'error';
            }
        } else {
            $message['status'] = "error";
            $message['msg'] = "error";
        }
        echo CJSON::encode($message);
    }
    
    

    //=============================================================================================
    
    
    //login con user and password
    public function actionLoginTest() {
        $message = array();        
        $model = Users::model()->findByPk(12);
        
        if ($model != null){
            $message['url'] = $this->createUrl('/services');
            
            $message['status'] = $this->validateUserFront('', $model->email, $model->password, false, true,'internal');
            if ($message['status'] == "success") {
                $message['msg'] = "Ingreso Correcto";
            } else {
                $message['msg'] = $message['status'];
                $message['status'] = 'error';
            }
        } else {
            $message['status'] = "error";
            $message['msg'] = "Por favor ingresar sus credenciales";
        }
        
        print_r($message);
        exit;
        
        echo CJSON::encode($message);
    }
    
    //=============================================================================================
    
    public function actionRecover() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'));
        
        if (isset($_POST)) {

            if (Yii::app()->user->isGuest) {
                
                $model = new Recover; 
                $model->setAttributes($_POST);
                
                if ($model->validate()) {
                    $recover = Users::model()->find(array('condition' => 'email LIKE "'.$model->email.'"'));
                    //$recover = Users::model()->find(array('condition' => 'email LIKE '.$model->email.' '));
                                        
                    if($recover != null){                        
                        if($recover->active == 1){                            
                            $password = Controller::creaPassword();
                            $recover->password = md5($password);
                            
                            if($recover->save(false)){
                                //sendMail
                                $htmlEmail = $this->renderPartial('/email/mail-recover-pass', array('model' => $model, 'password' => $password), true);
                                $subject = Yii::t('front','Nueva Contraseña');
                                Controller::SendGridMail($model->email,$model->name, $subject, $htmlEmail);                            
                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Se ha enviado una nueva contraseña al email ingresado');
                                
                            }else{
                                $return['msg'] = '';
                                foreach ($recover->getErrors() as $error) {
                                    $return['msg'] .= $error[0] . "<br/>";
                                }  
                            }
                        }else{
                            $return['msg'] = Yii::t('front', 'Usuario inactivo, comuniquese con el administrador.');
                        }                        
                    }else{                        
                        $return['msg'] = Yii::t('front', 'Usuario no encontrado.');                        
                    }
                }else{
                    $return['msg'] = '';
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            }else{
                $return['msg'] = Yii::t('front', 'Acción no permitida.');
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    //ejemplo connect social
    public function actionConnectSocial() {
        $session = Yii::app()->session;
        Yii::import('ext.hybridauth.Hybrid.Auth', true);
        // include hybridauth lib
        $url = $this->createAbsoluteUrl('site/connectSocial');
        $config = $this->configSocial($url);
        $hybridauth = new Hybrid_Auth($config);
        //posibles errores
        if (isset($_REQUEST['hauth_done']) && (($_REQUEST['hauth_done'] == 'Twitter' && isset($_REQUEST['denied'])) || ($_REQUEST['hauth_done'] == 'LinkedIn' && isset($_REQUEST['oauth_problem'])))
        ) {
            if (isset($session['social'])) {
                unset($session['social']);
            }
            $hybridauth->logoutAllProviders();
            $this->redirect(array('zonaSegura'));
            Yii::app()->end();
        }
        //validar auto sesiones
        if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
            Yii::import('ext.hybridauth.Hybrid.Endpoint', true);
            Hybrid_Endpoint::process();
        }
        // start login with facebook?
        if (isset($_GET["login"]) && ($_GET["login"] == "Facebook" || $_GET["login"] == "Google" || $_GET["login"] == "Twitter" || $_GET["login"] == "LinkedIn")) {
            try {
                $adapter = $hybridauth->authenticate($_GET["login"]);
                $user_profile = $adapter->getUserProfile();
                if (isset($user_profile)) {
                    if ((isset($user_profile->emailVerified) && $user_profile->emailVerified != "") || ($hybridauth->isConnectedWith('twitter') && isset($_GET["login"]) && $_GET["login"] == "Twitter")) {
                        $session['social'] = get_object_vars($user_profile);
                        $session['typeSocial'] = $_GET["login"];
                    } elseif (isset($session['social'])) {
                        unset($session['social']);
                        $hybridauth->logoutAllProviders();
                    }
                }
            } catch (Exception $e) {
                die("<b>got an error!</b> " . $e->getMessage());
            }
        }
        if (isset($session['social'])) {
            //campo en la base de datos
            $idred = "idfacebook";
            $identifier = $session['social']['identifier'];
            switch ($session['typeSocial']) {
                case "Facebook":
                    $idred = "idfacebook";
                    break;
                case "Google":
                    $idred = "idgoogle";
                    break;
                case "Twitter":
                    $idred = "idtwitter";
                    break;
                case "LinkedIn":
                    $idred = "idlinkedin";
                    break;
            }
            $resp = $this->validateUserFront($identifier, $identifier, false, $idred);
            //si el acceso es correcto
            if ($resp == "ok") {
                Yii::app()->user->setFlash('success', Yii::t('front', 'Bienvenido ' . Yii::app()->user->getState('title')));
                $this->redirect(array('zonaSegura'));
                //si el usuario no existe y debe registrarse
            } elseif (Usuario::model()->count("idfacebook='$identifier'") == 0) {
                $this->redirect(array('index', 't' => 'register'));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('front', $resp));
                $this->redirect(array('index'));
            }
        }
    }
    
    //=============================================================================================
    
    public function actionRegister() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true );
        
        if (Yii::app()->user->isGuest) {

            if (isset($_REQUEST)) {

                $model = new Register; 
                $model->setAttributes($_REQUEST);
                $model->setScenario('register');
                $model->is_internal = 0;
                $model->idUserProfile = 7;
                 
                if ($model->validate()) {
                    
                    if((isset($_REQUEST['id']) && $_REQUEST['id'] != '')){
                        $customers = Users::model()->findByPk($_REQUEST['id']);
                        $return['newRecord'] = false;    
                    }else{
                        $customers = new Users;
                    }
                    
                    $customers->setAttributes($_REQUEST);
                    $customers->is_internal = 0;
                    
                    if($return['newRecord']){
                        $token = Controller::siteEncodeURL($model->email);
                        $customers->password = md5($model->psswd);
                        $customers->image = 'https://storage.googleapis.com/cojunal-148320.appspot.com/12/12-12032019055142.PNG';
                        $customers->active = 0;
                        $customers->idCompany = 12; //id collectpay Yii::app()->user->getId();
                        $customers->userName = Controller::slugUrl($model->name);
                        $customers->idCity = 525;
                        $customers->notification = 0;
                        $customers->contact = $model->name;
                    }
                    
                    if($customers->validate()){
                        $customers->save(false);
                        if($return['newRecord']){
                            $profile = new UsersProfiles;
                            $profile->idUser = $customers->id;
                            $profile->idUserProfile = $model->idUserProfile;
                            
                            if($profile->save()){
                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Registro exitoso, revisa el correo ingresado para confirmar la cuenta !.');
                                $return['model'] = $model;                            
                                
                                //sendMail
                                $name = explode(' ', $model->name);
                                $name = $name[0];
                                $htmlEmail = $this->renderPartial('/email/mail-confirm-account', array('name' => $name, 'token' => $token), true);
                                $subject = Yii::t('front','Nueva Cuenta');
                                Controller::SendGridMail($model->email, $model->name, $subject, $htmlEmail);                                

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
                        
//                        $customerInfo = UsersInfo::model()->find(array('condition' => 'idUser ='.$customers->id));
//                        if($customerInfo == null){
//                            $customerInfo = new UsersInfo;                                    
//                        }
//
//                        $customerInfo->setAttributes($_POST);
//                        $customerInfo->idUser = $customers->id;
//                        
//                        $customerInfo->support_bank = (CUploadedFile::getInstanceByName('support_bank') != '')? CUploadedFile::getInstanceByName('support_bank') : $customerInfo->support_bank;
//
//                        if(!$customerInfo->save()){
//                            
//                            $return['msg'] = Yii::t('front', 'Error asigando información !. ');
//                            foreach ($customerInfo->getErrors() as $error) {
//                                $return['msg'] .= $error[0] . "<br/>";
//                            }
//                        }else{
//                            if(CUploadedFile::getInstanceByName('support_bank') != ''){
//                                $upload = Controller::uploadFile($customerInfo->support_bank,'users',$customers->id,'/uploads/');
//                                $customerInfo->support_bank = ($upload)? $upload['filename']:  $customerInfo->support_bank;   
//                                if(!$customerInfo->save(false)){
//                                    print_r($customerInfo->getErrors());
//                                    exit;
//                                }
//                            }
//                        }
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
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
  
}
