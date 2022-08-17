<?php

class ServicesController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public $access;
    public $adviser;
    public $pSize;
    public $payu;
    
    // PAYU URL  
    public $urlPayments;
    public $urlReports;
    public $urlSubscriptions; 

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->theeFront; //set theme default front
        $this->layout = 'layout_secure';
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        Yii::import('ext.payu.*');
                
        if(!Yii::app()->user->isGuest && Yii::app()->user->getState('rol') != 0){
            Yii::app()->user->logout();
            $this->redirect(array('/services'));             
        }
        
        $this->payu = PaymentsPlatforms::model()->find();
        
        if($this->payu == null){            
            throw new CHttpException(404, Yii::t('front', 'Configurar Pasarela de Pagos'));
        }else{
            $this->urlPayments         = ($this->payu->is_test == 1)? 'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi' : 'https://api.payulatam.com/payments-api/4.0/service.cgi';
            $this->urlReports          = ($this->payu->is_test == 1)? 'https://sandbox.api.payulatam.com/reports-api/4.0/service.cgi' : 'https://api.payulatam.com/reports-api/4.0/service.cgi';
            $this->urlSubscriptions    = ($this->payu->is_test == 1)? 'https://sandbox.api.payulatam.com/payments-api/rest/v4.3/' : 'https://api.payulatam.com/payments-api/rest/v4.3/';            
        }
        $this->isPay = true;
        $this->deviceSessionId = md5(session_id().microtime());
        
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
                
        if(Yii::app()->user->isGuest){ 
            $this->isLogin = true;
            $typeDocuments = TypeDocuments::model()->findAll(array('order' => 'name'));
            $render = '/services/login';
            $parameters = array(
                'typeDocuments' => $typeDocuments,
            );
        }else{
            
            $criteria = new CDbCriteria();  
            $criteria->join = 'JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0 AND tds.idDebtorsState IS NULL';
            
            $condition = 'code LIKE "'.Yii::app()->user->getId().'" AND capital > 0';
            
            $criteria->condition = $condition;
            
            $count = ViewDebtors::model()->count($criteria);
               
            $pages = new CPagination($count);

            $pages->pageSize = $this->pSize;
            $pages->applyLimit($criteria);

            $model = ViewDebtors::model()->findAll($criteria);
            
            $render = '/services/debtors_list';
            $parameters = array('model' => $model, 'pages' => $pages);
        }
            $this->render($render,$parameters);
    }
    
    //=============================================================================================
    
    //login con user and password
    public function actionLogin() {
        $message = array();
        if (isset($_POST['user'], $_POST['passwd'], $_POST['g-recaptcha-response'],$_POST['terms'])) {
            $message['url'] = $this->createUrl('/services');
            $message['status'] = $this->validateUserServicesFront($_POST['g-recaptcha-response'], $_POST['user'], $_POST['passwd'], ( isset($_POST['recordar']) && $_POST['recordar'] == "on" ? true : false), false,$_POST['terms']);
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
        echo CJSON::encode($message);
    }
    
    //=============================================================================================
    
    public function actionLogout() {
        
        Yii::app()->user->logout();
        $this->redirect(array('/services'));
    }
    
    //=============================================================================================
    public function actionDetail() {

        if (!Yii::app()->user->isGuest && isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
            
            $condition = 't.code = "'. Yii::app()->user->getId().'" AND capital > 0 AND t.id = '.Controller::siteDecodeURL($_REQUEST['id']);
            
            $criteria = new CDbCriteria();  
            $criteria->join = 'JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0 AND tds.idDebtorsState IS NULL';            
            $criteria->condition = $condition;

            $debtor = ViewDebtors::model()->find($criteria);
//            print_r($debtor);
//            exit;
            if ($debtor != NULL) {
                                
                $supports = DebtorsSupports::model()->with('idTypeSupport0')->findAll(array('condition' => 'idTypeSupport0.type = 1 AND idDebtor =' . $debtor->id,'order' => 'dateSupport DESC'));
                $payments = DebtorsPayments::model()->findAll(array('condition' => 'idPaymentsState <> 4 AND idDebtorDebt =' . $debtor->id,'order' => 'datePay DESC'));
                $agreements = DebtorsPayments::model()->findAll(array('condition' => ' idPaymentsState = 4 AND idDebtorDebt =' . $debtor->id,'order' => 'datePay DESC'));
                $othersValues = Controller::othersValues($debtor->id);
                
                //Obligations  
                $criteriaObligations = new CDbCriteria();   
                $criteriaObligations->select = 't.*';
                $criteriaObligations->join = 'JOIN tbl_debtors_debts_obligations tddo ON t.id = tddo.idDebtorObligation';                
                $criteriaObligations->condition = 'tddo.idDebtorDebt ='.$debtor->id;
                $criteriaObligations->order = 't.duedate DESC';
                
                $countObligations = ViewDebtorsObligations::model()->count($criteriaObligations);
                
                $pagesObligations = new CPagination($countObligations);
                $pagesObligations->pageSize = $this->pSize;
                $pagesObligations->applyLimit($criteriaObligations);  
                                
                $obligations = ViewDebtorsObligations::model()->findAll($criteriaObligations); 
                
                $this->render(
                    'detail', array(
                        'debtor' => $debtor,
                        'obligations' => $obligations,
                        'pagesObligations' => $pagesObligations,
                        'supports' => $supports,
                        'payments' => $payments,
                        'agreements' => $agreements,                       
                        'othersValues' => $othersValues,                       
                                            
                        )
                );
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(array('/services'));
        }
    }
    
    //=============================================================================================
    public function actionPay() {

        if (!Yii::app()->user->isGuest && isset($_GET['id']) && $_GET['id'] != '') {
            
            
            $condition = 't.code = "'. Yii::app()->user->getId().'" AND capital > 0 AND t.id = '.Controller::siteDecodeURL($_REQUEST['id']);
            
            $criteria = new CDbCriteria();  
            $criteria->join = 'JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0 AND tds.idDebtorsState IS NULL';            
            $criteria->condition = $condition;

            $debtor = ViewDebtors::model()->find($criteria);
            
            if ($debtor != NULL) {
                
                $valueCuote = 0;
                $nextPay = '00/00/000';
                
                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $othersValues = Controller::othersValues($debtor->id);
                $valueBalance = (isset($othersValues['model']))? ($othersValues['model']->capital + $othersValues['model']->interest + $othersValues['model']->fee - $othersValues['model']->payments) : 0;
                
                $reference = Date('Ymdhis').$debtor->id;
                
                $typeDocuments = array(
                                'CC' => 'Cédula de ciudadanía',
                                'CE' => 'Cédula de extranjería',
                                'PP' => 'Pasaporte',
                                'NIT' => 'Número de Identificacón Tributaria',
                );
                
                $typePersons = array(
                    'N' => 'Persona Natural',
                    'J' => 'Persona Jurídica',
                );
                
                $this->render(
                    'pay', array(
                    'id' => $_REQUEST['id'],
                    'debtor' => $debtor,
                    'reference' => $reference,
                    'countries' => $countries,
                    'typeDocuments' => $typeDocuments,                        
                    'typePersons' => $typePersons, 
                    'valueCuote' => $valueCuote,
                    'valueBalance' => $valueBalance,
                    'nextPay' => $nextPay
                        )
                );
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(array('/services'));
        }
    }
    //=============================================================================================
    
    
    public function actionConfirmPay() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '');

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            $model =  new PayConfirm;            
            $model->setAttributes($_POST);
                        
            if($model->validate()){
                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Validación ok.');
                
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
    
    public function actionFormPay() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '');

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            $model =  new PayConfirm;            
            $model->setAttributes($_POST);
            
            if($model->method_pay == 'PSE'){
                $model->setScenario('PSE');
                $idPaymentsMethod = 1;
            }elseif($model->method_pay == 'BALOTO'){
                $model->setScenario('BALOTO');
                $idPaymentsMethod = 2;
            }elseif($model->method_pay == 'EFECTY'){
                $model->setScenario('EFECTY');
                $idPaymentsMethod = 3;
            }elseif($model->method_pay == 'OTHERS_CASH'){
                $model->setScenario('OTHERS_CASH');
                $idPaymentsMethod = 3;
            }else{
                $model->setScenario('CARD');
                $idPaymentsMethod = 4;
            }
            
            $model->ip_address = Yii::app()->request->userHostAddress;
            
            if($model->validate()){
                
                $pay = new DebtorsPayments();
                $pay->idDebtorDebt = $model->id;
                $pay->value = $model->value;
                $pay->idPaymentsType = 7;
                $pay->idPaymentsMethod =  $idPaymentsMethod; 
                $pay->idPaymentsState = 5;
                $pay->idPaymentsWhoPaid = 14;
                $pay->datePay = date('Y-m-d');
 
                if($pay->save()){                    
                    
                    $payer = new DebtorsPaymentsPayer;
                    $payer->idDebtorPayment = $pay->id;
                    $payer->type_person = $model->type_person;
                    $payer->document_type = $model->document_type;
                    $payer->numberDocument = $model->document;
                    $payer->name = $model->name;
                    $payer->email = $model->email;
                    $payer->phone = $model->phone;
                    $payer->mobile = $model->mobile;
                    $payer->idCity = $model->idCity;
                    $payer->pse_financial_code = $model->bank;
                    $payer->numberCard = $model->number_card;
                    $payer->csc = $model->cvv;
                    $payer->validThru = ($model->year != null && $model->month != NULL)? $model->year.'/'.$model->month : NULL;
                    $payer->ip_address = Yii::app()->request->userHostAddress;
// * @property string $cookie
// * @property string $user_agent
// * @property string $dateCreated
                    
                    if($payer->save()){
                        
                        if($model->method_pay == 'PSE'){
                            $return = ServicesController::PayPSE($this->payu,$this->urlPayments ,$this->urlReports,$this->urlSubscriptions, $model,$pay,$payer);
                        }elseif($model->method_pay == 'BALOTO' || $model->method_pay == 'EFECTY' || $model->method_pay == 'OTHERS_CASH'){                            
                           $return = ServicesController::PayCash($this->payu,$this->urlPayments ,$this->urlReports,$this->urlSubscriptions, $model,$pay,$payer);
                        }else{
                           $return = ServicesController::PayCard($this->payu,$this->urlPayments ,$this->urlReports,$this->urlSubscriptions, $model,$pay,$payer);
                        }
                    }else{
                        $return['status'] = 'error';
                        $return['msg'] = 'Error ingresando Payer ';
                        Yii::log("Error Gastos", "error", "actionImport");
                        foreach ($payer->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }
                                        
                }else{
                    $return['status'] = 'error';
                    $return['msg'] = 'Error ingresando Pago';
                    Yii::log("Error Gastos", "error", "actionImport");
                    foreach ($pay->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
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
    public function actionGetForm() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '');

        if (isset($_POST['method_pay']) && $_POST['method_pay'] != '' && !Yii::app()->user->isGuest) {
            require_once 'protected/extensions/payu/PayU.php';   
            
            
            if($_POST['method_pay'] == 'PSE'){
                
                Environment::setPaymentsCustomUrl($this->urlPayments);
                Environment::setReportsCustomUrl($this->urlReports);
                Environment::setSubscriptionsCustomUrl($this->urlSubscriptions);

                PayU::$apiKey = $this->payu->apiKey; //Ingrese aquí su propio apiKey.
                PayU::$apiLogin = $this->payu->apiLogin; //Ingrese aquí su propio apiLogin.
                PayU::$merchantId = $this->payu->merchantId; //Ingrese aquí su Id de Comercio.
                PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
                PayU::$isTest = ($this->payu->is_test)? true : false; //Dejarlo True cuando sean pruebas.
                
                //Ingrese aquí el nombre del medio de pago
                $parameters = array(
                    //Ingrese aquí el identificador de la cuenta.
                    PayUParameters::PAYMENT_METHOD => "PSE",
                    //Ingrese aquí el nombre del pais.
                    PayUParameters::COUNTRY => PayUCountries::CO,
                );
                $array = PayUPayments::getPSEBanks($parameters);
                $banks = (isset($array->banks))?  $array->banks : array();
                $return['html'] = $this->renderPartial('/services/partials/form_pse', array('banks'=> $banks), true);
            }elseif($_POST['method_pay'] == 'VISA_DEBIT'){
                $return['html'] = $this->renderPartial('/services/partials/form_card', array(), true);
            }else{
                $return['html'] = '';                
            }
                $return['status'] = 'success';
            
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
     public function actionAgainPSE() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '');

        if (isset($_POST['id']) && $_POST['id'] != '' && !Yii::app()->user->isGuest) {

            $pay = DebtorsPayments::model()->findByPk($_POST['id']);
            
            if($pay != null && $pay->idPaymentsState == 3){     
                
                $model = new PayConfirm;
                $model->address = $pay->debtorsPaymentsPayers[0]->address;
                
                $model->reference = Date('Ymdhis').$pay->idDebtorObligation;
                $model->value = $pay->value;
            
                $model->email = $pay->debtorsPaymentsPayers[0]->email;
                $model->name = $pay->debtorsPaymentsPayers[0]->name;
                $model->phone = $pay->debtorsPaymentsPayers[0]->phone;
                $model->bank = $pay->debtorsPaymentsPayers[0]->pse_financial_code;
                $model->type_person = $pay->debtorsPaymentsPayers[0]->type_person;
                $model->document = $pay->debtorsPaymentsPayers[0]->numberDocument;
                $model->document_type = $pay->debtorsPaymentsPayers[0]->document_type;
                $model->ip_address = $pay->debtorsPaymentsPayers[0]->ip_address;
                
                
                $return = ServicesController::PayPSE($this->payu,$this->urlPayments ,$this->urlReports,$this->urlSubscriptions, $model,$pay,$model);                
            }else{                
              $return['status'] = 'error';
              $return['msg'] = Yii::t('front', 'No se puede procesar la solicitud');  
            }
        }

        echo CJSON::encode($return);
    }
    //=============================================================================================
    
    public static function PayPSE($payu,$urlPayments ,$urlReports,$urlSubscriptions, $model,$pay,$payer) {
             
            $return = array();
            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['model'] = '';
            $return['data'] = '';
            
            require_once 'protected/extensions/payu/PayU.php';   
            
                Environment::setPaymentsCustomUrl($urlPayments);
                Environment::setReportsCustomUrl($urlReports);
                Environment::setSubscriptionsCustomUrl($urlSubscriptions);

                PayU::$apiKey = $payu->apiKey; //Ingrese aquí su propio apiKey.
                PayU::$apiLogin = $payu->apiLogin; //Ingrese aquí su propio apiLogin.
                PayU::$merchantId = $payu->merchantId; //Ingrese aquí su Id de Comercio.
                PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
                PayU::$isTest = false; //Dejarlo True cuando sean pruebas.

            $reference = $model->reference;
            $value = $model->value;

            $parameters = array(
                    //Ingrese aquí el identificador de la cuenta.
                    PayUParameters::ACCOUNT_ID => $payu->account_id,
                    //Ingrese aquí el código de referencia.
                    PayUParameters::REFERENCE_CODE => $reference,
                    //Ingrese aquí la descripción.
                    PayUParameters::DESCRIPTION => "payment test",

                    // -- Valores --
                    //Ingrese aquí el valor de la transacción.
                    PayUParameters::VALUE => $value,
                    //Ingrese aquí el valor del IVA (Impuesto al Valor Agregado solo valido para Colombia) de la transacción,
                    //si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales.
                    //Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
                    PayUParameters::TAX_VALUE => "0",
                    //Ingrese aquí el valor base sobre el cual se calcula el IVA (solo valido para Colombia).
                    //En caso de que no tenga IVA debe enviarse en 0.
                    PayUParameters::TAX_RETURN_BASE => "0",
                    //Ingrese aquí la moneda.
                    PayUParameters::CURRENCY => "COP",

                    //Ingrese aquí el email del comprador.
                    PayUParameters::BUYER_EMAIL => $model->email,
                    //Ingrese aquí el nombre del pagador.
                    PayUParameters::PAYER_NAME => $model->name,
                    //Ingrese aquí el email del pagador.
                    PayUParameters::PAYER_EMAIL => $model->email,
                    //Ingrese aquí el teléfono de contacto del pagador.
                    PayUParameters::PAYER_CONTACT_PHONE=> $model->phone,

                    // -- infarmación obligatoria para PSE --
                    //Ingrese aquí el código pse del banco.
                    PayUParameters::PSE_FINANCIAL_INSTITUTION_CODE => $model->bank,
                    //Ingrese aquí el tipo de persona (N natural o J jurídica)
                    PayUParameters::PAYER_PERSON_TYPE => $model->type_person,
                    //Ingrese aquí el documento de contacto del pagador.
                    PayUParameters::PAYER_DNI => $model->document,
                    //Ingrese aquí el tipo de documento del pagador: CC, CE, NIT, TI, PP,IDC, CEL, RC, DE.
                    PayUParameters::PAYER_DOCUMENT_TYPE => $model->document_type,

                    //Ingrese aquí el nombre del método de pago
                    PayUParameters::PAYMENT_METHOD => "PSE",

                    //Ingrese aquí el nombre del pais.
                    PayUParameters::COUNTRY => PayUCountries::CO,

                    //IP del pagadador
                    PayUParameters::IP_ADDRESS => $model->ip_address,
                    //Cookie de la sesión actual.
                    PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
                    //Cookie de la sesión actual.
                    PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0",

                    //Página de respuesta a la cual será redirigido el pagador.
                    PayUParameters::RESPONSE_URL => Yii::app()->controller->createAbsoluteUrl("/services/responsePSE"),

            );

            $response = PayUPayments::doAuthorizationAndCapture($parameters);
            
            if($response){
                if($response->transactionResponse->state){                        
                    $pay->responseCode = $response->transactionResponse->responseCode;
                    if($response->transactionResponse->state=="PENDING"){
                        $pay->order_id =  $response->transactionResponse->orderId;
                        $pay->transaction_id = $response->transactionResponse->transactionId;
                        $pay->trazabilityCode = $response->transactionResponse->trazabilityCode;                            
                        $return['status'] = 'success';
                        $return['url'] = $response->transactionResponse->extraParameters->BANK_URL;
                    }else{
//                        print_r($response); exit;
                        $pay->idPaymentsState = 3;
                        $return['status'] = 'error';
                        $return['msg'] = ($response->transactionResponse->responseCode)? $response->transactionResponse->responseCode : 'Error procesando pago, por favor vuelva a intentar más tarde';
                    }
                    $pay->save(false);
                }                    
            }                                       
            return $return;
        }
        
    //=============================================================================================
    public function actionResponsePSE() {
        
        $polTransactionState = (isset($_REQUEST['polTransactionState']))? $_REQUEST['polTransactionState'] : '';
        $polResponseCode = (isset($_REQUEST['polResponseCode']))? $_REQUEST['polResponseCode'] : '';
        
        $state = '';
        $reference_pol = (isset($_REQUEST['reference_pol']))? $_REQUEST['reference_pol'] : '';
                
        $model = DebtorsPayments::model()->find(array('condition' => 'order_id ="'.$reference_pol.'"'));
                
        if($model != null){
            
            
            
            if($polTransactionState == 4 &&  $polResponseCode == 1){
                $model->idPaymentsState = 6;
                $state = Yii::t('front', 'Transacción aprobada');
            } elseif ($polTransactionState == 6 && $polResponseCode == 5) {
                $model->idPaymentsState = 3;
                $state = Yii::t('front', 'Transacción fallida');
            } elseif ($polTransactionState == 6 && $polResponseCode == 4) {
                $model->idPaymentsState = 3;
                $state = Yii::t('front', 'Transacción rechazada');
            } elseif (($polTransactionState == 12 || $polTransactionState == 14) && ($polResponseCode == 9994 || $polResponseCode == 25)) {
                $model->idPaymentsState = 5;
                $state = Yii::t('front', 'Transacción pendiente, por favor revisar si el débito fue realizado en el banco.');
            }
            
            if(isset($_REQUEST['lapResponseCode']) && $_REQUEST['lapResponseCode']  != ''){
                $model->responseCode = $_REQUEST['lapResponseCode'];
            }
            
            $model->save(false);
            
            ServicesController::generateSupport($model);
            
            $model = DebtorsPayments::model()->find(array('condition' => 'order_id ="'.$reference_pol.'"'));

            $this->render(
                    'response', array(
                'state' => $state,
                'referenceCode' => (isset($_REQUEST['referenceCode'])) ? $_REQUEST['referenceCode'] : '',
                'reference_pol' => $reference_pol,
                'cus' => (isset($_REQUEST['cus'])) ? $_REQUEST['cus'] : '',
                'pseBank' => (isset($_REQUEST['pseBank'])) ? $_REQUEST['pseBank'] : '',
                'TX_VALUE' => (isset($_REQUEST['TX_VALUE'])) ? $_REQUEST['TX_VALUE'] : '',
                'currency' => (isset($_REQUEST['currency'])) ? $_REQUEST['currency'] : '',
                'description' => (isset($_REQUEST['description'])) ? $_REQUEST['description'] : '',
                'pseReference1' => (isset($_REQUEST['pseReference1'])) ? $_REQUEST['pseReference1'] : '',
                'model' => $model,
                    )
            );
        }else{
            throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, orden de compra no encontrada'));
        } 
    }
    
    //=============================================================================================
        
    public static function PayCash($payu,$urlPayments ,$urlReports,$urlSubscriptions, $model,$pay,$payer) {
             
            $return = array();
            $return['status'] = 'error';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['model'] = '';
            $return['data'] = '';
            
           require_once 'protected/extensions/payu/PayU.php';   
            
            Environment::setPaymentsCustomUrl($urlPayments);
            Environment::setReportsCustomUrl($urlReports);
            Environment::setSubscriptionsCustomUrl($urlSubscriptions);

            PayU::$apiKey = $payu->apiKey; //Ingrese aquí su propio apiKey.
            PayU::$apiLogin = $payu->apiLogin; //Ingrese aquí su propio apiLogin.
            PayU::$merchantId = $payu->merchantId; //Ingrese aquí su Id de Comercio.
            PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
            PayU::$isTest = false; //Dejarlo True cuando sean pruebas.

            $reference = $model->reference;
            $value = $model->value;
            

            $parameters = array(
                    //Ingrese aquí el identificador de la cuenta.
                    PayUParameters::ACCOUNT_ID => $payu->account_id,
                    //Ingrese aquí el código de referencia.
                    PayUParameters::REFERENCE_CODE => $reference,
                    //Ingrese aquí la descripción.
                    PayUParameters::DESCRIPTION =>  "payment test",
                    // -- Valores --
                    //Ingrese aquí el valor de la transacción.
                    PayUParameters::VALUE => $value,
                    //Ingrese aquí el valor del IVA (Impuesto al Valor Agregado solo valido para Colombia) de la transacción,
                    //si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales.
                    //Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
                    PayUParameters::TAX_VALUE => "0",
                    //Ingrese aquí el valor base sobre el cual se calcula el IVA (solo valido para Colombia).
                    //En caso de que no tenga IVA debe enviarse en 0.
                    PayUParameters::TAX_RETURN_BASE => "0",
                    //Ingrese aquí la moneda.
                    PayUParameters::CURRENCY => "COP",
                    //Ingrese aquí el email del comprador.
                    PayUParameters::BUYER_EMAIL => $model->email,
                    //Ingrese aquí el nombre del pagador.
                    PayUParameters::PAYER_NAME => $model->name,
                    //Ingrese aquí el documento de contacto del pagador.
                    PayUParameters::PAYER_DNI=> $model->document,

                    //Ingrese aquí el nombre del método de pago
                    PayUParameters::PAYMENT_METHOD => $model->method_pay, //EFECTY

                    //Ingrese aquí el nombre del pais.
                    PayUParameters::COUNTRY => PayUCountries::CO,

                    //Ingrese aquí la fecha de expiración.
                    PayUParameters::EXPIRATION_DATE => "",
                    //IP del pagadador
                    PayUParameters::IP_ADDRESS => $model->ip_address,
            );

            $response = PayUPayments::doAuthorizationAndCapture($parameters);

            if($response){
                    
                    $pay->order_id = $response->transactionResponse->orderId;
                    $pay->transaction_id = $response->transactionResponse->transactionId;                    
                    $pay->responseCode = $response->transactionResponse->responseCode;
                    
                    if($response->transactionResponse->state=="PENDING"){
                        $pay->url_html = $response->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML;                        
                        $pay->url_file = $response->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_PDF;                        
                        $return['status'] = 'success';
                        $return['url'] = Yii::app()->controller->createAbsoluteUrl('/services/responseCash/'.$pay->id);
                    }else{
//                        print_r($response);
//                        exit;
                        $pay->idPaymentsState = 3;
                        $return['status'] = 'error';
                        $return['msg'] = ($response->transactionResponse->responseCode)? $response->transactionResponse->responseCode : 'Error procesando pago, por favor vuelva a intentar más tarde';
                    }
                    $pay->save(false);
            } 
            return $return;
        }
        
    //=============================================================================================
    public function actionResponseCash() {
        
        if(isset($_GET['id']) && $_GET['id'] != ''){
            
            $model = DebtorsPayments::model()->findByPk($_GET['id']);
            
            if($model != null && ($model->idPaymentsMethod == 2 || $model->idPaymentsMethod == 3 ) && $model->idPaymentsState == 5){
                
                ServicesController::generateSupport($model);
                $model = DebtorsPayments::model()->findByPk($_GET['id']);
                                
                $this->render(
                           'response_cash', array(
                               'model' => $model)
                        );
            }else{                
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
            
        } else {
            throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
        }
    }
        
    //=============================================================================================
    
    public static function PayCard($payu,$urlPayments ,$urlReports,$urlSubscriptions, $model,$pay,$payer) {
             
            $return = array();
            $return['status'] = 'error';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['model'] = '';
            $return['data'] = '';
            
            require_once 'protected/extensions/payu/PayU.php';   
            
            Environment::setPaymentsCustomUrl($urlPayments);
            Environment::setReportsCustomUrl($urlReports);
            Environment::setSubscriptionsCustomUrl($urlSubscriptions);

            PayU::$apiKey = $payu->apiKey; //Ingrese aquí su propio apiKey.
            PayU::$apiLogin = $payu->apiLogin; //Ingrese aquí su propio apiLogin.
            PayU::$merchantId = $payu->merchantId; //Ingrese aquí su Id de Comercio.
            PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
//            PayU::$isTest = ($this->payu->is_test)? true : false; //Dejarlo True cuando sean pruebas.
            PayU::$isTest = false; //Dejarlo True cuando sean pruebas.

            $reference = $model->reference;
            $value = $model->value;
            

            $parameters = array(
                //Ingrese aquí el identificador de la cuenta.
                PayUParameters::ACCOUNT_ID => $payu->account_id,
                //Ingrese aquí el código de referencia.
                PayUParameters::REFERENCE_CODE => $reference,
                //Ingrese aquí la descripción.
                PayUParameters::DESCRIPTION => "payment test",

                // -- Valores --
                //Ingrese aquí el valor de la transacción.
                PayUParameters::VALUE => $value,
                //Ingrese aquí el valor del IVA (Impuesto al Valor Agregado solo valido para Colombia) de la transacción,
                //si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales.
                //Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
                PayUParameters::TAX_VALUE => "0",
                //Ingrese aquí el valor base sobre el cual se calcula el IVA (solo valido para Colombia).
                //En caso de que no tenga IVA debe enviarse en 0.
                PayUParameters::TAX_RETURN_BASE => "0",
                //Ingrese aquí la moneda.
                PayUParameters::CURRENCY => "COP",

                // -- Comprador
                //Ingrese aquí el nombre del comprador.
                PayUParameters::BUYER_NAME => $model->name,
                //Ingrese aquí el email del comprador.
                PayUParameters::BUYER_EMAIL => $model->email,
                //Ingrese aquí el teléfono de contacto del comprador.
                PayUParameters::BUYER_CONTACT_PHONE => $model->phone,
                //Ingrese aquí el documento de contacto del comprador.
                PayUParameters::BUYER_DNI => $model->document,
                //Ingrese aquí la dirección del comprador.
                PayUParameters::BUYER_STREET => $model->address,
                PayUParameters::BUYER_CITY => "Medellin",
                PayUParameters::BUYER_STATE => "Antioquia",
                PayUParameters::BUYER_COUNTRY => "CO",
                PayUParameters::BUYER_PHONE => $model->mobile,

                // -- pagador --
                //Ingrese aquí el nombre del pagador.
                PayUParameters::PAYER_NAME => $model->name,
                //Ingrese aquí el email del pagador.
                PayUParameters::PAYER_EMAIL => $model->email,
                //Ingrese aquí el teléfono de contacto del pagador.
                PayUParameters::PAYER_CONTACT_PHONE => $model->phone,
                //Ingrese aquí el documento de contacto del pagador.
                PayUParameters::PAYER_DNI => $model->document,
                //Ingrese aquí la dirección del pagador.
                PayUParameters::PAYER_STREET => $model->address,
                PayUParameters::PAYER_STREET_2 => "125544",
                PayUParameters::PAYER_CITY => "Bogota",
                PayUParameters::PAYER_STATE => "Bogota",
                PayUParameters::PAYER_COUNTRY => "CO",
                PayUParameters::PAYER_POSTAL_CODE => "000000",
                PayUParameters::PAYER_PHONE => $model->mobile,

                // -- Datos de la tarjeta de crédito --
                //Ingrese aquí el número de la tarjeta de crédito
                PayUParameters::CREDIT_CARD_NUMBER => $model->number_card,
                //Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
                PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $model->year.'/'.$model->month,
                //Ingrese aquí el código de seguridad de la tarjeta de crédito
                PayUParameters::CREDIT_CARD_SECURITY_CODE=> $model->cvv,
                //Ingrese aquí el nombre de la tarjeta de crédito
                //VISA||MASTERCARD||AMEX||DINERS
                PayUParameters::PAYMENT_METHOD => $model->method_pay,

                //Ingrese aquí el número de cuotas.
                PayUParameters::INSTALLMENTS_NUMBER => "1",
                //Ingrese aquí el nombre del pais.
                PayUParameters::COUNTRY => PayUCountries::CO,

                //Session id del device.
                PayUParameters::DEVICE_SESSION_ID => $model->deviceSessionId,
                //IP del pagadador
                PayUParameters::IP_ADDRESS => $payer->ip_address,
                //Cookie de la sesión actual.
                PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
                //Cookie de la sesión actual.
                PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );

        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        if($response){
                    
                if($response->transactionResponse->state=="PENDING"){
                   $pay->idPaymentsState = 5; 
                }elseif($response->transactionResponse->state=="APPROVED"){                    
                   $pay->idPaymentsState = 6; 
                   $pay->authorizationCode = $response->transactionResponse->authorizationCode;
                   $pay->trazabilityCode = $response->transactionResponse->trazabilityCode;
                                      
                }elseif($response->transactionResponse->state == "REJECTED" || $response->transactionResponse->state == "DECLINED"){  
                   $pay->idPaymentsState = 3;                     
                }
                   $pay->order_id = $response->transactionResponse->orderId;
                   $pay->responseCode = $response->transactionResponse->responseCode;
                   $pay->transaction_id = $response->transactionResponse->transactionId;
                   
                   
                    $pay->save(false);
                    $model = DebtorsPayments::model()->findByPk($pay->id);
                    ServicesController::generateSupport($model);
                    $return['status'] = 'success';
                    $return['url'] =  Yii::app()->controller->createAbsoluteUrl('/services/responseCard/'.$pay->id);
                    $return['msg'] = Yii::t('front', 'Ok');  
        }
 
        return $return;
    }
        
    //=============================================================================================
    
    public function actionResponseCard() {
        
        if(isset($_GET['id']) && $_GET['id'] != ''){
            
            $model = DebtorsPayments::model()->findByPk($_GET['id']);
            
            if($model != null && $model->idPaymentsMethod == 4){
                                
                $this->render(
                           'response_card', array(
                               'model' => $model)
                        );
            }else{                
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
            
        } else {
            throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
        }
    }
    
    //=============================================================================================
    
    public static function generateSupport($model) {
        $return = array('status' => 'success', 'msg' => 'ok');
        
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5', 0, '', 0, 0, 0, 0, 0, 0);
        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML(Yii::app()->controller->renderPartial('webroot.themes.default.views.services.support', array('model' => $model,), true));

        # Out puts ready PDF
        $semilla = Date('Ymdhis') . '.pdf';
        $path = Yii::getPathOfAlias('webroot') . "/uploads/supports/".$semilla;
        $mPDF1->Output($path, 'F');

        if (file_exists($path)) {
            chmod($path, 0777);
            
            
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

            
            //Subir archivo a bucket
            $credentials = new Google_Auth_AssertionCredentials($configuration['login'], $configuration['scope'], $configuration['key']);
            $client = new Google_Client();
            $client->setAssertionCredentials($credentials);
            if ($client->getAuth()->isAccessTokenExpired()) {
                $client->getAuth()->refreshTokenWithAssertion();
            }

            # Starting Webmaster Tools Service
            $storage = new Google_Service_Storage($client);

            $uploadDir = 'uploads/supports/';
            $file_name = "supports/payments/".$model->id . "/" . $semilla;
            $obj = new Google_Service_Storage_StorageObject();
            $obj->setName($file_name);
            try {
                $storage->objects->insert(
                        "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $semilla), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
                );
                $model->supportPayments = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                if(!$model->save(false)){
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    Yii::log("Error Pagos", "error", "actionSave");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }else{
                    $return['status'] = 'success';
                    $return['file'] = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                    $return['msg'] = Yii::t('front', 'PDF');
                }
                
            } catch (Exception $e) {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'No se pudo guardar el soporte');
            }

            if (file_exists($path)) {
                unlink($path);
            }
        }else{
            $return['status'] = 'error';
            $return['msg'] = Yii::t('front', 'No se pudo generar el soporte');
        }
        
        return $return;
    }
    
    public function actionTestPSE(){
        
        $reference = date('Ymdhis');
        $value = "20000";
        
        require_once 'protected/extensions/payu/PayU.php';   
            
            Environment::setPaymentsCustomUrl($this->urlPayments);
            Environment::setReportsCustomUrl($this->urlReports);
            Environment::setSubscriptionsCustomUrl($this->urlSubscriptions);

            PayU::$apiKey = $this->payu->apiKey; //Ingrese aquí su propio apiKey.
            PayU::$apiLogin = $this->payu->apiLogin; //Ingrese aquí su propio apiLogin.
            PayU::$merchantId = $this->payu->merchantId; //Ingrese aquí su Id de Comercio.
            PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
//            PayU::$isTest = ($this->payu->is_test)? true : false; //Dejarlo True cuando sean pruebas.
            PayU::$isTest = false; //Dejarlo True cuando sean pruebas.

        $parameters = array(
                //Ingrese aquí el identificador de la cuenta.
                PayUParameters::ACCOUNT_ID => $this->payu->account_id,
                //Ingrese aquí el código de referencia.
                PayUParameters::REFERENCE_CODE => $reference,
                //Ingrese aquí la descripción.
                PayUParameters::DESCRIPTION => "payment test",

                // -- Valores --
                //Ingrese aquí el valor de la transacción.
                PayUParameters::VALUE => $value,
                //Ingrese aquí el valor del IVA (Impuesto al Valor Agregado solo valido para Colombia) de la transacción,
                //si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales.
                //Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
                PayUParameters::TAX_VALUE => "3193",
                //Ingrese aquí el valor base sobre el cual se calcula el IVA (solo valido para Colombia).
                //En caso de que no tenga IVA debe enviarse en 0.
                PayUParameters::TAX_RETURN_BASE => "16806",
                //Ingrese aquí la moneda.
                PayUParameters::CURRENCY => "COP",

                //Ingrese aquí el email del comprador.
                PayUParameters::BUYER_EMAIL => "buyer_test@test.com",
                //Ingrese aquí el nombre del pagador.
                PayUParameters::PAYER_NAME => "First name and second buyer  name",
                //Ingrese aquí el email del pagador.
                PayUParameters::PAYER_EMAIL => "payer_test@test.com",
                //Ingrese aquí el teléfono de contacto del pagador.
                PayUParameters::PAYER_CONTACT_PHONE=> "7563126",

                // -- infarmación obligatoria para PSE --
                //Ingrese aquí el código pse del banco.
                PayUParameters::PSE_FINANCIAL_INSTITUTION_CODE => "1022",
                //Ingrese aquí el tipo de persona (N natural o J jurídica)
                PayUParameters::PAYER_PERSON_TYPE => "N",
                //Ingrese aquí el documento de contacto del pagador.
                PayUParameters::PAYER_DNI => "123456789",
                //Ingrese aquí el tipo de documento del pagador: CC, CE, NIT, TI, PP,IDC, CEL, RC, DE.
                PayUParameters::PAYER_DOCUMENT_TYPE => "CC",

                //Ingrese aquí el nombre del método de pago
                PayUParameters::PAYMENT_METHOD => "PSE",

                //Ingrese aquí el nombre del pais.
                PayUParameters::COUNTRY => PayUCountries::CO,

                //IP del pagadador
                PayUParameters::IP_ADDRESS => "127.0.0.1",
                //Cookie de la sesión actual.
                PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
                //Cookie de la sesión actual.
                PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0",

                //Página de respuesta a la cual será redirigido el pagador.
                PayUParameters::RESPONSE_URL => Yii::app()->controller->createAbsoluteUrl("/services/responsePSE"),

        );

        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        if($response){
                $response->transactionResponse->orderId;
                $response->transactionResponse->transactionId;
                $response->transactionResponse->state;
                if($response->transactionResponse->state)
                if($response->transactionResponse->state=="PENDING"){
                        $response->transactionResponse->pendingReason;
                        $response->transactionResponse->extraParameters->BANK_URL;
                }
                $response->transactionResponse->responseCode;
        }
        
        print_r($response);
        exit;
        
        
    }
    
    public function actionTestCash(){
        
                
        require_once 'protected/extensions/payu/PayU.php';   
            
            Environment::setPaymentsCustomUrl($this->urlPayments);
            Environment::setReportsCustomUrl($this->urlReports);
            Environment::setSubscriptionsCustomUrl($this->urlSubscriptions);

            PayU::$apiKey = $this->payu->apiKey; //Ingrese aquí su propio apiKey.
            PayU::$apiLogin = $this->payu->apiLogin; //Ingrese aquí su propio apiLogin.
            PayU::$merchantId = $this->payu->merchantId; //Ingrese aquí su Id de Comercio.
            PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
//            PayU::$isTest = ($this->payu->is_test)? true : false; //Dejarlo True cuando sean pruebas.
            PayU::$isTest = false; //Dejarlo True cuando sean pruebas.

            $reference = date('Ymdhis');
        $value = "20000";

        $parameters = array(
	//Ingrese aquí el identificador de la cuenta.
	PayUParameters::ACCOUNT_ID => $this->payu->account_id,
	//Ingrese aquí el código de referencia.
	PayUParameters::REFERENCE_CODE => $reference,
	//Ingrese aquí la descripción.
	PayUParameters::DESCRIPTION => "payment test",

	// -- Valores --
        //Ingrese aquí el valor de la transacción.
        PayUParameters::VALUE => $value,
        //Ingrese aquí el valor del IVA (Impuesto al Valor Agregado solo valido para Colombia) de la transacción,
        //si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales.
        //Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
        PayUParameters::TAX_VALUE => "3193",
        //Ingrese aquí el valor base sobre el cual se calcula el IVA (solo valido para Colombia).
        //En caso de que no tenga IVA debe enviarse en 0.
        PayUParameters::TAX_RETURN_BASE => "16806",
	//Ingrese aquí la moneda.
	PayUParameters::CURRENCY => "COP",

	//Ingrese aquí el email del comprador.
	PayUParameters::BUYER_EMAIL => "buyer_test@test.com",
	//Ingrese aquí el nombre del pagador.
	PayUParameters::PAYER_NAME => "First name and second buyer  name",
	//Ingrese aquí el documento de contacto del pagador.
	PayUParameters::PAYER_DNI=> "5415668464654",

	//Ingrese aquí el nombre del método de pago
	PayUParameters::PAYMENT_METHOD => "BALOTO", //EFECTY

	//Ingrese aquí el nombre del pais.
	PayUParameters::COUNTRY => PayUCountries::CO,

	//Ingrese aquí la fecha de expiración.
	PayUParameters::EXPIRATION_DATE => "2018-09-26T00:00:00",
	//IP del pagadador
	PayUParameters::IP_ADDRESS => "127.0.0.1",
);

$response = PayUPayments::doAuthorizationAndCapture($parameters);


        print_r($response);
        exit;
        
        
    }
    
    public function actionTestCard(){
        
                
        require_once 'protected/extensions/payu/PayU.php';   
            
            Environment::setPaymentsCustomUrl($this->urlPayments);
            Environment::setReportsCustomUrl($this->urlReports);
            Environment::setSubscriptionsCustomUrl($this->urlSubscriptions);

            PayU::$apiKey = $this->payu->apiKey; //Ingrese aquí su propio apiKey.
            PayU::$apiLogin = $this->payu->apiLogin; //Ingrese aquí su propio apiLogin.
            PayU::$merchantId = $this->payu->merchantId; //Ingrese aquí su Id de Comercio.
            PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
//            PayU::$isTest = ($this->payu->is_test)? true : false; //Dejarlo True cuando sean pruebas.
            PayU::$isTest = true; //Dejarlo True cuando sean pruebas.

            $reference = date('Ymdhis');
        $value = "20000";

        $parameters = array(
            //Ingrese aquí el identificador de la cuenta.
            PayUParameters::ACCOUNT_ID => $this->payu->account_id,
            //Ingrese aquí el código de referencia.
            PayUParameters::REFERENCE_CODE => $reference,
            //Ingrese aquí la descripción.
            PayUParameters::DESCRIPTION => "payment test",
            // -- Valores --
            //Ingrese aquí el valor de la transacción.
            PayUParameters::VALUE => $value,
            //Ingrese aquí el valor del IVA (Impuesto al Valor Agregado solo valido para Colombia) de la transacción,
            //si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales.
            //Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
            PayUParameters::TAX_VALUE => "3193",
            //Ingrese aquí el valor base sobre el cual se calcula el IVA (solo valido para Colombia).
            //En caso de que no tenga IVA debe enviarse en 0.
            PayUParameters::TAX_RETURN_BASE => "16806",
            //Ingrese aquí la moneda.
            PayUParameters::CURRENCY => "COP",
            // -- Comprador
            //Ingrese aquí el nombre del comprador.
            PayUParameters::BUYER_NAME => "DECLINED",
            //Ingrese aquí el email del comprador.
            PayUParameters::BUYER_EMAIL => "buyer_test@test.com",
            //Ingrese aquí el teléfono de contacto del comprador.
            PayUParameters::BUYER_CONTACT_PHONE => "7563126",
            //Ingrese aquí el documento de contacto del comprador.
            PayUParameters::BUYER_DNI => "5415668464654",
            //Ingrese aquí la dirección del comprador.
            PayUParameters::BUYER_STREET => "calle 100",
            PayUParameters::BUYER_STREET_2 => "5555487",
            PayUParameters::BUYER_CITY => "Medellin",
            PayUParameters::BUYER_STATE => "Antioquia",
            PayUParameters::BUYER_COUNTRY => "CO",
            PayUParameters::BUYER_POSTAL_CODE => "000000",
            PayUParameters::BUYER_PHONE => "7563126",
            // -- pagador --
            //Ingrese aquí el nombre del pagador.
            PayUParameters::PAYER_NAME => "DECLINED",
            //Ingrese aquí el email del pagador.
            PayUParameters::PAYER_EMAIL => "payer_test@test.com",
            //Ingrese aquí el teléfono de contacto del pagador.
            PayUParameters::PAYER_CONTACT_PHONE => "7563126",
            //Ingrese aquí el documento de contacto del pagador.
            PayUParameters::PAYER_DNI => "5415668464654",
            //Ingrese aquí la dirección del pagador.
            PayUParameters::PAYER_STREET => "calle 93",
            PayUParameters::PAYER_STREET_2 => "125544",
            PayUParameters::PAYER_CITY => "Bogota",
            PayUParameters::PAYER_STATE => "Bogota",
            PayUParameters::PAYER_COUNTRY => "CO",
            PayUParameters::PAYER_POSTAL_CODE => "000000",
            PayUParameters::PAYER_PHONE => "7563126",
            // -- Datos de la tarjeta de crédito --
            //Ingrese aquí el número de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_NUMBER => "4509420000000008",
            //Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2018/12",
            //Ingrese aquí el código de seguridad de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_SECURITY_CODE => "321",
            //Ingrese aquí el nombre de la tarjeta de crédito
            //VISA||MASTERCARD||AMEX||DINERS
            PayUParameters::PAYMENT_METHOD => "VISA_DEBIT",
            //Ingrese aquí el número de cuotas.
            PayUParameters::INSTALLMENTS_NUMBER => "1",
            //Ingrese aquí el nombre del pais.
            PayUParameters::COUNTRY => PayUCountries::CO,
            //Session id del device.
            PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
            //IP del pagadador
            PayUParameters::IP_ADDRESS => "127.0.0.1",
            //Cookie de la sesión actual.
            PayUParameters::PAYER_COOKIE => "pt1t38347bs6jc9ruv2ecpv7o2",
            //Cookie de la sesión actual.
            PayUParameters::USER_AGENT => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );

        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        print_r($response);
        exit;
        
        
    }
    
    public function actionTestPDF(){
        
        $model = DebtorsPayments::model()->findByPk(381);
        $return = ServicesController::generateSupport($model);
        
        print_r($return);
        exit;
        
    }
    
    public function actionHtmlPDF(){
         $this->layout = '';
        $model = DebtorsPayments::model()->findByPk(381);
        
        
        
        $this->render(
                'support', array(
                    'model' => $model)
             );
        
    }
    
}
