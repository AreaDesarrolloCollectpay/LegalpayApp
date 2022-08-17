<?php

class WalletController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================

    public $cuadrants;
    public $coordinators;
    public $coordinator;
    public $adviser;
    public $administrators;
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
	
	public function actionDebtorsObligationss() {
		Yii::log('hola como estoy aja');
	}
    //=============================================================================================

    public function actionCluster() {
        
        
        if (!Yii::app()->user->isGuest) {
            $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            if ($user != null) {

                $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','agreement', 'idTypeDocument','idCreditModality');
                                
                $criteria = new CDbCriteria();                
                $select = 't.id, t.customer, t.name, t.code, city, t.capital, t.idDebtor, t.interest, t.payments, t.agreement, t.fee, t.balance, t.is_legal, t.state, vml.date';
                $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0
                        left JOIN view_management_last vml on t.id = vml.idDebtorDebt AND vml.active = 1';
                $condition = '';
                
                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'id' && $key != 'quadrant') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'idState' && $key != 'idTypeDocument')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }

                if ((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) || (isset($_REQUEST['idCoordinator']) && $_REQUEST['idCoordinator'] != '') ) {
                    $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = ';
                    $condition .= (isset($_REQUEST['idCoordinator']) && $_REQUEST['idCoordinator'] != '')? $_REQUEST['idCoordinator'] : (( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator);
                }
               
                if (Yii::app()->user->getState('rol') == 7 || (isset($_REQUEST['idCustomer']) && $_REQUEST['idCustomer'] != '')) {
                    $idCustomer = (Yii::app()->user->getState('rol') == 7)? Yii::app()->user->getId() : $_REQUEST['idCustomer']; 
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCustomer = ' . $idCustomer;
                }
                
                if (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '' && $_REQUEST['idRegion'] != 0) {
                    $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion ='.$_REQUEST['idRegion']; 
                }
                
                if ((isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] != '' && $_REQUEST['idMLModel'] != 0) || (isset($_REQUEST['idCluster']) && $_REQUEST['idCluster'] != '' && $_REQUEST['idCluster'] != 0) ) {
                    $cond = (isset($_REQUEST['idCluster']) && $_REQUEST['idCluster'] != '') ? 'tc.id = '.$_REQUEST['idCluster'] : 'tc.idMLModel = '.$_REQUEST['idMLModel'];
                    $join .= ' JOIN tbl_debtors_obligations_clusters tdoc ON t.id = tdoc.idDebtorObligation 
                       JOIN tbl_clusters tc ON tdoc.idCluster = tc.id AND '.$cond; 
                    //echo $join;exit;
                }
                
                if (isset($_REQUEST['investigation']) && $_REQUEST['investigation'] != '') {
                    $oper = ($_REQUEST['investigation'] == 1)? '>' : '=';
                    $join .= ' JOIN view_check_demographics vcd ON t.idDebtor = vcd.idDebtor AND vcd.cant '.$oper.' 0'; 
                }
                
                if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'idCreditModality ='.$_REQUEST['id'];
                }
                
                if (isset($_REQUEST['quadrant']) && $_REQUEST['quadrant'] != '' && $_REQUEST['quadrant'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.ageDebt ='.$_GET['quadrant'];
                }
                
                if (isset($_GET['is_legal']) && $_GET['is_legal'] != '' && $_GET['is_legal'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' t.is_legal = '.$_REQUEST['is_legal'];                    
                }
                
                if (isset($_REQUEST['property']) && $_REQUEST['property'] != '') {
                    $property = ($_REQUEST['property'] == 0)? ' = 0' : ' > 0';
                    $join .= ' JOIN view_indicators_property vip ON t.idDebtor = vip.idDebtor AND vip.cant'.$property; 
                }
                
                $conditionS = 'historic = 0 AND active = 1 AND idDebtorsState IS NULL ';
                $conditionS .= (isset($_REQUEST['quadrant']) && $_REQUEST['quadrant'] == 0)? '' : ' AND is_legal = 0';
                
                $debtorState = DebtorsState::model()->findAll(array('condition' => $conditionS, 'order' => 'name ASC'));
                
                if(isset($_REQUEST['age']) && $_REQUEST['age'] != '' && $_REQUEST['age'] != 0){
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'YEAR(t.duedate) ='.$_REQUEST['age'];
                }
                        
                $criteria->join = $join;
                $criteria->condition = $condition;
                
//                $criteria->select = 'SUM(t.capital) as capital';
//                $total = ViewDebtors::model()->find($criteria);                
                $total = 0;
                
                $criteria->select = $select;
                $count = ViewDebtors::model()->count($criteria);
                
                if(isset($_REQUEST['order']) && $_REQUEST['order'] != ''){
                    $order = str_replace('_', ' ', $_REQUEST['order']);
                }else{
                    $order = NULL;
                }

                $criteria->order = $order;
                                
                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);
                

                $model = ViewDebtors::model()->findAll($criteria);
                $id = (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '')? $_REQUEST['idRegion'] : 0;
                $quadrant = (isset($_REQUEST['quadrant']) && $_REQUEST['quadrant'] != '')? $_REQUEST['quadrant'] : 0;
                
                $coordinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
                              
                $clustersSelect = (isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] != 0)? Clusters::model()->findAll(array('condition' => 'idMLModel ='.$_REQUEST['idMLModel'],'order' => 'name')) : array();
                
                //              Managements  
                $criteriaClusters = new CDbCriteria();   
                $criteriaClusters->select = 't.*';
                $criteriaClusters->condition = 't.idMLModel ='.$_REQUEST['idMLModel'];
                $criteriaClusters->order = 't.id ASC';

                $countClusters = Clusters::model()->count($criteriaClusters);

                $pagesClusters = new CPagination($countClusters);
                $pagesClusters->pageSize = $this->pSize;
                $pagesClusters->applyLimit($criteriaClusters);  

                $clusters = Clusters::model()->findAll($criteriaClusters); 
                $mlModels = Mlmodels::model()->findAll(array('limit' => 3));
                $modelML = (isset($_REQUEST['idMLModel']))? $_REQUEST['idMLModel'] : 0;
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;
                
                print_r($criteria);
                exit;
                                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/wallet/partials/content-debtor-table', array('model' => $model,'modelML' => $modelML), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'cluster'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                    $this->render('debtors_list', array('model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'debtorState' => $debtorState,
                        'id' => $id,
                        'quadrant' => $quadrant,
                        'url' => 'wallet/'.$id.'/'.$quadrant,
                        'urlExport' => "wallet/exportDebtors/".$id."/".$quadrant,
                        'legal' => (isset($_REQUEST['is_legal']))? $_REQUEST['is_legal'] : 0 ,
                        'modelML' => $modelML ,
                        'coordinators' => $coordinators,
                        'accounts' => $count,
                        'total' => ($total != null)? $total->capital : 0,
                        'mlModel' => Mlmodels::model()->findByPk($_REQUEST['idMLModel']),
                        'clustersSelect' => $clustersSelect,
                        'clusters' => $clusters, 
                        'pagesClusters' => $pagesClusters,
                        'countClusters' => $countClusters,
                        'mlModels' => $mlModels,
                            ));                    
                }
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    public function actionIndexPage() {
        
        if (!Yii::app()->user->isGuest) {
            $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            if ($user != null) {

                $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','agreement', 'idTypeDocument','idCreditModality');
                                
                $criteria = new CDbCriteria();                
                $select = 't.id, t.customer, t.name, t.code, city, t.capital, t.idDebtor, t.is_legal, t.state, vml.date';
                $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0
                        left JOIN view_management_last vml on t.id = vml.idDebtorDebt';
                $condition = '';
                
                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'id' && $key != 'ageDebt') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'idState' && $key != 'idTypeDocument')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }

                if ((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) || (isset($_REQUEST['idCoordinator']) && $_REQUEST['idCoordinator'] != '') ) {
                    $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = ';
                    $condition .= (isset($_REQUEST['idCoordinator']) && $_REQUEST['idCoordinator'] != '')? $_REQUEST['idCoordinator'] : (( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator);
                }
                
                if ((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'])))) {
                    $join .= ' JOIN tbl_assignments_debtors_advisers tada ON t.idDebtor = tada.idDebtor';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' tada.idAdviser = '.Yii::app()->user->getId();
                }
                
                if(Yii::app()->user->getState('rol') == 11){
                    $join .= ' JOIN tbl_users tu ON t.idCustomer = tu.id';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = '.Yii::app()->user->getId();
                } 
               
                if (Yii::app()->user->getState('rol') == 7 || (isset($_REQUEST['idCustomer']) && $_REQUEST['idCustomer'] != '')) {
                    $idCustomer = (Yii::app()->user->getState('rol') == 7)? Yii::app()->user->getId() : $_REQUEST['idCustomer']; 
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCustomer = ' . $idCustomer;
                }
                
                if(isset($_REQUEST['date']) && $_REQUEST['date'] != ''){
                    $date = Controller::CleanFilterDate($_REQUEST['date']);
                    if((int)$date['count'] > 1){                        
                        $condition .= 'vml.date BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                    }else{  
                        $condition .= 'vml.date = "'.$date['date'][0].'"' ;                     
                    }  
                }
                
                
                if (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '' && $_REQUEST['idRegion'] != 0) {
                    $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion ='.$_REQUEST['idRegion']; 
                }
                
                if ((isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] != '' && $_REQUEST['idMLModel'] != 0) || (isset($_REQUEST['idCluster']) && $_REQUEST['idCluster'] != '' && $_REQUEST['idCluster'] != 0) ) {
                    $cond = (isset($_REQUEST['idCluster']) && $_REQUEST['idCluster'] != '') ? 'tc.id = '.$_REQUEST['idCluster'] : 'tc.idMLModel = '.$_REQUEST['idMLModel'];
                    $join .= ' JOIN view_debtors_debts_clusters vddc ON t.id = vddc.idDebtorDebt 
                       JOIN tbl_clusters tc ON vddc.idCluster = tc.id AND '.$cond; 
//                    echo '--'.$join;exit;
                }else{
//                    echo 'no';
//                    exit;
                }
                                
                if (isset($_REQUEST['investigation']) && $_REQUEST['investigation'] != '') {
                    $oper = ($_REQUEST['investigation'] == 1)? '>' : '=';
                    $join .= ' JOIN view_check_demographics vcd ON t.idDebtor = vcd.idDebtor AND vcd.cant '.$oper.' 0'; 
                }
                
                if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'idCreditModality ='.$_REQUEST['id'];
                }
                
                if (isset($_REQUEST['ageDebt']) && $_REQUEST['ageDebt'] != '' && $_REQUEST['ageDebt'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.ageDebt ='.$_REQUEST['ageDebt'];
                }
                
                if (isset($_REQUEST['is_legal']) && $_REQUEST['is_legal'] != '') {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' t.is_legal = '.$_REQUEST['is_legal'];                    
                }
                
                if (isset($_REQUEST['property']) && $_REQUEST['property'] != '') {
                    $property = ($_REQUEST['property'] == 0)? ' = 0' : ' > 0';
                    $join .= ' JOIN view_indicators_property vip ON t.idDebtor = vip.idDebtor AND vip.cant'.$property; 
                }
                
                $conditionS = 'historic = 0 AND active = 1 AND idDebtorsState IS NULL ';
                $conditionS .= (isset($_REQUEST['ageDebt']) && $_REQUEST['ageDebt'] == 0)? '' : ' AND is_legal = 0';
                
                $debtorState = DebtorsState::model()->findAll(array('condition' => $conditionS, 'order' => 'name ASC'));
                
                if(isset($_REQUEST['age']) && $_REQUEST['age'] != '' && $_REQUEST['age'] != 0){
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'YEAR(t.duedate) ='.$_REQUEST['age'];
                }
                                
                $criteria->join = $join;
                $criteria->condition = $condition;
                
                $criteria->select = 'SUM(t.capital) as capital';
                $total = ViewDebtors::model()->find($criteria);
                
                $criteria->select = $select;
                $count = ViewDebtors::model()->count($criteria);
                
                
                if(isset($_REQUEST['order']) && $_REQUEST['order'] != ''){
                    $order = str_replace('_', ' ', $_REQUEST['order']);
                }else{
                    $order = "t.capital DESC";
                }

                $criteria->order = $order;
                                
                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);
                
                
                $model = ViewDebtors::model()->findAll($criteria);
                
