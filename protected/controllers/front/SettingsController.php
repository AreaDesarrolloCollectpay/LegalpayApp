<?php

class SettingsController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public $access;
    
    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->theeFront; //set theme default front
        $this->layout = 'layout_secure';
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        $this->access = array(1);
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
            
            $filters = array('name', 'currency');
            $criteria = new CDbCriteria();
            $condition = '';


            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                       $condition .=  ' LIKE "%'.$value.'%"';  
                        $i++;
                    }
                }

                
                $condition .= ($condition != '') ? ')' : '';
            }
                        
                        
            $criteria->condition = $condition;
            $criteria->order = "t.id DESC";            

            $count = Currencies::model()->count($criteria);           

            $pages = new CPagination($count);

            $pages->pageSize = 15;
            $pages->applyLimit($criteria);
            
            $model = Currencies::model()->findAll($criteria);
            
            $this->render('settings',array(
                'model' => $model,
                'pages' => $pages
                    ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================
    public function actionCurrency() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            $filters = array('name', 'currency');

            $criteria = new CDbCriteria();
            $condition = '';


            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                       $condition .=  ' LIKE "%'.$value.'%"';  
                        $i++;
                    }
                }

                
                $condition .= ($condition != '') ? ')' : '';
            }
                        
                        
            $criteria->condition = $condition;  
            
            $count = Currencies::model()->count($criteria);  
            
            $pages = new CPagination($count);

            $pages->pageSize = 15;
            $pages->applyLimit($criteria);
            
            $model = Currencies::model()->findAll($criteria);
            
            $this->render('currency',array(
                'model' => $model,
                'pages' => $pages
                    ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
        
    public function actionGetCurrency() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {

                $model = Currencies::model()->findByPk($_POST['id']);
                if($model != null){
                    $return['status'] = 'success';
                    $return['model'] = $model;
                }else{
                    $return['msg'] = Yii::t('front', 'Error moneda no encontrada !. ');                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionUpdateCurrency() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST)) {

                if (isset($_POST['id']) && $_POST['id'] != '') {
                    $model = Currencies::model()->findByPk($_POST['id']);
                    $return['newRecord'] = false;
                } else {
                    $model = new Currencies;
                }
                
                $model->setAttributes($_POST);
                    
                if ($model->save(false)) {
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                    $return['model'] = $model; 
                                        
                }else{
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
    
    public function actionPolitical() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            $filters = array('idUser', 'name');

            $criteria = new CDbCriteria();
            $criteriaC = new CDbCriteria();
            $criteriaC->join = 'JOIN tbl_users_political tup ON t.id = tup.idUser';
            $condition = '';


            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if (($key != 'page') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idUser'))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
                        
                        
            $criteria->condition = $condition;
            $criteria->order = "t.dateCreated DESC";
            

            $count = UsersPolitical::model()->count($criteria);           

            $pages = new CPagination($count);

            $pages->pageSize = 15;
            $pages->applyLimit($criteria);
            
            $model = UsersPolitical::model()->findAll($criteria);
            
            $criteriaC->select = 't.*';
            $criteriaC->condition = str_replace('t.', 'tup.', $condition);
            $criteriaC->order = 't.name';
            $criteriaC->group = 't.id';
            $customersF  = ViewCustomers::model()->findAll($criteriaC);
            $customersM  = ViewCustomers::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
            
            $edit = (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['admin']))? true : false;           
            
            $this->render('political',array(
                'model' => $model,
                'pages' => $pages,
                'edit' => $edit,
                'customersF' =>  $customersF,
                'customersM' =>  $customersM,
                    ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
     //=============================================================================================

    public function actionSavePolitical() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);        
        
        if (isset($_POST) && !Yii::app()->user->isGuest) {
            
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = UsersPolitical::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new UsersPolitical;
            }

            $model->setAttributes($_POST);

            $model->file = (CUploadedFile::getInstanceByName('file') != '') ? CUploadedFile::getInstanceByName('file') : $model->file;
            
          
            if ($model->validate()) {
                $model->idUser = ($model->idUser == 0)? NULL : $model->idUser;
                $model->save(false);
                $file = CUploadedFile::getInstanceByName('file');
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
                        $model->file = $configuration['storage']['url'] . $bucket . '/' . $file_name;
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
                $edit = (!in_array(Yii::app()->user->getState('rol'), Yii::app()->params['admin']))? true : false;
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/settings/partials/item-political', array('model' => $model,'edit' => $edit), true);
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
       
}
