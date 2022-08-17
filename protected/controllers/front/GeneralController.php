<?php

class GeneralController extends Controller {

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
    public function actionGetDepartments() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = false;

        if (isset($_POST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';

            if ($_POST['id'] != '') {
                $model = Departments::model()->findAll(array('condition' => 'idCountry =' . $_POST['id'], 'order' => 'name ASC'));
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'ok');
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    public function actionGetCities() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = false;

        if (isset($_POST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';

            if ($_POST['id'] != '') {
                $model = Cities::model()->findAll(array('condition' => 'idDepartment =' . $_POST['id'], 'order' => 'name ASC'));
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'ok');
        }

        echo CJSON::encode($return);
    }
    //=============================================================================================
    public function actionGetAdvisers() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = false;

        if (isset($_POST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';

            if ($_POST['id'] != '') {
                $model = ViewAdvisers::model()->findAll(array('condition' => 'idCoordinator =' . $_POST['id'], 'order' => 'name ASC'));
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'ok');
        }

        echo CJSON::encode($return);
    }
    //=============================================================================================
    public function actionGetTasksEffects() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = false;

        if (isset($_POST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';

            if ($_POST['id'] != '') {
                $model = TasksActions::model()->findAll(array('condition' => 'idTasksAction =' . $_POST['id'], 'order' => 'name ASC'));
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . Yii::t('front', $value->name) . '</option>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'ok');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionGetCoordinators() {
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida', 'model' => '', 'html' => '', 'newRecord' => false, 'selected' => false);

        if (isset($_REQUEST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';
            
            if(in_array($_REQUEST['id'], Yii::app()->params['advisers'])) { 
                $coordinator = ($_REQUEST['id'] == 3)? 2 : 5;
                
                $condition = 't.active = 1 AND usersProfiles.idUserProfile = '.$coordinator;
                
                if(Yii::app()->user->getState('rol') == 11) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCompany = ' . Yii::app()->user->getId();                    
                }

                $criteria = new CDbCriteria();
                $criteria->condition = $condition;
                $criteria->order = 't.name ASC';
                
                $model = Users::model()->with('usersProfiles')->findAll($condition);
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
                
                $return['status'] = 'success';
                $return['selected'] = in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])? true : false;
                $return['idCoordinator'] = Yii::app()->user->getId();
                $return['msg'] = Yii::t('front', 'ok');
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionGetRelationship() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = false;

        if (isset($_POST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';

            if ($_POST['id'] != '') {
                $model = RelationshipType::model()->findAll(array('condition' => 'idTypeReference =' . $_POST['id'], 'order' => 'name ASC'));
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'ok');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionGetHelpLinks() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
        
        
        if (isset($_POST['type']) && $_POST['type'] != '') {             

            $model = LinksHelp::model()->findAll(array('condition' => 'type ='.$_POST['type'],'order' => 'name ASC'));

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');

            foreach ($model as $value){
                $return['html'] .= $this->renderPartial('/general/partials/item-help-links', array('model' => $value), true);                                                
            }
        }
        

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionSearchDebtor() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
                
        if (isset($_POST) && !Yii::app()->user->isGuest) {
                        
            
            $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            
            if ($user != null) {
                $model = new SearchDebtor;
                $model->setAttributes($_POST);

                if($model->validate()){
                    
                    $criteria = new CDbCriteria();
                    $criteria->select = 't.idDebtor, t.customer, t.name, t.code';
                    $criteria->limit = 5;
                    $criteria->offset = 0;
                    $condition = 'code LIKE "%' . $_POST['code'] . '%"';

                    if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'],Yii::app()->params['coordinators']))) {                        
                        $criteria->join = ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= ' cc.idCoordinator = ';
                        $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
                    } elseif(Yii::app()->user->getState('rol') == 7) {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 't.idCustomer = ' . Yii::app()->user->getId();
                    }

                    $states = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');
                
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idState NOT IN ('.implode(",", $states).')';
                    
                    $criteria->condition = $condition;
                    $criteria->order = "t.code";
                    
                    $count = ViewDebtors::model()->count($criteria);
                    $model = ViewDebtors::model()->findAll($criteria);
                    
                    $return['html'] = ($count == 0)? '<p>'.Yii::t('front', 'No se encontraron registros').'</p>' : $this->renderPartial('/general/searchDebtor', array('model' => $model), true);       
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                    
                }else{
                    
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    Yii::log("Error Pagos", "error", "actionSave");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }

                }
                
            }
            
        }
        

        echo CJSON::encode($return);
    }
    
    
    //=============================================================================================
    public function actionCheckTerms() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
                
        if (isset($_POST) && !Yii::app()->user->isGuest) {             
                $model = new UsersPrivacy;
                $model->setAttributes($_POST);
                $model->id = Yii::app()->user->getId();
                $model->date = date("Y-m-d H:i:s");

                if($model->validate()){                    
                    $user = Users::model()->findByPk($model->id);                    
                    if($user != null){
                        $user->check_terms = $model->terms;
                        $user->date_check_terms = $model->date;                        
                        if($user->save(false)){
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'Validación Exitosa');
                        }else{
                            $return['status'] = 'error';
                            $return['msg'] = '';
                            Yii::log("Error Privacy user", "error", " save check privacy");
                            foreach ($user->getErrors() as $error) {
                                $return['msg'] .= $error[0] . "<br/>";
                            }
                        }                        
                    }else{
                       $return['status'] = 'warning';
                       $return['msg'] = Yii::t('front', 'Usuario no localizado'); 
                    }
                }else{
                    $return['status'] = 'error';
                    $return['msg'] = '';
                    Yii::log("Error Privacy user", "error", "check privacy");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
        }
        

        echo CJSON::encode($return);
    }
    
    
    //=============================================================================================
    public function actionGetCategoryLegal() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = false;

        if (isset($_POST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';

            if ($_POST['id'] != '') {
                $model = OfficeLegal::model()->findAll(array('condition' => 'idOfficeLegal =' . $_POST['id'], 'order' => 'name ASC'));
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'ok');
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionViewSupport() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'html' => '',
            'type' => '',
            );
        
        if (isset($_POST['file']) && $_POST['file'] != '') {
            
            $file = Controller::viewSupport($_POST['file']);
            
            $return['status'] = $file['status'];
            $return['type'] = $file['type'];
            $return['html'] = ($file['status'] == 'success')? $this->renderPartial('/general/partials/item-view-support', array('file' => $file), true)  : '' ;
            $return['msg'] = $file['msg'];
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionGetMapsDebtor() {
        
        
        $models = Debtors::model()->findAll(array('condition' => 'address_lat is null AND address <> ""','order'=> 'id DESC'));
        //,'limit' => '30', 'offset' => 0
        
        foreach ($models as $model){
            $result = Controller::getLocationDebtor($model);
            
            if($result['status'] == 'error'){
                echo $model->id.'--'.$result['msg'].'<br>';
            }
        }        
    }
    
    //=============================================================================================
    public function actionGetMapsBusiness() {
        
        
        $models = Users::model()->findAll(array('condition' => 'lat is null AND address <> ""','order'=> 'id DESC'));
        //,'limit' => '30', 'offset' => 0
        
        foreach ($models as $model){
            $result = Controller::getLocationBusiness($model);
            
            if($result['status'] == 'error'){
                echo $model->id.'--'.$result['msg'].'<br>';
            }
        }
        
        
    }
    //=============================================================================================    
    public function actionGetNotifications() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Inválida'),
            'html' => '',
            'type' => '',
            );
        
        $limit = 15;
        $idQuery = array('-*idD*-');
        
        $model = UsersNotifications::model()->findAll(array('condition' => 'idUser ='.Yii::app()->user->getId().'','limit' => 15,'order' => 'dateCreated DESC'));
        $count = UsersNotifications::model()->count(array('condition' => 'idUser ='.Yii::app()->user->getId().'')); 
        $params = array();
        foreach ($model as $value){ 
            $params = $value->getParams(); 
            $value->message = $value->messages->msg;
            foreach($params as $key=>$par){
                //$par = str_replace(' ', '', $par);
                if(in_array($key, $idQuery)){
                    if(isset($params['params'])){
                        $params_select = '';
                        $params['params'] = explode(',', $params['params']);
                        $key = array();
                        $i = 0;
                        //Se recorren los parámetros y se crea un arreglo para los parámetros
                        foreach ($params['params'] as $param){
                            $key[$i] = ' -*'.$param.'*-'; 
                            $params_select .= $param.' AS '.$i.',';                       
                            $i++;
                        }
                        $params_select = substr($params_select, 0, -1);
                        $data = Yii::app()->db->createCommand()
                            ->select($params_select)
                            ->from($params['tbl'])
                            ->where('id=:id', array(':id'=>$par))
                            ->queryRow();                   
                        if($data != null){
                            $par = Controller::formatParams($data);
                        }else{
                            $value->idMessage = 7;
                            $value->save();
                        }  
                    }
                    $value->url = ($value->idMessage == 7) ? "#" : Yii::app()->createUrl("/".$value->messages->typeNot->single_url."/".Controller::unformatMoney($par[0]));  
                }
                $value->message = str_replace($key,$par,$value->message);
            }
            $typeNotification = array(1,5,6);
            if(in_array($value->messages->idTypeNotification, $typeNotification)){
                if($value->idMessage == 7){
                    $value->url = "#";
                }else{
                    $value->url = (array_key_exists('-*numbers*-', $params) && $params['-*numbers*-'] == 1) ? Yii::app()->createUrl("/".$value->messages->typeNot->single_url."/".$params['-*idL*-']) : Yii::app()->createUrl("/".$value->messages->typeNot->general_url);
                }         
            }
        }
        UsersNotifications::model()->updateAll(array('seen' => 1,'idUser = '.Yii::app()->user->getId()));
        $return['html'] = $this->renderPartial('/layouts/partials/items-notifications', array('model' => $model, 'count' => $count, 'limit' => $limit), true);
        $return['status'] = 'success';
        $return['msg'] = 'Notifications !';
        
         echo CJSON::encode($return);
        
        
    }    
    //=============================================================================================
    public function actionGetDebtorAmortization() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'html' => '',
            'newRecord' => false
            );

        if (isset($_POST['idDebtor'])) {

            $return['newRecord'] = false;
            $model = ViewDebtors::model()->find(array('condition' => 'idDebtor ='.$_POST['idDebtor']));
            $debtor = Debtors::model()->findByPk($_POST['idDebtor']);
            
            if($model != null){                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'ok');
                $return['html'] =  $this->renderPartial('/general/partials/form-amortization', array('model' => $model, 
                    'debtor' => $debtor ), true);
            }else{
                $return['msg'] = Yii::t('front', 'Información no encontrada');                
            }
        }

        echo CJSON::encode($return);
    }
    //=============================================================================================
    public function actionCalculateAmortizacion() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['html'] = '';
          
