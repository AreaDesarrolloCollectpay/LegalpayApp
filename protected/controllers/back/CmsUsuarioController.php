<?php

class CmsUsuarioController extends GxController {

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
            $model = new CmsUsuario('nuevo');
            if (isset($_POST['CmsUsuario'])) {
                    $model->setAttributes($_POST['CmsUsuario']);
                    $psw = $this->creaPassword();
                    if($model->contrasena == "" && $model->contrasena_confirm == ""){
                        $model->contrasena = $psw;
                        $model->contrasena_confirm = $model->contrasena;
                    }
                    if ($model->validate()) {
                        $psw = $model->contrasena;
                        $model->contrasena = md5($psw);
                        $model->contrasena_confirm = $model->contrasena;
                    }else{
                        $model->contrasena = "";
                        $model->contrasena_confirm = "";
                    }
                    if ($model->save()) {
                            if (Yii::app()->getRequest()->getIsAjaxRequest()){
                                    Yii::app()->end();
                            }else{
                                $subject = 'Hola '.$model->nombres . ' ' . $model->apellidos.', estos son los datos de su nueva cuenta';
                                $bodyEmail = '<table width="632" border="0" align="center">
                                  <tr>
                                    <td height="522">
                                        <table width="55%" border="0" align="center">
                                            <tr>
                                                <td>
                                                  <p>
                                                    Hola '.$model->nombres . ' ' . $model->apellidos.', se ha creado una nueva cuenta para usted. Para ingresar haga clic en el siguiente link: <br><br>
                                                    '.$this->createAbsoluteUrl('cms/index').'</a><br><br>
                                                    Sus datos de acceso son los siguientes:<br><br>
                                                    <strong>Email:</strong><br>'.$model->email.'<br><br>
                                                    <strong>Su clave:</strong><br>'.$psw.'<br><br>--<br><br>
                                                    Guarde este correo para<br>futuras referencias
                                                  <p>
                                                  <br><br>
                                                  Cordialmente,<br>Staff <a href="http://cojunal.com" target="_blank">cojunal.com</a>
                                                  <br><br>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                  </tr>
                                </table>';
                                if(Controller::sendMail(array($model->email => $model->nombres . ' ' . $model->apellidos), $subject, $bodyEmail)){
                                    Yii::app()->user->setFlash("success", Yii::t('app', "Usuario creado con éxito"));
                                    $this->redirect(array('admin'));
                                }else{
                                    throw new CHttpException(400, Yii::t('err', 'Error al enviar email'));
                                }
                            }
                    }
            }
            $this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'CmsUsuario');
                $psw = $model->contrasena;
                $model->contrasena = "";
		if (isset($_POST['CmsUsuario'])) {
			$model->setAttributes($_POST['CmsUsuario']);
                        if ($model->contrasena != "" && $model->contrasena_confirm != "" && $model->validate()) {
                            $model->contrasena = md5($model->contrasena);
                            $model->contrasena_confirm = $model->contrasena;
                            
                        }elseif($model->contrasena == "" && $model->contrasena_confirm == "" && $model->validate()) {
                            $model->contrasena = $psw;
                            $model->contrasena_confirm = $psw;
                        }
			if ($model->save()) {
				Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
                        }else{
                            $model->contrasena = "";
                            $model->contrasena_confirm = "";
                        }
		}

		$this->render('update', array(
				'model' => $model,
				));
	}
        
	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'CmsUsuario')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new CmsUsuario('search');
		$model->unsetAttributes();
		if (isset($_GET['CmsUsuario'])){
			$model->setAttributes($_GET['CmsUsuario']);
                }
		$this->render('admin', array('model' => $model));
	}

}