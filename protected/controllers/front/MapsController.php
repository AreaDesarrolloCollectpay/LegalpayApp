<?php

class MapsController extends Controller {

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
        $this->access = array(1, 7, 9);
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
                        
            $creditModalities = CreditModality::model()->findAll();
            $regions = Regions::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));
            $ageDebts = AgeDebt::model()->findAll();
            $coodinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
            $customers = ViewCustomers::model()->findAll(array('select'  => 'id, name'));
            
            $this->render('maps',array(
                'creditModalities' => $creditModalities,
                'regions' => $regions,
                'ageDebts' => $ageDebts,
                'coodinators' => $coodinators,
                'customers' => $customers,
                    ));            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionGetMaps() {
        $return = array();
        $return['status'] = 'success';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['locations'] = '';
        
        $filters = array('idRegion', 'idCustomer', 'ageDebt', 'idType');       
                
        $criteria = new CDbCriteria();
        $condition = '';
        $join = '';
                
        if (isset($_POST)) {
            $i = 0;
            foreach ($_POST as $key => $value) {

                if ($value != '' && in_array($key, $filters)) {
                    $condition .= ($i == 0) ? ' ( ' : '';
                    $condition .= ($i > 0) ? ' AND ' : '';
                    $condition .= 't.' . $key.' = ' . $value;                    
                    $i++;
                }
            }

            $condition .= ($condition != '') ? ')' : '';
        }
                
        if(isset($_POST['idCoordinator'],$_POST['idAdviser']) && ($_POST['idCoordinator'] != '' || $_POST['idAdviser'] != '')){
            $join .= ' JOIN tbl_campaigns_debtors cd ON t.id = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$_POST['idCoordinator'];
                                    
        }                      
        
        $condition .= ($condition != '') ? ' AND ' : '';        
        $condition .= 't.idState IN (SELECT id FROM tbl_debtors_state WHERE idDebtorsState IS NULL AND historic = 0 )';
        
        $criteria->condition =  $condition;
        $criteria->join =  $join;
        $criteria->group = 't.id';
        $criteria->order = 't.id ASC';
        
//        echo $criteria->select;
//        echo '<br>';
//        echo $join;
//        echo '<br>';
//        echo $condition;
//        exit;
        
        $model = ViewMaps::model()->findAll($criteria);
        $return['locations'] = array_map(create_function('$m','return $m->getAttributes();'),$model);
        
//        print_r($return['locations']);
//        
//        exit;
                      
                
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionBusiness() {
        if (!Yii::app()->user->isGuest) {
                        
            $businessStates = UsersState::model()->findAll(array('condition' => 'active = 1 AND type = 2', 'order' => 'id ASC'));
            $regions = Regions::model()->findAll(array('condition' => 'active = 1','order' => 'name ASC'));            
            $businessAdvisers = ViewBusinessAdvisor::model()->findAll(array('condition' => 'active = 1' , 'order' => 'name ASC'));
            
            $this->render('maps_business',array(
                'businessStates' => $businessStates,
                'regions' => $regions,
                'businessAdvisers' => $businessAdvisers,
                    ));            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionGetMapsBusiness() {
        $return = array();
        $return['status'] = 'success';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['locations'] = '';
        
        $filters = array('idRegion', 'idBusinessAdvisor', 'idUserState');       
                
        $criteria = new CDbCriteria();
        $condition = '';
        $join = '';
                
        if (isset($_POST)) {
            $i = 0;
            foreach ($_POST as $key => $value) {

                if ($value != '' && in_array($key, $filters)) {
                    $condition .= ($i == 0) ? ' ( ' : '';
                    $condition .= ($i > 0) ? ' AND ' : '';
                    $condition .= 't.' . $key.' = ' . $value;                    
                    $i++;
                }
            }

            $condition .= ($condition != '') ? ')' : '';
        }
        
        $condition .= ($condition != '') ? ' AND ' : '';
        $condition .= '(t.lat <> "" AND t.lng <> "")';
                
        $criteria->condition =  $condition;
        //$criteria->join =  $join;
        $criteria->group = 't.id';
        $criteria->order = 't.id ASC';
                
        $model = ViewMapsBusiness::model()->findAll($criteria);
        $return['locations'] = array_map(create_function('$m','return $m->getAttributes();'),$model);
                             
                
        echo CJSON::encode($return);
    }
        
}