        if (isset($_POST)){
            
            $model = new Amortization();
            $model->setAttributes($_POST);
            
            if($model->type_solution != 1){
                $model->setScenario('dateInitial');
            }
            
            if($model->validate()){
                
                if($model->type_solution == 1){
                   $html = GeneralController::getPayTotal($model); 
                }else{
                   $html = GeneralController::getPayQuote($model);
                }
                $return['status'] = 'success';
                $return['msg'] = 'ok.';
                $return['html'] = $html;
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error amortizacion", "error", "actionCalculate");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
                
            }

        }
        

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public static function getPayTotal($model) {
        
        $html = Yii::app()->controller->renderPartial('/general/partials/item-amortization', array('ano' => '',
                'm' => 1, 
                'month' => '-',
                'days' => '-',
                'rate' => '-',
                'cuota' => $model->capital, 
                'intereses' => 0,
                'interestPending' => 0,
                'amortizacion' => $model->capital,
                'capitalpendiente' => 0
                    ), true);   

        
        return  $html;
    } 
    
    //=============================================================================================
    public static function getPayQuote($model) {
        
        $int = $model->interest;
        $princ = ($model->agreement - $model->quote_initial);
        $dateInitial = $model->date_initial;
        $intRate = ($int > 0 )? (($int / 12) / 100) : 0;
        $months = $model->time; 
        $floor = ($int > 0)? ($princ * $intRate) : $princ;
        $quote = ($int > 0)? (1 - pow(1 + $intRate, (-1 * $months))) : $months;
        $cuota = round((($floor / $quote * 100) / 100), 2);
       
        $capitalpendiente = $princ;
        $ano = 1;
        $m = 0;

        $html = Yii::app()->controller->renderPartial('/general/partials/item-amortization', array('ano' => '',
                'm' => 0, 
                'month' => $dateInitial,
                'days' => '',
                'rate' => '',
                'cuota' => 0, 
                'intereses' => '',
                'interestPending' => '',
                'amortizacion' => '',
                'capitalpendiente' => ''
                    ), true);   

        $date = GeneralController::getDateAmortization($dateInitial);                
        $dateM = $date;

        for($i = 1; $i <= $months; $i++){ 
            $m++;
            if ($m > 12) {
                $ano++;
                $m = 1;
            }

            $days = ($i == 1)? Controller::getDays($dateInitial,$dateM) : 30;

            $intereses = ($intRate > 0)? $capitalpendiente * $intRate * 100 / 100 : 0;
            $amortizacion = ($cuota - $intereses) * 100 / 100;
            $capitalpendiente = ($capitalpendiente - $amortizacion) * 100 / 100;
            $quote = Yii::app()->controller->renderPartial('/general/partials/item-amortization', array('ano' => $ano,
                'm' => $m, 
                'month' => $dateM,
                'days' => $days,
                'rate' => $int,
                'cuota' => $cuota, 
                'intereses' => $intereses,
                'interestPending' => 0,
                'amortizacion' => $amortizacion,
                'capitalpendiente' => $capitalpendiente
                    ), true);                                                

            if ($i == $months) { //ultima cuota redondeo
                $nuevacuota = ($cuota + $capitalpendiente) * 100 / 100;
                $quote = Yii::app()->controller->renderPartial('/general/partials/item-amortization', array('ano' => $ano,
                'm' => $m, 
                'month' => $dateM,
                'days' => $days,
                'rate' => $int,
                'cuota' => $nuevacuota, 
                'intereses' => $intereses,
                'interestPending' => 0,
                'amortizacion' => $nuevacuota,
                'capitalpendiente' => 0
                    ), true);  
            }
            $dateInitial = $dateM;
            $dateM = date('Y-m-d', strtotime("+1 months", strtotime($dateM)));
            $html .= $quote;
        }
        
        return $html;
    }   
    
    
    //=============================================================================================
    public static function getDateAmortization($date) {
        $firsMonth = '';
                
        $days = array('05','20');
        
        $exit = false;
        $i = 0;
        do{               
          $datePay = date('Y-m-d', strtotime("+".$i."months", strtotime($date)));

            foreach ($days as $day){
                $dateArray = date_parse_from_format('Y-m-d', $datePay);
                $newPay = $dateArray['year'].'-'.$dateArray['month'].'-'.$day;
                $cantDays = Controller::getDays($date,$newPay);

                if( $cantDays >= 30 && $cantDays <= 45 ){
                    $firsMonth = $newPay;
                    $exit = true;
                }  
            }
          //$exit = ($i > 1 &&  $firsMonth != '')? true : false;
          $i++;  
        }while(!$exit);
            
        return $firsMonth;
        
    }
    
