<?php

class CampaignsController extends GxController {

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
        

    /**
    *
    * Función que permite el envío de correos electrónicos apra los asesores, para el ingreso al sistema
    * @param $key Key generado por la plataforma para no aceptar peticiones fuera de esta
    * @param $name Nombre del usaurio al que se envía el correo
    * @param $mail Correo electrónico al cual se envía el correo
    * @param $user Usuario con el cual se va registra el asesor
    * @param $password Clave con la cual el asesor va a ingresar al sistema 
    */
    public function sendMailCampaigns($key,$name, $mail, $user, $password){
        Yii::log("Se hace el envío de correo" . $name, "error", "sendMailCampaigns");
        $companyData = explode("|" , $name);
        
        $token = Token::model()->findByAttributes(array('permision_key'=>$key));
        if(count($token)>0){
            Yii::log("Se prepara el envío de correo", "error", "sendMailCampaigns");
            $token->delete();
            $subject = 'Nueva Campaña creada';
            $bodyEmail = '<table width="100%" border="0" align="center">
              <tr>
                <td height="100%">
                    <table width="100%" border="0" align="center">
                        <tr>
                            <td>
                              <p>
                                Hola, ' .$companyData[0]. ', se ha creado una nueva campaña para la empresa '.$companyData[1].' a la cual usted representa por favor ingrese al sistema para poder dar gestión de la misma.
                              <p>
                              
                              -<b>Link de ingreso:</b> ' .Yii::app()->getBaseUrl(true). '/iniciar-sesion <br>
                              -<b>Usuario:</b> ' .$mail. ' <br>
                              -<b>Clave:</b> '.$password.' <br>
                            
                              <br><br>
                              Cordialmente,<br>Staff <a href="http://cojunal.com" target="_blank">cojunal.com</a>
                              <br><br>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
            </table>';
            if(Controller::sendMailMandrill(array($mail), $subject, $bodyEmail)){
                Yii::log("Se envió el correo", "error", "sendMailAdvisers");
                return true;
            }else {
                Yii::log("No se envió el correo", "error", "sendMailAdvisers");
                return "mail-error";
            }    
        }else{
            Yii::log("Hubo un error con el Token" . $key , "error", "sendMailAdvisers");
            return false;
        }
        
    }

	public function actionCreate() {
		$model = new Campaigns;
        $newToken = new Token;
        $now = date("Y-m-d H:m:s");
        $keyPermission = md5($now);
        $newToken->permision_key = $keyPermission;
        $newToken->date = $now;
        $modelAuthAssigment = new AuthAssignment;
		$this->performAjaxValidation($model, 'campaigns-form');
		if (isset($_POST['Campaigns'])) {
			$model->setAttributes($_POST['Campaigns']);
            $model->fCreacion = $now;
            $model->dUpdate = $now;
            $hash = substr(md5($now), 0, 8);
            $model->passwd = md5($hash);
            $modelAdviser = Advisers::model()->findByPk($model->idAdviser);
            $modelAuthAssigment->userid = $model->contactEmail;
            $modelAuthAssigment->bizrule = "Rol empresa";
            $modelAuthAssigment->data = "Rol empresa";
            $modelAuthAssigment->itemname = "Empresa";
            if(count(Advisers::model()->findByAttributes(array('email'=>$model->contactEmail)))>0 || count(AuthAssignment::model()->findByAttributes(array('userid'=>$modelAuthAssigment->userid)))>0){
                Yii::log("No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos" . $keyPermission, "error", "actionCreate");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos"));
                $this->redirect(array('admin'));
            }else {
                if($newToken->save()){
                    if($modelAuthAssigment->save()){
                        if ($model->save()) {
                            $mailSender = $this->sendMailCampaigns($keyPermission, $model->contactName . "|" . $model->companyName, $model->contactEmail, $model->contactEmail, $hash);    
                            if (Yii::app()->getRequest()->getIsAjaxRequest()){
                                Yii::app()->end();
                            }else{
                                Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                                $this->redirect(array('admin'));
                            }
                        }else{
                            Yii::log("No se ha podido Guardar la campaña ", "error", "actionCreate");
                            Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear la campaña por favor intente de nuevo"));
                            $this->redirect(array('admin'));
                        }
                    }
                }else{
                    Yii::log("No se ha podido cargar el key para envio de correo " . $keyPermission, "error", "actionCreate");
                    Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear la campaña por favor intente de nuevo"));
                    $this->redirect(array('admin'));
                }
            }
            
			
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Campaigns');
        if($model->passwd==""){
            $model->passwd = "123";
        }
        $emailOrigin = $model->contactEmail;
		$this->performAjaxValidation($model, 'campaigns-form');
		if (isset($_POST['Campaigns'])) {
			$model->setAttributes($_POST['Campaigns']);
            if($model->contactEmail!=$emailOrigin){
                if(count(Campaigns::model()->findByAttributes(array('contactEmail'=>$model->contactEmail)))>0){
                    Yii::app()->user->setFlash("error", Yii::t('app', "No se puede actualizar la campaña ya que el correo con el cual desea actualizar ya existe"));
                    $this->redirect(array('admin'));    
                }else {
                    if ($model->save()) {
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                        if($model->passwd=="123"){
                            $this->actionUpdatePassword($id);
                        }else 
                            $this->redirect(array('admin'));
                    }
                }
            }else {
                if ($model->save()) {
                    Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                    $this->redirect(array('admin'));
                }    
            }
			
		}
		$this->render('update', array( 'model' => $model));
	}

    public function actionUpdatePassword($id) {
        $newToken = new Token;
        $now = date("Y-m-d H:m:s");
        $keyPermission = md5($now);
        $newToken->permision_key = $keyPermission;
        $newToken->date = $now;
        $model = $this->loadModel($id, 'Campaigns');
        if($newToken->save()){
            $model->dUpdate = $now ;
            $hash = substr(md5($now), 0, 8);
            $model->passwd = md5($hash);
            if($model->save()){
                $mailSender = $this->sendMailCampaigns($keyPermission, $model->contactName . "|" . $model->companyName, $model->contactEmail, $model->contactEmail, $hash);    
                if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                    Yii::app()->user->setFlash("success", Yii::t('app', "Se ha actualizado la contraseña de la empresa y se ha enviado el correo respectivo"));
                    $this->redirect(array('admin'));
                }        
            } else {
                Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo actualizar la contraseña de la empresa"));
                $this->redirect(array('admin'));
            }
            
        } else {
            Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo actualizar la contraseña de la empresa"));
            $this->redirect(array('admin'));
        }
        
        
    }

	public function actionDelete($id) {
        $model = Campaigns::model()->findByPk($id);
		if ($model) {
            $model = Campaigns::model()->findByPk($id);
            $model->active = 0;
            if($model->save()){
                Yii::log("Guardó cambios de " . $model->name, "error", "Campaign");
                if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                    Yii::app()->user->setFlash("success", Yii::t('app', "Registro inactivado con éxito"));
                }    
            }else {
                Yii::log("Error cambiando al usuario " . $model->name, "error", "Campaign");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido inactivar la campaña"));
            }
		} else{
            throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
        }
        $this->actionAdmin();
	}

	public function actionAdmin() {
		$model = new Campaigns('search');
		$model->unsetAttributes();
		if (isset($_GET['Campaigns'])){
			$model->setAttributes($_GET['Campaigns']);
                }
		$this->render('admin', array('model' => $model));
	}

}