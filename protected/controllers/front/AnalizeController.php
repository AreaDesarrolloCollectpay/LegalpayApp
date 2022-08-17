<?php

class AnalizeController extends Controller {

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
    
     public function actionSaveMlCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'model' => '','file' => '');
        $root = Yii::getPathOfAlias('webroot');
        if (isset($_REQUEST) && !Yii::app()->user->isGuest) {            
            $user = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));            
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
                $model = Centroids::model()->findByPk($_REQUEST['id']);
                $return['newRecord'] = false;
            } else {
                $model = new Centroids;
            }            
            $model->setAttributes($_REQUEST);
            $model->idCreator = Yii::app()->user->getId();
            
            if ($model->save()) {
            
                $sql = MachineController::getQuerySource($model->idMLModel0,$model,0);
                                
                if ($sql['status'] == 'success') {

                    set_time_limit(0);
                    $connection = Yii::app()->db;
                    $transaction = $connection->beginTransaction();

                    try {                        
                        $connection->createCommand($sql['query'])->execute();
                        //.... other SQL executions
                        $transaction->commit();

                        if (file_exists($root.$sql['file'])) {
                            $return['status'] = 'success';
                            $return['msg'] = Yii::t('front', 'CREANDO MODELO ...');
                            $return['model'] = $model;
                            $return['file'] = $sql['file'];
                            $model->file = $sql['file']; 
                            $model->save(false);
                        }else{
                            $return['status'] = 'error';
                            $return['msg'] = Yii::t('front', 'Error, archivo no encontrado'); 
                            $model->delete();                            
                        }
                    } catch (Exception $e) { // an exception is raised if a query fails
                        $transaction->rollback();
                        $return['msg'] = $e->getMessage();
                        $model->delete();
                    }
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = Yii::t('front', 'Error, exportando data'); 
                    $model->delete();
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }               
            }
        }        
        echo CJSON::encode($return);        
    }
   
    //=============================================================================================
    
     public function actionCreateSource() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'file' => '', 'source' => '', 'dataset' => '', 'prediction' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Centroids::model()->findByPk($_REQUEST['id']);      
            
            if ($model != null){  
                $slug = @Controller::slugUrl('source_cluster_'.$model->id.'_analize');
                $return = Controller::createSource($model->file,$slug);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'GENERANDO FUENTE DE DATOS ...');
                    //updateModel
                    $model->source = $return['source'];
                    $model->save(false);
                }
            } else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }

        echo CJSON::encode($return);
    }
        
    //=============================================================================================
    
    public function actionGetSource() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Centroids::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){    
                $return = Controller::getSource($model->source);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'OBTENIENDO FUENTE DE DATOS ...');               
                }
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
            
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    public function actionCreateDataset() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Centroids::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){   
                $slug = @Controller::slugUrl('dataset_cluster_'.$model->id.'_analize');
                $return = Controller::createDataset($model->source,$slug);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'GENERANDO CONJUNTO DE DATOS ...');
                        //updateModel
                    $model->dataset = $return['dataset'];
                    $model->save(false);
    //                    $return = Controller::createBatchPrediction();
                }
           }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
           }

        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetDataset() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {
            $model = Centroids::model()->findByPk($_REQUEST['id']); 
            if ($model != null){  
                $return = Controller::getDataset($model->source,$model->dataset);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', ' OBTENIENDO CONJUNTO DE DATOS ...');            
                }
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }

        echo CJSON::encode($return);
    }
   
    //=============================================================================================
    public function actionCreateBatchCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'),'model' => '', 'source' => '', 'dataset' => '', 'cluster' => '', 'clusters' => '', 'file' => '');
         
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Centroids::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){   
                $slug = @Controller::slugUrl('batch_centroid_'.$model->id.'_analize');
                $return = Controller::createBatchCentroid($model->source,$model->dataset,$model->idMLModel0->cluster,$slug);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', 'GENERANDO ANÁLISIS ...');
                    //updateModel
                    $model->batchCentroide = $return['batch'];
                    $model->save(false);
                }
           }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
           }

        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    public function actionGetBatchCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'cluster' => '', 'batch' => '', 'file' => '');
         
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Centroids::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){  
                $return = Controller::getBatchCentroid($model->batchCentroide);
                $return['model'] = $model;
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                    $return['msg'] = Yii::t('front', ' OBTENIENDO ANÁLISIS ...'); 
                    if($return['status'] == 'success'){
                        $model->batchCentroide = $return['batch'];                    
                        $model->save(false);                                               
                    }
                }
            }else {
                $return['status'] = 'error';
                $return['msg'] = Yii::t('front', 'Error, modelo no encontrado');
            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
     public function actionDownloadBatchCentroid() {
        $return = array('status' => 'error', 'msg' => Yii::t('front', 'Solicitud Invalida'), 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '','percent' => 0,'series' => '','model' =>'');
        
        if (isset($_REQUEST['id']) && !Yii::app()->user->isGuest) {

            $model = Centroids::model()->findByPk($_REQUEST['id']);            
            
            if ($model != null){ 
            
                $return = Controller::downloadBatchCentroid($model->source,$model->dataset,$model->batchCentroide);
            
                if($return['status'] == 'success' || $return['status'] == 'waiting'){ 
                                //updateModel
    //                    $return = Controller::createBatchPrediction();
                    if($return['status'] == 'success'){

                        $location = $return['file']; 

                        if(file_exists($location)){

                            $caracterSeparator = $this->getFileDelimiter($location);
                            $lot = Date('d_m_Y_h_i_s');
                            $condition = "idMLModel = '".$model->id."', lot = '".$lot."', migrate = 0";

                            $sql = "LOAD DATA INFILE '" . $location . "'
                            INTO TABLE `tbl_tempo_centroid`
                            CHARACTER SET latin1
                            FIELDS
                                TERMINATED BY '" . $caracterSeparator . "'
                                ENCLOSED BY '\"'
                            LINES
                                TERMINATED BY '\\n'
                             IGNORE 1 LINES 
                             (idDebtorObligation,cluster)
                             SET ".$condition;

                                $connection = Yii::app()->db;
                                $transaction = $connection->beginTransaction();
                                try {
                                    $connection->createCommand($sql)->execute();
                                    $transaction->commit();
                                    
                                    $criteria = new CDbCriteria;
                                    $criteria->condition = 'idMLModel = "'.$model->id.'" AND lot = "' . $lot. '" AND migrate = 0 ';
                
                                    if(TempoCentroid::model()->updateAll(array("migrate" => 1), $criteria)){ 
                                        $return['status'] = 'success';
                                        $return['msg'] = Yii::t('front', 'ANÁLISIS FINALIZADO!.');
                                        $return['model'] = $model;
                                    }else{
                                        $return['status'] = 'error';
                                        $return['msg'] = Yii::t('front', 'MIGRANDO ANÁSLISIS!.');                                        
                                    }
                                } catch (Exception $e) {
                                    $return['status'] = 'warning';
                                    $return['msg'] = Yii::t('front', 'Error, cargando archivo');
                                    $return['msg'] .= ' '.$e;
                                }

                            if (file_exists($location)) {
                                unlink($location);
                            }
                        }
                    }
                }
            }
        }
        echo CJSON::encode($return); 
    }
    
    //=============================================================================================
        
    public function actionTest(){
                
        //$this->render('test', array());
           
        require_once 'protected/extensions/bigml/Machinebigml.php';   

        $api = new BigML\BigML(["username" => "desarrollo",
                   "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                   "project" => "project/5cb08b756997fa1812000772"
               ]);
        
//        $batch = $api->get_batchcentroid('batchcentroid/5d4d8e2342129f7dff00002a');
//        print_r($batch);
//        exit;
//        $batch_centroid = $api->create_batch_centroid('cluster/5d432e7ae476847bb40065a4',
//                                                  'dataset/5d4313a25299637de00063d6',
//                                                  array("name"=>"my_batch_centroid_test",
//                                                        "all_fields"=> true,
//                                                        "header"=> true));
//        
//        print_r($batch_centroid);
//        exit;
//        
//        $model = Mlmodels::model()->findByPk(2); 
//        $input_fields = array();
//        if($model != null){
//            $fields = json_decode($model->fields); 
//            foreach ($fields as $field){
//                $fModel = MlmodelsFields::model()->findByPk($field);                    
//                if($fModel != null){ 
//                    $input_fields[] = $fModel->name_export;
//                }
//            }            
//        }
//         $cluster = $api->create_cluster(
//                        'dataset/5d4313a25299637de00063d6', 
//                        array("name"=> "cluster".Date('d_m_Y_h_i_s'), 
//                                 "excluded_fields" => array('idDebtorObligation','portfolioName'),
//                        ));
//         
//         print_r($cluster);
//         exit;
        
               
//
        $cluster = $api->get_cluster('cluster/5d2cf2ce7811dd68a2000984'); 
        print_r($cluster->object->rows);
        exit;
        $fields = array();
        foreach ($cluster->object->clusters->fields as $key => $value) {
            $condition = 'name_export LIKE "%'.$value->name.'%"';
            $field = MlmodelsFields::model()->find(array('condition' => $condition));

            if($field != NULL){
                $fields[$key] = array('name' => $value->name,'missing_count' => $value->summary->missing_count);
            }else{
                echo $condition.'-- no';
                echo '<br>';                
            }

        }
        
        echo json_encode($fields);
        exit;
//        
//        
//        $fields = array();
//        foreach ($cluster->object->clusters->fields as $key => $value){
//            
//            $fields[$key] = array('name' => $value->name);
//            //echo $key.' - '.$value->name;
//            print_r($value);
//            //echo '<br>';
//            //echo $value->name.'<br>';
//            break;
//        }
        
        //print_r($fields);
        
//        exit;
//        echo 'sss';
//        print_r($cluster->object->clusters->clusters);
        
//        foreach($cluster->object->clusters->clusters as $value){
            
            //echo $value->name.'<br>';
//            $name = explode(' ', $value->name);
//            echo $name[1].'<br>';
//            print_r($value);
//            echo '<br>';
//            //id, name ,json_encode( value)
//            break;
//            
//        }
//        exit;
//            
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
