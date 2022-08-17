<?php

class NotificationsController extends Controller {

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
            $idQuery = array('-*idD*-');
            $criteria=new CDbCriteria();
            $criteria->condition = "idUser = ".Yii::app()->user->getId();
            $criteria->order = "dateCreated DESC";
            $count = UsersNotifications::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = $this->pSize;
            $pages->applyLimit($criteria);
            $model = UsersNotifications::model()->findAll($criteria);
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
                if($value->messages->idTypeNotification == 1){
                    if($value->idMessage == 7){
                        $value->url = "#";
                    }else{
                        $value->url = ($params['-*numbers*-'] > 1) ? Yii::app()->createUrl("/".$value->messages->typeNot->general_url) : Yii::app()->createUrl("/".$value->messages->typeNot->single_url."/".$params['-*idL*-']);
                    }         
                }
            }
            $this->render('notifications',array('model' => $model,'count' => $count, 'pages' => $pages));
            $userId = Yii::app()->user->getId();
            UsersNotifications::model()->updateAll(array( 'seen' => 1,
                      'idUser = '.$userId
            ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    public function actionUpdateNotification(){
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Inválida'),
            );
        if(isset($_POST['id']) && is_numeric($_POST['id'])){
            $id = $_POST['id'];
            $model = UsersNotifications::model()->findByPk($id);
            $model->seen = 1;
            if($model->save()){
                $return['status'] = "ok";
                $return['msg'] = "Actualizado";
            }
        }
        
        echo CJSON::encode($return);
    }
    
    public function actionTest(){
        
    }
}
