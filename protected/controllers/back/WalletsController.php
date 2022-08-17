<?php

class WalletsController extends GxController {

        public $defaultAction = 'admin';

        public function filters() {
            Yii::app()->getComponent('booster');
            return array(
                'accessControl', 
            );
        }

        public function accessRules() {
            return array(
                array('allow',
                        'expression'=>'Controller::validateAccess()',
                        ),
                array('deny', 
                        'users'=>array('*'),
                        ),
            );
        }
        

	public function actionCreate() {
		$model = new Wallets;
        $now = date("Y-m-d H:m:s");
        $sysParams = Sysparams::model()->findByPk(1);
        $feeValue = $sysParams->feeRate;
        $interestRate = $sysParams->interestRate;
        $modelWalletsHasCampaigns = new WalletsHasCampaigns;
		$this->performAjaxValidation($model, 'wallets-form');
		if (isset($_POST['Wallets'])) {
            $modelCampaigns = $_POST['Campaigns'];
			$model->setAttributes($_POST['Wallets']);
            $model->dUpdate = $now ;
            $model->currentDebt = 0;
            $model->feeValue = ($model->capitalValue*$feeValue)/100;
            $model->interestsValue = ($model->capitalValue*$interestRate)/100;
            $modelWalletsHasCampaigns->idCampaign = $modelCampaigns['idCampaign'];
            if(isset($model->walletsHasCampaigns))
                $model->unsetAttributes(array('walletsHasCampaigns'));
			if ($model->save()) {
                $modelWalletsHasCampaigns->idWallet = $model->idWallet;
                if($modelWalletsHasCampaigns->save()){
                            if (Yii::app()->getRequest()->getIsAjaxRequest()){
                                Yii::app()->end();
                            }else{
                                Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                                $this->redirect(array('admin'));
                            }
                }else{
                    $model->delete();
                    Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido registrar el deudor"));
                }
                $this->redirect(array('admin'));
			}
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) { 
        $now = date("Y-m-d H:m:s");
        $sysParams = Sysparams::model()->findByPk(1);
        $feeValue = $sysParams->feeRate;
        $interestRate = $sysParams->interestRate;
		$model = $this->loadModel($id, 'Wallets');
		$this->performAjaxValidation($model, 'wallets-form');
		if (isset($_POST['Wallets'])) {
                    $model->setAttributes($_POST['Wallets']);
                    $modelCampaigns = $_POST['Campaigns'];
                    $walletsHasCampaigns = WalletsHasCampaigns::model()->findByPk($model->idWallet);
                    
                    if(isset($modelCampaigns['idCampaign']) && $modelCampaigns['idCampaign'] != '' && $walletsHasCampaigns != NULL){
                        $walletsHasCampaigns->idCampaign = $modelCampaigns['idCampaign'];
                        
                    }
                    $model->feeValue = ($model->capitalValue*$feeValue)/100;
                    $model->interestsValue = ($model->capitalValue*$interestRate)/100;
                    $model->dUpdate = $now ;
                    if ($model->save()) {
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));                                    
                        if((isset($modelCampaigns['idCampaign']) && $modelCampaigns['idCampaign'] != '' && $walletsHasCampaigns != NULL)){
                            $walletsHasCampaigns->save();
                        }
                    }else{
                        $msg = '';
                        foreach ($model->getErrors() as $error) {
                            $msg .= $error[0] . "<br/>";
                        }
                        
                        Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido actualizar el deudor :".$msg));
                    }
                        $this->redirect(array('admin'));
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'Wallets')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new Wallets('search');
		$model->unsetAttributes();
		if (isset($_GET['Wallets'])){
			$model->setAttributes($_GET['Wallets']);
                }
		$this->render('admin', array('model' => $model));
	}
        
        public function actionReporte() {
            set_time_limit(0);
            ini_set('memory_limit','-1');
            $model = Wallets::model()->findAll(array('order' => 'idWallet ASC'));
            $this->toExcel($model,
                array(
                   'idNumber','capitalValue','feeValue','interestsValue','dAssigment','updated','created','legalName','address','phone','email','Campaign','campaignName','recoveryPorc','idAdviser0.name','idDistrict0.idCity0.departments.name','idDistrict0.name','idStatus0.description','product','currentDebt','titleValue','validThrough','prescription','accountNumber','negotiation','vendorEmail','vendorName','vendorPhone','phones','references','emails','addresses','Dmanagement','Amanagement','Tmanagement','paymentTotal','Dpayment'),
                'cartera',
                array(
                    'creator' => 'Imaginamos',
                ),
                'CSV'
            );
        }
                        
        public function actionReporte5() {
            set_time_limit(0);
            $filename = Yii::getPathOfAlias('webroot') ."/uploads/"."export_".Date('d_m_Y_h_i_s_').".csv";
            $connection = Yii::app()->db;
            $transaction=$connection->beginTransaction();
            try
            {
                
                $sql = ' 
                    
                       SELECT 
                       \'Campaña\',\'Identificacion\',\'Nombre deudor\',\'Capital\',\'Meses Deuda\',\'Intereses\',\'Honorarios\',\'Abono\',\'Saldo\',
                       \'Fecha Ultimo Pago\',\'Fecha Deuda\',\'Prescripcion\',\'Porcentaje Recuperacion\',\'Estado\',\'Cantidad Obligaciones\',\'Producto\',\'País\',\'Departamento\', \'Ciudad\',\'Contacto Campaña\',\'Asesor\',
                       \'Fecha Asignacion\',\'Fecha Actualizacion\',\'Fecha Creacion\',\'Titulo\',\'Cuenta\',\'Telefono\',\'Email\',\'Direccion\',
                       \'Negociacion\',\'Nombre Proveedor\',\'Email Proveedor\',\'Telefono Proveedor\',\'Telefonos Deudor\',\'Direcciones Deudor\',\'Emails Deudor\',\'Referencias Deudor\',\'Fecha Ultima Gestion\',\'Asesor Ultima Gestion\',\'Infomacion Gestion\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(nameCampaigns , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       idNumber,
                       REPLACE(REPLACE(REPLACE(nameWallet , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(capitalValue,\'.\',\',\') AS capitalValue,
                       debtMoth,
                       REPLACE(ROUND(interest,2),\'.\',\',\') AS interest,
                       REPLACE(ROUND(fee,2),\'.\',\',\') AS fee,
                       IF((paymentsTotal IS NOT NULL), REPLACE(paymentsTotal,\'.\',\',\'), 0) as paymentsTotal,
                       REPLACE(balance,\'.\',\',\') AS balance,
                       Dpayment,dateDebt,prescription,recoveryPorc,
                       REPLACE(REPLACE(REPLACE(state , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       countDebt,
                       REPLACE(REPLACE(REPLACE(product , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(Country , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(Department , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(City , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(contactCampaigns , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(nameAdviser , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       assigment,updated,created,
                       REPLACE(REPLACE(REPLACE(titleValue , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(accountNumber , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(phone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(email , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(address , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(negotation , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(vendorName , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(vendorEmail , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(vendorPhone , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(phones , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(addresses , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(emails , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(reference , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(Dmanagement , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(Amanagement , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(Tmanagement , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \')
                       FROM wallets_export
                       INTO OUTFILE \''.$filename.'\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'' ;
//                echo $sql;
//                exit;
                //$sql = "SELECT * FROM wallets_export INTO OUTFILE '".$filename."' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n\r'";
               
                $connection->createCommand($sql)->execute();
                //.... other SQL executions
                $transaction->commit();
                
                if (file_exists($filename)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($filename));
                    readfile($filename);
                    Yii::app()->end();
                }
                
                
            }
            catch(Exception $e) // an exception is raised if a query fails
            {
                $transaction->rollback();
                echo $e->getMessage();
                exit;
            }            
        }        

        public function behaviors() {
            return array(
                'eexcelview' => array(
                    'class' => 'ext.eexcelview.EExcelBehavior',
                ),
            );
        }

}