//                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){  
//                    print_r($criteria);
//                    exit;
//                }
                
                if(Yii::app()->user->getId() == 20){
//                    print_r($criteria);
//                    exit;
                }
                
                $id = (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '')? $_REQUEST['idRegion'] : 0;
                $quadrant = (isset($_REQUEST['ageDebt']) && $_REQUEST['ageDebt'] != '')? $_REQUEST['ageDebt'] : 0;
                
                $coordinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
                
                $clustersSelect = (isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] != 0)? Clusters::model()->findAll(array('condition' => 'idMLModel ='.$_REQUEST['idMLModel'],'order' => 'name')) : array();
                
                 
                $criteriaClusters = new CDbCriteria();   
                $criteriaClusters->select = 't.*';
                $criteriaClusters->condition = 't.idMLModel ='.(isset($_REQUEST['idMLModel'])? $_REQUEST['idMLModel'] : 0 );
                $criteriaClusters->order = 't.id ASC';

                $countClusters = Clusters::model()->count($criteriaClusters);

                $pagesClusters = new CPagination($countClusters);
                $pagesClusters->pageSize = $this->pSize;
                $pagesClusters->applyLimit($criteriaClusters);  

                $clusters = Clusters::model()->findAll($criteriaClusters); 
                $mlModels = Mlmodels::model()->findAll(array('limit' => 3));
                $modelML = (isset($_REQUEST['idMLModel']))? $_REQUEST['idMLModel'] : '';
                $clusterML = (isset($_REQUEST['idCluster']))? $_REQUEST['idCluster'] : '';
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 
                $ageDebts = AgeDebt::model()->findAll(array('order' => 'name ASC'));
                
                $vars = array('model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'debtorState' => $debtorState,
                        'id' => $id,
                        'quadrant' => $quadrant,
                        'url' => 'wallet/'.$id.'/'.$quadrant,
                        'urlExport' => "wallet/exportDebtors/".$id."/".$quadrant,
                        'legal' => (isset($_REQUEST['is_legal']))? $_REQUEST['is_legal'] : 0 ,
                        'modelML' => $modelML ,
                        'clusterML' => $clusterML ,
                        'coordinators' => $coordinators,
                        'accounts' => $count,
                        'total' => ($total != null)? $total->capital : 0,
                        'mlModel' => null,
                        'clustersSelect' => $clustersSelect,
                        'clusters' => $clusters, 
                        'pagesClusters' => $pagesClusters,
                        'countClusters' => $countClusters,
                        'mlModels' => $mlModels,
                        'ageDebts' => $ageDebts
                            );
                //INSERT INTO `collectpay_beta`.`tbl_debtors_obligations_clusters` (`idCluster`, `idDebtorObligation`) VALUES ((SELECT id from tbl_clusters where idMLModel = 22  order by RAND() limit 1),44958);
                 if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/wallet/partials/item-debtor', $vars, true);
                    $script = Controller::hideOptionsProfiles();
                    $return['table'] .= "<script>
                       $(document).ready(function(){    
                            ".$script."
                       });
                       </script>"; 
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'cluster'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{                               
                    $this->render('debtors_list', $vars);
                }
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================
    public function actionIndex() {
        if (!Yii::app()->user->isGuest) {
            
            $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            $url = '';
            
            if ($user != null) {
                
                $id = (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '')? $_REQUEST['idRegion'] : 0;
                $quadrant = (isset($_REQUEST['ageDebt']) && $_REQUEST['ageDebt'] != '')? $_REQUEST['ageDebt'] : 0;                       
                $orders = array('customer' => 't.customer', 'name' => 't.name', 'code' => 't.code', 'city' => 't.city', 'capital' => 't.capital', 'ageDebt' => 't.ageDebt', 'idState' => 't.idState', 'date' => 'vml.date');
                $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest', 'totalDebt', 'ageDebt', 'fee', 'payments', 'balance', 'idState','agreement', 'idTypeDocument','idCreditModality');
                                
                if (Yii::app()->getRequest()->getIsAjaxRequest()){
                    
                    $draw = $_REQUEST['draw'];
                    $row = $_REQUEST['start'];
                    $rowperpage = $_REQUEST['length']; // Rows display per page
                    $columnIndex = $_REQUEST['order'][0]['column']; // Column index
                    $columnName = $_REQUEST['columns'][$columnIndex]['data']; // Column name
                    $sort = (isset($_REQUEST['columns'][$columnIndex]['orderable'])); // Column name
                    $columnSortOrder = $_REQUEST['order'][0]['dir']; // asc or desc
                    $order = NULL;
                                        
                    if(array_key_exists($columnName, $orders)){ 
                        if($sort){    
                            $order = $orders[$columnName].' '.$columnSortOrder;                             
                        }
                    }
                                        
                    $_REQUEST['page'] = ($_REQUEST['start'] / $this->pSize) + 1;                     
                                
                    $criteria = new CDbCriteria();                
                    $select = 't.id, t.customer, t.name, t.code, city, t.capital, t.idDebtor, t.is_legal, t.state, vml.date';
                    $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND tds.historic = 0
                            left JOIN view_management_last vml on t.id = vml.idDebtorDebt';
                    $condition = '';

                    if (isset($_REQUEST['search'])) {
                        $i = 0;
                        foreach ($_REQUEST['search'] as $key => $value) {
    
                            if (($key != 'page' && $key != 'id') && $value != '' && in_array($key, $filters)) {
                                $condition .= ($i == 0) ? '( ' : '';
                                $condition .= ($i > 0) ? ' AND ' : '';
                                $condition .= 't.' . $key;
                                $condition .= (($key != 'idState' && $key != 'idTypeDocument' && $key != 'ageDebt')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                                $i++;
                            }
                        }
    
                        $condition .= ($condition != '') ? ')' : '';
                        
                        if(isset($_REQUEST['search']['date']) && $_REQUEST['search']['date'] != ''){
                            $condition .= ($condition != '') ? ' AND ' : ''; 
                            $condition .= ' timestampdiff(DAY,vml.date,curdate())'.$_REQUEST['search']['date'];
                        }
                    }
                    
                    if ((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinator'])) || (isset($_REQUEST['idCoordinator']) && $_REQUEST['idCoordinator'] != '') ) {
                        $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= ' cc.idCoordinator = ';
                        $condition .= (isset($_REQUEST['idCoordinator']) && $_REQUEST['idCoordinator'] != '')? $_REQUEST['idCoordinator'] : (( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinator'])) ? Yii::app()->user->getId() : $user->idCoordinator);
                    }

                    if ((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'])))) {
                        $join .= ' JOIN tbl_assignments_debtors_advisers tada ON t.idDebtor = tada.idDebtor';
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= ' tada.idAdviser = '.Yii::app()->user->getId();
                    }

                    if(Yii::app()->user->getState('rol') == 11){
                        $join .= ' JOIN tbl_users tu ON t.idCustomer = tu.id';
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 'tu.idCompany = '.Yii::app()->user->getId();
                    } 

                    if (Yii::app()->user->getState('rol') == 7 || (isset($_REQUEST['idCustomer']) && $_REQUEST['idCustomer'] != '')) {
                        $idCustomer = (Yii::app()->user->getState('rol') == 7)? Yii::app()->user->getId() : $_REQUEST['idCustomer']; 
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 't.idCustomer = ' . $idCustomer;
                    }

                    if(isset($_REQUEST['date']) && $_REQUEST['date'] != ''){
                        $date = Controller::CleanFilterDate($_REQUEST['date']);
                        if((int)$date['count'] > 1){                        
                            $condition .= 'vml.date BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                        }else{  
                            $condition .= 'vml.date = "'.$date['date'][0].'"' ;                     
                        }  
                    }

                    if (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '' && $_REQUEST['idRegion'] != 0) {
                        $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion ='.$_REQUEST['idRegion'];                         
                    }

                    if ((isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] != '' && $_REQUEST['idMLModel'] != 0) || (isset($_REQUEST['idCluster']) && $_REQUEST['idCluster'] != '' && $_REQUEST['idCluster'] != 0) || (isset($_REQUEST['search']['idMLModel']) && $_REQUEST['search']['idMLModel'] != '' && $_REQUEST['search']['idMLModel'] != 0) || (isset($_REQUEST['search']['idCluster']) && $_REQUEST['search']['idCluster'] != '' && $_REQUEST['search']['idCluster'] != 0) ) {
                        $cond = '';
                        if (isset($_REQUEST['idMLModel'], $_REQUEST['idCluster'])){
                            $cond = ($_REQUEST['idCluster'] != '') ? 'tc.id = '.$_REQUEST['idCluster'] : 'tc.idMLModel = '.$_REQUEST['idMLModel'];                            
                        }elseif(isset($_REQUEST['search']['idMLModel'],$_REQUEST['search']['idCluster'])){
                            $cond = ($_REQUEST['search']['idCluster']) ? 'tc.id = '.$_REQUEST['search']['idCluster'] : 'tc.idMLModel = '.$_REQUEST['search']['idMLModel'];                            
                        }
                        if($cond != ''){
                            $join .= ' JOIN view_debtors_debts_clusters vddc ON t.id = vddc.idDebtorDebt 
                               JOIN tbl_clusters tc ON vddc.idCluster = tc.id AND '.$cond; 
                        }
                    }

                    if (isset($_REQUEST['investigation']) && $_REQUEST['investigation'] != '') {
                        $oper = ($_REQUEST['investigation'] == 1)? '>' : '=';
                        $join .= ' JOIN view_check_demographics vcd ON t.idDebtor = vcd.idDebtor AND vcd.cant '.$oper.' 0'; 
                    }

                    if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] != 0) {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 'idCreditModality ='.$_REQUEST['id'];
                    }

                    if (isset($_REQUEST['ageDebt']) && $_REQUEST['ageDebt'] != '' && $_REQUEST['ageDebt'] != 0) {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 't.ageDebt ='.$_REQUEST['ageDebt'];
                    }

                    if (isset($_REQUEST['is_legal']) && $_REQUEST['is_legal'] != '') {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= ' t.is_legal = '.$_REQUEST['is_legal'];
                    }
                    if (isset($_REQUEST['property']) && $_REQUEST['property'] != '') {
                        $property = ($_REQUEST['property'] == 0)? ' = 0' : ' > 0';
                        $join .= ' JOIN view_indicators_property vip ON t.idDebtor = vip.idDebtor AND vip.cant'.$property; 
                    }

                    if(isset($_REQUEST['age']) && $_REQUEST['age'] != '' && $_REQUEST['age'] != 0){
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 'YEAR(t.duedate) ='.$_REQUEST['age'];
                    }
                    

                    $criteria->join = $join;
                    $criteria->condition = $condition;

                    $criteria->select = 'SUM(t.capital) as capital';
                    $total = ViewDebtors::model()->find($criteria);

                    $criteria->select = $select;
                    $count = ViewDebtors::model()->count($criteria);

                    $criteria->order = $order;                                
                    $pages = new CPagination($count);

                    $pages->pageSize = $this->pSize;
                    $pages->applyLimit($criteria);

                    $model = ViewDebtors::model()->findAll($criteria);

                    if(Yii::app()->user->getId() == 20){
    //                    print_r($criteria);
    //                    exit;
                    }


                    $criteriaClusters = new CDbCriteria();   
                    $criteriaClusters->select = 't.*';
                    $criteriaClusters->condition = 't.idMLModel ='.(isset($_REQUEST['idMLModel'])? $_REQUEST['idMLModel'] : 0 );
                    $criteriaClusters->order = 't.id ASC';

                    $countClusters = Clusters::model()->count($criteriaClusters);

                    $pagesClusters = new CPagination($countClusters);
                    $pagesClusters->pageSize = $this->pSize;
                    $pagesClusters->applyLimit($criteriaClusters);  

                    $modelML = (isset($_REQUEST['idMLModel']))? $_REQUEST['idMLModel'] : '';
                    $clusterML = (isset($_REQUEST['idCluster']))? $_REQUEST['idCluster'] : '';
                    
                    $data = array();

                    foreach ($model as $value) {
                        $lastManagement = Controller::lastManagement($value->date, $value->id);
                        $othersValues = Controller::othersValues($value->id,false);
                        $mlModelD = Controller::getModelCluster($modelML, $clusterML, $value->id);
                       $data[] = array(
                                'id' => $value->id,
                                'company' => '<div class="txt_center"><img src="'.$lastManagement['alliance']['image'].'" style="max-width: 30px; margin: auto;" /></div>',
                                'customer' => $value->customer,
                                'name' => $value->name,
                                'code' => $value->code,
                                'city' => $value->city,
                                'capital' => '$'.number_format($value->capital, 0, ',', '.'),
                                'idMLModel' => $mlModelD['model'], 
                                'idCluster' => $mlModelD['cluster'],
                                'impago' => $mlModelD['percent'].' %',
                                'ageDebt' => $othersValues['ageDebt'],
                                'idState' => $value->state,
                                'date' => '<span class="'.$lastManagement['color'].'-text">'.$lastManagement['date'].'</span>',
                        );
                    }
                    
                    $return = array(
                        "draw" => intval($draw),
                        "iTotalRecords" => $count,
                        "iTotalDisplayRecords" => $count,
                        "aaData" => $data,
                    );
                    echo CJSON::encode($return);
                    Yii::app()->end();                    
                }else{
                    
                    $conditionS = 'historic = 0 AND active = 1 AND idDebtorsState IS NULL ';
                    $conditionS .= (isset($_REQUEST['ageDebt']) && $_REQUEST['ageDebt'] == 0)? '' : ' AND is_legal = 0';
                    $debtorState = DebtorsState::model()->findAll(array('condition' => $conditionS, 'order' => 'name ASC'));
                    
                    $ageDebts = AgeDebt::model()->findAll(array('order' => 'name ASC'));
                    $clustersSelect = (isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] != 0)? Clusters::model()->findAll(array('condition' => 'idMLModel ='.$_REQUEST['idMLModel'],'order' => 'name')) : array();
                    $mlModels = Mlmodels::model()->findAll(array('limit' => 3));
                    
                    if (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '') {
                        $url .= ($url != '') ? '/' : '';
                        $url .= $_REQUEST['idRegion'];
                    }
                    
                    if (isset($_REQUEST['ageDebt']) && $_REQUEST['ageDebt'] != '') {
                        $url .= ($url != '') ? '/' : '';
                        $url .= $_REQUEST['ageDebt'];
                    }

                    if (isset($_REQUEST['is_legal']) && $_REQUEST['is_legal'] != '') {
                        $url .= ($url != '') ? '/' : '';
                        $url .= $_REQUEST['is_legal'];
                    }
                    
                    $hideML = (Yii::app()->user->getState('ml') != null && Yii::app()->user->getState('ml') == 0)? 'false' : 'true';                    
                    $hideCompany = (Yii::app()->user->getState('rol') != null && in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'],Yii::app()->params['customers'])))? 'false' : 'true';
                    $hideCustomer = (Yii::app()->user->getState('rol') != null && in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers'])))? 'false' : 'true';
         
                    $vars = array(                    
                            'ageDebts' => $ageDebts,
                            'debtorState' => $debtorState,
                            'clustersSelect' => $clustersSelect,
                            'mlModels' => $mlModels,
                            'total' => 0,
                            'accounts' => 0,
                            'id' => $id,
                            'quadrant' => $quadrant,
                            'legal' => (isset($_REQUEST['is_legal']))? $_REQUEST['is_legal'] : 0,   
                            'url' => $url,
                            'hideML' => $hideML,
                            'hideCompany' => $hideCompany,
                            'hideCustomer' => $hideCustomer,
                        );
                    
                    $this->render('debtors_list', $vars);
                }
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================

    public function actionExportDebtors() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_debtors_" . Date('d_m_Y_h_i_s') . ".csv";


            $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','agreement', 'idTypeDocument','idCreditModality');

            $criteria = new CDbCriteria();
            $join = ' JOIN tbl_debtors td ON t.idDebtor = td.id';
            $condition = '';


            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if (($key != 'page' && $key != 'id' && $key != 'quadrant') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idState')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
//               echo $condition.'<br>';

                             
            if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : Yii::app()->user->getState('idCoordinator');
            }
            
            if (Yii::app()->user->getState('rol') == 7 || (isset($_GET['idCustomer']) && $_GET['idCustomer'] != '')) {
                $idCustomer = (Yii::app()->user->getState('rol') == 7)? Yii::app()->user->getId() : $_GET['idCustomer']; 
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomer = ' . $idCustomer;
            }

            if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] != 0) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'idCreditModality ='.$_GET['id'];
            }

            if (isset($_GET['quadrant']) && $_GET['quadrant'] != '' && $_GET['quadrant'] != 0) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'ageDebt ='.$_GET['quadrant'];
            }
            
            
            $states = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');
            
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 'idState NOT IN ('.implode(",", $states).')';
            $condition .= (isset($_GET['quadrant']) && ($_GET['quadrant'] == 0 || $_GET['quadrant'] == 5))? '' : ' AND t.is_legal = 0';

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';
            
            
//            echo $condition;


            $sql = 'SELECT 
                       \'Cliente\',\'Nombre Deudor\',\'CC / NIT \',\'Ciudad\',\'Telefono\',\'Direccion\',\'Email\',\'Capital\',\'Estado\',\'Obligaciones(N. Credito, Fecha, Capital, Intereses, Int. mora, Int mora migrados, Gastos, Otros )\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(t.customer , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(t.name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       t.code,
                       REPLACE(REPLACE(REPLACE(t.city , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                                               
                       REPLACE(REPLACE(REPLACE(td.phone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                        
                       REPLACE(REPLACE(REPLACE(td.address , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                        
                       REPLACE(REPLACE(REPLACE(td.email , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                        
                       REPLACE(t.capital,\'.\',\',\') AS value,                                             
                       REPLACE(REPLACE(REPLACE(t.state , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \') ,
                       (SELECT group_concat(concat_ws(" - ",`to`.`credit_number`,`to`.`duedate`,`to`.`capital`,`to`.`interest`,`to`.`interest_arrears`, `to`.`interest_arrears_migrate`, `to`.`charges`, `to`.`others`, `tdoi`.origin_credit ) separator " ? ") AS `obligation` FROM `tbl_debtors_obligations` `to` 
	JOIN `tbl_debtors_obligations_info` `tdoi` ON `to`.`id` = `tdoi`.`idDebtorObligation` 
	WHERE `to`.`idDebtor` =  t.idDebtor) 
                       FROM view_debtors t
                       '.$join.' 
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

    
     //=============================================================================================
    public function actionLegal(){
        if (!Yii::app()->user->isGuest) {
                
            $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','agreement', 'idTypeDocument');
            
            $id = (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '')? $_REQUEST['idRegion'] : 0;
            
            $quadrant = (isset($_REQUEST['quadrant']) && $_REQUEST['quadrant'] != '')? $_REQUEST['quadrant'] : 0; 
                                                
            $join = 'JOIN tbl_debtors_debts tdd ON t.id = tdd.id left JOIN view_management_last vml on t.id = vml.idDebtorDebt';
            $condition = '';
            
            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {

                    if (($key != 'page' && $key != 'id' && $key != 'quadrant') && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idState')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            
            if($quadrant != 0 && $quadrant <= 4 ){
               $condition .= ' ageDebt = '.$quadrant;
            }
            
            if(isset($_REQUEST['settledNumber']) && $_REQUEST['settledNumber'] != ''){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' tdd.settledNumber = '.$_REQUEST['settledNumber'];
            }
            
            if(isset($_REQUEST['office_legal_location']) && $_REQUEST['office_legal_location'] != ''){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' tdd.office_legal_location LIKE "%'.$_REQUEST['office_legal_location'].'%"';
            }
            
            if (isset($_REQUEST['terms']) && $_REQUEST['terms'] != '') {
                $join .= ($_REQUEST['terms'] == 0)? ' LEFT' : '';
                $cond = ($_REQUEST['terms'] == 0)? ' vt.id IS NULL' : 'vt.idTasksAction = 30';
                $join .= ' JOIN view_tasks vt ON  t.id = vt.idPrimary AND '.$cond; 
            }
            
            if(isset($_REQUEST['idTypeProcess']) && $_REQUEST['idTypeProcess'] != ''){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' tdd.idTypeProcess = '.$_REQUEST['idTypeProcess'];
            }
            
            if(isset($_REQUEST['idCustomer']) && $_REQUEST['idCustomer'] != ''){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' t.idCustomer = '.$_REQUEST['idCustomer'];
            }
            
             if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
                $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
            } elseif (Yii::app()->user->getState('rol') == 7) {
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomer = ' . Yii::app()->user->getId();
            }elseif((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'])))){
                $join .= ' JOIN tbl_assignments_debtors_advisers tada ON t.idDebtor = tada.idDebtor';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' tada.idAdviser = '.Yii::app()->user->getId();
            }
            
            if(Yii::app()->user->getState('rol') == 11){
                $join .= ' JOIN tbl_users tu ON t.idCustomer = tu.id';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'tu.idCompany = '.Yii::app()->user->getId();
            } 
            
            if (isset($_REQUEST['idRegion']) && $_REQUEST['idRegion'] != '' && $_REQUEST['idRegion'] != 0) {
                $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion ='.$_REQUEST['idRegion']; 
            }

            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 'idDebtorState = ';
                        
            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 2;                          
            //is ajax       
            
            if (Yii::app()->getRequest()->getIsAjaxRequest()){  ;
                $html = '';
                $legalState = (isset($_REQUEST['idState']) && $_REQUEST['idState'] != '')? $_REQUEST['idState'] : 0;
                $models = WalletController::getDebtorsLegal($condition, $join ,$legalState,$currentPage);
                foreach ($models['models'] as $model) {
                    $html .= $this->renderPartial('/wallet/partials/item-debtor-legal', array('model' => $model), true);
                }
                
                $return = array(
                        "status" => 'success',
                        "msg" => 'ok',
                        "html" => $html,
                        "page" => ($currentPage + 1),
                        "id" => $legalState,
                        "more" => $models['more'],
                    );
                    echo CJSON::encode($return);
                    Yii::app()->end(); 
                
            }else{
                                                
                $criteria = new CDbCriteria();
                $conditionL = 't.is_legal = 1 AND t.historic = 0 AND t.idDebtorsState IS NULL AND t.active = 1';
                $criteria->select = 't.id as id, t.name as name';
                $criteria->order = 't.order ASC';

                $criteria->group = 't.id';
                $criteria->condition = $conditionL;

                $legalStates = DebtorsState::model()->findAll($criteria);
                
                $html = $this->renderPartial('/wallet/legal_content', array('legalStates' => $legalStates,'condition' => $condition,'join' => $join, 'currentPage' => $currentPage), true);                        
                $coordinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
                $modelML = (isset($_REQUEST['idMLModel']))? $_REQUEST['idMLModel'] : 0;
                $typeProcess = TypeProcess::model()->findAll(array('condition' => 't.is_legal = 1'));
                $mlModels = Mlmodels::model()->findAll(array('limit' => 3));
                $conditionS = 'historic = 0 AND active = 1 AND idDebtorsState IS NULL AND is_legal = 1';
                $debtorState = DebtorsState::model()->findAll(array('condition' => $conditionS, 'order' => 'name ASC'));
                
                $this->render('legal',array('html' => $html,
                    'id' => $id,
                    'quadrant' => $quadrant,
                    'debtorState' => $debtorState,
                    'urlExport' => "wallet/exportDebtors/".$id."/".$quadrant,
                    'coordinators' => $coordinators,
                    //'clusters' => $clusters, 
                    'mlModels' => $mlModels,
                    'typeProcess' => $typeProcess,
                    'currentPage' => $currentPage,

                        ));
            }
            
                        
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================

    public static function GetDebtorsLegal($condition, $join, $idSate, $page = 0) {
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.id as id, t.idDebtor as idDebtor,t.customer as customer, t.name as name, t.code as code, t.capital as capital, ageDebt as ageDebt, prescription as prescription, vml.date';
        $criteria->condition =  $condition.$idSate;        
        $criteria->join =  ($join != '')? $join : NULL;
                    
        $_REQUEST['page'] = $page;
        
        $criteria->order = "t.capital DESC";
        $criteria->group = 't.id';
        $count = ViewDebtorsLegal::model()->count($criteria);
        
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $model['models'] = ViewDebtorsLegal::model()->findAll($criteria);
        $model['more'] = $return['more'] = ($count > ($page * $pages->pageSize))? true : false;
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

    public function actionHistoric() {

        if (!Yii::app()->user->isGuest) {
            $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            if ($user != null) {

                $filters = array('customer', 'name', 'code', 'city', 'capital', 'idState');

                $criteria = new CDbCriteria();     
                $select = 't.id, t.customer, t.name, t.code, city, t.capital, t.idDebtor, t.state, vml.date';
                $join = 'left JOIN view_management_last vml on t.id = vml.idDebtorDebt';
                $condition = '';


                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'id' && $key != 'quadrant') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'idState')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
//               echo $condition.'<br>';

                if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
                    $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = ';
                    $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
                } elseif (Yii::app()->user->getState('rol') == 7) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCustomer = ' . Yii::app()->user->getId();
                }
                
                if (Yii::app()->user->getState('rol') == 11) {
                    $join .= ' JOIN tbl_users tu ON t.idCustomer = tu.id';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'tu.idCompany = ' . Yii::app()->user->getId();
                }

                if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'idCreditModality ='.$_REQUEST['id'];
                }
                
                if (isset($_REQUEST['quadrant']) && $_REQUEST['quadrant'] != '' && $_REQUEST['quadrant'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'ageDebt ='.$_REQUEST['quadrant'];
                }
                
                if(isset($_REQUEST['date']) && $_REQUEST['date'] != ''){
                    $date = Controller::CleanFilterDate($_REQUEST['date']);                     
                    $condition .= ($condition != '') ? ' AND ' : ''; 
                    if((int)$date['count'] > 1){                        
                        $condition .= 'vml.date BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                    }else{  
                        $condition .= 'vml.date = "'.$date['date'][0].'"' ;                     
                    }                    
                }
                
                $conditionS = 'historic = 1 AND active = 1 AND idDebtorsState IS NULL ';
                $conditionS .= (isset($_REQUEST['quadrant']) && $_REQUEST['quadrant'] == 0)? '' : ' AND is_legal = 0';
                
                $debtorState = DebtorsState::model()->findAll(array('condition' => $conditionS, 'order' => 'name ASC'));
                
                $states = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');
                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'idState IN ('.implode(",", $states).')';
                //$condition .= (isset($_GET['quadrant']) && ($_GET['quadrant'] == 0 || $_GET['quadrant'] == 5))? '' : ' AND is_legal = 0';
                
                /*echo $condition."<br>";
                echo $join."<br>";
                exit;*/
                
                $criteria->join = $join;
                $criteria->condition = $condition;
                
                $criteria->select = 'SUM(t.capital) as capital';
                $total = ViewHistoric::model()->find($criteria);
                
                $criteria->select = $select;
                $count = ViewHistoric::model()->count($criteria);
                
                if(isset($_REQUEST['order']) && $_REQUEST['order'] != ''){
                    $order = str_replace('_', ' ', $_REQUEST['order']);
                }else{
                    $order = "t.capital DESC";
                }
                
                $criteria->order = $order;
                                
                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);
                
                $model = ViewHistoric::model()->findAll($criteria);
                
                $coordinators = ViewCoordinators::model()->findAll(array('condition' => 'active = 1 AND idProfile = 2'));
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
                
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/wallet/partials/content-historic-table', array('model' => $model), true);
                    $script = Controller::hideOptionsProfiles();
                    $return['table'] .= "<script>
                       $(document).ready(function(){    
                            ".$script."
                       });
                       </script>"; 
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'historic'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                
                    $this->render('historic_list', array('model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'debtorState' => $debtorState,
                        'id' => (isset($_REQUEST['id']) && $_REQUEST['id'] != '')? $_REQUEST['id'] : 0,
                        'quadrant' => (isset($_REQUEST['quadrant']) && $_REQUEST['quadrant'] != '')? $_REQUEST['quadrant'] : 0,
                        'url' => 'historic',
                        'urlExport' => "wallet/exportDebtorsHistoric",
                        'historic' => true,
                        'legal' => (isset($_REQUEST['is_legal']))? $_REQUEST['is_legal'] : 0 ,
                        'coordinators' => $coordinators,
                        'accounts' => $count,
                        'total' => ($total != null)? $total->capital : 0                    
                        ));
                }
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //=============================================================================================
    
    
    public function actionHistoricDebtor() {
        
        if (!Yii::app()->user->isGuest && isset($_GET['id']) && $_GET['id'] != '') {

            if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) {
                $idCoordinator = Yii::app()->user->getId();
                if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers'])) {
                    $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
                    $idCoordinator = $user->idCoordinator;
                }
                $debtor = Yii::app()->db->createCommand("SELECT t.*  FROM `view_historic` t  JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign WHERE t.idDebtor = " . $_GET['id'] . " AND cc.idCoordinator = " . $idCoordinator)->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
            } else {
                $condition = 'idDebtor = ' . $_GET['id'];
                if (Yii::app()->user->getState('rol') == 7) {
                    $condition .= ' AND idCustomer =' . Yii::app()->user->getId();
                }

                $debtor = ViewHistoric::model()->find(array('condition' => $condition));
            }

            if ($debtor != NULL) {
                $tCondition = ($debtor->is_legal)? '' : ' AND t.is_legal = 0';
                $task = (isset($_GET['task']) && $_GET['task'] != '')? DebtorsTasks::model()->findByPk($_GET['task']) : null;
                $conditionStatus = 'active = 1 AND idDebtorsState IS NULL AND is_legal ='.$debtor->is_legal;
                $conditionStatus .= ($debtor->is_legal)? ' OR historic = 1 ' : '';
                $status = DebtorsState::model()->findAll(array('condition' => $conditionStatus , 'order' => 'name ASC'));
                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $debt = Debtors::model()->findByPk($debtor->idDebtor);
                $debtDemographic = DebtorsDemographics::model()->find(array("condition" => "idDebtor = ".$debtor->idDebtor));
                $othersValues = Controller::othersValues($debtor->idDebtor);
                $debtorObli = DebtorsObligations::model()->findByPk($debtor->id);
                $educationLevels  = TypeEducationLevels::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $ages = TypeAge::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $typeHousings = TypeHousing::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $typeContracts = TypeContract::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
//                $paymentsCapital = Yii::app()->db->createCommand("SELECT SUM(t.value) as value FROM view_payments t WHERE idDebtor = ".$debtor->idDebtor." AND idPaymentsDiscrimination = 1")->setFetchMode(PDO::FETCH_OBJ)->queryScalar();
//                $paymentsInteres = Yii::app()->db->createCommand("SELECT SUM(t.value) as value FROM view_payments t WHERE idDebtor = ".$debtor->idDebtor." AND idPaymentsDiscrimination = 2")->setFetchMode(PDO::FETCH_OBJ)->queryScalar(); 
//                $paymentsHonorario = Yii::app()->db->createCommand("SELECT SUM(t.value) as value FROM view_payments t WHERE idDebtor = ".$debtor->idDebtor." AND idPaymentsDiscrimination = 3")->setFetchMode(PDO::FETCH_OBJ)->queryScalar();                 
                $assets = DebtorsProperty::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicEmail = DebtorsEmails::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicPhones = DebtorsPhones::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicAddresses = DebtorsAddresses::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicCoSigners = DebtorsContacts::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor .' AND idTypeDebtorContact = 1'));
                $demographicReferences = DebtorsContacts::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor .' AND idTypeDebtorContact = 2'));
                
                $payments = DebtorsPayments::model()->with('idDebtorObligation0')->findAll(array('condition' => 'idPaymentsState <> 4 AND idDebtorObligation0.active = 0 AND idDebtorObligation0.idDebtor =' . $debtor->idDebtor,'order' => 'datePay DESC'));
                $agreements = DebtorsPayments::model()->with('idDebtorObligation0')->findAll(array('condition' => 'idPaymentsState = 4 AND idDebtorObligation0.active = 0 AND idDebtorObligation0.idDebtor =' . $debtor->idDebtor,'order' => 'datePay DESC'));
                $supports = DebtorsSupports::model()->with('idTypeSupport0')->findAll(array('condition' => 'idTypeSupport0.type = 1 AND idDebtor =' . $debtor->id,'order' => 'dateSupport DESC'));
                $spendings = DebtorsSpendings::model()->findAll(array('condition' => 'idDebtor =' . $debtor->id));
                $comments = DebtorsComments::model()->findAll(array('condition' => 'idDebtor =' . $debtor->id));
                
                $actions  = TasksActions::model()->findAll(array('condition' => 'active = 1 AND idTasksAction IS NULL '.$tCondition,'order' => 'name ASC'));                
                $nodes = Yii::app()->db->createCommand("select  id, name, idDebtorsState AS parent from  (select * from tbl_debtors_state where active = 1 order by idDebtorsState, id) tbl_debtors_state,(select @pv := ".$debtor->idState.") initialisation where   find_in_set(idDebtorsState, @pv) > 0 and @pv := concat(@pv, ',', id)")->queryAll();
//            
                $tree = Controller::buildTree($nodes,$debtor->idState);
                $ageDebts = AgeDebt::model()->findAll();
                $creditModalities = CreditModality::model()->findAll();
                
                $stateHistoric = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');
                
                $historic = (in_array($debtor->idState, $stateHistoric));
                $genders = Genders::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                $occupations = Occupations::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                $maritalStates = MaritalStates::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                
                $paymentStates = PaymentsState::model()->findAll(array('condition' => 'active = 1'));
                $paymentClasses = PaymentsType::model()->findAll(array('condition' => 'active = 1'));
                $paymentPaidTos = PaymentsWhopaid::model()->findAll(array('condition' => 'active = 1'));
                $paymentTypeDiscriminations = PaymentsDiscrimination::model()->findAll(array('condition' => 'active = 1'));
                $paymentMethods = PaymentsMethods::model()->findAll(array('condition' => 'active = 1'));
                $spendingTypes = SpendingTypes::model()->findAll(array('condition' => 'active = 1'));
                $assetTypes = PropertyType::model()->findAll(array('condition' => 'active = 1'));
                $typeReferences = TypeReference::model()->findAll(array('condition' => 'active = 1'));
                $phoneClasses = PhoneClass::model()->findAll(array('condition' => 'active = 1'));
                
                $typeSupports = TypeSupports::model()->findAll(array('condition' => 'type = 1 AND active = 1','order' => 'name ASC'));
                $typeLegalSupports = TypeSupports::model()->findAll(array('condition' => 'type = 2 AND active = 1','order' => 'name ASC'));
                
                $officeLegals = ($debtor->is_legal)? OfficeLegal::model()->findAll(array('condition' => 'idOfficeLegal IS NULL AND active = 1', 'order' => 'name ASC')) : array();
                
                //              Supports legal
                    // obligations 
                $jObligations = 'JOIN tbl_debtors_obligations tdo on t.idDebtor = tdo.id AND tdo.active = 0';
                
                $criteriaSLegal = new CDbCriteria();   
                $criteriaSLegal->select = 't.*';
                $criteriaSLegal->condition = 'idTypeSupport0.type = 2 AND t.idDebtor =' . $debtor->id;
                $criteriaSLegal->join = $jObligations;
                $criteriaSLegal->order = 't.dateSupport DESC';
                
                $count = DebtorsSupports::model()->with('idTypeSupport0')->count($criteriaSLegal);
                
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteriaSLegal);                
                
                $supportsLegals = DebtorsSupports::model()->with('idTypeSupport0')->findAll($criteriaSLegal);
                
//              Managements  
                $criteriaManagement = new CDbCriteria();   
                $criteriaManagement->select = 't.*';
                $criteriaManagement->condition = 't.idDebtor ='.$debtor->id.' AND t.state = 1 AND t.date <= CURDATE()';
                $criteriaManagement->order = 't.date DESC,t.id DESC';
                
                $countManagement = ViewManagement::model()->count($criteriaManagement);
                
                $pagesManagement = new CPagination($countManagement);
                $pagesManagement->pageSize = $this->pSize;
                $pagesManagement->applyLimit($criteriaManagement);  
                
                $managements = ViewManagement::model()->findAll($criteriaManagement);                
                
//              Filter Managements                
                $criteriaManagement->select = 't.idTasksAction, t.management';
                $criteriaManagement->group = 't.idTasksAction'; 
                $actionsManagements = ViewManagement::model()->findAll($criteriaManagement);
                
//              Obligations  
                $criteriaObligations = new CDbCriteria();   
                $criteriaObligations->select = 't.*';
                $criteriaObligations->condition = 't.idDebtor ='.$debtor->idDebtor.' AND t.active = 0';
                $criteriaObligations->order = 't.duedate DESC';
                
                $countObligations = ViewDebtorsObligations::model()->count($criteriaObligations);
                
                $pagesObligations = new CPagination($countObligations);
                $pagesObligations->pageSize = $this->pSize;
                $pagesObligations->applyLimit($criteriaObligations);  
                                
                $obligations = ViewDebtorsObligations::model()->findAll($criteriaObligations);                 
                                
//              properties
                $criteriaProperties = new CDbCriteria();   
                $criteriaProperties->select = 't.*';
                $criteriaProperties->condition = 't.idDebtor =' . $debtor->idDebtor;
                $criteriaProperties->order = 't.id DESC';
                
                $countProperties = DebtorsProperty::model()->count($criteriaProperties);
                
                $pagesProperties = new CPagination($countProperties);
                $pagesProperties->pageSize = $this->pSize;
                $pagesProperties->applyLimit($criteriaProperties);  
                                
                $properties = DebtorsProperty::model()->findAll($criteriaProperties);   
                
//              percent demographics 
                $demographicsPorc = Controller::demographicsPercent($debtor->idDebtor);
                
                $mlModels = Mlmodels::model()->findAll(array('limit' => 3));
                
                $typeProcess = TypeProcess::model()->findAll(array('condition' => 't.is_legal ='.$debtor->is_legal));
                
                $this->render(
                    'debtor', array(
                    'debtor' => $debtor,
                    'debt' => $debt,
                    'demographicsPorc' => $demographicsPorc,
                    'debtDemographic' => $debtDemographic,
                    'othersValues' => $othersValues,
                    'debtorObli' => $debtorObli,
                    'task' => $task,
                    'obligations' => $obligations,
                    'pagesObligations' => $pagesObligations,
                    'status' => $status,
                    'countries' => $countries,
                    'actions' =>  $actions,
                    'payments' => $payments,
                    'agreements' => $agreements,
                    'spendings' => $spendings,
                    'supports' => $supports,                        
                    'supportsLegals' => $supportsLegals,                        
                    'pages' => $pages,                                             
                    'demographicPhones' => $demographicPhones,
                    'demographicReferences' => $demographicReferences,
                    'demographicEmail' => $demographicEmail,
                    'demographicAddresses' => $demographicAddresses,
                    'demographicCoSigners' => $demographicCoSigners,
                    'assets' => $assets,
                    'comments' => $comments,
                    'countManagement' => $countManagement,
                    'managements' => $managements,
                    'actionsManagements' => $actionsManagements,    
                    'pagesManagement' => $pagesManagement,   
                    'countProperties' => $countProperties,
                    'properties' => $properties,
                    'pagesProperties' => $pagesProperties,  
                    'tree' => $tree,
                    'ageDebts' => $ageDebts,
                    'creditModalities' => $creditModalities, 
                    'historic' => $historic,
                    'genders' => $genders,
                    'occupations' => $occupations,
                    'maritalStates' => $maritalStates,
                    'typeSupports' =>  $typeSupports,
                    'typeLegalSupports' => $typeLegalSupports,
                    'officeLegals' => $officeLegals,
                    'educationLevels' => $educationLevels,
                    'ages' => $ages,
                    'typeHousings' => $typeHousings,
                    'typeContracts' => $typeContracts, 
                    'paymentStates' => $paymentStates,
                    'paymentClasses' => $paymentClasses,
                    'paymentPaidTos' => $paymentPaidTos,
                    'paymentTypeDiscriminations' => $paymentTypeDiscriminations,
                    'paymentMethods' => $paymentMethods,
                    'spendingTypes' => $spendingTypes,
                    'assetTypes' => $assetTypes,
                    'typeReferences' => $typeReferences,
                    'phoneClasses' => $phoneClasses,
                    'call' => false,
                    'phones' => array(),
                    'phonesSMS' => array(),
                    'emailEmails' => array(),
                    'assets' => array(),
                    'isMobile' => $this->isMobile,
                    'mlModels' => $mlModels,
                    'typeProcess' => $typeProcess,
                        )
                );
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    
    public function actionTest(){
        //$model = Debtors::model()->find();
             
//        $object = Controller::demographicsPercent_(43393);
//        
//        print_r($object);
//        exit;
        
    }
    
    //=============================================================================================
    
    public function actionExportDebtorsHistoric() {
            $return = array('status' => 'error',
                'msg' => Yii::t('front', 'Solicitud Invalida'),
                'file' => '',
            );

            set_time_limit(0);
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();

            try {
                $root = Yii::getPathOfAlias('webroot');
                $filename = "/uploads/export/" . "export_debtors_" . Date('d_m_Y_h_i_s') . ".csv";


                $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','agreement');

                $criteria = new CDbCriteria();
                $join = ' JOIN tbl_debtors td ON t.idDebtor = td.id';
                $condition = '';


                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

                        if (($key != 'page' && $key != 'id' && $key != 'quadrant') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .= (($key != 'idState')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
    //               echo $condition.'<br>';


                if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
                    $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = ';
                    $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : Yii::app()->user->getState('idCoordinator');
                } elseif (Yii::app()->user->getState('rol') == 7) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idCustomer = ' . Yii::app()->user->getId();
                }

                if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'idCreditModality ='.$_GET['id'];
                }

                if (isset($_GET['quadrant']) && $_GET['quadrant'] != '' && $_GET['quadrant'] != 0) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 'ageDebt ='.$_GET['quadrant'];
                }


                $states = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');

                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'idState IN ('.implode(",", $states).')';
                $condition .= (isset($_GET['quadrant']) && ($_GET['quadrant'] == 0 || $_GET['quadrant'] == 5))? '' : ' AND t.is_legal = 0';

                $condition = ($condition != '') ? 'WHERE ' . $condition : '';


    //            echo $condition;


                $sql = 'SELECT 
                           \'Cliente\',\'Nombre Deudor\',\'CC / NIT \',\'Ciudad\',\'Telefono\',\'Direccion\',\'Email\',\'Capital\',\'Estado\'
                           UNION
                           SELECT 
                           REPLACE(REPLACE(REPLACE(t.customer , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                           REPLACE(REPLACE(REPLACE(t.name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                           t.code,
                           REPLACE(REPLACE(REPLACE(t.city , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                                               
                           REPLACE(REPLACE(REPLACE(td.phone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                        
                           REPLACE(REPLACE(REPLACE(td.address , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                        
                           REPLACE(REPLACE(REPLACE(td.email , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                        
                           REPLACE(t.capital,\'.\',\',\') AS value,
                           REPLACE(REPLACE(REPLACE(t.state , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \')
                           FROM view_debtors t
                           '.$join.' 
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

    
     //=============================================================================================

    public function actionDebtor() {
       
        if (!Yii::app()->user->isGuest && isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
            $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            
            $criteria = new CDbCriteria();
            $join = '';
            $condition = 't.id = ' . $_REQUEST['id'];

            if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) {
                $idCoordinator = Yii::app()->user->getId();
                if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers'])) {
                    $idCoordinator = $user->idCoordinator;
                }
                $join = 'JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign AND cc.idCoordinator = '.$idCoordinator;                
//                $debtor = Yii::app()->db->createCommand("SELECT t.*  FROM `view_debtors` t   WHERE t.id = " . $_GET['id'] . " AND cc.idCoordinator = " . $idCoordinator)->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
            } elseif(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) {                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' idCustomer =' . Yii::app()->user->getId();
            }
            
            $criteria->select = 't.*';
            $criteria->condition = $condition;
            $criteria->join = $join;
            
            $debtor = ViewDebtors::model()->find($criteria);                               
                        
            if($debtor == null){
                //echo 'historic';exit;
                $debtor = ViewHistoric::model()->find(array('condition' => $condition));                                               
            }
            
                       
            if ($debtor != NULL) {               
                $state = DebtorsState::model()->findByPk($debtor->idState);                   
                $tCondition = ($debtor->is_legal)? '' : ' AND t.is_legal = 0';
                $task = (isset($_REQUEST['task']) && $_REQUEST['task'] != '')? DebtorsTasks::model()->findByPk($_REQUEST['task']) : null;                 
                $conditionStatus = ($state != null)? 't.order >='.$state->order : '';
                $conditionStatus .= ($conditionStatus != '') ? ' AND ' : '';
                $conditionStatus .= 't.active = 1 AND t.idDebtorsState IS NULL AND t.is_legal ='.$debtor->is_legal;
                $conditionStatus .= ($debtor->is_legal)? ' OR t.historic = 1 ' : '';                
                $orderStatus = ($debtor->is_legal)? 't.order ASC' : 't.name ASC';
                $status = DebtorsState::model()->findAll(array('condition' => $conditionStatus , 'order' => $orderStatus));                
                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                //
                $debt = Debtors::model()->findByPk($debtor->idDebtor);
                $debtDemographic = DebtorsDemographics::model()->find(array("condition" => "idDebtor = ".$debtor->idDebtor));
                $othersValues = Controller::othersValues($debtor->id);
                $debtorObli = DebtorsDebts::model()->findByPk($debtor->id);
                $educationLevels  = TypeEducationLevels::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $ages = TypeAge::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $typeHousings = TypeHousing::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $typeContracts = TypeContract::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $demographicEmail = DebtorsEmails::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicPhones = DebtorsPhones::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicAddresses = DebtorsAddresses::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicCoSigners = DebtorsContacts::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor .' AND idTypeDebtorContact = 1'));
                $demographicReferences = DebtorsContacts::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor .' AND idTypeDebtorContact = 2'));
                
                $payments = DebtorsPayments::model()->findAll(array('condition' => 'idPaymentsState <> 4 AND idDebtorDebt =' . $debtor->id,'order' => 'datePay DESC'));
                $agreements = DebtorsPayments::model()->findAll(array('condition' => ' idPaymentsState = 4 AND idDebtorDebt =' . $debtor->id,'order' => 'datePay DESC'));
                $supports = DebtorsSupports::model()->with('idTypeSupport0')->findAll(array('condition' => 'idTypeSupport0.type = 1 AND idDebtorDebt =' . $debtor->id,'order' => 'dateSupport DESC'));
                $spendings = DebtorsSpendings::model()->findAll(array('condition' => 'idDebtorDebt =' . $debtor->id));
                $comments = DebtorsComments::model()->findAll(array('condition' => 'idDebtor =' . $debtor->id));
                
                $actions    = TasksActions::model()->findAll(array('condition' => 'active = 1 AND idTasksAction IS NULL '.$tCondition,'order' => 'name ASC'));                
                $nodes = Yii::app()->db->createCommand("select  id, name, idDebtorsState AS parent from  (select * from tbl_debtors_state where active = 1 order by idDebtorsState, id) tbl_debtors_state,(select @pv := ".$debtor->idState.") initialisation where   find_in_set(idDebtorsState, @pv) > 0 and @pv := concat(@pv, ',', id)")->queryAll();
                
                $tree = Controller::buildTree($nodes,$debtor->idState);
                $ageDebts = AgeDebt::model()->findAll();
                $creditModalities = CreditModality::model()->findAll();
                
                $stateHistoric = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');
                
                $historic = (in_array($debtor->idState, $stateHistoric));
                $genders = Genders::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                $occupations = Occupations::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                $maritalStates = MaritalStates::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                
                $paymentStates = PaymentsState::model()->findAll(array('condition' => 'active = 1'));
                $paymentClasses = PaymentsType::model()->findAll(array('condition' => 'active = 1'));
                $paymentPaidTos = PaymentsWhopaid::model()->findAll(array('condition' => 'active = 1'));
                $paymentTypeDiscriminations = PaymentsDiscrimination::model()->findAll(array('condition' => 'active = 1'));
                $paymentMethods = PaymentsMethods::model()->findAll(array('condition' => 'active = 1'));
                $spendingTypes = SpendingTypes::model()->findAll(array('condition' => 'active = 1'));
                $assetTypes = PropertyType::model()->findAll(array('condition' => 'active = 1'));
                $typeReferences = TypeReference::model()->findAll(array('condition' => 'active = 1'));
                $phoneClasses = PhoneClass::model()->findAll(array('condition' => 'active = 1'));
                
                $typeSupports = TypeSupports::model()->findAll(array('condition' => 'type = 1 AND active = 1','order' => 'name ASC'));
                $typeLegalSupports = TypeSupports::model()->findAll(array('condition' => 'type = 2 AND active = 1','order' => 'name ASC'));
                
                $officeLegals = ($debtor->is_legal)? OfficeLegal::model()->findAll(array('condition' => 'idOfficeLegal IS NULL AND active = 1 AND type = 1', 'order' => 'name ASC')) : array();
                $categoryLegals = ($debtor->is_legal)? OfficeLegal::model()->findAll(array('condition' => 'idOfficeLegal IS NULL AND active = 1 AND type = 2', 'order' => 'name ASC')) : array();
                
//              Supports legal
                $criteriaSLegal = new CDbCriteria();   
                $criteriaSLegal->select = 't.*';
                $criteriaSLegal->condition = 'idTypeSupport0.type = 2 AND t.idDebtorDebt =' . $debtor->id;
                $criteriaSLegal->order = 't.dateSupport DESC';
                
                $count = DebtorsSupports::model()->with('idTypeSupport0')->count($criteriaSLegal);
                
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteriaSLegal);                
                
                $supportsLegals = DebtorsSupports::model()->with('idTypeSupport0')->findAll($criteriaSLegal);
                
//              Managements  
                $criteriaManagement = new CDbCriteria();   
                $criteriaManagement->select = 't.*';
                $criteriaManagement->condition = 't.idDebtorDebt ='.$debtor->id.' AND t.state = 1 AND t.date <= CURDATE()';
                $criteriaManagement->order = 't.date DESC,t.id DESC';
                
                $countManagement = ViewManagement::model()->count($criteriaManagement);
                
                $pagesManagement = new CPagination($countManagement);
                $pagesManagement->pageSize = $this->pSize;
                $pagesManagement->applyLimit($criteriaManagement);  
                
                $managements = ViewManagement::model()->findAll($criteriaManagement);                
                
//              Filter Managements                
                $criteriaManagement->select = 't.idTasksAction, t.management';
                $criteriaManagement->group = 't.idTasksAction'; 
                $actionsManagements = ViewManagement::model()->findAll($criteriaManagement);
                
//              Obligations  
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
				/*echo "<pre>";
                 var_dump($obligations);     
				echo "</pre>";	*/			 
//              properties
                $criteriaProperties = new CDbCriteria();   
                $criteriaProperties->select = 't.*';
                $criteriaProperties->condition = 't.idDebtor =' . $debtor->idDebtor;
                $criteriaProperties->order = 't.id DESC';
                
                $countProperties = DebtorsProperty::model()->count($criteriaProperties);
                
                $pagesProperties = new CPagination($countProperties);
                $pagesProperties->pageSize = $this->pSize;
                $pagesProperties->applyLimit($criteriaProperties);  
                                
                $properties = DebtorsProperty::model()->findAll($criteriaProperties);   
                
//              percent demographics 
                $demographicsPorc = Controller::demographicsPercent($debtor->idDebtor);
                
                $phones = ViewDebtorsPhone::model()->findAll(array('condition' => 't.idDebtor = '.$debtor->idDebtor.' AND (t.number IS NOT NULL AND t.number <> "")'));
                
                $phonesSMS = ViewDebtorsPhone::model()->findAll(array('condition' => 't.idDebtor = '.$debtor->idDebtor.' AND t.idPhoneClass = 1 AND (t.number IS NOT NULL AND t.number <> "")'));
                
                $emailEmails = ViewDebtorsEmails::model()->findAll(array('condition' => 't.idDebtor = '.$debtor->idDebtor));
                
                $mlModels = Mlmodels::model()->findAll(array('limit' => 3));
                $typeProcess = TypeProcess::model()->findAll(array('condition' => 't.active = 1 AND t.is_legal ='.$debtor->is_legal));
                $typeReports = TypeReports::model()->findAll(array('condition' => 't.active = 1 AND t.is_legal ='.$debtor->is_legal));
                $this->render(
                    'debtor', array(
                    'debtor' => $debtor,
                    'debt' => $debt,
                    'demographicsPorc' => $demographicsPorc['percent'],
                    'debtDemographic' => $debtDemographic,
                    'othersValues' => $othersValues,
                    'debtorObli' => $debtorObli,
                    'task' => $task,
                    'obligations' => $obligations,
                    'pagesObligations' => $pagesObligations,
                    'status' => $status,
                    'countries' => $countries,
                    'actions' =>  $actions,
                    'payments' => $payments,
                    'agreements' => $agreements,
                    'spendings' => $spendings,
                    'supports' => $supports,                        
                    'supportsLegals' => $supportsLegals,                        
                    'pages' => $pages,                                             
                    'demographicPhones' => $demographicPhones,
                    'demographicReferences' => $demographicReferences,
                    'demographicEmail' => $demographicEmail,
                    'demographicAddresses' => $demographicAddresses,
                    'demographicCoSigners' => $demographicCoSigners,
                    'comments' => $comments,
                    'countManagement' => $countManagement,
                    'managements' => $managements,
                    'actionsManagements' => $actionsManagements,    
                    'pagesManagement' => $pagesManagement,                      
                    'countProperties' => $countProperties,
                    'properties' => $properties,
                    'pagesProperties' => $pagesProperties,  
                    'tree' => $tree,
                    'ageDebts' => $ageDebts,
                    'creditModalities' => $creditModalities, 
                    'historic' => $historic,
                    'genders' => $genders,
                    'occupations' => $occupations,
                    'maritalStates' => $maritalStates,
                    'typeSupports' =>  $typeSupports,
                    'typeLegalSupports' => $typeLegalSupports,
                    'officeLegals' => $officeLegals,
                    'categoryLegals' => $categoryLegals,
                    'educationLevels' => $educationLevels,
                    'ages' => $ages,
                    'typeHousings' => $typeHousings,
                    'typeContracts' => $typeContracts, 
                    'paymentStates' => $paymentStates,
                    'paymentClasses' => $paymentClasses,
                    'paymentPaidTos' => $paymentPaidTos,
                    'paymentTypeDiscriminations' => $paymentTypeDiscriminations,
                    'paymentMethods' => $paymentMethods,
                    'spendingTypes' => $spendingTypes,
                    'assetTypes' => $assetTypes,
                    'typeReferences' => $typeReferences,
                    'phoneClasses' => $phoneClasses,
                    'phones' => $phones,
                    'phonesSMS' => $phonesSMS,
                    'emailEmails' => $emailEmails,
                    'call' => true,
                    'assets' => array(),
                    'isMobile' => $this->isMobile,
                    'mlModels' => $mlModels,
                    'typeProcess'    => $typeProcess,
                    'typeReports'    => $typeReports,
                        )
                );
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    public function actionDebtor_() {

        if (!Yii::app()->user->isGuest && isset($_GET['id']) && $_GET['id'] != '') {

            if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) {
                $idCoordinator = Yii::app()->user->getId();
                if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers'])) {
                    $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
                    $idCoordinator = $user->idCoordinator;
                }
                $debtor = Yii::app()->db->createCommand("SELECT t.*  FROM `view_debtors` t  JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign WHERE t.idDebtor = " . $_GET['id'] . " AND cc.idCoordinator = " . $idCoordinator)->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
            } else {
                $condition = 'idDebtor = ' . $_GET['id'];
                if (Yii::app()->user->getState('rol') == 7) {
                    $condition .= ' AND idCustomer =' . Yii::app()->user->getId();
                }

                $debtor = ViewDebtors::model()->find(array('condition' => $condition));
            }

            if ($debtor != NULL) {
                $state = DebtorsState::model()->findByPk($debtor->idState);                   
                $tCondition = ($debtor->is_legal)? '' : ' AND t.is_legal = 0';
                $task = (isset($_GET['task']) && $_GET['task'] != '')? DebtorsTasks::model()->findByPk($_GET['task']) : null;
                $conditionStatus = ($state != null)? 't.order >='.$state->order : '';
                $conditionStatus .= ($conditionStatus != '') ? ' AND ' : '';
                $conditionStatus .= 't.active = 1 AND t.idDebtorsState IS NULL AND t.is_legal ='.$debtor->is_legal;
                $conditionStatus .= ($debtor->is_legal)? ' OR t.historic = 1 ' : '';                
                $orderStatus = ($debtor->is_legal)? 't.order ASC' : 't.name ASC';
                $status = DebtorsState::model()->findAll(array('condition' => $conditionStatus , 'order' => $orderStatus));                
                $countries = Countries::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $debt = Debtors::model()->findByPk($debtor->idDebtor);
                $debtDemographic = DebtorsDemographics::model()->find(array("condition" => "idDebtor = ".$debtor->idDebtor));
                $othersValues = Controller::othersValues($debtor->idDebtor);
                $debtorObli = DebtorsObligations::model()->findByPk($debtor->id);
                $educationLevels  = TypeEducationLevels::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $ages = TypeAge::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $typeHousings = TypeHousing::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $typeContracts = TypeContract::model()->findAll(array('condition' => 'active = 1', 'order' => 'name ASC'));
                $demographicEmail = DebtorsEmails::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicPhones = DebtorsPhones::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicAddresses = DebtorsAddresses::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor));
                $demographicCoSigners = DebtorsContacts::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor .' AND idTypeDebtorContact = 1'));
                $demographicReferences = DebtorsContacts::model()->findAll(array('condition' => 'idDebtor =' . $debtor->idDebtor .' AND idTypeDebtorContact = 2'));
                
                $payments = DebtorsPayments::model()->with('idDebtorObligation0')->findAll(array('condition' => 'idPaymentsState <> 4 AND idDebtorObligation0.active = 1 AND idDebtorObligation0.idDebtor =' . $debtor->idDebtor,'order' => 'datePay DESC'));
                $agreements = DebtorsPayments::model()->with('idDebtorObligation0')->findAll(array('condition' => 'idPaymentsState = 4 AND idDebtorObligation0.active = 1 AND idDebtorObligation0.idDebtor =' . $debtor->idDebtor,'order' => 'datePay DESC'));
                $supports = DebtorsSupports::model()->with('idTypeSupport0')->findAll(array('condition' => 'idTypeSupport0.type = 1 AND idDebtor =' . $debtor->id,'order' => 'dateSupport DESC'));
                $spendings = DebtorsSpendings::model()->findAll(array('condition' => 'idDebtor =' . $debtor->id));
                $comments = DebtorsComments::model()->findAll(array('condition' => 'idDebtor =' . $debtor->id));
                
                $actions    = TasksActions::model()->findAll(array('condition' => 'active = 1 AND idTasksAction IS NULL '.$tCondition,'order' => 'name ASC'));                
                $nodes = Yii::app()->db->createCommand("select  id, name, idDebtorsState AS parent from  (select * from tbl_debtors_state where active = 1 order by idDebtorsState, id) tbl_debtors_state,(select @pv := ".$debtor->idState.") initialisation where   find_in_set(idDebtorsState, @pv) > 0 and @pv := concat(@pv, ',', id)")->queryAll();
                
                $tree = Controller::buildTree($nodes,$debtor->idState);
                $ageDebts = AgeDebt::model()->findAll();
                $creditModalities = CreditModality::model()->findAll();
                
                $stateHistoric = CHtml::listData( DebtorsState::model()->findAll(array('condition' => 'historic = 1 AND idDebtorsState IS NULL', 'order' => 'name ASC')), 'id' , 'id');
                
                $historic = (in_array($debtor->idState, $stateHistoric));
                $genders = Genders::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                $occupations = Occupations::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                $maritalStates = MaritalStates::model()->findAll(array('condition' => 'active = 1','order' => 'name'));
                
                $paymentStates = PaymentsState::model()->findAll(array('condition' => 'active = 1'));
                $paymentClasses = PaymentsType::model()->findAll(array('condition' => 'active = 1'));
                $paymentPaidTos = PaymentsWhopaid::model()->findAll(array('condition' => 'active = 1'));
                $paymentTypeDiscriminations = PaymentsDiscrimination::model()->findAll(array('condition' => 'active = 1'));
                $paymentMethods = PaymentsMethods::model()->findAll(array('condition' => 'active = 1'));
                $spendingTypes = SpendingTypes::model()->findAll(array('condition' => 'active = 1'));
                $assetTypes = PropertyType::model()->findAll(array('condition' => 'active = 1'));
                $typeReferences = TypeReference::model()->findAll(array('condition' => 'active = 1'));
                $phoneClasses = PhoneClass::model()->findAll(array('condition' => 'active = 1'));
                
                $typeSupports = TypeSupports::model()->findAll(array('condition' => 'type = 1 AND active = 1','order' => 'name ASC'));
                $typeLegalSupports = TypeSupports::model()->findAll(array('condition' => 'type = 2 AND active = 1','order' => 'name ASC'));
                
                $officeLegals = ($debtor->is_legal)? OfficeLegal::model()->findAll(array('condition' => 'idOfficeLegal IS NULL AND active = 1', 'order' => 'name ASC')) : array();
                
//              Supports legal
                $criteriaSLegal = new CDbCriteria();   
                $criteriaSLegal->select = 't.*';
                $criteriaSLegal->condition = 'idTypeSupport0.type = 2 AND t.idDebtor =' . $debtor->id;
                $criteriaSLegal->order = 't.dateSupport DESC';
                
                $count = DebtorsSupports::model()->with('idTypeSupport0')->count($criteriaSLegal);
                
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteriaSLegal);                
                
                $supportsLegals = DebtorsSupports::model()->with('idTypeSupport0')->findAll($criteriaSLegal);
                
//              Managements  
                $criteriaManagement = new CDbCriteria();   
                $criteriaManagement->select = 't.*';
                $criteriaManagement->condition = 't.idDebtor ='.$debtor->id.' AND t.state = 1 AND t.date <= CURDATE()';
                $criteriaManagement->order = 't.date DESC,t.id DESC';
                
                $countManagement = ViewManagement::model()->count($criteriaManagement);
                
                $pagesManagement = new CPagination($countManagement);
                $pagesManagement->pageSize = $this->pSize;
                $pagesManagement->applyLimit($criteriaManagement);  
                
                $managements = ViewManagement::model()->findAll($criteriaManagement);                
                
//              Filter Managements                
                $criteriaManagement->select = 't.idTasksAction, t.management';
                $criteriaManagement->group = 't.idTasksAction'; 
                $actionsManagements = ViewManagement::model()->findAll($criteriaManagement);
                
//              Obligations  
                $criteriaObligations = new CDbCriteria();   
                $criteriaObligations->select = 't.*';
                $criteriaObligations->condition = 't.idDebtor ='.$debtor->idDebtor.' AND t.active = 1';
                $criteriaObligations->order = 't.duedate DESC';
                
                $countObligations = ViewDebtorsObligations::model()->count($criteriaObligations);
                
                $pagesObligations = new CPagination($countObligations);
                $pagesObligations->pageSize = $this->pSize;
                $pagesObligations->applyLimit($criteriaObligations);  
                                
                $obligations = ViewDebtorsObligations::model()->findAll($criteriaObligations);                 
                                
//              properties
                $criteriaProperties = new CDbCriteria();   
                $criteriaProperties->select = 't.*';
                $criteriaProperties->condition = 't.idDebtor =' . $debtor->idDebtor;
                $criteriaProperties->order = 't.id DESC';
                
                $countProperties = DebtorsProperty::model()->count($criteriaProperties);
                
                $pagesProperties = new CPagination($countProperties);
                $pagesProperties->pageSize = $this->pSize;
                $pagesProperties->applyLimit($criteriaProperties);  
                                
                $properties = DebtorsProperty::model()->findAll($criteriaProperties);   
                
//              percent demographics 
                $demographicsPorc = Controller::demographicsPercent($_GET['id']);
                $this->render(
                    'debtor_', array(
                    'debtor' => $debtor,
                    'debt' => $debt,
                    'demographicsPorc' => $demographicsPorc['percent'],
                    'debtDemographic' => $debtDemographic,
                    'othersValues' => $othersValues,
                    'debtorObli' => $debtorObli,
                    'task' => $task,
                    'obligations' => $obligations,
                    'pagesObligations' => $pagesObligations,
                    'status' => $status,
                    'countries' => $countries,
                    'actions' =>  $actions,
                    'payments' => $payments,
                    'agreements' => $agreements,
                    'spendings' => $spendings,
                    'supports' => $supports,                        
                    'supportsLegals' => $supportsLegals,                        
                    'pages' => $pages,                                             
                    'demographicPhones' => $demographicPhones,
                    'demographicReferences' => $demographicReferences,
                    'demographicEmail' => $demographicEmail,
                    'demographicAddresses' => $demographicAddresses,
                    'demographicCoSigners' => $demographicCoSigners,
                    'comments' => $comments,
                    'countManagement' => $countManagement,
                    'managements' => $managements,
                    'actionsManagements' => $actionsManagements,    
                    'pagesManagement' => $pagesManagement,                      
                    'countProperties' => $countProperties,
                    'properties' => $properties,
                    'pagesProperties' => $pagesProperties,  
                    'tree' => $tree,
                    'ageDebts' => $ageDebts,
                    'creditModalities' => $creditModalities, 
                    'historic' => $historic,
                    'genders' => $genders,
                    'occupations' => $occupations,
                    'maritalStates' => $maritalStates,
                    'typeSupports' =>  $typeSupports,
                    'typeLegalSupports' => $typeLegalSupports,
                    'officeLegals' => $officeLegals,
                    'educationLevels' => $educationLevels,
                    'ages' => $ages,
                    'typeHousings' => $typeHousings,
                    'typeContracts' => $typeContracts, 
                    'paymentStates' => $paymentStates,
                    'paymentClasses' => $paymentClasses,
                    'paymentPaidTos' => $paymentPaidTos,
                    'paymentTypeDiscriminations' => $paymentTypeDiscriminations,
                    'paymentMethods' => $paymentMethods,
                    'spendingTypes' => $spendingTypes,
                    'assetTypes' => $assetTypes,
                    'typeReferences' => $typeReferences,
                    'phoneClasses' => $phoneClasses,
                    'assets' => array(),
                        )
                );
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    
    
    //=============================================================================================
    
    
    public function actionSupportLegalPage() {
        $return = array('status' => 'error',
                'msg' => Yii::t('front', 'Solicitud Invalida'),
                'html' => '',
            );
                
        if(isset($_REQUEST['idDebtor']) && $_REQUEST['idDebtor'] != ''){

            $debtor = DebtorsDebts::model()->find(array('condition' => 'id = '.$_REQUEST['idDebtor']));
            $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;
            
            if($debtor != null){

                $condition = 'idTypeSupport0.type = 2 AND t.idDebtorDebt =' . $_REQUEST['idDebtor'];

                $criteriaSLegal = new CDbCriteria();   
                $criteriaSLegal->select = 't.*';


                if(isset($_REQUEST['idTypeSupport']) && $_REQUEST['idTypeSupport'] != ''){
                   $condition .= ($condition != '') ? ' AND ' : '';
                   $condition .= 't.idTypeSupport ='.$_REQUEST['idTypeSupport']; 
                }

                if (isset($_REQUEST['from']) && $_REQUEST['from'] != '') {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $to = (isset($_REQUEST['to']) && $_REQUEST['to'] != '') ? ' "' . $_REQUEST['to'] . '"' : ' CURDATE()';
                    $condition .= '(t.dateSupport BETWEEN "' . $_REQUEST['from'] . '"  AND' . $to . ')';
                }

                if(isset($_REQUEST['comments']) && $_REQUEST['comments'] != '' ){
                   $condition .= ($condition != '') ? ' AND ' : '';
                   $condition .= 't.comments LIKE "%'.$_REQUEST['comments'].'%"'; 
                }
                
                $criteriaSLegal->condition = $condition;
                $criteriaSLegal->order = 't.dateSupport DESC';
                
                $count = DebtorsSupports::model()->with('idTypeSupport0')->count($criteriaSLegal);
                
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteriaSLegal);
                                
                
                $supportsLegals = DebtorsSupports::model()->with('idTypeSupport0')->findAll($criteriaSLegal);
                
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    

                foreach ($supportsLegals as $supportsLegal) {
                   $return['table'] .= $this->renderPartial('/wallet/partials/item-support', array('model' => $supportsLegal), true);
                }               
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'supportLegal'), true);
                
            }
        }
        
        
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    
    public function actionManagementPage() {
        $return = array('status' => 'error',
                'msg' => Yii::t('front', 'Solicitud Invalida'),
                'html' => '',
            );
                
        if(isset($_POST['idDebtor']) && $_POST['idDebtor'] != ''){

            $debtor = DebtorsDebts::model()->find(array('condition' => 'id = '.$_POST['idDebtor']));
            $currentManagementPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
            
            if($debtor != null){

                $condition = 't.idDebtorDebt ='.$_POST['idDebtor'].' AND t.state = 1 AND t.date <= CURDATE()';

                $criteriaManagement = new CDbCriteria();   
                $criteriaManagement->select = 't.*';


                if(isset($_POST['idTasksAction']) && $_POST['idTasksAction'] != ''){
                   $condition .= ($condition != '') ? ' AND ' : '';
                   $condition .= 't.idTasksAction ='.$_POST['idTasksAction']; 
                }

                if (isset($_POST['from']) && $_POST['from'] != '') {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $to = (isset($_POST['to']) && $_POST['to'] != '') ? ' "' . $_POST['to'] . '"' : ' CURDATE()';
                    $condition .= '(t.date BETWEEN "' . $_POST['from'] . '"  AND' . $to . ')';
                }

                if(isset($_POST['comments']) && $_POST['comments'] != '' ){
                   $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.comments LIKE "%'.$_POST['comments'].'%"'; 
                }
                
                $criteriaManagement->condition = $condition;
                $criteriaManagement->order = 't.date DESC,t.id DESC';
                
                $countManagement = ViewManagement::model()->count($criteriaManagement);
                                
                $pagesManagement = new CPagination($countManagement);
                $pagesManagement->pageSize = $this->pSize;
                $pagesManagement->applyLimit($criteriaManagement);  
                
                $managements = ViewManagement::model()->findAll($criteriaManagement);
                
                $return = array('status' => 'success','table' =>'', 'pagination' => '');                    

                foreach ($managements as $management) {
                   $return['table'] .= $this->renderPartial('/wallet/partials/item-support-task', array('model' => $management), true);
                }               
                $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pagesManagement,'currentPage' => $currentManagementPage, 'id' => 'management-'.$debtor->id), true);
                
            
            }
        }
        
        
        echo CJSON::encode($return);
        Yii::app()->end();
    }
    
    //=============================================================================================
    
    
    public function actionObligationsPage() {
        $return = array('status' => 'error',
                'msg' => Yii::t('front', 'Solicitud Invalida'),
                'html' => '',
            );
        
        if(isset($_REQUEST['idDebtor']) && $_REQUEST['idDebtor'] != ''){
            $debtor = DebtorsDebts::model()->find(array('condition' => 'id = '.$_REQUEST['idDebtor']));
            $currentObligationPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;
            
            if($debtor != null){

                $condition = 'tddo.idDebtorDebt ='.$_REQUEST['idDebtor'];

                $criteriaObligations = new CDbCriteria();   
                $criteriaObligations->select = 't.*';


//                if(isset($_POST['idTasksAction']) && $_POST['idTasksAction'] != ''){
//                   $condition .= ($condition != '') ? ' AND ' : '';
//                   $condition .= 't.idTasksAction ='.$_POST['idTasksAction']; 
//                }

                if (isset($_REQUEST['from']) && $_REQUEST['from'] != '') {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $to = (isset($_REQUEST['to']) && $_REQUEST['to'] != '') ? ' "' . $_REQUEST['to'] . '"' : ' CURDATE()';
                    $condition .= '(t.duedate BETWEEN "' . $_REQUEST['from'] . '"  AND' . $to . ')';
                }

                if(isset($_REQUEST['credit_number']) && $_REQUEST['credit_number'] != '' ){
                   $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.credit_number LIKE "%'.$_REQUEST['credit_number'].'%"'; 
                }
                
                $criteriaObligations->condition = $condition;
                $criteriaObligations->join = 'JOIN tbl_debtors_debts_obligations tddo ON t.id = tddo.idDebtorObligation';
                $criteriaObligations->order = 't.duedate DESC';
                
                $countObligations = ViewDebtorsObligations::model()->count($criteriaObligations);
                                
                $pagesObligations = new CPagination($countObligations);
                $pagesObligations->pageSize = $this->pSize;
                $pagesObligations->applyLimit($criteriaObligations);  
                
                $obligations = ViewDebtorsObligations::model()->findAll($criteriaObligations);
                
                $return['status'] = 'success';

                $return['html'] = $this->renderPartial('/wallet/partials/content-debtor-obligations', array('debtor' => $debtor, 'obligations' => $obligations, 'pagesObligations' => $pagesObligations,'currentObligationPage' => $currentObligationPage), true);
            }
        }
        
        
        echo CJSON::encode($return);
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

    public function actionSaveTasks() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'html' => '', 'newRecord' => true);
                
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
            $model->idDebtor = NULL;
            
            if(($model->date != '' && ($model->date <= $today)) ){
                $model->setScenario('complete');
                if($model->idDebtorState == '') {
                   $model->idDebtorState = $model->idDebtorDebt0->idDebtorsState;
                }
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
//                    $model->idDebtorDebt0->setScenario('updateD');
                    $model->idDebtorDebt0->idDebtorsState =  $model->idDebtorState; 
                    $model->idDebtorDebt0->idDebtorSubstate = $model->idDebtorSubstate;
                    
                    if(!$model->idDebtorDebt0->save()){
                        $return['status'] = 'error';
                        $return['msg'] = 'Verifique los siguientes datos del deudor';
                        Yii::log("Error Agreement", "error", "actionSave");
                        foreach ($model->idDebtorDebt0->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
//                        print_r($return);
//                        exit;
                    } 
                }
                
                
                if($model->idDebtorState == 1){
                    $agreement = new DebtorsPayments();
                    $agreement->idDebtorDebt = $model->idDebtorDebt;
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
                $return['idDebtor'] = $model->idDebtorDebt;
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
    public function actionGetManagement() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '');
                
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest){                                    
            $model = DebtorsTasks::model()->findByPk($_REQUEST['id']);            
            if ($model != null) {
                if((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']) && $model->idUserAsigned == Yii::app()->user->getId()) ||  (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin'], Yii::app()->params['coordinators'])))){                    
                    $return['model'] = $model;
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'ok');
                }else{
                    $return['status'] = 'warning';
                    $return['msg'] = Yii::t('front', 'No tiene permisos para realizar esta acción.');                    
                }                                
            }else{
                    
                $return['msg'] .= Yii::t('front', 'No se econtraron registros');

            }
            
        }
        echo CJSON::encode($return);
    }
    //=============================================================================================
    
    public function actionGetReport() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '');
                
        if (isset($_REQUEST['idTypeReport'],$_REQUEST['idDebtorDebt']) && !Yii::app()->user->isGuest && ($_REQUEST['idTypeReport'] != '' && $_REQUEST['idDebtorDebt'] != '')){                                                
            $model = DebtorsDebtsReports::model()->find(array('condition' => 'idTypeReport ='.$_REQUEST['idTypeReport'].' AND idDebtorDebt ='.$_REQUEST['idDebtorDebt']));                        
            if ($model == null) {
                $model = new DebtorsDebtsReports;
                $model->setAttributes($_REQUEST);
            }            
            $return['status'] = 'success'; 
            $return['msg'] = 'ok'; 
            $return['model'] = $model;
        }
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionSaveReport() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);

        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {

            if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
                $model = DebtorsDebtsReports::model()->findByPk($_REQUEST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new DebtorsDebtsReports;
            }
            $model->setAttributes($_REQUEST);
            $model->idCreator = Yii::app()->user->getId();
            $model->support = (CUploadedFile::getInstanceByName('support') != '')? CUploadedFile::getInstanceByName('support') : $model->support;
            $model->date = ($model->date == '')? NULL : $model->date;
            
            if ($model->save()) {
                
                if(CUploadedFile::getInstanceByName('support') != ''){
                    $upload = Controller::uploadFile($model->support,'supports',$model->id,'/uploads/');
                    $model->support = ($upload)? $upload['filename']:  $model->support;   
                    if(!$model->save(false)){
                        print_r($model->getErrors());
                        exit;
                    }
                }                
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro guadrado exitosamente !.');
                $return['model'] = $model;
                $return['html'] = $this->renderPartial('/wallet/partials/item-report', array('typeReport' => $model->idTypeReport0, 'model' => $model, 'debtor' => $model->idDebtorDebt), true);
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
    
    public function actionSaveCall() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
                
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
            $model->idDebtor = NULL;
            
            if(!$return['newRecord'] && $model->support == null){
                $support = DebtorsTasksSupport::model()->find(array('condition' => 'idDebtorTask = '.$model->id));
                $model->support = ($support != null)? $support->support : null;
            }
                                    
            if ($model->save()) {
                
                if($model->idDebtorState != NULL){ 
//                    $model->idDebtorDebt0->setScenario('updateD');
                    
                    $model->idDebtorDebt0->idDebtorsState =  $model->idDebtorState; 
                    $model->idDebtorDebt0->idDebtorSubstate = $model->idDebtorSubstate;
                    
                    if(!$model->idDebtorDebt0->save()){
                        $return['status'] = 'error';
                        $return['msg'] = 'Verifique los siguientes datos del deudor';
                        Yii::log("Error Agreement", "error", "actionSave");
                        foreach ($model->idDebtorDebt0->getErrors() as $error) {
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
                $return['idDebtor'] = $model->idDebtorDebt0->id;
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
            $model->idDebtorObligation = NULL;
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
            $model->idDebtor = NULL;
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
                    if(!$model->save(false)){
                        print_r($model->getErrors());
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
            $model->idDebtor = NULL;

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
        $return = array('status' =>'error', 'msg' => Yii::t('front', 'Solicitud Invalida'));

        if (isset($_POST['id'], $_POST['idDebtorsState']) && !Yii::app()->user->isGuest){
                     
            if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['admin'],Yii::app()->params['advisers'],Yii::app()->params['customers']))){
                
                $criteria = new CDbCriteria();
                $condition = '';
        
                if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
       //            $criteria->join = ' JOIN tbl_campaigns c ON t.idCustomer = c.idCustomer  JOIN tbl_campaigns_debtors cb ON cb.idDebtor = t.idDebtor';
       //            $condition .= ($condition != '') ? ' AND ' : '';
       //            $condition .= ' c.idCoordinator = ';
       //            $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
               }

                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idDebtorsState NOT IN (6,7,11) AND t.is_legal = 1 AND t.id = '.$_POST['id'];
                $criteria->condition = $condition;
                
                $state = DebtorsState::model()->find(array('condition' => 'id ='.$_POST['idDebtorsState'].' AND active = 1'));                               
                $model = DebtorsDebts::model()->find($criteria);
                
                if(($model != null && $state != null)){
                    
//                    if($state->order >= $model->idDebtorsState0->order){
                        
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
//                    }else{
//                        $return['msg'] = Yii::t('front', 'No se puede realizar el cambio de estado');
//                    }                    
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
                
                $model = DebtorsDebts::model()->find($criteria);
                
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
    
    //=============================================================================================
    
    public function actionSmsDebtor() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'html' => '',
            'model' => '',
            );
                
        if (isset($_REQUEST) && !Yii::app()->user->isGuest){                        
            
            $sms = new SmsDebtor();
            $sms->setAttributes($_REQUEST);
            
            if($sms->validate()){
                //sms                 
                $debtor = ViewDebtors::model()->find(array('condition' => 't.id = '.$sms->idDebtor));
 
                if($debtor != null){
                    
                    $model = new DebtorsTasks();
                    $model->idDebtorDebt = $debtor->id;
                    $model->idDebtor = null;
                    $model->idDebtorState = $debtor->idState;
                    $model->idTasksAction = 19;
                    $model->idUserCreated = Yii::app()->user->getId();
                    $model->idUserAsigned = Yii::app()->user->getId();
                    $model->state = 1;
                    $model->date = date("Y-m-d");
                    $model->comments = 'Se envia SMS al número ' . $sms->number . ' con el siguiente mensaje : ' . $sms->message;

                    if ($model->save(false)) {                        
                        $sms = Controller::sendSMS($sms->number, $sms->message);
                        if ($sms['status'] == 'success') {                            
                            $return['status'] = $sms['status'];
                            $return['msg'] = Yii::t('front', 'Mensaje enviado exitosamente');
                            $management = ViewManagement::model()->find(array('condition' => 'id ='.$model->id));
                            $return['html'] = $this->renderPartial('/wallet/partials/item-support-task', array('model' => $management), true);
                        } else {
                            $model->delete();
                            $return['msg'] = 'Error, enviando SMS';
                        }
                    } else {
                        $return['msg'] = '';
                        foreach ($model->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }
                } else {
                    $return['msg'] = Yii::t('front', 'Deudor no encontrado');
                }
            }else{
                $return['msg'] = '';
                foreach ($sms->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }     
        }
        
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionEmailDebtor() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'html' => '',
            'model' => '',
            );
                
        if (isset($_REQUEST) && !Yii::app()->user->isGuest){                        
            
            $email = new EmailDebtor();
            $email->setAttributes($_REQUEST);
            
            if($email->validate()){
                //sms                 
                $debtor = ViewDebtors::model()->find(array('condition' => 't.id = '.$email->idDebtor));
 
                if($debtor != null){
                    
                    $model = new DebtorsTasks();
                    $model->idDebtorDebt = $debtor->id;
                    $model->idDebtor = null;
                    $model->idDebtorState = $debtor->idState;
                    $model->idTasksAction = 6;
                    $model->idUserCreated = Yii::app()->user->getId();
                    $model->idUserAsigned = Yii::app()->user->getId();
                    $model->state = 1;
                    $model->date = date("Y-m-d");
                    $model->comments = 'Se envia EMAIL al correo ' . $email->email . ' con el siguiente mensaje : ' . $email->message;
                    $htmlEmail = $this->renderPartial('/email/mail-message-debtor', array('name' => $debtor->name,'message' => $email->message), true);
                    if ($model->save(false)) {                        
                        $email = Controller::SendGridMail($email->email,$debtor->name, $email->subject, $htmlEmail);
                        if ($email) {                            
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'Mensaje enviado exitosamente');
                            $management = ViewManagement::model()->find(array('condition' => 'id ='.$model->id));
                            $return['html'] = $this->renderPartial('/wallet/partials/item-support-task', array('model' => $management), true);
                        } else {
                            $model->delete();
                            $return['msg'] = 'Error, enviando Email';
                        }
                    } else {
                        $return['msg'] = '';
                        foreach ($model->getErrors() as $error) {
                            $return['msg'] .= $error[0] . "<br/>";
                        }
                    }
                } else {
                    $return['msg'] = Yii::t('front', 'Deudor no encontrado');
                }
            }else{
                $return['msg'] = '';
                foreach ($email->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }     
        }
        
        echo CJSON::encode($return);
    }


}
