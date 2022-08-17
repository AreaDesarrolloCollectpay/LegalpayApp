<?php

class AdvisersController extends GxController {

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
    public function sendMailAdvisers($key,$name, $mail,$user,$password){
        Yii::log("Se hace el envío de correo", "error", "sendMailAdvisers");
        $token = Token::model()->findByAttributes(array('permision_key'=>$key));
        if(count($token)>0){
            Yii::log("Se prepara el envío de correo", "error", "sendMailAdvisers");
            $token->delete();
            $subject = 'Credenciales para el ingreso';
            $bodyEmail = '<table width="100%" border="0" align="center">
              <tr>
                <td height="100%">
                    <table width="100%" border="0" align="center">
                        <tr>
                            <td>
                              <p>
                                Hola, ' .$name. ', se ha generado un clave para el ingreso al sistema de Cojunal a continuación se muestran los datos.
                              <p>
                              
                              -<b>Link de ingreso:</b> ' .Yii::app()->getBaseUrl(true). '/iniciar-sesion <br>
                              -<b>Usuario:</b> ' .$user. '<br>
                              -<b>Clave:</b> '.$password.'<br>
                              
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
		$model = new Advisers;
        $newToken = new Token;
        $now = date("Y-m-d H:m:s");
        $keyPermission = md5($now);
        $newToken->permision_key = $keyPermission;
        $newToken->date = $now;
        $modelAuthAssigment = new AuthAssignment;
        $this->performAjaxValidation($model, 'advisers-form');
		if (isset($_POST['Advisers'])) {
			$model->setAttributes($_POST['Advisers']);

            $modelAuthAssigment->userid = $model->idAuthAssignment;
            unset($model->idAuthAssignment);
            $modelAuthAssigment->bizrule = "Rol asesor";
            $modelAuthAssigment->data = "Rol asesor";
            $modelAuthAssigment->itemname = "Asesor";

            $model->dCreation = $now ;
            $model->dUpdate = $now ;
            $hash = substr(md5($now), 0, 8);
            $model->passwd = md5($hash);
            if(count(Advisers::model()->findByAttributes(array('email'=>$model->email)))>0 || count(AuthAssignment::model()->findByAttributes(array('userid'=>$modelAuthAssigment->userid)))>0){
                Yii::log("No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos" . $keyPermission, "error", "actionCreate");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos"));
                $this->redirect(array('admin'));
            }else{
                if($newToken->save()){
                    if($modelAuthAssigment->save()){
                        $model->idAuthAssignment = $modelAuthAssigment->idAuthAssignment;
                        if ($model->save()) {
                            $mailSender = $this->sendMailAdvisers($keyPermission, $model->name, $model->email,$modelAuthAssigment->userid,$hash);    
                            if (Yii::app()->getRequest()->getIsAjaxRequest()){
                                Yii::app()->end();
                            }else{
                                Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                                $this->redirect(array('admin'));
                            }
                        }
                    }else {
                        Yii::app()->user->setFlash("error", Yii::t('app', "El nombre del usuario ya se encuentra registrado"));
                        $this->redirect(array('admin'));
                    }
                }else{
                    Yii::log("No se ha podido cargar el key para envio de correo " . $keyPermission, "error", "actionCreate");
                    Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear el asesor por favor intente de nuevo"));
                    $this->redirect(array('admin'));
                }    
            } 
            
			
		}
		$this->render('create', array( 'model' => $model));
	}

    public function actionUpdatePassword($id) {
        $newToken = new Token;
        $now = date("Y-m-d H:m:s");
        $keyPermission = md5($now);
        $newToken->permision_key = $keyPermission;
        $newToken->date = $now;
        $model = $this->loadModel($id, 'Advisers');
        if($newToken->save()){
            $model->dUpdate = $now ;
            $hash = substr(md5($now), 0, 8);
            $model->passwd = md5($hash);
            $modelAuthAssigment = AuthAssignment::model()->findByPk($model->idAuthAssignment);
            if($model->save()){
                $mailSender = $this->sendMailAdvisers($keyPermission, $model->name, $model->email,$modelAuthAssigment->userid,$hash);    
                if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                    Yii::app()->user->setFlash("success", Yii::t('app', "Se ha actualizado la contraseña del asesor y se ha enviado el correo respectivo"));
                    $this->redirect(array('admin'));
                }        
            } else {
                Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo actualizar la contraseña del asesor"));
                $this->redirect(array('admin'));
            }
            
        } else {
            Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo actualizar la contraseña del asesor"));
            $this->redirect(array('admin'));
        }
        
        
    }

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Advisers');
        $emailOrigin = $model->email;
		$this->performAjaxValidation($model, 'advisers-form');
		if (isset($_POST['Advisers'])) {
			$model->setAttributes($_POST['Advisers']);
            $model->dUpdate = date("Y-m-d H:m:s");
            if($emailOrigin != $model->email){
                if(count(Advisers::model()->findByAttributes(array('email'=>$model->email)))>0){
                    Yii::app()->user->setFlash("error", Yii::t('app', "No se puede actualizar el asesor ya que el correo con el cual desea actualizar ya existe"));
                    $this->redirect(array('admin'));    
                }else {
                    if ($model->save()) {
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
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

	public function actionDelete($id) {
        $model = Advisers::model()->findByPk($id);
		if (isset($model)) {
            $model = Advisers::model()->findByPk($id);
            $model->active = 0;
            if($model->save()){
                Yii::log("Guardó cambios de " . $model->name, "error", "Adviser");
                if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                    Yii::app()->user->setFlash("success", Yii::t('app', "Registro inactivado con éxito"));
                    $this->redirect(array('admin'));
                }    
            }else {
                Yii::log("Error cambiando al usuario " . $model->name, "error", "Adviser");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido inactivar el usuario"));
                $this->redirect(array('admin'));
            }
                    
		} else{
            throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
        }
	}


    public function actionSuperasesor($id){
        $model = $model = Advisers::model()->findByPk($id);
        $modelAuthAssigment = AuthAssignment::model()->findByPk($model->idAuthAssignment);
        
        $validAuthAssignment = AuthAssignment::model()->findByAttributes(array('itemname'=>"Coordinador"));
        if(count($validAuthAssignment)>0){
            $validAuthAssignment->attributes=array('itemname'=>'Asesor');
            $validAuthAssignment->save();
        }   
        
        $modelAuthAssigment->itemname = "Coordinador";
        if($modelAuthAssigment->save()){
            Yii::log("Guardó cambios de " . $model->name, "error", "Adviser");
            if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                Yii::app()->user->setFlash("success", Yii::t('app', "Coordinador creador con éxito"));
                $this->redirect(array('admin'));
            }    
        }else {
                Yii::log("Error cambiando al usuario " . $model->name, "error", "Adviser");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear como coordinador el usuario"));
                $this->redirect(array('admin'));

        }


    }

	public function actionAdmin() {
		$model = new Advisers('search');
		$model->unsetAttributes();
		if (isset($_GET['Advisers'])){
			$model->setAttributes($_GET['Advisers']);
                }
		$this->render('admin', array('model' => $model));
	}

}