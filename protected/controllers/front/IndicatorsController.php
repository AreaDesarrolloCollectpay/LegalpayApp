<?php

class IndicatorsController extends Controller {

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
        $this->access = array(1, 7);
        $this->pSize = 4;
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

    //INDICATORS
    //
    //=============================================================================================
    public function actionIndex() {
        if (!Yii::app()->user->isGuest) {
                                                
            $creditModalities = CreditModality::model()->findAll();
            $regions = Regions::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));
            $ageDebts = AgeDebt::model()->findAll(array('limit' => 4, 'offset' => 0));
            $coordinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
            $customers = ViewCustomers::model()->findAll(array('select'  => 'id, name', 'order' => 'name ASC'));
            
            $indicators = Controller::getIndicators();
            
            $this->render('indicators',array(
                'creditModalities' => $creditModalities,
                'regions' => $regions,
                'ageDebts' => $ageDebts,
                'coordinators' => $coordinators,
                'customers' => $customers,
                'indicators' => $indicators
                    ));            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionGetChartIndicators() {
        $return = array('status' => 'success', 'msg', Yii::t('front', 'Solicitud Invalida'), 'data' => array());
                
        $type = (isset($_REQUEST['idType']) && $_REQUEST['idType'] != '')? $_REQUEST['idType'] : 0;
        
        switch ($type) {
            case 0:
                $return = IndicatorsController::ChartIndicatorsStates($_REQUEST);  
                break;
            case 1:
                $return = IndicatorsController::ChartIndicatorsRegional($_REQUEST);
                break;
            case 2:
                $return = IndicatorsController::ChartIndicatorsModalities($_REQUEST);
                break;
            case 3:
                $return = IndicatorsController::ChartIndicatorsPerson($_REQUEST);
                break;
            case 4:
                $return = IndicatorsController::ChartIndicatorsProperty($_REQUEST);
                break;
            case 5:
                $return = IndicatorsController::ChartIndicatorsYear($_REQUEST);
                break;
            case 6:
                $return = IndicatorsController::ChartIndicatorsAgreement($_REQUEST);
                break;
        }
        
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    
    //=============================================================================================
        
        public static function ChartIndicatorsStates($POST) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'),'title' => Yii::t('front', 'ESTADOS DE CARTERA'), 'model' => '', 'color' => '#312691');
            
            $filters = array('idCustomer', 'ageDebt');       

            $criteria = new CDbCriteria();
            $condition = '';
            $condition_ = '';
            $cJoin = '';
            $join = 'LEFT JOIN view_indicators vi ON t.id = vi.idState';
            
            $criteria->select = 't.id,IFNULL(SUM(vi.capital),0) as capital, count(vi.idDebtor) as cant,t.name as name,t.color as color';                

            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $cJoin .= ($i == 0) ? ' AND ( ' : '';
                        $cJoin .= ($i > 0) ? ' AND ' : '';
                        $cJoin .= 'vi.' . $key.' = ' . $value;
                        $i++;
                    }
                }

                $cJoin .= ($cJoin != '') ? ')' : '';
            }

            $join .= $cJoin;

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){                
                $join .= ' JOIN tbl_campaigns_debtors cd ON vi.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            }

            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 't.historic = 0 AND t.idDebtorsState IS NULL AND t.is_legal = 0';

            $criteria->join =  $join;
            $criteria->group = 't.id';
            $criteria->order = 't.name';
            $criteria->condition = $condition;
            
            $model = DebtorsState::model()->findAll($criteria);
            
            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= '?idState=*';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';
            
            $data = array_map(function($m)use ($url){               
                return  array("name" => $m->name,"y" => $m->capital, "cant" => $m->cant, "url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', $m->id, $url)));                
            },$model);
                        
            $condition_ .= ($condition_ != '') ? ' AND ' : '';
            $condition_ .= 't.historic = 0 AND t.idDebtorsState IS NULL AND t.is_legal = 1';            
            $criteria->condition = $condition_;
            $criteria->group = null;
            
            $model = DebtorsState::model()->find($criteria);
            $cantL = DebtorsState::model()->count($criteria);
            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '?idCustomer='.$POST['idCustomer'] : '';
            $legal = ($cantL > 0)?  array(array("name" => $model->name,"y" => $model->capital, "cant" => $model->cant, "url" => Yii::app()->controller->createAbsoluteUrl('wallet/legal/0'.$url))) : array();
            
            $return['data'] = array_merge($data,$legal);                 

            return $return;
        }

    //=============================================================================================
    
        public static function ChartIndicatorsRegional($POST) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => '', 'title', Yii::t('front', 'DISTRIBUCIÓN REGIONAL'), 'color' => '#FF4C13');
            
            $filters = array('idCustomer', 'ageDebt');       

            $criteria = new CDbCriteria();
            $condition = '';
            $join = 'LEFT JOIN view_indicators vi ON t.id = vi.idCity JOIN tbl_debtors_state tds ON vi.idState = tds.id AND tds.historic = 0';

            $criteria->select = 't.id,IFNULL(SUM(vi.capital),0) as capital, count(vi.idDebtor) as cant,t.name as name';                

            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 'vi.' . $key.' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON vi.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];

            }

            $criteria->join =  $join;
            $criteria->group = 't.id';
            $criteria->order = 't.name';
            $criteria->condition = $condition;

    //        print_r($criteria);
    //        exit;
            
            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= '?city=*';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';
            
            $model = Cities::model()->findAll($criteria);        
            $return['data'] = $return['data'] = array_map(function($m)use ($url){
                return  array("name" => $m->name,"y" => $m->capital, "cant" => $m->cant, "url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', $m->name, $url)));
                
            },$model); 

            return $return;
        }    

        //=============================================================================================
    
        public static function ChartIndicatorsModalities($POST){
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'color' => '#7cb5ec');
            
            $filters = array('idRegion', 'ageDebt');       

            $criteria = new CDbCriteria();            
            $condition = '';
            $cJoin = '';
            $join = 'LEFT JOIN view_indicators vi ON t.id = vi.idCreditModality JOIN tbl_debtors_state tds ON vi.idState = tds.id AND tds.historic = 0';

            $criteria->select = 't.id,IFNULL(SUM(vi.capital),0) as capital, count(vi.idDebtor) as cant,t.name as name';                

            if (isset($_POST)) {
                $i = 0;
                foreach ($_POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $cJoin .= ($i == 0) ? ' AND ( ' : '';
                        $cJoin .= ($i > 0) ? ' AND ' : '';
                        $cJoin .= 'vi.' . $key.' = ' . $value;
                        //$condition .= (($key != 'idState')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $cJoin .= ($cJoin != '') ? ')' : '';
            }

            if(isset($_POST['idCustomer']) && $_POST['idCustomer'] != ''){   
                $cJoin .= ' AND vi.idCustomer = '.$_POST['idCustomer'];
            }

            $join .= $cJoin;

            if(isset($_POST['idCoordinator'],$_POST['idAdviser']) && ($_POST['idCoordinator'] != '' || $_POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON vi.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            }

            $criteria->join =  $join;
            $criteria->group = 't.id';
            $criteria->order = 't.name';
            $criteria->condition = $condition;
            
            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= '?idCreditModality=*';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';
            
            $model = CreditModality::model()->findAll($criteria);        
            $return['data'] = $return['data'] = array_map(function($m)use ($url){
                return  array("name" => $m->name,"y" => $m->capital, "cant" => $m->cant, "url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', $m->id, $url)));
                
            },$model); 

            return $return;
        }    
        //=============================================================================================
        
        public static function ChartIndicatorsPerson($POST) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'title' => Yii::t('front', 'TIPOS DE PERSONA'), 'model' => '', 'color' => '#90ed7d');
            
            $filters = array('idCustomer', 'ageDebt');       

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN view_indicators vi ON t.id = vi.idTypeDocument JOIN tbl_debtors_state tds ON vi.idState = tds.id AND tds.historic = 0';

            $criteria->select = 't.id,IFNULL(SUM(vi.capital),0) as capital, count(vi.idDebtor) as cant,t.alias as alias';                

            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? ' ( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 'vi.' . $key.' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
               $join .= ' JOIN tbl_campaigns_debtors cd ON vi.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];

            }

            $criteria->join =  $join;
            $criteria->group = 't.id';
            $criteria->order = 't.name';
            $criteria->condition = $condition;

            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= '?idTypeDocument=*';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';
            
            $model = TypeDocuments::model()->findAll($criteria);
            
            $return['data'] = array_map(function($m)use ($url){
                return  array("name" => $m->alias,"y" => $m->capital, "cant" => $m->cant, "url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', $m->id, $url)));}
                ,$model);                 
            return $return;
        }

        //=============================================================================================

        public static function ChartIndicatorsProperty($POST) {
            $return = array('status' => 'success', 'msg' => 'Solicitud Invalida', 'data' => array(),'title' => Yii::t('front', 'GARANTIAS'),'color' => '#FFD800');

            $filters = array('idCustomer', 'ageDebt');       
            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0';

            $criteria->select = 'IFNULL(SUM(t.capital),0) as capital,count(t.idDebtor) as cant';                

            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? ' ( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key.' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }


            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            }

            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 'cant';

            $criteria->join =  $join;        
            $criteria->condition = $condition.' > 0';
            
            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= '?property=*';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';
            
            // GARANTIAS
            $data = ViewIndicatorsProperty::model()->find($criteria); 
            $property = array(array('name' => Yii::t('front', 'CON GARANTIAS'), 'y' => (($data!= null)? $data->capital : 0), 'cant' => (($data!= null)? $data->cant : 0), "url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', 1, $url))));

            // SIN GARANTIAS
            $criteria->condition = $condition.' = 0';
            $data = ViewIndicatorsProperty::model()->find($criteria);        
            $return['data'] = array_merge($property, array(array('name' => Yii::t('front', 'SIN GARANTIAS'), 'y' => (($data!= null)? $data->capital : 0), 'cant' => (($data!= null)? $data->cant : 0), "url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', 0, $url)) )));

            return $return;
        }   
        
        //=============================================================================================

        public static function ChartIndicatorsYear($POST) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => '', 'title' => Yii::t('front', 'EDADES'), 'color' => '#FF4C13');
            
            $filters = array('idCustomer', 'ageDebt');       

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0';

            $criteria->select = 't.id,IFNULL(SUM(t.capital),0) as capital, count(t.id) as cant, YEAR(t.duedate) as name';                

            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key.' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            }

            $criteria->join =  $join;
            $criteria->group = 'YEAR(t.duedate)';
            $criteria->order = 't.name';
            $criteria->condition = $condition;

            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= '?age=*';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';
            
            $model = ViewDebtors::model()->findAll($criteria);  
                              
            $return['data'] =  array_map(function($m)use($url){
                return  array("name" => $m->name,"y" => $m->capital, "cant" => $m->cant,"url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', $m->name, $url)));}
            ,$model); 

            return $return;
        }    
        
        //=============================================================================================
        
        public static function ChartIndicatorsAgreement($POST) {
            $return = array('status' => 'success', 'msg' => 'Solicitud Invalida', 'data' => array(),'title' => Yii::t('front', 'ACUERDOS DE PAGO'),'color' => '#FFD800');

            $filters = array('idCustomer', 'ageDebt');       
            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN view_debtors_agreements vda ON t.idDebtor = vda.idDebtor';

            $criteria->select = 'IFNULL(SUM(vda.value),0) as capital,count(t.idDebtor) as cant';                

            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? ' ( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key.' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            }
            
            $criteria->join =  $join;        
            $criteria->condition = $condition;
//            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
//            $url .= '?property=*';
//            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';            
            // ACUERDO
            $data = ViewDebtors::model()->find($criteria); 
            $agreement = array(array('name' => Yii::t('front', 'CON ACUERDO'), 'y' => (($data!= null)? $data->capital : 0), 'cant' => (($data!= null)? $data->cant : 0), "url" => '#'));

            // SIN ACUERDO            
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 'vda.id is NULL';
            $criteria->condition = $condition;
            $criteria->join = 'LEFT '.$join;
            
            $data = ViewDebtors::model()->find($criteria);        
            $return['data'] = array_merge($agreement, array(array('name' => Yii::t('front', 'SIN ACUERDO'), 'y' => (($data!= null)? $data->capital : 0), 'cant' => (($data!= null)? $data->cant : 0), "url" => '#' )));

            return $return;
        }
        
        //=============================================================================================
        
        public function actionGetStates() {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '');
            
            $states = DebtorsState::model()->findAll(array('condition' => 'idDebtorsState IS NULL AND is_legal = 0','order' => 'name ASC'));
            $return['model'] = CHtml::listData( $states,'id','name');
            $return['model'] = array_merge($return['model'],array('0' => Yii::t('front', 'JURÍDICO')));

            echo CJSON::encode($return);
        }
        
        //=============================================================================================
        
       
    
      
    //PERFORMANCE
    //
    //=============================================================================================
    public function actionPerformance() {
        if (!Yii::app()->user->isGuest) {
                        
            $creditModalities = CreditModality::model()->findAll();
            $regions = Regions::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));
            $ageDebts = AgeDebt::model()->findAll(array('limit' => 4, 'offset' => 0));
            $coodinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2', 'order' => 'name'));
            $customers = ViewCustomers::model()->findAll(array('select'  => 'id, name'));
            $indicators = Controller::getIndicators();
            
            $this->render('performance',array(
                'creditModalities' => $creditModalities,
                'regions' => $regions,
                'ageDebts' => $ageDebts,
                'coodinators' => $coodinators,
                'customers' => $customers,
                'indicators' => $indicators
                    ));                     
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionGetChartPerformance() {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'),'title' => Yii::t('front', 'KPI’s (Key Performance Indicator)'), 'data' => array(),'bg' => array());
        
        $radius = 112;        
        $rP = $radius-12;
         
        $penetration = IndicatorsController::KPIPenetration($_POST,$radius,$rP);
        
        $radius = $rP - 1;
        $rP = $radius - 12;
        
        $intensity =  IndicatorsController::KPIIntensity($_POST,$radius,$rP);       
       
        $radius = $rP - 1;
        $rP = $radius - 12;
        
        $hits = IndicatorsController::KPIHits($_POST,$radius,$rP,$penetration, $intensity);      
                
        $radius = $rP - 1;
        $rP = $radius - 12;
        
        $RPC = IndicatorsController::KPIRPC($_POST,$radius,$rP);      
        
        $radius = $rP - 1;
        $rP = $radius - 12;
        
        $PTP = IndicatorsController::KPIPTP($_POST,$radius,$rP,$RPC['RPC']);      
        
        $radius = $rP - 1;
        $rP = $radius - 12;
        
        $KP = IndicatorsController::KPIKP($_POST,$radius,$rP,$PTP['PTP']);
                        
        $return['data'] = array_merge($penetration['data'], $intensity['data'], $hits['data'], $RPC['data'], $PTP['data'], $KP['data']);
        $return['bg'] = array_merge($penetration['bg'], $intensity['bg'], $hits['bg'], $RPC['bg'], $PTP['bg'], $KP['bg']);
                        
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    
    //=============================================================================================

        public static function KPIPenetration($POST,$radius,$rP) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'bg' => array());

            $stateCondition = '*.historic = 0 AND *.idDebtorsState IS NULL';                      
            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.is_contact = 1 AND  '.str_replace('*', 'tds', $stateCondition);
            $join_ = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND  '.str_replace('*', 'tds', $stateCondition);

            if(isset($POST['idRegion']) &&  $POST['idRegion'] != '' ){
                $join .= ' JOIN view_location vw ON t.idCity = vw.idCity AND vw.idRegion = '.$POST['idRegion'];                    
                $join_ .= ' JOIN view_location vw ON t.idCity = vw.idCity AND vw.idRegion = '.$POST['idRegion'];                    
            }

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $user = ($POST['idAdviser'] != '')? ViewUsers::model()->find(array('condition' => 'id =' . $POST['idAdviser'])) : null;
                $coordinator = ($user == null)? $POST['idCoordinator']  : $user->idCoordinator;
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$coordinator;
                $join_ .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$coordinator;
            } 


            // cuentas contactadas
            $criteria->join =  $join;                    
            $criteria->select = 't.idDebtor';  
            $criteria->condition = $condition;
            $datac = ViewDebtors::model()->count($criteria);

            // cuentas asignadas
            $criteria->join = $join_;        
            $dataA = ViewDebtors::model()->count($criteria);

            $data = ($dataA > 0)? ( $datac / $dataA) : 0;
            $return['C'] = $datac;
            $return['A'] = $dataA;
            $return['data'] = array( array(
                'name' => Yii::t('front', 'Penetración'),
                'data' => array( array(
                            'color' => 'rgb(124,181,236)',
                            'radius' => $radius.'%',
                            'innerRadius' =>  $rP.'%',
                            'y' => round(($data * 100),2) ,
                            'z' => Yii::t('front','Cuentas Contactadas / Cuentas Asignadas'),
                )),
                'showInLegend' => true
            ));

            $return['bg'] = array(array(
                 'outerRadius' =>  $radius.'%',
                 'innerRadius' =>  $rP.'%',
                 'backgroundColor' => 'rgba(124,181,236,0.3)',
                 'borderWidth' =>  '0'
            )); 

            return $return;
        } 
        //=============================================================================================

        public static function KPIIntensity($POST,$radius,$rP) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'bg' => array());

            $stateCondition = '*.historic = 0  AND *.idDebtorsState IS NULL';        
            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_obligations tdo ON t.idDebtor = tdo.id JOIN tbl_debtors td ON tdo.idDebtor = td.id  JOIN tbl_debtors_state tds ON td.idDebtorsState = tds.id AND '.str_replace('*', 'tds', $stateCondition);

            if(isset($POST['idRegion']) &&  $POST['idRegion'] != '' ){
                $join .= ' JOIN view_location vw ON td.idCity = vw.idCity AND vw.idRegion = '.$POST['idRegion'];                    
            }     

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){            
                $condition_ = '';
                if($POST['idAdviser'] != ''){
                    $condition_ .= ' va.id = '.$POST['idAdviser'];
                }else{        
                    $condition_ .= 'va.idCoordinator = '.$POST['idCoordinator'];
                }                    
                $user = ($POST['idAdviser'] != '')? ViewUsers::model()->find(array('condition' => 'id =' . $POST['idAdviser'])) : null;
                $coordinator = ($user == null)? $POST['idCoordinator']  : $user->idCoordinator;            
                $join .= ' JOIN view_advisers va ON t.idUserAsigned = va.id  AND '.$condition_.' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$coordinator;

            } 

            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 't.idTasksAction IN (1,12)';
            $criteria->condition = $condition;
            //Intentos
            $criteria->join =  $join;   
            $criteria->select = 't.id';
            $dataI = ViewManagement::model()->count($criteria);

            //print_r($dataI);

            //cuentas intentadas
            $criteria->select = 't.id';
            $criteria->group = 'td.id';
            $dataC = ViewManagement::model()->count($criteria);


            $data = ($dataC > 0)? ((($dataI != null)? $dataI : 0) / $dataC) : 0;

            $return['I'] =  ($dataI != null)? $dataI : 0;
            $return['C'] =  ($dataC != null)? $dataC : 0;

            $return['data'] = array( array(
                'name' => Yii::t('front', 'Intensidad'),
                'data' => array( array(
                            'color' => 'rgb(67,67,72)',
                            'radius' => $radius.'%',
                            'innerRadius' =>  $rP.'%',
                            'y' => round(($data * 100),2),
                            'z' => Yii::t('front','Intentos / Cuentas Intentadas'),
                )),
                'showInLegend' => true
            ));          

            $return['bg'] = array(array(
                 'outerRadius' =>  '99%',
                 'innerRadius' =>  '87%',
                 'backgroundColor' => 'rgba(67,67,72,0.3)',
                 'borderWidth' =>  '0'
            )); 

            return $return;
        } 

        //=============================================================================================

        public static function KPIHits($POST,$radius,$rP,$penetration,$intensity) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'bg' => array());

            $data = ($intensity != null && $intensity['I'] > 0)? ((($penetration != null)? $penetration['C'] : 0) / (($intensity != null)? $intensity['I'] : 0)) : 0;

            $return['data'] = array( array(
                'name' => Yii::t('front', 'Hits'),
                'data' => array( array(
                            'color' => 'rgb(144,237,125)',
                            'radius' => $radius.'%',
                            'innerRadius' =>  $rP.'%',
                            'y' => round(($data * 100),2),
                            'z' => Yii::t('front','Contactos / Intentos'),
                )),
                'showInLegend' => true
            ));          

            $return['bg'] = array(array(
                 'outerRadius' =>  $radius.'%',
                 'innerRadius' =>  $rP.'%',
                 'backgroundColor' => 'rgba(144,237,125,0.3)',
                 'borderWidth' =>  '0'
            )); 

            return $return;
        } 

        //=============================================================================================

        public static function KPIRPC($POST,$radius,$rP) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'bg' => array());

            $stateCondition = '*.historic = 0  AND *.idDebtorsState IS NULL';

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_obligations tdo ON t.idDebtor = tdo.id JOIN tbl_debtors td ON tdo.idDebtor = td.id  JOIN tbl_debtors_state tds ON td.idDebtorsState = tds.id AND '.str_replace('*', 'tds', $stateCondition);

            if(isset($POST['idRegion']) &&  $POST['idRegion'] != '' ){
                $join .= ' JOIN view_location vw ON td.idCity = vw.idCity AND vw.idRegion = '.$POST['idRegion'];                    
            }        

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $user = ($POST['idAdviser'] != '')? ViewUsers::model()->find(array('condition' => 'id =' . $POST['idAdviser'])) : null;
                $coordinator = ($user == null)? $POST['idCoordinator']  : $user->idCoordinator;
                $join .= ' JOIN view_advisers va ON t.idUserAsigned = va.id AND va.idCoordinator = '.$coordinator.' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$coordinator;

            } 

            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(t.datePay BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }

            $condition .= ($condition != '') ? ' AND ' : '';        
            $condition .= 't.idTasksAction IN (1,12)';
            $criteria->condition = $condition;
            $criteria->join = $join;
            $dataT = ViewManagement::model()->count($criteria);

            //Intentos
            $condition .= ($condition != '') ? ' AND ' : '';        
            $condition .= 't.is_contact = 1';
            $criteria->condition =  $condition;

            $dataC = ViewManagement::model()->count($criteria);

            $data = ($dataT > 0)? ((($dataC != null)? $dataC : 0) / $dataT) : 0;

            $return['RPC'] = round(($data * 100),2);
            $return['data'] = array( array(
                'name' => Yii::t('front', 'RPC (Contactos Correctos)'),
                'data' => array( array(
                            'color' => 'rgb(247,163,92)',
                            'radius' => $radius.'%',
                            'innerRadius' =>  $rP.'%',
                            'y' => round(($data * 100),2),
                            'z' => Yii::t('front','Contactos Exitosos / Total Contactos'),
                )),
                'showInLegend' => true
            ));          

            $return['bg'] = array(array(
                 'outerRadius' =>  $radius.'%',
                 'innerRadius' =>  $rP.'%',
                 'backgroundColor' => 'rgba(247,163,92,0.3)',
                 'borderWidth' =>  '0'
            )); 

            return $return;
        } 

        //=============================================================================================

        public static function KPIPTP($POST,$radius,$rP,$RPC) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'bg' => array());

            $stateCondition = '*.historic = 0  AND *.idDebtorsState IS NULL';

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_obligations tdo ON t.idDebtorObligation = tdo.id JOIN tbl_debtors td ON tdo.idDebtor = td.id  JOIN tbl_debtors_state tds ON td.idDebtorsState = tds.id AND '.str_replace('*', 'tds', $stateCondition);


            if(isset($POST['idRegion']) &&  $POST['idRegion'] != '' ){
                $join .= ' JOIN view_location vw ON td.idCity = vw.idCity AND vw.idRegion = '.$POST['idRegion'];                    
            }      

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $condition_ = '';
                if($POST['idAdviser'] != ''){
                    $condition_ .= ' va.id = '.$POST['idAdviser'];
                }else{        
                    $condition_ .= 'va.idCoordinator = '.$POST['idCoordinator'];
                }                    
                $user = ($POST['idAdviser'] != '')? ViewUsers::model()->find(array('condition' => 'id =' . $POST['idAdviser'])) : null;
                $coordinator = ($user == null)? $POST['idCoordinator']  : $user->idCoordinator;
                $join .= ' JOIN view_advisers va ON t.idUserPayments = va.id AND '.$condition_.' JOIN tbl_campaigns_debtors cd ON tdo.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$coordinator;

            } 

            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(t.datePay BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }

            $condition .= ($condition != '') ? ' AND ' : '';        
            $condition .= 't.idPaymentsState = 4';
            $criteria->join = $join;
            $criteria->condition = $condition;
            $criteria->select = 't.id';
            $criteria->group = 'td.id';
            $dataP = DebtorsPayments::model()->count($criteria);

    //        echo $dataP.'<br>';
    //        echo $RPC;
    //        exit;
            $data =  ($RPC > 0)? ((($dataP != null)? $dataP : 0) / (($RPC != null)? $RPC : 0)) : 0;

            $return['PTP'] = round(($data),2);
            $return['data'] = array( array(
                'name' => Yii::t('front', 'PTP (Promesas a Pagar)'),
                'data' => array( array(
                            'color' => 'rgb(128,133,233)',
                            'radius' => $radius.'%',
                            'innerRadius' =>  $rP.'%',
                            'y' => round(($data),2),
                            'z' => Yii::t('front','Promesas de Pago / RPC'),
                )),
                'showInLegend' => true
            ));          

            $return['bg'] = array(array(
                 'outerRadius' =>  $radius.'%',
                 'innerRadius' =>  $rP.'%',
                 'backgroundColor' => 'rgba(128,133,233,0.3)',
                 'borderWidth' =>  '0'
            ));

            return $return;
        } 

        //=============================================================================================
        public static function KPIKP($POST,$radius,$rP,$PTP) {
            $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'bg' => array());

            $stateCondition = '*.historic = 0  AND *.idDebtorsState IS NULL';

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_obligations tdo ON t.idDebtorObligation = tdo.id JOIN tbl_debtors td ON tdo.idDebtor = td.id  JOIN tbl_debtors_state tds ON td.idDebtorsState = tds.id AND '.str_replace('*', 'tds', $stateCondition);

            if(isset($POST['idRegion']) &&  $POST['idRegion'] != '' ){
                $join .= ' JOIN view_location vw ON td.idCity = vw.idCity AND vw.idRegion = '.$POST['idRegion'];                    
            }        

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $condition_ = '';
                if($POST['idAdviser'] != ''){
                    $condition_ .= ' va.id = '.$POST['idAdviser'];
                }else{        
                    $condition_ .= 'va.idCoordinator = '.$POST['idCoordinator'];
                }                    
                $user = ($POST['idAdviser'] != '')? ViewUsers::model()->find(array('condition' => 'id =' . $POST['idAdviser'])) : null;
                $coordinator = ($user == null)? $POST['idCoordinator']  : $user->idCoordinator;
                $join .= ' JOIN view_advisers va ON t.idUserPayments = va.id AND '.$condition_.' JOIN tbl_campaigns_debtors cd ON tdo.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$coordinator;

            } 

            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(t.datePay BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }

            $condition .= ($condition != '') ? ' AND ' : '';        
            $condition .= 't.idPaymentsState = 6 AND t.is_promise = 1';
            $criteria->join = $join;
            $criteria->condition = $condition;
            $criteria->select = 't.id';
            $criteria->group = 'td.id';
            $dataP = DebtorsPayments::model()->count($criteria);

    //        echo $dataP.'<br>';
    //        echo $PTP;
    //        exit;
            $data =  ($PTP > 0)? ((($dataP != null)? $dataP : 0) / $PTP ) : 0;

            $return['PTP'] = round(($data),2);
            $return['data'] = array( array(
                'name' => Yii::t('front', 'KP (Promesas Mantenidas)'),
                'data' => array( array(
                            'color' => 'rgb(241,92,128)',
                            'radius' => $radius.'%',
                            'innerRadius' =>  $rP.'%',
                            'y' => round(($data),2),
                            'z' => Yii::t('front','Promesas Cumplidas / PTP'),
                )),
                'showInLegend' => true
            ));          

            $return['bg'] = array(array(
                 'outerRadius' =>  $radius.'%',
                 'innerRadius' =>  $rP.'%',
                 'backgroundColor' => 'rgba(241,92,128,0.3)',
                 'borderWidth' =>  '0'
            ));

            return $return;
        } 

        //=============================================================================================
    
    // TENDENCIES //
    //
    //=============================================================================================
    
    public function actionTendencies() {
        if (!Yii::app()->user->isGuest) {
                        
            $creditModalities = CreditModality::model()->findAll();
            $regions = Regions::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));
            $ageDebts = AgeDebt::model()->findAll(array('limit' => 4, 'offset' => 0));
            $coodinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
            $customers = ViewCustomers::model()->findAll(array('select'  => 'id, name'));
            $indicators = Controller::getIndicators();
            
            $this->render('tendencies',array(
                'creditModalities' => $creditModalities,
                'regions' => $regions,
                'ageDebts' => $ageDebts,
                'coodinators' => $coodinators,
                'customers' => $customers,
                'indicators' => $indicators
                    ));                     
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
        public function actionGetChartTendencies() {
            $return = array();
            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['data'] = array();

            $type = (isset($_POST['idType']) && $_POST['idType'] != '')? $_POST['idType'] : 0;

            switch ($type) {
                case 0:
                    $return = IndicatorsController::ChartTendenciesStates($_POST);
                    break;
                case 1:
                    $return = IndicatorsController::ChartTendenciesRegional($_POST);
                    break;
                case 2:
                    echo "i es igual a 2";
                    break;
                case 3:
                    $return = IndicatorsController::ChartTendenciesPerson($_POST);
                    break;
            }

            echo json_encode($return,JSON_NUMERIC_CHECK);
        } 

        //=============================================================================================

        public static function ChartTendenciesStates($POST) {
            $return = array();
            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['title'] = Yii::t('front', 'ESTADOS DE CARTERA');
            $return['data'] = array();

            $filters = array('idRegion', 'ageDebt');       

            $criteriaS = new CDbCriteria();
            $stateCondition = '*.active = 1 AND *.historic = 0 AND *.is_legal = 0 AND *.idDebtorsState IS NULL';
            $stateCondition_ = '*.active = 1 AND *.historic = 0 AND *.is_legal = 1 AND *.idDebtorsState IS NULL';
            $criteriaS->condition = str_replace('*', 't', $stateCondition);        
            $debtorStates = DebtorsState::model()->findAll($criteriaS);

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND '.str_replace('*', 'tds', $stateCondition);
            $join_ = ' JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND '.str_replace('*', 'tds', $stateCondition_);


            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key.' = ' . $value;                    
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }        

            if(isset($POST['idCustomer']) && $POST['idCustomer'] != ''){   
                $condition .= ($condition != '') ? ' AND ' : '';    
                $condition .= ' t.idCustomer = '.$POST['idCustomer'];
            }

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
                $join_ .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            } 

            //$criteria->select = 't.id,DATE_FORMAT(date,"%d/%m/%Y") as date';        
            $criteria->join =  $join;
            $criteria->group = 't.date';
            $criteria->order = 't.date';


            $criteria->select = '(UNIX_TIMESTAMP(t.dateCreated) * 1000) as dateCreated,IFNULL(SUM(t.capital),0) as capital, count(t.idDebtor) as cant, tds.color as color';
            $conditionL = $condition;
            $condition .= ($condition != '') ? ' AND ' : '';  
            
            foreach ($debtorStates as $debtorState){

                $criteria->condition = $condition.' t.idDebtorState ='.$debtorState->id; 

                $datac = ViewTendencies::model()->findAll($criteria);
                $return['data'][] = array('name' => $debtorState->name,
                                            'color' => $debtorState->color,
                                            'data' => array_values(array_map(function($m){return  array("x" => $m->dateCreated,"y" => $m->capital, "z" => $m->cant, "showInLegend" => false,);},$datac)),
                                          );

            }
            
            // legal
            
            $criteria->join = $join_;
            $criteria->condition = $conditionL;
            $datac = ViewTendencies::model()->findAll($criteria); 
            
            $return['data'][] = array('name' => 'JURIDICO',
                                            'color' => '#ff0000',
                                            'data' => array_values(array_map(function($m){return  array("x" => $m->dateCreated,"y" => $m->capital, "z" => $m->cant, "showInLegend" => false,);},$datac)),
                                          );
            

            return $return;
        } 

        //=============================================================================================

        public static function ChartTendenciesRegional($POST) {
            $return = array();
            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['title'] = Yii::t('front', 'DISTRIBUCIÓN REGIONAL');
            $return['data'] = array();

            $filters = array('idRegion', 'idCustomer', 'ageDebt');       
            $stateCondition = '*.historic = 0 AND *.idDebtorsState IS NULL';
            $regions = Regions::model()->findAll(array('condition' => 'active = 1'));

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND '.str_replace('*', 'tds', $stateCondition);


            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key.' = ' . $value;                    
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }        

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            } 

            //$criteria->select = 't.id,DATE_FORMAT(date,"%d/%m/%Y") as date';        
            $criteria->join =  $join;
            $criteria->condition = $condition;
            $criteria->group = 't.date';
            $criteria->order = 't.date';


            $criteria->select = '(UNIX_TIMESTAMP(t.dateCreated) * 1000) as dateCreated,IFNULL(SUM(t.capital),0) as capital, count(t.idDebtor) as cant';
            $condition .= ($condition != '') ? ' AND ' : '';    
            foreach ($regions as $region){

                $criteria->condition = $condition.' t.idRegion ='.$region->id;        
    //            print_r($criteria);
    //            exit;
                $datac = ViewTendencies::model()->findAll($criteria);
                $return['data'][] = array('name' => $region->name,
                                            'data' => array_values(array_map(function($m){return  array("x" => $m->dateCreated,"y" => $m->capital, "z" => $m->cant, "showInLegend" => false,);},$datac)),
                                          );

            }

            return $return;
        } 

        //=============================================================================================
        public static function ChartTendenciesModalities($POST) {
            
            $return = array();
            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['model'] = '';
            $return['color'] = '#7cb5ec';

            $filters = array('idRegion', 'ageDebt');       

            $criteria = new CDbCriteria();            
            $condition = '';
            $cJoin = '';
            $join = 'LEFT JOIN view_indicators vi ON t.id = vi.idCreditModality JOIN tbl_debtors_state tds ON vi.idState = tds.id AND tds.historic = 0';


            $criteria->select = 't.id,IFNULL(SUM(vi.capital),0) as capital, count(vi.idDebtor) as cant,t.name as name';                

            if (isset($_POST)) {
                $i = 0;
                foreach ($_POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $cJoin .= ($i == 0) ? ' AND ( ' : '';
                        $cJoin .= ($i > 0) ? ' AND ' : '';
                        $cJoin .= 'vi.' . $key.' = ' . $value;
                        //$condition .= (($key != 'idState')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $cJoin .= ($cJoin != '') ? ')' : '';
            }


            if(isset($_POST['idCustomer']) && $_POST['idCustomer'] != ''){   
                $cJoin .= ' AND vi.idCustomer = '.$_POST['idCustomer'];
            }

            $join .= $cJoin;

            if(isset($_POST['idCoordinator'],$_POST['idAdviser']) && ($_POST['idCoordinator'] != '' || $_POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON vi.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            }

            $criteria->join =  $join;
            $criteria->group = 't.id';
            $criteria->order = 't.name';
            $criteria->condition = $condition;

            
            $url = (isset($POST['ageDebt']) && $POST['ageDebt'] != '')? '/'.$POST['ageDebt'] : '/0';
            $url .= '?idCreditModality=*';
            $url .= (isset($POST['idCustomer']) && $POST['idCustomer'] != '')? '&idCustomer='.$POST['idCustomer'] : '';
            
            $model = CreditModality::model()->findAll($criteria);        
            $return['data'] = $return['data'] = array_map(function($m)use ($url){
                return  array("name" => $m->name,"y" => $m->capital, "cant" => $m->cant, "url" => Yii::app()->controller->createAbsoluteUrl('/wallet/0'. str_replace('*', $m->id, $url)));
                
            },$model); 

            return $return;
            
            
            
            $return = array();
            $return['status'] = 'success';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['title'] = Yii::t('front', 'TIPOS DE PRODUCTO');
            $return['data'] = array();

            $filters = array('idRegion', 'idCustomer', 'ageDebt');       
            $stateCondition = '*.historic = 0 AND *.idDebtorsState IS NULL';
            $regions = Regions::model()->findAll(array('condition' => 'active = 1'));

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND '.str_replace('*', 'tds', $stateCondition);


            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key.' = ' . $value;                    
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }        

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            } 

            //$criteria->select = 't.id,DATE_FORMAT(date,"%d/%m/%Y") as date';        
            $criteria->join =  $join;
            $criteria->condition = $condition;
            $criteria->group = 't.date';
            $criteria->order = 't.date';


            $criteria->select = '(UNIX_TIMESTAMP(t.dateCreated) * 1000) as dateCreated,IFNULL(SUM(t.capital),0) as capital, count(t.idDebtor) as cant';
            $condition .= ($condition != '') ? ' AND ' : '';    
            foreach ($regions as $region){

                $criteria->condition = $condition.' t.idRegion ='.$region->id;        
    //            print_r($criteria);
    //            exit;
                $datac = ViewTendencies::model()->findAll($criteria);
                $return['data'][] = array('name' => $region->name,
                                            'data' => array_values(array_map(function($m){return  array("x" => $m->dateCreated,"y" => $m->capital, "z" => $m->cant, "showInLegend" => false,);},$datac)),
                                          );

            }

            return $return;
        } 

        //=============================================================================================

        public static function ChartTendenciesPerson($POST) {
            $return = array('status' => 'success', 'msg' => 'Solicitud Invalida', 'title' => 'TIPOS DE PERSONAS', 'data' => array());

            $filters = array('idRegion', 'idCustomer', 'ageDebt');       
            $stateCondition = '*.historic = 0 AND *.idDebtorsState IS NULL';
            $typeDocuments = TypeDocuments::model()->findAll();

            $criteria = new CDbCriteria();
            $condition = '';
            $join = ' JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND '.str_replace('*', 'tds', $stateCondition). ' JOIN tbl_debtors td ON t.idDebtor = td.id';


            if (isset($POST)) {
                $i = 0;
                foreach ($POST as $key => $value) {

                    if (($key != 'idCoordinator' && $key != 'idAdviser' ) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key.' = ' . $value;                    
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }        

            if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
            } 
            
            //$criteria->select = 't.id,DATE_FORMAT(date,"%d/%m/%Y") as date';        
            $criteria->join =  $join;
            $criteria->condition = $condition;
            $criteria->group = 't.date';
            $criteria->order = 't.date';

            $criteria->select = '(UNIX_TIMESTAMP(t.dateCreated) * 1000) as dateCreated,IFNULL(SUM(t.capital),0) as capital, count(t.idDebtor) as cant';

            $condition .= ($condition != '') ? ' AND ' : '';            

            foreach ($typeDocuments as $typeDocument){

                $criteria->condition = $condition.' td.idTypeDocument ='.$typeDocument->id;        
    //            print_r($criteria);
    //            exit;
                $datac = ViewTendencies::model()->findAll($criteria);
                $return['data'][] = array('name' => $typeDocument->alias,
                                            'data' => array_values(array_map(function($m){return  array("x" => $m->dateCreated,"y" => $m->capital, "z" => $m->cant, "showInLegend" => false,);},$datac)),
                                          );

            }

            return $return;
        } 

        //=============================================================================================
            
        
    public function actionGetDebtors() {
        $return = array();
        $return['status'] = 'success';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        
        $filters = array('idCustomer','customer','ageDebt', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','state' ,'agreement');

        $criteria = new CDbCriteria();
        //$criteriaIndicators = new CDbCriteria();
        $join = '';
        $condition = '';
        if(isset($_POST['state']) && $_POST['state'] != ''){
            $_POST['state'] = ($_POST['state'] != 'ASIGNADO')? $_POST['state'] : '';            
        }

        if (isset($_POST)) {
            $i = 0;
            foreach ($_POST as $key => $value) {

                if (($key != 'page' && $key != 'idCoordinator') && $value != '' && in_array($key, $filters)) {
                    $condition .= ($i == 0) ? '( ' : '';
                    $condition .= ($i > 0) ? ' AND ' : '';
                    $condition .= 't.' . $key;
                    $condition .= (($key == 'state' )) ? ' LIKE "' . $value . '"' : ' = ' . $value;                        
                    $i++;
                }
            }

            $condition .= ($condition != '') ? ')' : '';
        }
//               echo $condition.'<br>';


        if (isset($_POST['idCoordinator'],$_POST['idAdviser']) && ($_POST['idCoordinator'] != '' || $_POST['idAdviser'] != '')) {
            $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= ' cc.idCoordinator = ';
            $user = ($_POST['idAdviser'] != '')? ViewUsers::model()->find(array('condition' => 'id =' . $_POST['idAdviser'])) : null;
            $coordinator = ($user == null && $user->idCoordinator != '')? $_POST['idCoordinator']  : $user->idCoordinator;
            $condition .= $coordinator;
        } 
        
        if(isset($_POST['idRegion']) && $_POST['idRegion'] != ''){
           $join .= ' LEFT JOIN tbl_cities tc ON  t.idCity = tc.id LEFT JOIN tbl_departments td ON tc.idDepartment = td.id'; 
           $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= ' td.idRegion = '.$_POST['idRegion'];
        }
        

        $conditionS = 'historic = 0 AND active = 1 AND idDebtorsState IS NULL ';
        $conditionS .= (isset($_POST['ageDebt']) && $_POST['ageDebt'] == 0)? '' : ' AND is_legal = 0';

        $debtorState = DebtorsState::model()->findAll(array('condition' => $conditionS, 'order' => 'name ASC'));

        $states = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');

        $condition .= ($condition != '') ? ' AND ' : '';
        $condition .= 'idState NOT IN ('.implode(",", $states).')';
        $condition .= (isset($_POST['ageDebt']) && ($_POST['ageDebt'] == 0 || $_POST['ageDebt'] == 5))? '' : ' AND is_legal = 0';

        $criteria->join = $join;
        $criteria->condition = $condition;

        $criteria->order = "t.code";
        
//        echo $condition;
//        exit;

//        //indicators
//        $criteriaIndicators->select = '(SUM(t.capital)) as capital, COUNT(t.idDebtor) as cant';
//        $criteriaIndicators->join = $join;
//        $criteriaIndicators->condition = $condition;
//            //assigned
//        $assigned = ViewDebtors::model()->find($criteriaIndicators); 
//            //recovered
//            $cRecovered = ' AND t.payments > 0';
//        $criteriaIndicators->select = '(SUM(t.payments)) as capital, COUNT(t.idDebtor) as cant';
//        $criteriaIndicators->condition = $condition.$cRecovered;                
//        $recovered = ViewDebtors::model()->find($criteriaIndicators); 
//
//            //estimated - agreement
//            $cAgreement = ' AND t.agreement > 0';
//        $criteriaIndicators->select = '(SUM(t.agreement)) as capital, COUNT(t.idDebtor) as cant';
//        $criteriaIndicators->condition = $condition.$cAgreement;                
//        $agreement = ViewDebtors::model()->find($criteriaIndicators); 
//
//        $indicators = new Indicators();
//        $indicators->assigned = ($assigned != null)? $assigned->capital : 0;
//        $indicators->countAssigned = ($assigned != null)? $assigned->cant : 0;
//        $indicators->credit = ($agreement != null)? $agreement->capital : 0;
//        $indicators->countCredit = ($agreement != null)? $agreement->cant : 0;
//        $indicators->pending = ($assigned != null && $recovered != null)? ($assigned->capital - $recovered->capital) : 0;
//        $indicators->recovered = ($recovered != null)? $recovered->capital : 0;
//        $indicators->countRecovered = ($recovered != null)? $recovered->cant : 0;
//        $indicators->pRecovered = ($recovered != null && $indicators->assigned > 0)? round((($indicators->recovered*100)/ $indicators->assigned),2) : 0;


        $count = ViewDebtors::model()->count($criteria);

        $pages = new CPagination($count);

        $pages->pageSize = $this->pSize;
        $pages->applyLimit($criteria);

        $model = ViewDebtors::model()->findAll($criteria);
        
        $return['html'] = $this->renderPartial('/wallet/debtors_list_modal', array(
            'model' => $model,
            'debtorState' => $debtorState,
            'pages' => $pages,
                ), true);
        
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
        
    
    // INVESTMENT
    //
    //=============================================================================================
    
    public function actionInvestments() {
        if (!Yii::app()->user->isGuest) {
                        
            $creditModalities = CreditModality::model()->findAll();
            $regions = Regions::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));
            $ageDebts = AgeDebt::model()->findAll(array('limit' => 4, 'offset' => 0));
            $coodinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
            $customers = ViewCustomers::model()->findAll(array('select'  => 'id, name'));
            $indicators = Controller::getIndicators();
            
            $this->render('investments',array(
                'creditModalities' => $creditModalities,
                'regions' => $regions,
                'ageDebts' => $ageDebts,
                'coodinators' => $coodinators,
                'customers' => $customers,
                'indicators' => $indicators
                    ));                     
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
        //=============================================================================================

        public function actionGetChartInvestment() {
            $return = array();
            $return['status'] = 'error';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['model'] = '';
            $return['html'] = '';
            $return['newRecord'] = true;

            if (isset($_POST) && !Yii::app()->user->isGuest) {


                $model = new InvestmentLoad;                
                $model->setAttributes($_POST);


                $model->file = (CUploadedFile::getInstanceByName('file') != '') ? CUploadedFile::getInstanceByName('file') : $model->file;

                if ($model->validate()) {
                    $date = Date('d_m_Y_h_i_s');
                    $file = CUploadedFile::getInstanceByName('file');
                    if ($file != ''){
                        //Upload del archivo
                        $fname = @Controller::slugUrl(Date('d_m_Y_h_i_s')) . "." . $file->getExtensionName();

                        $location = Yii::getPathOfAlias('webroot') . "/uploads/investments/" . $fname;
                        $file->saveAs($location);

                        $connection = Yii::app()->db;
                        $table = "tbl_investment";
                        
                        $caracterSeparator = $this->getFileDelimiter($location);
                        
                        $sql_2 = "LOAD DATA INFILE '" . $location . "'
                                    INTO TABLE ".$table."
                                    CHARACTER SET latin1
                                    FIELDS
                                        TERMINATED BY '" . $caracterSeparator . "'
                                        ENCLOSED BY '\"'
                                    LINES
                                        TERMINATED BY '\\n'
                                     IGNORE 1 LINES 
                                     (`period`,`value`)SET lot = '" . $date . "'";
                        $transaction_ = $connection->beginTransaction();
                            try {
                                $connection->createCommand($sql_2)->execute();
                                $transaction_->commit();
                                $condition =  'lot ="'.$date.'"';
                                $count = Investment::model()->count(array('condition' => $condition));
                                $total = Investment::model()->find(array('select' => 'SUM(value) as value','condition' => $condition));

                                $return['status'] = 'success';
                                $return['msg'] = Yii::t('front', 'Cargue exitoso!.');
                                $return['model']['count'] = ($count != null)? $count : 0;
                                $return['model']['total'] = ($total != null)? $total->value : 0;
                                $return['model']['total_format'] = '$ '.Yii::app()->format->formatNumber(($total != null)? $total->value : 0);
                                $return['model']['value'] = $model->value;
                                $return['model']['rate'] = $model->rate;
                                $return['model']['lot'] = $date;

                            } catch (Exception $e){
                                $return['status'] = 'warning';
                                $return['msg'] = Yii::t('front', 'Error, cargando archivo');
                                $return['msg'] .= ' '.$e;
                            }

    //                    if (file_exists($location)) {
    //                        unlink($location);
    //                    }
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

        public function actionAnaliceData() {
            $return = array();
            $return['status'] = 'error';
            $return['msg'] = Yii::t('front', 'Solicitud Invalida');
            $return['data'] = array();
            $return['earnings'] = 0;

            if ((isset($_POST['lot']) && $_POST['lot']) && !Yii::app()->user->isGuest) {

                $criteria = new CDbCriteria();
    //            $criteria->select = 'value as value';
                $criteria->condition = 'lot ="'.$_POST['lot'].'"';
                $model = Investment::model()->findAll($criteria);


                $data = array_map(function($m){return  $m->value;},$model); 
                $category = array();
                for($i = 1; $i <= $_POST['count']; $i++){
                    $category[] = $i.' Periodo';                
                }



                $criteria->select = 'SUM(value) as value';
                $earnings = Investment::model()->find($criteria);

                if($model != null){                
                    $return['status'] = 'success';
                    $return['msg'] = 'ok';
                    $return['data'] = $data;
                    $return['category'] = $category;
                    $return['earnings'] = ($earnings != null)? $earnings->value : 0;
                }

            }

            echo json_encode($return,JSON_NUMERIC_CHECK);
        }
        
        
        //=============================================================================================
        
            public function actionGoals() {
                if (!Yii::app()->user->isGuest) {

                    $creditModalities = CreditModality::model()->findAll();
                    $regions = Regions::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));
                    $ageDebts = AgeDebt::model()->findAll(array('limit' => 4, 'offset' => 0));
                    $coordinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
                    $customers = ViewCustomers::model()->findAll(array('select'  => 'id, name'));

                    $indicators = Controller::getIndicators();

                    $this->render('goals',array(
                        'creditModalities' => $creditModalities,
                        'regions' => $regions,
                        'ageDebts' => $ageDebts,
                        'coordinators' => $coordinators,
                        'customers' => $customers,
                        'indicators' => $indicators
                            ));            
                } else {
                    $this->redirect(Yii::app()->homeUrl);
                }
            }
       
    //=============================================================================================
    
    public function actionGetChartGoals() {
        $return = array();
        $return['status'] = 'success';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['data'] = array();
        
        $type = (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] != '')? $_POST['idCoordinator'] : 0;
        
        switch ($type) {
            case 0:
                $return = IndicatorsController::ChartGoalsG($_POST);  
                break;
            default:
                $return = IndicatorsController::ChartGoalsE($_POST);
                break;
        }
              
        
        echo json_encode($return,JSON_NUMERIC_CHECK);
    }         
    
    //=============================================================================================
    
     public static function ChartGoalsG($POST) {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'title' => Yii::t('front', 'ESTADOS DE CARTERA'), 'category' => '','data' => '');

        $dataA = array();
        $dataR = array();
        $dataG = array();
        $filters = array('idCustomer');       
        
        $dates = Yii::app()->db->createCommand("select DATE_FORMAT(date, '%M') as nameMonth, date,  MONTH(date) as month, YEAR(date) as year FROM (select distinct date FROM tbl_debtors_log_state ORDER BY date DESC) tmp where date > date_sub(curdate(), interval 3 month) group by YEAR(date), MONTH(date)")->setFetchMode(PDO::FETCH_OBJ)->queryAll(true);
        
        foreach ($dates as $date){
             $assignments = DebtorsLogState::model()->find(array('select' => 'count(t.id) as cant, SUM(t.capital) as capital','condition' => 'date = "'.$date->date.'"', 'join' => ' JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND tds.historic = 0')); //AND dateRecovered < "'.$date->lastDay.'"
             
             if($assignments != null){
                 $return['category'][] = Yii::t('front', $date->nameMonth).' '.$date->year;
                 $dataA[] = $assignments->capital; 
                 $dataG[] = ($assignments->capital * 10 ) / 100;
                 $collect = ViewPayments::model()->find(array('select' => 'SUM(t.value) as value', 'condition' => 'MONTH(t.datePay) = '.$date->month.' AND YEAR(t.datePay) = '.$date->year));                
                 $dataR[] =  ($collect != null)? $collect->value : 0; 

             }

        }
        
        $return['data'] = array(array('name' => 'ASIGANDO', 'data' => $dataA, 'marker' => array('enabled' => true)), array('name' => 'METAS', 'data' => $dataG, 'marker' => array('enabled' => true)), array('name' => 'RECAUDOO', 'data' => $dataR, 'marker' => array('enabled' => true)));
        
        return $return;
    }
    
    //=============================================================================================
    
     public static function ChartGoalsE($POST) {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'title' => Yii::t('front', 'ESTADOS DE CARTERA'), 'category' => '','data' => '');

        $dataA = array();
        $dataR = array();
        $dataG = array();
        $filters = array('idCustomer');       
        
        $dates = Yii::app()->db->createCommand("select DATE_FORMAT(date, '%M') as nameMonth, date,  MONTH(date) as month, YEAR(date) as year FROM (select distinct date FROM tbl_debtors_log_state ORDER BY date DESC) tmp where date > date_sub(curdate(), interval 3 month) group by YEAR(date), MONTH(date)")->setFetchMode(PDO::FETCH_OBJ)->queryAll(true);
        
        $join = 'JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND tds.historic = 0';
        
        if(isset($POST['idCoordinator'],$POST['idAdviser']) && ($POST['idCoordinator'] != '' || $POST['idAdviser'] != '')){
            $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$POST['idCoordinator'];
        } 
        foreach ($dates as $date){
             $assignments = DebtorsLogState::model()->find(array('select' => 'count(t.id) as cant, SUM(t.capital) as capital','condition' => 'date = "'.$date->date.'"', 'join' => $join)); //AND dateRecovered < "'.$date->lastDay.'"
             
             if($assignments != null){
                 $return['category'][] = Yii::t('front', $date->nameMonth).' '.$date->year;
                 $dataA[] = $assignments->capital; 
                 
                 $dataG[] = ($assignments->capital * 10 ) / 100;

                 $collect = ViewPayments::model()->find(array('select' => 'SUM(t.value) as value', 'condition' => 'MONTH(t.datePay) = '.$date->month.' AND YEAR(t.datePay) = '.$date->year));                
                 $dataR[] =  ($collect != null)? $collect->value : 0; 

             }

        }
        $return['data'] = array(array('name' => 'ASIGANDO', 'data' => $dataA, 'marker' => array('enabled' => true)), array('name' => 'METAS', 'data' => $dataG, 'marker' => array('enabled' => true)), array('name' => 'RECAUDOO', 'data' => $dataR, 'marker' => array('enabled' => true)));
        
        return $return;
    }
    
    // METRICS
    //
    //=============================================================================================
    
    public function actionMetrics() {
        if (!Yii::app()->user->isGuest) {  
            $criteria = new CDbCriteria(); 
            
            $criteria->select = '*';
            $condition = 't.active = 1';
            $join = '';
            $order = 't.order ASC';
            if(!in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin']))){
                $condition .= ($condition != '') ? ' AND ' : '';
                $join = ' JOIN tbl_metrics_users_profile tmup ON t.id = tmup.idMetrics';
                $condition .= ' tmup.idUserProfile ='.Yii::app()->user->getState('rol'); 
                $order = 'tmup.order ASC';
            } 
            
            $criteria->join = $join;
            $criteria->condition = $condition;
                    
            $count = Metrics::model()->count($criteria);
            
            $criteria->order = $order;
                                
            $pages = new CPagination($count);

            $pages->pageSize = $this->pSize;
            $pages->applyLimit($criteria);
            
            $models = Metrics::model()->findAll($criteria);
            
            $this->render('metrics',array('models' => $models, 'count' => $count, 'pages' => $pages));                     
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionGetChartPlacement() {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'name' => '');                
        $type = (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] != '')? $_POST['idCoordinator'] : 0;

        $name  = 'ASIGNACIÓN';
        $dates = Yii::app()->db->createCommand("select DATE_FORMAT(dateCreated, '%M') as nameMonth, dateCreated,  MONTH(dateCreated) as month, YEAR(dateCreated) as year FROM (select distinct dateCreated FROM tbl_debtors_obligations ORDER BY dateCreated DESC) tmp where dateCreated > date_sub(curdate(), interval 3 month) group by YEAR(dateCreated), MONTH(dateCreated)")->setFetchMode(PDO::FETCH_OBJ)->queryAll(true);
        $data = array();
        $category = array();
       
        if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers'],Yii::app()->params['companies']))){            
            foreach ($dates as $date){
                $category[] = Yii::t('front', $date->nameMonth).' '.$date->year;

                $criteria = new CDbCriteria();
                $criteria->select = 'count(t.id) as cant, SUM(t.capital) as capital';
                $condition = 'MONTH(t.dateCreated) = '.$date->month.' AND YEAR(t.dateCreated) = '.$date->year;
                $join = '';

                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers']))){             
                    $join .= ' JOIN tbl_debtors td ON t.idDebtor = td.id AND td.idCustomers ='.Yii::app()->user->getId();   
                }
                
                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['companies']))){
                    $condition .= ($condition != '') ? ' AND ' : '';
                     $condition .= 'tu.idCompany = '.Yii::app()->user->getId();   
                    $join .= ' JOIN tbl_debtors td ON t.idDebtor = td.id JOIN tbl_users tu ON td.idCustomers = tu.id'; 
                }

                $criteria->condition = $condition;
                $criteria->join = $join;

                $model = DebtorsObligations::model()->find($criteria);

                $data[] = ($model != null)? $model->capital : 0;
            }  
        }else{
           $return = $category = array('ENE 2019','FEB 2019','MAR 2019','ABR 2019' );
           $data = Array ('296498041','795298041','79298041', '179298041');
                 
        }
        
        $return = array('name' => $name,'category' =>$category, 'data' => Array ( 0 => Array ( 'name' => 'ASIGNACIÓN', 'color' => '#52FF33', 'data' => $data, 'marker' => Array ( 'enabled' => 1 ) )));
                      
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    
    //=============================================================================================
    
    public function actionGetChartPlacement1() {
        $return = array();
        $return['status'] = 'success';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['data'] = array();
        
        $type = (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] != '')? $_POST['idCoordinator'] : 0;
        
        switch ($type) {
            case 0:
                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin']))){         
                    $return = array('category' =>array('ENE 2019','FEB 2019','MAR 2019','ABR 2019' ), 'data' => Array ( 0 => Array ( 'name' => 'ROA', 'color' => '#FF0000', 'data' => Array ('8','11.5','17.3', '19.2'), 'marker' => Array ( 'enabled' => 1 ) )));
                }
                break;
            default:
                $return = IndicatorsController::ChartGoalsE($_POST);
                break;
        }
                      
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    
    //=============================================================================================
    public function actionGetChartPlacement2() {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'name' => '');                
        $type = (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] != '')? $_POST['idCoordinator'] : 0;

        $name = 'GASTOS';
        $dates = Yii::app()->db->createCommand("select DATE_FORMAT(dateSpending, '%M') as nameMonth, dateSpending,  MONTH(dateSpending) as month, YEAR(dateSpending) as year FROM (select distinct dateSpending FROM view_spendings ORDER BY dateSpending DESC) tmp where dateSpending > date_sub(curdate(), interval 3 month) group by YEAR(dateSpending), MONTH(dateSpending)")->setFetchMode(PDO::FETCH_OBJ)->queryAll(true);
        $data = array();
        $category = array();
        
        if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers'],Yii::app()->params['companies']))){    
            
            foreach ($dates as $date){
                $category[] = Yii::t('front', $date->nameMonth).' '.$date->year;

                $criteria = new CDbCriteria();
                $criteria->select = 'count(t.id) as cant, SUM(t.value) as value';
                $condition = 'MONTH(t.dateSpending) = '.$date->month.' AND YEAR(t.dateSpending) = '.$date->year;
                $join = '';

                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers']))){
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' t.idCustomer ='.Yii::app()->user->getId();   
                }
                
                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['companies']))){
                    $condition .= ($condition != '') ? ' AND ' : '';
                     $condition .= 'tu.idCompany = '.Yii::app()->user->getId();   
                    $join .= 'JOIN tbl_users tu ON t.idCustomer = tu.id'; 
                }

                $criteria->condition = $condition;
                $criteria->join = $join;

                $model = ViewSpendings::model()->find($criteria);

                $data[] = ($model != null)? $model->value : 0;

            }
        }else{
           $return = $category = array('ENE 2019','FEB 2019','MAR 2019','ABR 2019' );
           $data = Array ('276498041','75298041','7928041', '198041');                     
        }
        
        $return = array('name' => $name,'category' =>$category, 'data' => Array ( 0 => Array ( 'name' => $name, 'color' => '#FF8000', 'data' => $data, 'marker' => Array ( 'enabled' => 1 ) )));
                      
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    //=============================================================================================
    public function actionGetChartPlacement3() {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' => array(), 'name' => '');                
        $type = (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] != '')? $_POST['idCoordinator'] : 0;
        
        $name = 'RECAUDO';
        $dates = Yii::app()->db->createCommand("select DATE_FORMAT(datePay, '%M') as nameMonth, datePay,  MONTH(datePay) as month, YEAR(datePay) as year FROM (select distinct datePay FROM view_payments ORDER BY datePay DESC) tmp where datePay > date_sub(curdate(), interval 3 month) group by YEAR(datePay), MONTH(datePay)")->setFetchMode(PDO::FETCH_OBJ)->queryAll(true);
        $data = array();
        $category = array();
        if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers'],Yii::app()->params['companies']))){    
         
            foreach ($dates as $date){
                $category[] = Yii::t('front', $date->nameMonth).' '.$date->year;

                $criteria = new CDbCriteria();
                $criteria->select = 'count(t.id) as cant, SUM(t.value) as value';
                $condition = 'MONTH(t.datePay) = '.$date->month.' AND YEAR(t.datePay) = '.$date->year;
                $join = '';

                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers']))){
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' t.idCustomer ='.Yii::app()->user->getId();   
                }
                
                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['companies']))){
                    $condition .= ($condition != '') ? ' AND ' : '';
                     $condition .= 'tu.idCompany = '.Yii::app()->user->getId();   
                    $join .= 'JOIN tbl_users tu ON t.idCustomer = tu.id'; 
                }

                $criteria->condition = $condition;
                $criteria->join = $join;

                $model = ViewPayments::model()->find($criteria);

                $data[] = ($model != null)? $model->value : 0;

            }  
        }else{
            $return = $category = array('ENE 2019','FEB 2019','MAR 2019','ABR 2019' );
            $data = Array ('2498041','552980471','792478041', '258041');                  
        }
        $return = array('name' => $name,'category' =>$category, 'data' => Array ( 0 => Array ( 'name' => $name, 'color' => '#0174FE', 'data' => $data, 'marker' => Array ( 'enabled' => 1 ) )));
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    
    //=============================================================================================
    
    public function actionGetChartPlacement4() {
        $return = array();
        $return['status'] = 'success';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['data'] = array();
        
        $type = (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] != '')? $_POST['idCoordinator'] : 0;
        
        switch ($type) {
            case 0:
                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin']))){         
                    $return = array('category' =>array('ENE 2019','FEB 2019','MAR 2019','ABR 2019' ), 'color' => '#FF0040', 'data' => Array ( 0 => Array ( 'name' => 'ROE', 'data' => Array ('10','12.2','15.3', '17'), 'marker' => Array ( 'enabled' => 1 ) )));
                }
                break;
            default:
                $return = IndicatorsController::ChartGoalsE($_POST);
                break;
        }
                      
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    
    //=============================================================================================
    public function actionGetChartPlacement5() {
        $return = array();
        $return['status'] = 'success';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['data'] = array();
        
        $type = (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] != '')? $_POST['idCoordinator'] : 0;
        $name = 'INGRESOS';
        switch ($type) {
            case 0:
                if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin']))){         
                    $return = array('name' => $name,'category' =>array('ENE 2019','FEB 2019','MAR 2019','ABR 2019' ), 'data' => Array ( 0 => Array ( 'name' => 'INGRESOS', 'color' => '#9A2EFE', 'data' => Array ('2498041','3798041','3498041', '2445061'), 'marker' => Array ( 'enabled' => 1 ) )));
                }
                break;
            default:
                $return = IndicatorsController::ChartGoalsE($_POST);
                break;
        }
                      
        echo json_encode($return,JSON_NUMERIC_CHECK);
    } 
    
    //=============================================================================================
    
    public static function ChartPlacementG($POST) {
        $return = array('status' => 'success', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'title' => Yii::t('front', ''), 'category' => '','data' => '');

        $dataA = array();
        $dataR = array();
        $dataG = array();
        $filters = array('idCustomer');       
        
        $dates = Yii::app()->db->createCommand("select DATE_FORMAT(date, '%M') as nameMonth, date,  MONTH(date) as month, YEAR(date) as year FROM (select distinct date FROM tbl_debtors_log_state ORDER BY date DESC) tmp where date > date_sub(curdate(), interval 3 month) group by YEAR(date), MONTH(date)")->setFetchMode(PDO::FETCH_OBJ)->queryAll(true);
        
        foreach ($dates as $date){
             $assignments = DebtorsLogState::model()->find(array('select' => 'count(t.id) as cant, SUM(t.capital) as capital','condition' => 'date = "'.$date->date.'"', 'join' => ' JOIN tbl_debtors_state tds ON t.idDebtorState = tds.id AND tds.historic = 0')); //AND dateRecovered < "'.$date->lastDay.'"
             
             if($assignments != null){
                 $return['category'][] = Yii::t('front', $date->nameMonth).' '.$date->year;
                 $dataA[] = $assignments->capital; 
                 $dataG[] = ($assignments->capital * 10 ) / 100;
                 $collect = ViewPayments::model()->find(array('select' => 'SUM(t.value) as value', 'condition' => 'MONTH(t.datePay) = '.$date->month.' AND YEAR(t.datePay) = '.$date->year));                
                 $dataR[] =  ($collect != null)? $collect->value : 0; 

             }

        }
        
        $return['data'] = array(array('name' => 'ASIGANDO', 'data' => $dataA, 'marker' => array('enabled' => true)), array('name' => 'METAS', 'data' => $dataG, 'marker' => array('enabled' => true)), array('name' => 'RECAUDOO', 'data' => $dataR, 'marker' => array('enabled' => true)));
        
        return $return;
    }
    

}
