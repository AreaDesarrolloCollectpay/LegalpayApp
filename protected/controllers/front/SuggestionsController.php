<?php

class SuggestionsController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public $access;
    public $pSize;
    
    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->theeFront; //set theme default front
        $this->layout = 'layout_secure';
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        $this->access = array(1,2,3,5,6,7,8,9,10,11);
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
                
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
            
            if($user != null){
                $filters = array('idProfile', 'name', 'comments');            
                $criteria = new CDbCriteria();
                $join = ' LEFT JOIN view_users vu ON t.idCreator = vu.id';
                $condition = '';
                
                if (isset($_REQUEST)) {
                    $i = 0;
                    foreach ($_REQUEST as $key => $value) {

                        if (($key != 'page' && $key != 'q') && $value != '' && in_array($key, $filters)) {
                            $condition .= ($i == 0) ? '( ' : '';
                            $condition .= ($i > 0) ? ' AND ' : '';
                            $condition .= (($key == 'idProfile' || $key == 'name' ))? 'vu' : 't';
                            $condition .= '.'.$key;
                           $condition .= (($key != 'idProfile' && $key != 'idState' ))? ' LIKE "%'.$value.'%"' : ' = '.$value;  
                            $i++;
                        }
                    }

                    $condition .= ($condition != '') ? ')' : '';
                }
                               
                if(isset($_REQUEST['date']) && $_REQUEST['date'] != ''){
                    $date = Controller::CleanFilterDate($_REQUEST['date']);
                    if((int)$date['count'] > 1){                        
                        $condition .= 't.date BETWEEN "'.$date['date'][0].'"  AND "'.$date['date'][1].'"' ;    
                    }else{  
                        $condition .= 't.date = "'.$date['date'][0].'"' ;                     
                    }  
                }

                if (!(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['admin']))) {
                        $condition .= ($condition != '') ? ' AND ' : '';
                        $condition .= 't.idCreator = ' . Yii::app()->user->getId(); 
                }
                
                $criteria->select = 't.*, vu.profile as profile, vu.name as name';
                $criteria->condition = $condition;
                $criteria->join = $join;
                $criteria->order = "t.id DESC";
                                
                $count = Suggestions::model()->count($criteria);  
                
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = Suggestions::model()->findAll($criteria);
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ;  
                
                $profiles = UsersProfile::model()->findAll(array('condition' => 't.active = 1', 'order' => 'name ASC'));

                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']){                    
                    $return = array('status' => 'success','table' =>'', 'pagination' => '');                    
                    $return['table'] = $this->renderPartial('/suggestions/partials/content-suggestions-table', array('model' => $model), true);
                    $return['pagination'] = $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'customers'), true);
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }else{
                    $this->render('suggestions',array(
                        'model' => $model,
                        'pages' => $pages,
                        'currentPage' => $currentPage,
                        'profiles' => $profiles,
                            ));
                }
            }            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }    
    //=============================================================================================
    public function actionUpdateSuggestions() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            if (isset($_REQUEST)) {
                $model = new Suggestions; 
                $model->setAttributes($_REQUEST);
                $model->support = (CUploadedFile::getInstanceByName('support') != '')? CUploadedFile::getInstanceByName('support') : $model->support;
                $model->idCreator =  Yii::app()->user->getId();
                        
                if ($model->save()) { 
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Tu sugerencia ha sido registrada con éxito, Gracias!.');
                    $return['model'] = $model;
                    
                    if(CUploadedFile::getInstanceByName('support_bank') != ''){
                        $upload = Controller::uploadFile($model->support,'suggestions',$model->id,'/uploads/');
                        $model->support = ($upload)? $upload['filename']:  $model->support;   
                        if(!$model->save(false)){
                            print_r($model->getErrors());
                            exit;
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
}
