<?php

class DashboardController extends Controller {

    public function filters() {
        Yii::app()->getComponent("booster");
        return array(
            'accessControl',
            array(
                'application.filters.html.ECompressHtmlFilter',
                'gzip' => true,
                'doStripNewlines' => true,
                'actions' => '*'
            ),
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'login', 'error', 'recovery', 'recoverypassword', 'logout'),
                'users' => array('*'),
            ),
            array('allow',
                'expression' => 'Controller::validateAccess(array(),"",true)',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionUpdateTables() {
        $tables = Yii::app()->db->createCommand("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'")->queryAll();
        foreach ($tables as $value){
            $tabla = array_values($value);
            $columns = Yii::app()->db->createCommand("SHOW COLUMNS FROM `$tabla[0]`")->queryAll();
            foreach ($columns as $value2){
                $columna = array_values($value2);                    
                if($tabla[0] != 'usuario_notificacion'){                        
                    Yii::app()->db->createCommand("UPDATE `$tabla[0]` SET `$columna[0]` = REPLACE(`$columna[0]`, '/uploads/', '/plataforma/uploads/')")->execute();
                }
            }
        }
        echo "ejecutadas";
    }

    public function actionChangePass() {
        if (isset($_POST['ant'], $_POST['new']) && $this->validateCsrfTokenPost()) {
            $model = CmsUsuario::model()->findByPk(Yii::app()->user->getId());
            $passant = $model->contrasena;
            if (md5($_POST['ant']) == $passant) {
                $model->contrasena = md5($_POST['new']);
                if ($model->save()) {
                    echo "ok";
                } else {
                    echo Yii::t('app', "Error al cambiar contraseña, por favor intentelo de nuevo.");
                }
            } else {
                echo Yii::t('app', 'La contraseña anterior no coincide con la registrada en el sistema.');
            }
        } else {
            echo Yii::t('app', 'Contraseña anterior y nueva son necesarias para realizar esta operación.');
        }
    }

    public function actionIndex() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('dashboard/admin'));
        } else {
            $this->layout = 'main_login';
            $this->render('index');
        }
    }

    public function actionLogin() {
        //sleep(2);
        $model = new LoginForm;
        $message = array();
        if (isset($_POST['username']) && isset($_POST['password']) && $this->validateCsrfTokenPost()) {
            $model->username = $_POST['username'];
            $model->password = $_POST['password'];
            $model->site = false;
            if ($model->validate() && $model->login()) {
                $message['url'] = Yii::app()->user->returnUrl != "" ? $this->routeRemoveSub(Yii::app()->user->returnUrl, false, 'cms/dashboard/index') : 'cms/dashboard/index';
                $message['status'] = "ok";
                $message['message'] = Yii::t('app', "Ingreso Correcto");
            } else {
                $errorres = "";
                $message['status'] = "err";
                foreach ($model->getErrors() as $error) {
                    $errorres .= $error[0] . "<br/>";
                }
                $message['message'] = $errorres;
            }
        } else {
            $message['status'] = "err";
            $message['message'] = Yii::t('app', "Datos invalidos");
        }
        $this->responseJson($message);
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('index'));
    }

    public function actionAdmin() {
        $this->render('admin');
    }

    public function actionRecovery() {
        $this->layout = 'main_login';
        $this->render('recovery');
    }

    public function actionRecoveryPassword() {
        $data = "";
        if (isset($_POST['emailRecipient']) && $this->validateCsrfTokenPost()) {
            $model = CmsUsuario::model()->find("email='" . $_POST['emailRecipient'] . "'");
            if ($model != null) {
                $psw = $this->creaPassword();
                $model->contrasena = md5($psw);
                if ($model->save()) {
                    $subject = Yii::t('app', 'Nueva clave');
                    $bodyEmail = '<table width="632" border="0" align="center">
                          <tr>
                            <td height="522">
                                <table width="55%" border="0" align="center">
                                  <tr>
                                    <td>
                                        '.Yii::t('app', "Su email de ingreso").' :<br/>
                                        ' . $model->email . '<br/><br/>
                                        '.Yii::t('app', "Su nueva clave es la siguiente").':<br/><br/>
                                        <h2>' . $psw . '</h2><br/>
                                        '.Yii::t('app', "Haga clic en el siguiente enlace para ingresar al CMS").'<br>
                                        <a href="' . $this->createAbsoluteUrl('cms/index') . '" target="_blank">' . $this->createAbsoluteUrl('cms/index') . '</a><br/><br/>
                                        '.Yii::t('app', "Si pierde u olvida esta clave,<br/>puede solicitar una nueva repetiendo<br/>este mismo proceso").'.
                                        <br><br>
                                        '.Yii::t('app', "Cordialmente").',<br/>Staff <a href="http://www.cojunal.com" target="_blank">cojunal.com</a>
                                        <br><br>
                                      </td>
                                  </tr>
                                </table>
                            </td>
                          </tr>
                        </table>';
                    if ($this->sendMail(array($model->email => $model->nombres . ' ' . $model->apellidos), $subject, $bodyEmail)) {
                        $data = "ok";
                    }
                } else {
                    $data = Yii::t('app', "Ha ocurrido un error al restaurar la clave, por favor intentelo de nuevo");
                }
            } else {
                $data = Yii::t('app', "El email que ha ingresado no está autorizado o no está bien escrito... verifique por favor");
            }
        } else {
            $data = Yii::t('app', "Datos invalidos");
        }
        echo $data;
    }

    public function actionSortTables() {
        if (isset($_POST['items'], $_POST['table'], $_POST['field']) && is_array($_POST['items']) && $_POST['table'] != "" && $_POST['field'] != "") {
            $i = 0;
            $message = array();
            $message['status'] = "ok";
            foreach ($_POST['items'] as $item) {
                $model = $_POST['table']::model()->findByPk($item);
                $model->setAttribute($_POST['field'], $i);
                if (!$model->save()) {
                    $message['status'] = "err";
                    $message['result'][] = $model->getErrors();
                }
                $i++;
            }
            $this->responseJson($message);
        }
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
