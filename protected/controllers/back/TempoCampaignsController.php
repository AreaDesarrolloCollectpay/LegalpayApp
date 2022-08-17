<?php

class TempoCampaignsController extends GxController {

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
		$model = new TempoCampaigns;
		// if (isset($_POST['TempoCampaigns'])) {
		// 	$model->setAttributes($_POST['TempoCampaigns']);
		// 	if ($model->save()) {
  //                           if (Yii::app()->getRequest()->getIsAjaxRequest()){
  //                               Yii::app()->end();
  //                           }else{
  //                               Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
  //                               $this->redirect(array('admin'));
  //                           }
		// 	}
		// }
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'TempoCampaigns');
		if (isset($_POST['TempoCampaigns'])) {
			$model->setAttributes($_POST['TempoCampaigns']);
			if ($model->save()) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'TempoCampaigns')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new TempoCampaigns('search');
		$model->unsetAttributes();
		if (isset($_GET['TempoCampaigns'])){
			$model->setAttributes($_GET['TempoCampaigns']);
                }
		$this->render('admin', array('model' => $model));
	}


    public function actionMasiveData(){
        Yii::log("Entre a la accion", "error", "actionMasiveData");
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', '2000M');
        $nameTempTable = rand();
        $error = false;
        if(isset($_FILES['file']))
        {
            Yii::log("Pase el post", "error", "actionMasiveData");
            $uploadedFile = CUploadedFile::getInstanceByName('file',$_FILES['file']);
            $fp = Yii::getPathOfAlias('webroot') . "/uploads/" . $nameTempTable . ".csv";
            if(!empty($uploadedFile))
            {
                Yii::log("Intenete guardar en " . Yii::getPathOfAlias('webroot') . "/uploads/", "error", "actionMasiveData");
                $uploadedFile->saveAs($fp);
                $date = new Datetime();
                $date = $date->format('Y-m-d H:i:s');
                $caracterSeparator = ";";
                if( strpos(file_get_contents($fp),",") !== false) {
                    $caracterSeparator = ",";
                }
                $sql="LOAD DATA INFILE '".$fp."'
                    INTO TABLE `tempo_campaigns`
                    FIELDS
                        TERMINATED BY '".$caracterSeparator."'
                        ENCLOSED BY '\"'
                    LINES
                        TERMINATED BY '\\n'
                     IGNORE 1 LINES 
                     (idNumber,name,companyName,distric,address,contactName,contactEmail,phone,@lote)
                     SET lote = sha1('".$date."')" ;
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();
                try
                    {
                        $connection->createCommand($sql)->execute();
                        $transaction->commit();

                        Yii::app()->user->setFlash('success', "Los datos han sido precargados con éxito");            
                        $this->redirect(array('../cms/tempoCampaigns/lote/'.sha1($date)));    
                    }catch(Exception $e){
                        $error = true;
                        Yii::log($e->getMessage(), "error", "actionMasiveData");
                        $transaction->rollBack();
                        Yii::app()->user->setFlash('error', "Algunos registros de los que está subiendo está repetidos");            
                        $this->redirect(array('../cms/tempoCampaigns/create'));

                     }
            }else {
                Yii::app()->user->setFlash('error', "Debe subir un archivo valido");            
                $this->redirect(array('../cms/tempoCampaigns/create'));
            }
        }else {
            Yii::app()->user->setFlash('error', "Debe subir un archivo valido");            
            $this->redirect(array('../cms/tempoCampaigns/create'));
        }
    }


    public function actionLote($lote){
        $command=Yii::app()->db->createCommand();
        $command->select('count(lote)');
        $command->from('tempo_campaigns');
        $command->where('lote=:lote', array(':lote'=>$lote));
        $usersUpload = $command->queryScalar();
        if($usersUpload>0){
            $this->render('../tempoCampaigns/create', array('lote'=>$lote, 'usersUpload'=>$usersUpload));     
        }else{
            Yii::app()->user->setFlash('error', "Está intentado hacer una operación no permitida");            
            $this->redirect(array('../tempoCampaigns/create'));    
        }
        
    }


    public function actionDeleteLote($lote){
        $criteria = new CDbCriteria;
        $criteria->condition = 'lote = "' . $lote. '"';
        if(TempoCampaigns::model()->deleteAll($criteria)){
            Yii::app()->user->setFlash('error', "No se han subido los registros. Por favor revise nuevamente el archivo y verifique la ciudad que se encuentre dentro de la base de datos del sistema.");            
            $this->redirect(array('../cms/tempoCampaigns/create'));    
        } else{
            Yii::app()->user->setFlash('error', "Ocurrio un error por favor intente de nuevo");            
            $this->redirect(array('../cms/tempoCampaigns/create/'.$lote));    
        }
    }

    public function actionUploadLote($lote){
        $criteria = new CDbCriteria;
        $criteria->condition = 'lote = "' . $lote. '" and active = 0';
        try{
            if(TempoCampaigns::model()->updateAll(array("active"=>1), $criteria)){
                Yii::app()->user->setFlash('success', "Se han subido los registros");            
                $this->redirect(array('../cms/tempoCampaigns/create/'));    
            } else{
                Yii::app()->user->setFlash('error', "Ocurrio un error por favor intente de nuevo");            
                $this->redirect(array('../cms/tempoCampaigns/create/'.$lote));    
            }    
        }catch(Exception $e){
            Yii::app()->user->setFlash('error', "Ocurrio un error por favor revise el archivo que tenga valores correctos y que existan en como las ciudades");            
            $this->redirect(array('../cms/tempoCampaigns/create/'.$lote));    
        }
        
    }

}