    //=============================================================================================
    public function actionClickToCall() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'));
        
        $model = new ClickToCall;
        $model->setAttributes($_POST);
        
        if($model->validate()){
            Controller::toCall('573166999882');
        }else{
            $return['status'] = 'error';
            $return['msg'] = '';
            Yii::log("Error amortizacion", "error", "actionCalculate");
            foreach ($model->getErrors() as $error) {
                $return['msg'] .= $error[0] . "<br/>";
            } 
        }
        
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetInfoCall() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'));        
        
        if(isset($_POST['callerid'],$_POST['number']) && ($_POST['callerid'] != '' && $_POST['number'] != '') ){            
            $callerid = $_POST['callerid'];
            $ndestino = $_POST['number'];
            $url = 'http://34.73.87.227/estado.php?callerid=' . $callerid . '&ndestino=' . $ndestino;
            $JSON = file_get_contents($url);
            $datos = json_decode($JSON);

            if(array_key_exists(0, $datos)){            
                $return['status'] = 'success';
                $return['msg'] = 'ok';
                $return['model'] = $datos[0];
            }
        }
                
        echo CJSON::encode($return);
                
    } 
    
    //=============================================================================================
    
    public function actionGetClusters() {
		//die("y aja");
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = false;

        if (isset($_POST['id'])) {

            $return['newRecord'] = false;
            $return['html'] .= '<option value="">' . Yii::t('front', 'Seleccionar opción') . '</option>';

            if ($_POST['id'] != '') {
                $model = Clusters::model()->findAll(array('condition' => 'idMLModel =' . $_POST['id'], 'order' => 'name ASC'));
                foreach ($model as $value) {
                    $return['html'] .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }

            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'ok');
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================


}
