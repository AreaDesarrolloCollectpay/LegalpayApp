<?php

class AnalyticsController extends Controller {

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
        $this->access = array(1,2,11);
        $this->pSize = 1;
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
                                
                $criteria = new CDbCriteria();
                //$join = '';
                //$condition = '';
                
                $criteria->condition = 'id < 4 ';
                $criteria->order = "dateCreated DESC";
                
                $count = Mlmodels::model()->count($criteria);
                                
                $pages = new CPagination($count);

                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = Mlmodels::model()->findAll($criteria);
                
                $currentPage = (isset($_REQUEST['page']) && $_REQUEST['page'] != '')? $_REQUEST['page'] : 0 ; 
        
                $this->render('mlmodels', array('model' => $model, 'count' => $count, 'pages' => $pages,'currentPage' => $currentPage,));
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionSaveMlModels() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '', 'html' => '', 'newRecord' => true);

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $model = Mlmodels::model()->findByPk($_POST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new Mlmodels();
            }
            $model->setAttributes($_POST);

            if ($model->save()) {
                $return['status'] = 'success';
                $return['msg'] = Yii::t('front', 'Registro ingresado exitosamente !.');
                $return['model'] = $model;                 
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
    public function actionGetMlModels() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '');
        
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (isset($_POST['id']) && $_POST['id'] != '') {

                $model = Mlmodels::model()->findByPk($_POST['id']);
                
                if($model != null){
                    $return['status'] = 'success';
                    $return['model'] = $model;                         
                }else{
                    $return['msg'] = Yii::t('front', 'Error Modelo no encontrado !. ');                    
                }
            }
        } else {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Sesión Finalizada');
        }
        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionClusters() {
        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access) && (isset($_GET['id']) && $_GET['id'] != '')) {
            $models = Mlmodels::model()->findByPk($_GET['id']);
            
            if($models != NULL){              
                $criteria = new CDbCriteria();
                $condition = '';            
               $filters = array('customer', 'name', 'code', 'city', 'capital', 'interest','totalDebt' , 'fee', 'payments', 'balance', 'idState','agreement', 'idTypeDocument','idCreditModality');
                                
                if (isset($_GET)) {
                    $i = 0;
                    foreach ($_GET as $key => $value) {

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
                
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition = 't.idMLModel = '.$_GET['id'];
                
                $criteria->condition = $condition;
                $criteria->order = "dateCreated DESC";
                $count = Clusters::model()->count($criteria);           
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);
                $model = Clusters::model()->findAll($criteria);
                
                $this->render('clusters',array(
                    'model' => $model,
                    'pages' => $pages,
                ));        
                
            }else{
                throw new CHttpException(404,'La solicitud es inválida, archivo no encontrado');
            }          
            
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
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
