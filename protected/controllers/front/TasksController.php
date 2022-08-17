<?php

class TasksController extends Controller {
    
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
        $return = array('html' => '','status'=>'');
        $pro = '';
        if (!Yii::app()->user->isGuest) {
            
            $criteria = new CDbCriteria(); 
            $join  = ' JOIN view_users vu ON t.idUserAsigned = vu.id';
            $condition = '';
            
            $t = array('idUserAsigned', 'numberDocument', 'name', 'idTasksAction');
            $vu = array('idProfile');
            
            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {
                    if ($value != '' && in_array($key, array_merge($t,$vu))) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        if(in_array($key, $t)){                            
                            $condition .= 't.';
                        }else{
                            $condition .= 'vu.';                            
                        }
                        $condition .= $key;
                        $condition .= (($key != 'idUserAsigned' && $key != 'idProfile' && $key != 'idTasksAction')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }
             
            if(isset($_REQUEST['type'])){
                if($_REQUEST['type'] != ''){                    
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $operator = ($_REQUEST['type'] == 1)? '=' : (($_REQUEST['type'] == 2)? '<' : '>');                                 
                    $condition .= 't.date '.$operator.' CURDATE()';                
                }
            }
                        
            if(!(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'],Yii::app()->params['advisorBusiness'])))){    
                if((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'])))){
                    $pro = implode(',', Yii::app()->params['coordinators']);
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= '(vu.id = '.Yii::app()->user->getId().'  OR vu.idCoordinator = '.Yii::app()->user->getId().')'; 
                }elseif(Yii::app()->user->getState('rol') == 1){
                    $pro = implode(',',array_merge(Yii::app()->params['advisers'], Yii::app()->params['coordinators'], Yii::app()->params['advisorBusiness']));                                
                }
            }else{
               $condition .= ($condition != '') ? ' AND ' : '';
               $condition .= 'vu.id = '.Yii::app()->user->getId();  
//                if(Yii::app()->user->getId() == 635){
//                    print_r($condition);
//                    exit;
//
//                }
            }
           
            $criteria->condition = $condition;                
            $criteria->join = $join;                
            $count = ViewTasks::model()->count($criteria);
            $criteria->order = 't.date ASC';
            
            $pages = new CPagination($count);
            $pages->pageSize = $this->pSize;
            $pages->applyLimit($criteria);          

            $model = ViewTasks::model()->findAll($criteria);
            
            $profiles = ($pro != '')? UsersProfile::model()->findAll(array('condition' => 't.id IN ('.$pro.')', 'order' => 'name ASC')) : array();
                        
            $page = (isset($_REQUEST['page']))? $_REQUEST['page'] : 1;
            
            $actions = TasksActions::model()->findAll(array('condition' => 't.active = 1 AND t.idTasksAction IS NULL', 'order' => 't.name ASC'));
            
            if(Yii::app()->request->isAjaxRequest){
                $return['page'] = $page + 1;                 
                $return['status'] = "success";
                $i = 1;
                foreach($model as $value){
                    $return['html'] .= $this->renderPartial('/tasks/partials/item-tasks', array('model' => $value, 'i' => $i),true);    
                    if($i == 3){
                        $i = 1;
                    }else{
                        $i++;
                    }
                }
                $return['more'] = ($count > ($page * $this->pSize))? true : false;
                $return['msg'] = ($model != null) ? "":Yii::t("front","No existen más registros");
                echo CJSON::encode($return);
            }else{
                $this->render('tasks',array(
                    'profile' => array(),
                    'profiles' => $profiles,
                    'actions' => $actions,
                    'model' => $model,
                    'page' => $page, 
                    'url' => '',
                    'count' => $count
                    
                ));    
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    //=============================================================================================
    public function actionGetCalendar() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' =>'');
        if (!Yii::app()->user->isGuest) {
            
            $criteria = new CDbCriteria(); 
            $join  = ' JOIN view_users vu ON t.idUserAsigned = vu.id';
            $condition = '';
            
            $t = array('idUserAsigned', 'numberDocument', 'name', 'idTasksAction');
            $vu = array('idProfile');
            
            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {

                    if ($value != '' && in_array($key, array_merge($t,$vu))) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        if(in_array($key, $t)){                            
                            $condition .= 't.';
                        }else{
                            $condition .= 'vu.';                            
                        }
                        $condition .= $key;
                        $condition .= (($key != 'idUserAsigned' && $key != 'idProfile' && $key != 'idTasksAction')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }
             
            if(isset($_REQUEST['type'])){
                if($_REQUEST['type'] != ''){                    
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $operator = ($_REQUEST['type'] == 1)? '=' : (($_REQUEST['type'] == 2)? '<' : '>');                                 
                    $condition .= 't.date '.$operator.' CURDATE()';                
                }
            }
                        
            if(!(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'])))){    
                if((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'])))){
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= '(vu.id = '.Yii::app()->user->getId().'  OR vu.idCoordinator = '.Yii::app()->user->getId().')'; 
                }
            }else{
               $condition .= ($condition != '') ? ' AND ' : '';
               $condition .= 'vu.id = '.Yii::app()->user->getId();  
            }
           
            $criteria->select = 'CONCAT(COUNT(t.id)," ","'.Yii::t('front', 'Tarea(s)').'") as name,t.date';
            $criteria->condition = $condition;                
            $criteria->join = $join;
            $criteria->group = 't.date';
            
            $model = ViewTasks::model()->findAll($criteria);
               
            $data = array_map(function($m) {return array("title" => $m->name, "start"=> $m->date);}, $model); 
            $return['status'] = 'success';
            $return['msg'] = 'ok';
            $return['data'] = $data;
            
        }
        
        echo CJSON::encode($return);
    }
    //=============================================================================================
     public function actionGetModalTask() {
        $return = array('html' => '','status'=>'','title' => '', 'msg' => '');
        $pro = '';
        if (!Yii::app()->user->isGuest) {
            
            $criteria = new CDbCriteria(); 
            $join  = ' JOIN view_users vu ON t.idUserAsigned = vu.id';
            $condition = '';
            
            $t = array('idUserAsigned', 'numberDocument', 'name', 'idTasksAction');
            $vu = array('idProfile');
            
            if (isset($_REQUEST)) {
                $i = 0;
                foreach ($_REQUEST as $key => $value) {
                    if ($value != '' && in_array($key, array_merge($t,$vu))) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        if(in_array($key, $t)){                            
                            $condition .= 't.';
                        }else{
                            $condition .= 'vu.';                            
                        }
                        $condition .= $key;
                        $condition .= (($key != 'idUserAsigned' && $key != 'idProfile' && $key != 'idTasksAction')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }
                $condition .= ($condition != '') ? ')' : '';
            }
             
            if(isset($_REQUEST['type'])){
                if($_REQUEST['type'] != ''){                    
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $operator = ($_REQUEST['type'] == 1)? '=' : (($_REQUEST['type'] == 2)? '<' : '>');                                 
                    $condition .= 't.date '.$operator.' CURDATE()';                
                }
            }
            
            if(isset($_REQUEST['date'])){
                if($_REQUEST['date'] != ''){                    
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $operator = '=';                                 
                    $condition .= 't.date '.$operator.' "'.$_REQUEST['date'].'" ';                
                }
            }
                        
            if(!(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers'])))){    
                if((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'])))){
                    $pro = implode(',', Yii::app()->params['coordinators']);
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= '(vu.id = '.Yii::app()->user->getId().'  OR vu.idCoordinator = '.Yii::app()->user->getId().')'; 
                }elseif(Yii::app()->user->getState('rol') == 1){
                    $pro = implode(',',array_merge(Yii::app()->params['advisers'], Yii::app()->params['coordinators'], Yii::app()->params['advisorBusiness']));                                
                }
            }else{
               $condition .= ($condition != '') ? ' AND ' : '';
               $condition .= 'vu.id = '.Yii::app()->user->getId();  
            }
           
            $criteria->condition = $condition;                
            $criteria->join = $join;                
            $count = ViewTasks::model()->count($criteria);
            
            $criteria->order = 't.date ASC';
            $model = ViewTasks::model()->findAll($criteria);
            $date = (isset($_REQUEST['date']))? date("Y-m-d", strtotime($_REQUEST['date'])) : '';            
            $return['title'] = Yii::t('front', 'TAREAS').' ('.$count.') - '.$date;
            
            $i = 1;
                foreach($model as $value){
                    $return['html'] .= $this->renderPartial('/tasks/partials/item-tasks', array('model' => $value, 'i' => $i),true);    
                    if($i == 3){
                        $i = 1;
                    }else{
                        $i++;
                    }
                }
            $return['msg'] = 'ok';
            $return['status'] = 'success';
        }
        echo CJSON::encode($return);
    }
    //=============================================================================================
    public function actionPushTaks() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'data' =>'');
        if (!Yii::app()->user->isGuest) {
            
            $criteria = new CDbCriteria(); 
            $join  = ' JOIN view_users vu ON t.idUserAsigned = vu.id';
            //$condition = 't.idUserAsigned = '.Yii::app()->user->getId().' AND t.date < CURDATE() ';
            $condition = 't.idUserAsigned = '.Yii::app()->user->getId().' AND t.date < CURDATE() ';
                        
            $criteria->select = 'vu.name as actionName, CONCAT(COUNT(t.id)," ","'.Yii::t('front', 'Tarea(s)').'") as name, t.date';
            $criteria->condition = $condition;                
            $criteria->join = $join;
            $criteria->group = 't.idUserAsigned';
            
            $model = ViewTasks::model()->find($criteria);
            if($model != null){
                $return['status'] = 'success';
                $return['msg'] = 'ok';                
                $return['data'] = array('title' => $model->actionName.'!',
                    'msg' => Yii::t('front','Tienes').' '.$model->name.' '.Yii::t('front','Pendiente(s)'),
                    'img' => Yii::app()->theme->baseUrl.'/assets/img/icons/icon_alert_push.png',                      
                    'url' => Yii::app()->baseUrl.'/tasks');     
            }
            
        }
        
        echo CJSON::encode($return);
    }
    //=============================================================================================
    public function actionGetUsers(){
        $return = array(
            'html' => '',
            'status'=>'error'
        );
        if(isset($_POST['id']) && $_POST['id'] != "" && is_numeric($_POST['id'])){
            $profile = $_POST['id'];
            $criteria = new CDbCriteria();
            $join = ""; 
            $condition = "";
            
            if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCoordinator ='.Yii::app()->user->getId()." AND ";
            }
            
            $condition .= "t.idProfile = ".$profile." AND t.active = 1";
            $criteria->join = $join;
            $criteria->condition = $condition;
            /*print_r($criteria);
            exit;*/
            $users = ViewUsers::model()->findAll($criteria);
            $return['html'] .= '<option value="" selected>Seleccione</option>';
            foreach($users as $user){
                $return['html'] .= '<option value="'.$user->id.'">'.$user->name.'</option>';
            }
            $return['status'] = "success";
        }
        echo CJSON::encode($return);
    }

}
