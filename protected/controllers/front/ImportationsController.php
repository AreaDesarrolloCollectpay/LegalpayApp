<?php
class ImportationsController extends Controller {
    
    public $access;
    
    public function init(){
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        $this->access = array(1,2,5,7);
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
    
    public function actionSaveDemographic($location, $caracterSeparator, $model, $date){
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = array();
        
        $condition = "lot = '" . $date . "', idCustomer = " . $model->idCustomer . ", migrate = 0";
        $sql = "LOAD DATA INFILE '" . $location . "'
        INTO TABLE `tbl_tempo_demographic`
        CHARACTER SET latin1
        FIELDS
            TERMINATED BY '" . $caracterSeparator . "'
            ENCLOSED BY '\"'
        LINES
            TERMINATED BY '\\n'
         IGNORE 1 LINES 
         (name,
         number,
         email,
         country,
         department,
         city,
         address,
         neighborhood,
         phone,
         mobile,
         occupation,
         marital_state,
         income_legal,
         age,
         labor_old,
         gender,
         social_stratus,
         type_contract,
         education_level,
         type_housing,
         contract_term,
         dependents,
         payment_capacity)
         SET ".$condition."
         ";

        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql)->execute();
            $transaction->commit();
            $count = TempoDemographic::model()->count(array('condition' => str_replace(',', ' AND ', $condition)));                        
            $criteria = new CDbCriteria;
            $criteria->select = "COUNT(*) AS count";   
            $criteria->join = "JOIN tbl_debtors td ON t.number = td.code"; 
            $criteria->condition = "td.idCustomers = ".$model->idCustomer." AND t.lot = '" . $date . "'";
            $criteria->group = "td.code";
            $matches = TempoDemographic::model()->count($criteria);
            if($count > 0){
                $model->accounts = $count;
                $model->capital = $matches;
                if(!$model->save(false)){
                    $return['msg'] = '';
                    Yii::log("Error Actualizaciones", "error", "actionImport");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                    $model->delete();
                }else{
                    $this->deleteFile($location);
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Cargue exitoso!.');  
                    $return['model']['lot'] = $date;
                    $return['model']['idCustomer'] = $model->idCustomer;
                    $return['model']['typeImport'] = 1;
                    $return['model']['count'] = $count;
                    $return['model']['total'] = $matches;                                                        
                    //$return['model']['total'] = Yii::app()->format->formatNumber($total);                                                                
                }
            }else{
                $return['msg'] = Yii::t('front', 'Error, Importando data, por favor validar archivo');                                
            }

        } catch (Exception $e) {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Error, cargando archivo');
            $return['msg'] .= ' '.$e;
        }
        
        return $return;
    }
    
    public function actionSaveManagements($location, $caracterSeparator, $model, $date){
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = array();
        
        $condition = "lot = '" . $date . "', idCustomer = " . $model->idCustomer .", userCreated = " . Yii::app()->user->getId() .", migrate = 0";
        $sql = "LOAD DATA INFILE '" . $location . "'
        INTO TABLE `tbl_tempo_managements`
        CHARACTER SET latin1
        FIELDS
            TERMINATED BY '" . $caracterSeparator . "'
            ENCLOSED BY '\"'
        LINES
            TERMINATED BY '\\n'
         IGNORE 1 LINES 
         (number,
         action,
         state,
         is_contact,
         userAsigned,
         comment)
         SET ".$condition."
         ";

        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql)->execute();
            $transaction->commit();
            $count = TempoManagements::model()->count(array('condition' => str_replace(',', ' AND ', $condition)));                        
            $criteria = new CDbCriteria;
            $criteria->select = "COUNT(*) AS count";   
            $criteria->join = "JOIN tbl_debtors AS td ON t.number = td.code"; 
            $criteria->condition = "td.idCustomers = ".$model->idCustomer." AND t.lot = '" . $date . "'";           
            $matches = TempoManagements::model()->count($criteria);
            if($count > 0){
                $model->accounts = $count;
                $model->capital = $matches;
                if(!$model->save(false)){
                    $return['msg'] = '';
                    Yii::log("Error Actualizaciones", "error", "actionImport");
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                    $model->delete();
                }else{
                    $this->deleteFile($location);
                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Cargue exitoso!.');  
                    $return['model']['lot'] = $date;
                    $return['model']['idCustomer'] = $model->idCustomer;
                    $return['model']['typeImport'] = 4;
                    $return['model']['count'] = $count;
                    $return['model']['total'] = $matches;                                                        
                    //$return['model']['total'] = Yii::app()->format->formatNumber($total);                                                                
                }
            }else{
                $return['msg'] = Yii::t('front', 'Error, Importando data, por favor validar archivo');                                
            }

        } catch (Exception $e) {
            $return['status'] = 'warning';
            $return['msg'] = Yii::t('front', 'Error, cargando archivo');
            $return['msg'] .= ' '.$e;
        }
        
        return $return;
    }
    
}
