<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
        private $_id;
        private $sesion;
        
	public function authenticate($site = false, $red = "correo")
	{       
            //login serveces debtors
            if(!$site){
                $users = ViewDebtors::model()->find('code=:code and idTypeDocument=:user', array(':user'=> $this->password,':code'=>$this->username));                
            //login front optional
            }else{
                //tabla de usuarios del front
                $users = ViewUsers::model()->find('email=:user or userName=:user', array(':user'=>$this->username));
            }
                        
            if ($users != null) {

                //$this->sesion = $this->checkSesion($users,$site);
                $this->sesion = false;
                
                if (!$this->sesion) {
                    //login cms
                    if (!$site) {                        
                        $this->_id = $users->code;
                        $name = ($users->idTypeDocument == 1) ? explode(' ', $users->name) : $users->name;
                        $this->username = $users->id;
                        $this->setState('title', ($users->idTypeDocument == 1) ? $name[0] : $name);
                        $this->setState('rol', 0);
                        $this->setState('idCoordinator', 0);
                        $this->setState('idPlan', 0);
                        $this->setState('call', 0);
                        $this->setState('sms', 0);
                        $this->setState('email', 0);
                        $this->setState('ml', 0);
                        $this->errorCode = self::ERROR_NONE;
                        //$this->storeSession();
                        //login front optional
                    } else {
                        if (($this->username != $users->userName) && ($this->username != $users->email)) {
                            $this->errorCode = self::ERROR_USERNAME_INVALID;
                        } elseif ($users->password != md5($this->password) && $red == "correo") {
                            $this->errorCode = self::ERROR_PASSWORD_INVALID;
                        } else if ($users->active == 0) {
                            $this->errorCode = "3";
                        } else {
                            if ((in_array($users->idProfile, Yii::app()->params['companies']))) {
                                $criteria = new CDbCriteria();
                                $criteria->join = ' JOIN tbl_plans_companies tpc ON t.id = tpc.idPlan AND tpc.active = 1 AND tpc.idCompany = ' . $users->id;
                                $plan = Plans::model()->find($criteria);
                            } else {
                                $plan = Plans::model()->findByPk($users->idPlan);
                            }
                            $this->_id = $users->id;
                            $this->username = $users->email;
                            $this->setState('title', $users->name);
                            $this->setState('rol', $users->idProfile);
                            $this->setState('idCoordinator', $users->idCoordinator);
                            $this->setState('idPlan', (($plan != null) ? $plan->id : $users->idPlan));
                            $this->setState('call', (($plan != null) ? $plan->call : (($users->idProfile == 1) ? 1 : 0)));
                            $this->setState('sms', (($plan != null) ? $plan->sms : (($users->idProfile == 1) ? 1 : 0)));
                            $this->setState('email', (($plan != null) ? $plan->email : (($users->idProfile == 1) ? 1 : 0)));
                            $this->setState('ml', (($plan != null) ? $plan->ml : (($users->idProfile == 1) ? 1 : 0)));
                            $this->errorCode = self::ERROR_NONE;
                            $this->storeSession($site);
                        }
                    }
                } else {
                    $this->errorCode = 5;
                }
            } else {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            
            return $this->errorCode;
	}
        
        public function getId() {
            return $this->_id;
        }
        
        private function checkSesion($users,$site){
            $return = true;
            $login_limit = 1;
            if($site){
               $model = Users::model()->findByPk($users->id);
            }else{
               $model = null; 
            }
                
            if($model != null){
                $countSession = count(json_decode($model->conc_login));
                if($model->conc_login == '' && ( $countSession == 0 && $countSession < $login_limit)){
                    $return = false;
                }else{
                    $logins = json_decode($model->conc_login);

                    foreach($logins as $key => $login){
                        if($login->time < time() - 120){
                            //this checks if the iterated login is greater than the current time -120seconds and if found to be true then the user is inactive
                            //then set this current login to null by using the below statement
                            //$logins[$key] = null; // or unset($logins[$key]) either should work;
                            unset($logins[$key]);
                        }
                    }
                    
                    $login_json = json_encode($logins);
                    $model->conc_login = $login_json;
                    $model->save(false);
                    //after iteration we check if the count of logins is still greater than the limit
                    if(count($logins) < $login_limit){
                        $return = false;                        
                    }
                }
            }            
            return $return;
        }
        
        private function storeSession($site){
            
            if($site){
                $model = Users::model()->findByPk($this->_id);
            }else{
                $model = null;
            }
            
            if($model != null){
                
//                $login_json = json_decode($active_sess->conc_login);
//                $login_json[] = [Yii::$app->session->getId() => Yii::$app->session->getId(), 'session_key' => Yii::$app->session->getId(), 'time' => time()];
//                $login_json = json_encode($login_json);
//                //print_r($login_json); exit;                
//                $active_sess->conc_login = $login_json;
//                $active_sess->save();

                $browser = get_browser(null, true);
                $userInfo = "Browser: ".$browser['parent']." / Platform: ".$browser['platform']." / Device: ".$browser['device_type']."";
                $command = Yii::app()->db->createCommand();
                $command->insert('tbl_users_session', array(
                    'idUser'=>$this->_id,
                    'ipAddress'=>$_SERVER['REMOTE_ADDR'],
                    'userAgent'=>$userInfo,
                ));
            }
        }
}