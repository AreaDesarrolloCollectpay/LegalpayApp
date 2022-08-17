<?php

class CampaignsController extends Controller {

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
        $this->access = array(1,2,5);
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
                
                $mlModels = Mlmodels::model()->findAll(array('limit' => 3));
                       
                $this->render('campaigns', array('mlModels' => $mlModels,));
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionSaveCampaigns() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if(isset($_POST['id']) && $_POST['id'] != '') {
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
                    
                        $condition = "lot = '" . $date . "', idCustomer = " . $model->idCustomer . ", migrate = 0";
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
//                        ECHO $sql;
//                        EXIT;
                     
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
                                    $return['model']['lot'] = $date;
                                    $return['model']['idCustomer'] = $model->idCustomer;
                                    $return['model']['count'] = $count;
                                    $return['model']['total'] = Yii::app()->format->formatNumber($total);                                                                
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
