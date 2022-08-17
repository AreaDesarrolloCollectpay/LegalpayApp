<?php

class AdvisersCampaignsController extends GxController {

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
    public function sendMailAdvisers($key,$name, $mail,$nameCampaign,$comment){
        Yii::log("Se hace el envío de correo", "error", "sendMailAdvisers");
        $token = Token::model()->findByAttributes(array('permision_key'=>$key));
        if(count($token)>0){
            Yii::log("Se prepara el envío de correo", "error", "sendMailAdvisers");
            $token->delete();
            $subject = 'Asignación de campañas';
            $bodyEmail = '<table width="100%" border="0" align="center">
              <tr>
                <td height="100%">
                    <table width="100%" border="0" align="center">
                        <tr>
                            <td>
                              <p>
                                Hola, ' .$name. ', ha sido asignado a una nueva campaña.
                              <p>
                              
                              -<b>Link de ingreso:</b> ' .Yii::app()->getBaseUrl(true). '/iniciar-sesion <br>
                              -<b>Nombre de la campaña:</b> ' .$nameCampaign. ' <br>
                              -<b>Comentarios:</b> '.$comment.' <br>
                              
                              <br><br>
                              Cordialmente,<br>Staff <a href="http://cojunal.com" target="_blank">cojunal.com</a>
                              <br><br>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
            </table>';
            if(Controller::sendMailMandrill(array($mail => $name), $subject, $bodyEmail)){
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
        $newToken = new Token;
        $now = date("Y-m-d H:m:s");
        $keyPermission = md5($now);
        $newToken->permision_key = $keyPermission;
        $newToken->date = $now;

		$model = new AdvisersCampaigns;
		$this->performAjaxValidation($model, 'advisers-campaigns-form');
		if (isset($_POST['AdvisersCampaigns'])) {
			$model->setAttributes($_POST['AdvisersCampaigns']);
            if($newToken->save()){
    			if ($model->save()) {
                                if (Yii::app()->getRequest()->getIsAjaxRequest()){
                                    Yii::app()->end();
                                }else{
                                    $modelAdviser = Advisers::model()->findByPk($model->idAdvisers);
                                    $modelCampaign = Campaigns::model()->findByPk($model->idCampaign);
                                    $mailSender = $this->sendMailAdvisers($keyPermission, $modelAdviser->name, $modelAdviser->email,$modelCampaign->name, $model->comment);
                                    Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                                    $this->redirect(array('admin'));
                                }
    			}
            }else {
                Yii::log("No se ha podido cargar el key para envio de correo " . $keyPermission, "error", "actionCreate");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear el asesor por favor intente de nuevo"));
                $this->redirect(array('admin'));
            }
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'AdvisersCampaigns');
		$this->performAjaxValidation($model, 'advisers-campaigns-form');
		if (isset($_POST['AdvisersCampaigns'])) {
			$model->setAttributes($_POST['AdvisersCampaigns']);
			if ($model->save()) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'AdvisersCampaigns')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new AdvisersCampaigns('search');
		$model->unsetAttributes();
		if (isset($_GET['AdvisersCampaigns'])){
			$model->setAttributes($_GET['AdvisersCampaigns']);
                }
		$this->render('admin', array('model' => $model));
	}


    public function actionCampaigns() {
        $model = new Campaigns('search');
        $model->unsetAttributes();
        if (isset($_GET['Campaings'])){
            $model->setAttributes($_GET['Campaigns']);
                }
        $this->render('campaigns', array('model' => $model));
    }

}