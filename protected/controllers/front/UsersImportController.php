<?php

class UsersImportController extends Controller {

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
        $this->access = array(1,2,5,7);
        $this->pSize = 5;
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
                $select = 't.id,t.name';
                $join = '';
                $condition = '';
                
                if ((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'])))) {
                    $join .= ' JOIN tbl_debtors td ON t.id = td.idCustomers 
                            JOIN tbl_campaigns_debtors cd ON td.id = cd.idDebtor 
                            JOIN tbl_campaigns c ON cd.idCampaigns = c.id 
                            JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= ' cc.idCoordinator = '.Yii::app()->user->getId();
                }
                $criteria->select = $select;
                if($condition != ''){
                    $criteria->condition = $condition;                    
                }
                if($join != ''){
                    $criteria->join = $join;
                }
                $criteria->group = 't.id';
                
                $customers = ViewCustomers::model()->findAll($criteria);              
                
                $join = '';
                $condition = '';
                
                if ((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'])))) {
                    $condition .= ($condition != '') ? ' AND ' : '';
                    $condition .= 't.idUserCreated = ' . Yii::app()->user->getId();
                }
                           
                $typeImports = TypeImport::model()->findAll(array("condition"=>"active = 1 AND id <> 5"));
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= "idTypeImport <> 5";
                $criteria->select = 't.*';
                $criteria->condition =  $condition;
                $criteria->join =  ($join != '')? $join : NULL; 
                $criteria->order = "t.dateCreated DESC";

                $count = UsersImport::model()->count($criteria);               
                $pages = new CPagination($count);
                $pages->pageSize = $this->pSize;
                $pages->applyLimit($criteria);

                $model = UsersImport::model()->findAll($criteria);     

                $data = array("name" => "Actualizaciones", "template" => "", "description" => "");
                $this->render('/importations/users-import', array("data" => $data, "typeImports" => $typeImports, "model" => $model, "customers" => $customers, "count" => $count, "pages" => $pages));
            } else {
                throw new CHttpException(404, 'La solicitud es inválida, archivo no encontrado');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    
    //=============================================================================================
    
    public function actionSaveImportationsData() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = array();
        $return['html'] = '';
        $return['newRecord'] = true;
        
        /*var_dump(isset($_POST));
        var_dump(!Yii::app()->user->isGuest);
        exit;*/
        if (isset($_POST) && !Yii::app()->user->isGuest) {
            $typeImport = $_POST['idTypeImport'];
            $model = new UsersImport();
            $model->setAttributes($_POST);
            $model->idUserCreated = Yii::app()->user->getId();
            $model->file = (CUploadedFile::getInstanceByName('file') != '') ? CUploadedFile::getInstanceByName('file') : $model->file;
            if ($model->save()) {
                $date = Date('d_m_Y_h_i_s');
                $file = CUploadedFile::getInstanceByName('file');
                $identificator = $model->id;
                $folder = $model->idCustomer;
                $uploadPath = "/uploads/assignments/";
                $upload = $this->uploadFile($file,$folder,$identificator,$uploadPath,false);
                if ($upload) {   
                    $location = $upload['location'];
                    $model->file = $upload['filename'];
                    $model->save(false);                                  
                    $caracterSeparator = $this->getFileDelimiter($location);
                    $importations = Yii::app()->createController('importations');//returns array containing controller instance and action index.
                    $importations = $importations[0]; //get the controller instance.
                    if($typeImport == 1){
                        $data = $importations->actionSaveDemographic($location, $caracterSeparator, $model, $date);
                        $return['status'] = $data['status'];
                        $return['msg'] = $data['msg'];
                        $return['model'] = $data['model'];
                        //print_r($data);
                    }else{
                        $data = $importations->actionSaveManagements($location, $caracterSeparator, $model, $date);
                        $return['status'] = $data['status'];
                        $return['msg'] = $data['msg'];
                        $return['model'] = $data['model'];
                    }
                }else{
                    $return['status'] = 'error';
                    $return['msg'] = Yii::t('front', 'No se pudo guardar el soporte');
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
    public function actionImportData() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            $model =  new ImportData;            
            $model->setAttributes($_POST);
            $typeImport = $_POST['typeImport'];
            $data = array('1' => 'TempoDemographic','2' => '','3' => '','4' => 'TempoManagements');
            
            if($model->validate() && array_key_exists($typeImport, $data)){
                $nModel = $data[$typeImport];
                $criteria = new CDbCriteria;
                $criteria->condition = 'lot = "' . $model->lot. '" AND migrate = 0 AND idCustomer =' . $model->idCustomer;

                if($nModel::model()->updateAll(array("migrate" => 1), $criteria)){ 

                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Importación exitosa!.');

                }else{

                    $return['status'] = 'warning';
                    $return['msg'] = Yii::t('front', 'Error al importar información');

                }    
                
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Gastos", "error", "actionImport");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
            
            
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    
    public function actionDeleteImport() {
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = Yii::t('front', 'Solicitud Invalida');
        $return['model'] = '';
        $return['html'] = '';
        $return['newRecord'] = true;

        if (isset($_POST) && !Yii::app()->user->isGuest) {

            $model =  new ImportData;            
            $model->setAttributes($_POST);
            $typeImport = $_POST['typeImport'];
            $data = array('1' => 'TempoDemographic','2' => '','3' => '','4' => 'TempoManagements');
            
            if($model->validate() && array_key_exists($typeImport, $data)){
                $nModel = $data[$typeImport];
                $criteria = new CDbCriteria;
                $criteria->condition = 'lot = "' . $model->lot. '" AND migrate = 0 AND idCustomer =' . $model->idCustomer;
        
                if($nModel::model()->deleteAll($criteria)){ 

                    $return['status'] = 'success';
                    $return['msg'] = Yii::t('front', 'Importación Eliminada!.');

                }else{

                    $return['status'] = 'warning';
                    $return['msg'] = Yii::t('front', 'Error al eliminar información');

                }    
                
            }else{
                $return['status'] = 'error';
                $return['msg'] = '';
                Yii::log("Error Gastos", "error", "actionImport");
                foreach ($model->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
            
            
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
        
    public function actionTemplate() {
        $return = array(
            'status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Inválida'),
            'file' => '',
        );

        set_time_limit(0);
        if(isset($_REQUEST['idCustomer'], $_REQUEST['idTypeImport']) && $_REQUEST['idCustomer'] != '' && $_REQUEST['idTypeImport'] != ''){
            
            $model  = TypeImport::model()->findByPk($_REQUEST['idTypeImport']);
                        
            if($model != null){
                
                switch ($model->id) {
                    case 1:
                        $return = IndicatorsController::ChartIndicatorsRegional($_POST);
                        break;
                    case 2:
                        $return = IndicatorsController::ChartIndicatorsModalities($_POST);
                        break;
                    case 3:
                        $return = IndicatorsController::ChartIndicatorsPerson($_POST);
                        break;
                    case 4:
                        $return = IndicatorsController::ChartIndicatorsProperty($_POST);
                        break;
                    case 5:
                        $return = IndicatorsController::ChartIndicatorsYear($_POST);
                        break;
                    case 6:
                        $return = UsersImportController::getAssignmentsAdviser($_REQUEST,$model);
                        break;
                }
            }
//            if($_POST['typeImport'] == 1){
//                $connection = Yii::app()->db;
//                $transaction = $connection->beginTransaction();
//                try {
//                    $root = Yii::getPathOfAlias('webroot');
//                    $typeImport = TypeImport::model()->findByPk($tImport);
//                    $filename = "/uploads/" . $typeImport->template ."_".Date('d_m_Y_h_i_s').".csv";
//                    $condition = "";
//
//                    $join = "LEFT JOIN tbl_debtors_demographics AS tdg ON td.id = tdg.idDebtor
//                            LEFT JOIN tbl_occupations AS tocc ON tocc.id = tdg.idOccupation 
//                            LEFT JOIN tbl_marital_states AS tms ON tms.id = tdg.idMaritalState
//                            LEFT JOIN tbl_genders AS tg ON tg.id = tdg.idGender
//                            LEFT JOIN tbl_type_contract AS tc ON tc.id = tdg.idTypeContract
//                            LEFT JOIN tbl_type_education_levels AS ttel ON ttel.id = tdg.idTypeEducationLevel
//                            LEFT JOIN tbl_type_housing AS tth ON tth.id = tdg.idTypeHousing
//                            LEFT JOIN tbl_cities AS c ON td.idCity = c.id
//                            LEFT JOIN tbl_departments AS dp ON c.idDepartment = dp.id
//                            LEFT JOIN tbl_countries AS cn ON dp.idCountry = cn.id 
//                            JOIN tbl_debtors_state AS ds ON td.idDebtorsState = ds.id AND ds.historic = 0";
//
//                    $condition .= "td.idCustomers = ".$customer."";
//
//                    if ((in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'])))) {
//                        $join .= ' JOIN tbl_campaigns_debtors cd ON td.id = cd.idDebtor JOIN tbl_campaigns tcm ON cd.idCampaigns = tcm.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
//                        $condition .= ($condition != '') ? ' AND ' : '';
//                        $condition .= ' cc.idCoordinator = '.Yii::app()->user->getId();
//                    }
//
//                    $condition = ($condition != '') ? 'WHERE ' . $condition : '';
//
//                    $sql = 'SELECT 
//                            \'NOMBRE\',\'NUMERO DOCUMENTO\',\'EMAIL\',\'PAIS\',\'DEPARTAMENTO\',\'CIUDAD\',\'DIRECCION\',\'BARRIO/ZONA\',\'TELEFONO\',\'CELULAR\',
//                            \'OCUPACION : AMA DE CASA - DESEMPLEADO - EMPLEADO - ESTUDIANTE - INDEPENDIENTE - JUBILADO - PENSIONADO\',
//                            \'ESTADO CIVIL : CASADO - ECLESCIASTICO - SEPARADO - SOLTERO - UNION LIBRE - VIUDO\',
//                            \'NIVEL DE INGRESOS : CANTIDAD EN SALARIOS MINIMOS - EJEMPLO 1\',\'EDAD\',\'ANTIGUEDAD LABORAL :  CANTIDAD ANOS\',\'GENERO : MASCULINO - FEMENINO \',
//                            \'ESTRATO SOCIAL : 1 - 2 - 3 - 4 - 5 - 6\',
//                            \'TIPO DE CONTRATO : JUBILADO - NINGUNO DE LOS ANTERIORES - SERVICIOS - TERMINO DEFINIDO -TERMINO INDEFINIDO\',
//                            \'NIVEL EDUCATIVO : NINGUNO - POSTGRADO - PRIMARIA - SECUNDARIA - TECNICO - TECNOLOGICO - UNIVERSITARIO\',
//                            \'TIPO DE VIVIENDA : ARRENDADA - FAMILIAR - PROPIA - NINGUNA DE LAS ANTERIORES\',
//                            \'PLAZO CONTRATO : CANTIDAD MESES\',\'PERSONAS A CARGO: CANTIDAD\',\'CAPACIDAD DE PAGO : CANTIDAD EN SALARIOS MINIMOS - EJEMPLO 1\'
//                            UNION
//                            SELECT
//                            IFNULL(TRIM(REPLACE(REPLACE(REPLACE(td.name, \'"\',\'\'), CHAR(13),\' \'), CHAR(10),\' \')),\'\'), 
//                            IFNULL(REPLACE(REPLACE(REPLACE(td.code, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'), 
//                            IFNULL(REPLACE(REPLACE(REPLACE(td.email, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(cn.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(dp.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(c.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(td.address, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(td.neighborhood, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(td.phone, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'), 
//                            IFNULL(REPLACE(REPLACE(REPLACE(td.mobile, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(tocc.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(tms.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(tdg.incomeLegal, \'0\'),
//                            IFNULL(tdg.age, \'0\'),
//                            IFNULL(tdg.laborOld, \'0\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(tg.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(tdg.stratus, \'0\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(tc.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(ttel.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(REPLACE(REPLACE(REPLACE(tth.name, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
//                            IFNULL(tdg.contractTerm, \'0\'),
//                            IFNULL(tdg.dependents, \'0\'),
//                            IFNULL(tdg.paymentCapacity, \'0\')                        
//                            FROM tbl_debtors AS td
//                            '.$join.'
//                            ' . $condition . '
//                            INTO OUTFILE \'' . $root . $filename . '\'
//                            CHARACTER SET latin2
//                            FIELDS TERMINATED BY \',\'
//                            OPTIONALLY ENCLOSED BY \'"\'
//                            LINES TERMINATED BY\'\n\'';             
//                    
//                    $connection->createCommand($sql)->execute();
//                    //.... other SQL executions
//                    $transaction->commit();
//
//                    if (file_exists($root . $filename)) {
//                        $return['status'] = 'success';
//                        $return['file'] = $filename;
//                        $return['msg'] = Yii::t('front', 'download !.');
//                    }
//                } catch (Exception $e) { 
//                    $transaction->rollback();
//                    $return['msg'] = $e->getMessage();
//                }
//            }else{
//                $typeImport = TypeImport::model()->findByPk($tImport);
//                $filename = "/uploads/" . $typeImport->template.".csv";
//                $return['status'] = 'success';
//                $return['file'] = $filename;
//                $return['msg'] = Yii::t('front', 'download !.');
//            }
        }

        echo CJSON::encode($return);
    }
    
    //=============================================================================================
    
    //=============================================================================================

        public static function getAssignmentsAdviser($POST,$model) {
            $return = array('status' => 'success', 'file' => '', 'msg' => Yii::t('front', 'Solicitud Invalida'));
            
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                $root = Yii::getPathOfAlias('webroot');
                $filename = "/uploads/" . $model->template ."_".Date('d_m_Y_h_i_s').".csv";

                $condition = "vd.idCustomer = ".$POST['idCustomer']."";

                $condition = ($condition != '') ? 'WHERE ' . $condition : '';

                $sql = 'SELECT 
                        \'NUMERO DOCUMENTO\',\'NOMBRE\'
                        UNION
                        SELECT
                        IFNULL(REPLACE(REPLACE(REPLACE(vd.code, \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),\'\'),
                        IFNULL(TRIM(REPLACE(REPLACE(REPLACE(vd.name, \'"\',\'\'), CHAR(13),\' \'), CHAR(10),\' \')),\'\') 
                        FROM view_debtors AS vd
                        ' . $condition . '
                        INTO OUTFILE \'' . $root . $filename . '\'
                        CHARACTER SET latin2
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
            } catch (Exception $e) { 
                $transaction->rollback();
                $return['msg'] = $e->getMessage();
            }
            return $return;
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
