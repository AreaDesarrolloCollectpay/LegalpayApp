<?php

class PropertiesController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public $access;
    public $adviser;
    
    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->theeFront; //set theme default front
        $this->layout = 'layout_secure';
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        $this->access = array(1,2,3,5);
        $this->adviser = array(3,6);
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
    public function actionMovables() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)){
          
             $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            if ($user != null) {
                
                $filters = array('customer', 'coordinator', 'city', 'code', 'property', 'comments');
                $criteria = new CDbCriteria();
                $condition = '';                
                $stateCondition = '*.historic = 0 AND *.idDebtorsState IS NULL';
                $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND '.str_replace('*', 'tds', $stateCondition);

                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

                        if (($key != 'page') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .=  ' LIKE "%'.$value.'%"';  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
                    $join = ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = ';
                    $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
                }
                
                $condition .= ($condition != '')? ' AND ' : '';
                $condition .= 't.idPropertyType = 1';
                
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "t.capital DESC";
               
                
                $count = ViewProperties::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = 20;
                $pages->applyLimit($criteria);

                $criteria->group = 't.id';
                $model = ViewProperties::model()->findAll($criteria);
                
                $this->render('movables',array(
                    'model' => $model,
                    'pages' => $pages,
                        ));                
             } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }  
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }    
    //=============================================================================================
    public function actionInmovables() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)){
          
              $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            if ($user != null) {
                
                $filters = array('customer', 'coordinator', 'city', 'code', 'property', 'comments');
                $criteria = new CDbCriteria();
                $condition = '';
                $stateCondition = '*.historic = 0 AND *.idDebtorsState IS NULL';
                $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND '.str_replace('*', 'tds', $stateCondition);

                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

                        if (($key != 'page') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .=  ' LIKE "%'.$value.'%"';  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
                    $join = ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = ';
                    $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
                }
                
                $condition .= ($condition != '')? ' AND ' : '';
                $condition .= 't.idPropertyType = 2';
                
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "t.capital DESC";
                
                
                $count = ViewProperties::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = 20;
                $pages->applyLimit($criteria);
                
                $criteria->group = 't.id';
                $model = ViewProperties::model()->findAll($criteria);
                
                $this->render('inmovables',array(
                    'model' => $model,
                    'pages' => $pages,
                        )); 
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }  
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }    
    //=============================================================================================
    public function actionOthers() {
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)){
          
              $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
            if ($user != null) {
                
                $filters = array('customer', 'coordinator', 'city', 'code', 'property', 'comments');
                $criteria = new CDbCriteria();
                $condition = '';
                $stateCondition = '*.historic = 0 AND *.idDebtorsState IS NULL';
                $join = ' JOIN tbl_debtors_state tds ON t.idState = tds.id AND '.str_replace('*', 'tds', $stateCondition);

                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

                        if (($key != 'page') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= 't.' . $key;
                            $condition .=  ' LIKE "%'.$value.'%"';  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                
                if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
                    $join = ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = ';
                    $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
                }
                
                $condition .= ($condition != '')? ' AND ' : '';
                $condition .= '(t.idPropertyType = 3 OR t.idPropertyType IS NULL)';
                
                
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "t.id DESC";
                
                $count = ViewProperties::model()->count($criteria);           

                $pages = new CPagination($count);

                $pages->pageSize = 20;
                $pages->applyLimit($criteria);

                $criteria->group = 't.id';
                $model = ViewProperties::model()->findAll($criteria);
                
                $this->render('others',array(
                    'model' => $model,
                    'pages' => $pages,
                        ));   
            } else {
                throw new CHttpException(404, Yii::t('front', 'La solicitud es inválida, archivo no encontrado'));
            }  
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }    
    
}
