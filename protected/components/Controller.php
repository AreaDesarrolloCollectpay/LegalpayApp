<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    
    public $themeFront = "front";
    
    public $isLogin = false;
    
    public $isMobile = false;
    
    public $isPay = false;
    
    public $deviceSessionId = '';
    
    
    public function init() {
        parent::init();
        $isMobile = Yii::app()->mobileDetect;
        $this->isMobile = $isMobile->isMobile();         
    }

    /**
     * @param array $emails
     * @param string $subject
     * @param string $mensaje
     * @param string $nombrecorreo
     * @param array $emailsCC
     * @param array $attachment
     * @return boolean
     */
    public function sendMail($emails, $subject, $mensaje, $nombrecorreo = "", $emailsCC = array(), $attachment = array(), $template = true) {
        Yii::log("Entre a sendmail", "error");
        $this->newSendGirdMail($emails,$subject,$mensaje);
    }

    public function getFilterMenu(){
        if (Yii::app()->user->getState('rol') > 1){
            return " AND idcmsmenu IN (SELECT m.idcmsmenu FROM cms_menu m JOIN cms_permission_rol r ON SUBSTRING_INDEX(m.url, '/', 1) = r.controller AND SUBSTRING_INDEX(SUBSTRING_INDEX(m.url, '/', 2), '/', -1) = r.action)";
        }else{
            return "";
        }
    }
    
    public function routeRemoveSub($url, $isRoute = true, $urlDefault = "site/index"){
        $base = Yii::app()->request->baseUrl;
        $url = str_replace(($isRoute ? $base : $base .'/'), '', $url);
        if($url == ""){
            return $urlDefault; 
        }else{
           return $url; 
        }
    }
    /**
     * 
     * @param array $actionsDeny
     * @param string $actionValidate
     * @return boolean
     */    
    public static function validateAccess($actionsDeny = array(), $actionValidate = "", $redirect = false) {
        $controllerId = Yii::app()->controller->id;
        $actionId = Yii::app()->controller->action->id;
        if (Yii::app()->user->isGuest) {
            if($redirect){
                Yii::app()->controller->redirect(Yii::app()->user->loginUrl);
                return false;
            }else{
                return false;
            }
        }else
        //deny actions
        if ($actionValidate == "" && $actionsDeny != array() && in_array($actionId, $actionsDeny)) {
            return false;
        }else
        //super usuario
        if (Yii::app()->user->getState('rol') == 1) {
            return true;
        }
        //valida la acción si es pemitida o no estatica, falta validar con base de datos
        elseif ($actionValidate != "" && in_array($actionValidate, $actionsDeny)) {
            return false;
        }
        //database
        elseif (CmsPermissionRol::model()->count('cms_rol_id=:rol AND controller=:controller AND action=:action', array(':rol' => Yii::app()->user->getState('rol'), ':action' => $actionId, ':controller' => $controllerId)) > 0) {
            return true;
        } else {
            //******Acciones y Controladores estaticas para los administradores y editor*******
            //controladores no permitidos para el usuario administrador(2)
            $denyAdmin = array('cmsMenu', 'cmsUsuario', 'cmsConfiguracion', 'cmsRol');
            //controladores y acciones permitidas para el rol 3
            $allowRol = 3;
            //controladores
            $allowController = array('test');
            //acciones permitidas para todos los controladores con rol 3
            $allowActions = array('view', 'create', 'update', 'delete', 'admin');
            if (Yii::app()->user->getState('rol') == 2 && in_array($controllerId, $denyAdmin)) {
                return false;
            } elseif (Yii::app()->user->getState('rol') == 2) {
                return true;
            }else
            //si es el usuario administrador(2) y tiene denegada estas operaciones
            if (Yii::app()->user->getState('rol') == $allowRol && in_array($controllerId, $allowController) && in_array($actionId, $allowActions)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 
     * @return boolean
     * @throws CHttpException
     */
    protected function validateCsrfTokenPost() {
        if (!isset($_POST['YII_CSRF_TOKEN'])) {
            throw new CHttpException(400, Yii::t('err', 'Token no válido.'));
        } elseif ($_POST['YII_CSRF_TOKEN'] != Yii::app()->request->csrfToken) {
            throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
        } else {
            return true;
        }
    }

    /**
     * 
     * @return string
     */
    public function creaPassword($caracteres = 7) {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789@#$?";
        srand((double) microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= $caracteres) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    /**
     * 
     * @return type
     */
    public function getLocationInfoByIp() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];
        $result = "";
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if ($ip_data && $ip_data->geoplugin_countryName != null) {
            $result = $ip_data->geoplugin_countryCode;
            //$result['city'] = $ip_data->geoplugin_city;
        }
        return $result;
    }

    /**
     * 
     * @param type $id
     * @return string
     */
    public function submenus($id) {
        $menus = "";
        $modelmenu = CmsMenu::model()->findAll(array('order' => 'orden', 'condition' => "visible = 1 and cms_menu_id=$id".$this->getFilterMenu()));
        foreach ($modelmenu as $value):
            $submenu2 = CmsMenu::model()->find('visible = 1 and cms_menu_id=' . $value->idcmsmenu.$this->getFilterMenu());
            if ($submenu2 == null):
                $menus .= '<li><a menu="' . substr($value->url, 0, strlen($value->url) - strlen(strstr($value->url, "/"))) . '" href="' . $this->createUrl($value->url) . '"> <i class="' . $value->icono . '"></i> ' . $value->titulo . '</a></li>
                              <li class="nav-divider"></li>';
            else:
                $menus .= '<li class="dropdown-submenu">
                                <a menu="' . substr($value->url, 0, strlen($value->url) - strlen(strstr($value->url, "/"))) . '" href="' . $this->createUrl($value->url) . '"> <i class="' . $value->icono . '"></i> ' . $value->titulo . '</a>
                                <ul class="dropdown-menu"> 
                                ' . $this->submenus($value->idcmsmenu) . '
                                </ul>
                              </li><li class="nav-divider"></li>';
            endif;
        endforeach;
        return $menus;
    }

    public static function calculaFecha($minutos) {
        $message = "";
        switch ($minutos) {
            case ($minutos == 1):
                $message = Yii::t('front', '1 Minuto');
                break;
            case ($minutos < 60):
                $message = $minutos . " " . Yii::t('front', 'Minutos');
                break;
            case ($minutos <= 120):
                $message = "1 " . Yii::t('front', 'Hora');
                break;
            case ($minutos > 120 && $minutos <= 1440 ):
                $message = round($minutos / 60) . " " . Yii::t('front', 'Horas');
                break;
            case ($minutos > 1440 && $minutos <= 2880 ):
                $message = '1 ' . Yii::t('front', 'Día');
                break;
            case ($minutos > 2880 && $minutos <= 43200 ):
                $message = round(($minutos / 60) / 24) . " " . Yii::t('front', 'Días');
                break;
            case ($minutos > 43200 && $minutos <= 86400 ):
                $message = "1 " . Yii::t('front', 'Mes');
            case ($minutos > 43200 && $minutos <= 518400 ):
                $message = round((($minutos / 60) / 24) / 30) . " " . Yii::t('front', 'Meses');
                break;
            case ($minutos > 518400 && $minutos <= 1036800 ):
                $message = '1 ' . Yii::t('front', 'Año');
                break;
            case ($minutos > 1036800 ):
                $message = round(((($minutos / 60) / 24) / 30) / 12) . " " . Yii::t('front', 'Años');
                break;
        }
        return Yii::t('front', 'Hace ') . $message;
    }
    
    public static function getMinsFecha($fecha){
        $fechaAct= date("Y-m-d H:i:s");
        $minutos = (strtotime($fecha)-strtotime($fechaAct))/60;
        $minutos = abs($minutos); 
        $minutos = floor($minutos);
        return $minutos;
    }

    public function siteEncodeURL($variable) {
        return base64_encode(str_rot13($variable));
    }

    public function siteDecodeURL($variable) {
        return str_rot13(base64_decode($variable));
    }

    public function setLanguageApp() {
        $session = Yii::app()->session;
        if ((!isset($session['idioma']) && $session['idioma'] == "") || (isset($session['idioma']) && !is_numeric($session['idioma'])) || !isset($session['idioma']) || $session['idioma'] == "") {
            $session['idioma'] = 1;
        }
        if ($session['idioma'] == "1") {
            Yii::app()->language = "es";
        } else {
            Yii::app()->language = "en";
        }
    }

    public function slugUrl($string, $separator = "-") {
        $string = trim($string);
        $string =  mb_strtolower($string, 'UTF-8');
        $string = str_replace("ñ", "n", $string);
        $search = explode(",", "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ñ,Á,É,Í,Ó,Ú,Ñ");
        $replace = explode(",", "c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,n,A,E,I,O,U,N");
        $string = str_replace($search, $replace, $string);
        $string = preg_replace("/[^a-zA-Z0-9 -]/", "", $string);
        $string = preg_replace('!\s+!', ' ', $string);
        $string = str_replace(" ", $separator, $string);
        return $string;
    }

    public function getFileProtected($file, $downloadfile = false) {
        ob_clean();
        $file = $this->routeRemoveSub(Yii::getPathOfAlias('webroot')) . $file;
        //$file = Yii::getPathOfAlias('webroot') . $file;
        if (!file_exists($file)) {
            return "";
        }
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers 
        header("Content-Type: " . mime_content_type($file));
        if ($downloadfile) {
            header("Content-Disposition: attachment; filename=\"" . urldecode(substr(strrchr($file, '/'), 1)) . "\";");
        }
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($file));
        readfile($file);
        Yii::app()->end();
    }

    public function parseProtectedImageUrl($urlFile, $controller = "") {
        if ($controller == "") {
            $controller = Yii::app()->controller->id;
        }
        $urlFile = trim(CHtml::encode($urlFile));
        if ($urlFile == "") {
            return Yii::app()->request->baseUrl . "/img/no_image.gif";
        }
        if (strpos($urlFile, 'http://') !== false || strpos($urlFile, 'https://') !== false) {
            return $urlFile;
        } else {
            return $this->createUrl("$controller/getImage", array('id' => $this->siteEncodeURL($urlFile)));
        }
    }

    public function parseProtectedFileUrl($urlFile, $controller = "") {
        if ($controller == "") {
            $controller = Yii::app()->controller->id;
        }
        $urlFile = trim(CHtml::encode($urlFile));
        if ($urlFile == "") {
            return "";
        }
        if (strpos($urlFile, 'http://') !== false || strpos($urlFile, 'https://') !== false) {
            return $urlFile;
        } else {
            return $this->createUrl("$controller/getFile", array('id' => $this->siteEncodeURL($urlFile)));
        }
    }
    
    public function sendMailSendGrid($emails, $subject, $mensaje, $nombrecorreo = "", $emailsCC = array(), $attachment = array()) {
        // Enviamos el mensaje
        $this->newSendGirdMail($emails,$subject,$mensaje);    
        
    }

    public function sendMailMandrill($emails, $subject, $mensaje, $nombrecorreo = "", $emailsCC = array(), $attachment = array()) {
        // Enviamos el mensaje
        $this->newSendGirdMail($emails,$subject,$mensaje);  
    }
        
    public function validateUserFront($captcha,$user, $pass, $remember = 0,$site = true, $social = "correo") {
        $model = new LoginForm;
        $model->username = $user;
        $model->password = $pass;
        $model->captcha = $captcha;
        $model->site = $site;
        $model->social = $social;
        $model->rememberMe = $remember;
        $resp = "";
        if($social == 'correo'){
            $model->setScenario('captcha');            
        }
                
        // validate user input and redirect to the previous page if valid
        if ($model->validate() && $model->login()) {
            $resp = "success";
        } else {
            foreach ($model->getErrors() as $error) {
                $resp .= $error[0] . "<br/>";
            }
        }
        return $resp;
    }
    
    public function validateUserServicesFront($captcha,$user, $pass, $remember = 0,$site = true,$terms , $social = "correo") {
        $model = new LoginServicesForm;
        $model->username = $user;
        $model->password = $pass;
        $model->captcha = $captcha;
        $model->site = $site;
        $model->terms = $terms;
        $model->social = $social;
        $model->rememberMe = $remember;
        $resp = "";        
        // validate user input and redirect to the previous page if valid
        if ($model->validate() && $model->login()) {
            $resp = "success";
        } else {
            foreach ($model->getErrors() as $error) {
                $resp .= $error[0] . "<br/>";
            }
        }
        return $resp;
    }
    
    /**
     * HybridAuth
     * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
     * (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
     * HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
     * 
     * @return array()
     */
    public function configSocial($url){
        return array(
		"base_url" => $url, 
		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"AOL"  => array ( 
				"enabled" => false 
			),

			"Yahoo" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ),
                                "scope"   => "email, user_about_me, user_birthday, user_hometown", // optional
                                "display" => "popup"
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			// windows live
			"Live" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"MySpace" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => ""
	);
    }
    
    public function createUrlFront($url){
        return Yii::app()->request->baseUrl . (substr($url,0,1) == "/" ? "" :"/") . $url;
    }
    
    public function responseJson($data){
        header('Content-type: application/json');
        echo CJSON::encode($data);
    }
    
    public function validAccessAuthRest(){
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : "";
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : "";
        $access = CmsConfiguracion::model()->find(array('select'=>'user_restful, password_restful'));
        if($access->user_restful == $user && $access->password_restful == $password){
            return true;
        }else{
            return false;
        }
    }

    public function actionLogout() {
        Yii::app()->homeUrl = Yii::app()->homeUrl . "iniciar-sesion";
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function newSendGirdMail($emails,$subject,$mensaje, $mailFrom="", $emailsCC = array(), $attachment = array()){
        try { 
            $model = CmsConfiguracion::model()->findByPk(1);
            
            if($mailFrom==""){
                $mailFrom = $model->username;
                $fromName = $model->nombre_correo;
                Yii::log($mailFrom,"warning","mailFrom");

            }else {
                $mailFrom = $mailFrom;
                $fromName = "Generic Mail";
                Yii::log($mailFrom,"warning","mailFrom");
            }

            $message = Yii::app()->sendgrid->createEmail();            

            if (is_array($emails)) {
                foreach ($emails as $key => $email) {
                    Yii::log($email,"warning","email");
                    $message->addTo($email);
                }
            }else {
                Yii::log($email,"warning","email");
                $message->addTo($emails);
            }
            
            if ($emailsCC != array() && is_array($emailsCC)) {
                foreach ($emailsCC as $email => $name) {
                    $message->addCc($email);
                }
            }            
            
            if ($attachment != array() && is_array($attachment)) {
                foreach ($attachment as $value) {
                    $message->addAttachment($value);
                }
            }
            
            $message->setHtml(str_replace("__content__", $mensaje, $model->plantilla))
                //->addTo('bar@foo.com') //One of the most notable changes is how `addTo()` behaves. We are now using our Web API parameters instead of the X-SMTPAPI header. What this means is that if you call `addTo()` multiple times for an email, **ONE** email will be sent with each email address visible to everyone.
                //->addTo("manuelramirezr@gmail.com")
                ->setFrom($mailFrom) 
                ->setFromName($fromName)
                ->setSubject($subject);

            Yii::app()->sendgrid->send($message);

            return true;
            
        } catch (Exception $e) {
            Yii::log("Mail Exception : " . print_r($e->getMessage(),true), "error", "newSendGirdMail");
            return false;
        }     

    }
    
    
    public function SendGridMail($to,$name,$subject,$mensaje){
        
        $return = false;
        
        require "protected/extensions/sendgrid-php-master/sendgrid-php.php";
//         
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("account-noreply@collectpay.co", "COLLECT PAY");
        $email->setSubject($subject);
        $email->addTo($to, $name);
        $email->addContent(
            "text/html", $mensaje
        );
        $sendgrid = new \SendGrid('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');
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";            
            if($response->statusCode() == 200 || $response->statusCode() == 202){
                $return = true;
            }            
            //print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            $return = false;
        }
        return $return;
    }
    
    public function SendGridMail_old($to,$subject,$mensaje){
        try { 
            
            $message = Yii::app()->sendgrid->createEmail();
            $message->setHtml($mensaje);
            //$message->addTo($to);
            //$message->setFrom(Yii::app()->params['adminEmail']);
            $message->setFromName(Yii::app()->params['nameEmail']);
            //$message->setSubject($subject);
            
            $message  
	->setSubject($subject)  
	->addTo($to)
	->setFrom(Yii::app()->params['adminEmail']);  
            
            
            //Yii::app()->sendgrid->send($message);

            if(!Yii::app()->sendgrid->send($message))
            {
              print_r(Yii::app()->sendgrid->lastErrors);
              echo 'si';
              exit;
            }
            return true;
            
        } catch (Exception $e) {
            Yii::log("Mail Exception : " . print_r($e->getMessage(),true), "error", "newSendGirdMail");
            return false;
        }     

    }
    
    public function getInitials($name = "") {

        $nameSeparete = explode(" ", $name);
        
        switch (count($nameSeparete)) {
            case 1:
                $iniciales = substr($name, 0, 1) . substr($name, 1, 1);
                break;
            case 3 :
                $iniciales = substr($nameSeparete[0], 0, 1) . substr($nameSeparete[2], 0, 1);
                break;
            default:
                $iniciales = substr($nameSeparete[0], 0, 1) . substr($nameSeparete[1], 0, 1);
                break;
        }


        return $iniciales;
    }
    
    public function buildTree(Array $data, $parent = 0) {
        $tree = array();
        foreach ($data as $d) {
            if ($d['parent'] == $parent) {
                $children = $this->buildTree($data, $d['id']);
                // set a trivial key
                if (!empty($children)) {
                    $d['_children'] = $children;
                }
                $tree[] = $d;
            }
        }
        return $tree;
    }
    
    public function printTree($tree, $r = 1, $p = null,$selected = null, $html = '') {
        foreach ($tree as $i => $t) {
            $dash = ($t['parent'] == 0) ? '' : str_repeat('-', $r) .' ';
            $oSelected = ($selected != NULL)? ($selected == $t['id'])? 'selected' : '' : ''; 
            //printf("\t<option value='%d' ".$oSelected." data-level='".$r."'>%s%s</option>\n", $t['id'], $dash, $t['name']);
            
            $html .= "<option value='".$t['id']."' ".$oSelected." data-level='".$r."'>".$t['name']."</option>";
            
            if ($t['parent'] == $p) {
                // reset $r
                $r = 1;
            }
            if (isset($t['_children'])) {
                $this->printTree($t['_children'], $r+1, $t['parent'],$selected,$html);
            }
        }
        return $html;
    }
    
    public function getMenu(){
        $menu = '';
        
        if(!Yii::app()->user->isGuest){
            
           $criteria = new CDbCriteria();
           $join = 'JOIN tbl_menu_users_profile tmup ON t.id = tmup.idMenu';
           $mCondition = 'IS NULL';
           $condition = 'tmup.active = 1 AND t.idMenu _menu_ AND tmup.idUserProfile = '.Yii::app()->user->getState('rol');
           
            if(!(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers'])))){
                if(in_array(Yii::app()->user->getState('idPlan'), Yii::app()->params['plans'])){
                    $condition .= ($condition != '')? ' AND' : '';
                    $condition .= ' tmup.idPlan = '.Yii::app()->user->getState('idPlan');
                }else{                 
                }
            }
            
            $criteria->join = $join;
            $criteria->condition = str_replace('_menu_', $mCondition, $condition);
            $criteria->order = 'tmup.order ASC';    
//            $criteria->group = 't.id';
            
            if(Yii::app()->user->getId() == 215){
                
//                print_r($criteria);
//                exit;
            }
//            print_r($criteria);
//            exit;
            //$menuUser = Menu::model()->with('menuUsersProfiles')->findAll(array('condition' => 'menuUsersProfiles.idUserProfile = '.Yii::app()->user->getState('rol'). ' ','order' => 'menuUsersProfiles.order ASC'));
            $menuUser = Menu::model()->findAll($criteria);
            
            foreach ($menuUser as $model){
                
                $mCondition = '='.$model->id;                
                $criteria->condition = str_replace('_menu_', $mCondition, $condition);
                $criteria->order = NULL;
                $criteria->group = NULL;
                $subItems = Menu::model()->count($criteria);
                //with('menuUsersProfiles')->findAll(array('condition' => 'menuUsersProfiles.idUserProfile = '.Yii::app()->user->getState('rol'). ' AND menuUsersProfiles.active = 1 AND t.idMenu ='.$model->id,'order' => 'menuUsersProfiles.order ASC'))
                if($subItems != null && $subItems > 0){
                    $menu .= $this->renderPartial("/layouts/partials/item-submenu",array('model' => $model,'criteria' => $criteria),true);                    
                }else{
                    $menu .= $this->renderPartial("/layouts/partials/item-menu",array('model' => $model),true);                    
                }
                
            }
        }
        
        return $menu;
    }
    
    public function getMenuServices(){
        $menu = '';
        
        if(!Yii::app()->user->isGuest){
           
            $menuUser = Menu::model()->findAll(array('condition' => 'id IN(8,15,16)','order' => 'id DESC'));
            foreach ($menuUser as $model){
                $menu .= $this->renderPartial("/layouts/partials/item-menu",array('model' => $model),true);
            }
        }
        
        return $menu;
    }
    
    public function GetProduct($creditModality = 0){
        $quadrants = null;
        
        if(!Yii::app()->user->isGuest){
            
            if(Yii::app()->user->getState('rol') == 1){
                $quadrants = Yii::app()->db->createCommand("CALL `getProductAdmin`(".$creditModality.")")->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);  
            }elseif(Yii::app()->user->getState('rol') == 7){
                $quadrants = Yii::app()->db->createCommand("CALL `getProductCustomer`(".$creditModality.",".Yii::app()->user->getId().")")->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);                  
            }else{
                $idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();                
                $quadrants = Yii::app()->db->createCommand("CALL `getProductCoordinator`(".$creditModality.",".$idCoordinator.")")->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);                
            }
            
        }
        
        return $quadrants;
        
    }
    
    public function GetAgeDebt($region = 0, $ageDebt = 0){
        
        $select = 'IFNULL(SUM(t.capital),0) as capital, COUNT(t.id) as cant';
        $join = '';
        
        $criteria = new CDbCriteria();
        $condition = '';
        
        if(isset($region) && $region != 0){
            $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion = '.$region;          
        }
        
        if(isset($ageDebt)){
            
            if($ageDebt > 0 &&  $ageDebt <= 4){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.ageDebt = '.$ageDebt.' AND t.is_legal = 0';              
            }elseif($ageDebt == 5 ){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.is_legal = 1';                            
            }elseif($ageDebt == 0 ){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.is_legal = 0';                            
            }
            
        }
        
        if(!Yii::app()->user->isGuest){
            
            if(Yii::app()->user->getState('rol') == 7){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomers = '.Yii::app()->user->getId();
            }
            if(Yii::app()->user->getState('rol') == 11){
                $join .= ' JOIN tbl_users tu ON t.idCustomers = tu.id';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'tu.idCompany = '.Yii::app()->user->getId();
            }
            if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))){
                $idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();                
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.idDebtor = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $idCoordinator;                                
            }
            
        }
        
        $criteria->select = $select;
        $criteria->condition = $condition;
        $criteria->join = $join;        
        //$criteria->group = 't.id';
                        
        $quadrants = ViewDebtors::model()->find($criteria);
        
        return $quadrants;
        
    }
    
    public function GetInvestigation($region = 0, $ageDebt = 0){
        
        $select = 'IFNULL(SUM(vdc.capital),0) as capital, COUNT(t.id) as cant';
        $join = ' JOIN tbl_debtors_state tds ON t.idDebtorsState = tds.id AND tds. historic = 0 AND tds.idDebtorsState IS NULL
                  JOIN view_debtors_capital vdc ON t.id = vdc.idDebtor
                  JOIN view_check_demographics vcd ON t.id = vcd.idDebtor AND vcd.cant = 0';
        $criteria = new CDbCriteria();
        $condition = '';
        
        if(isset($region) && $region != 0){
            $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion = '.$region;          
        }
        
        if(isset($ageDebt)){            
            if($ageDebt > 0 &&  $ageDebt <= 4){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'vdc.ageDebt = '.$ageDebt.' AND t.is_legal = 0';              
            }elseif($ageDebt == 5 ){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' t.is_legal = 1';                            
            }            
        }
        
        if(!Yii::app()->user->isGuest){
            
            if(Yii::app()->user->getState('rol') == 7){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomers = '.Yii::app()->user->getId();
            }
            if(Yii::app()->user->getState('rol') == 11){
                $join .= ' JOIN tbl_users tu ON t.idCustomers = tu.id';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'tu.idCompany = '.Yii::app()->user->getId();
            }            
            if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))){
                $idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();                
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.id = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $idCoordinator;                                
            }
            
        }
        
        $criteria->select = $select;
        $criteria->condition = $condition;
        $criteria->join = $join;
        //$criteria->group = 't.id';
                
        $quadrants = Debtors::model()->find($criteria);
        
        return $quadrants;
        
    }
    
    public function GetAgeDebt_($creditModality = 0, $ageDebt = 0){
        
        $select = 'IFNULL(SUM(vdc.capital),0) as capital, COUNT(t.id) as cant';
        $join = ' JOIN tbl_debtors_state tds ON t.idDebtorsState = tds.id AND tds. historic = 0 AND tds.idDebtorsState IS NULL
                  JOIN view_debtors_capital vdc ON t.id = vdc.idDebtor';
        $criteria = new CDbCriteria();
        $condition = '';
        
        if(isset($creditModality) && $creditModality != 0){
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 't.idCreditModality = '.$creditModality;              
        }
        
        if(isset($ageDebt)){
            
            if($ageDebt > 0 &&  $ageDebt <= 4){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 'vdc.ageDebt = '.$ageDebt;              
            }elseif($ageDebt == 5 ){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' t.is_legal = 1';                            
            }
            
        }
        
        if(!Yii::app()->user->isGuest){
            
            if(Yii::app()->user->getState('rol') == 7){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomers = '.Yii::app()->user->getId();
            }elseif(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))){
                $idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();                
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.id = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $idCoordinator;                                
            }
            
        }
        
        $criteria->select = $select;
        $criteria->condition = $condition;
        $criteria->join = $join;
        //$criteria->group = 't.id';
                
        $quadrants = Debtors::model()->find($criteria);
        
        return $quadrants;
        
    }
    
    
    public function GetRegionDebt($region = 0){
        
        $select = 'IFNULL(SUM(vdc.capital),0) as capital, COUNT(t.id) as cant';
        $join = ' JOIN tbl_debtors_state tds ON t.idDebtorsState = tds.id AND tds. historic = 0 AND tds.idDebtorsState IS NULL';
        
        if($region != 0){
            $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion = '.$region;
        }
        $join .= ' JOIN view_debtors_capital vdc ON t.id = vdc.idDebtor';
        
        $criteria = new CDbCriteria();
        $condition = '';
                
        if(!Yii::app()->user->isGuest){
            
            if(Yii::app()->user->getState('rol') == 7){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomers = '.Yii::app()->user->getId();
            }elseif(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))){
                $idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();                
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.id = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $idCoordinator;                                
            }
            
        }
        
        $criteria->select = $select;
        $criteria->condition = $condition;
        $criteria->join = $join;
        //$criteria->group = 't.id';
                
        $quadrants = Debtors::model()->find($criteria);
        
        return $quadrants;
        
    }
    
    public function GetClusterDebt($cluster = 0){
        
        $select = 'IFNULL(SUM(vdc.capital),0) as capital, COUNT(t.id) as cant';
        $join = ' JOIN tbl_debtors_state tds ON t.idDebtorsState = tds.id AND tds. historic = 0 AND tds.idDebtorsState IS NULL';
        
        $join .= ' JOIN view_debtors_capital vdc ON t.id = vdc.idDebtor';
        
        if($cluster != 0){
            $join .= ' JOIN tbl_debtors_obligations_clusters tdoc ON vdc.id = tdoc.idDebtorObligation 
                       JOIN tbl_clusters tc ON tdoc.idCluster = tc.id AND tc.idMLModel = '.$cluster;
            //$join .= ' JOIN   ON t.idCity = vl.idCity AND vl.idRegion = '.$region;
        }
        
        $criteria = new CDbCriteria();
        $condition = '';
                
        if(!Yii::app()->user->isGuest){
            
            if(Yii::app()->user->getState('rol') == 7){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomers = '.Yii::app()->user->getId();
            }elseif(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))){
                $idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();                
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.id = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $idCoordinator;                                
            }
            
        }
        
        $criteria->select = $select;
        $criteria->condition = $condition;
        $criteria->join = $join;
        //$criteria->group = 't.id';
                
        $quadrants = Debtors::model()->find($criteria);
        
        return $quadrants;
        
    }
    
    public function GetAgeState($region = 0, $state = 0){
        $select = 'IFNULL(SUM(vdc.capital),0) as capital, COUNT(t.id) as cant';
        $join = ' JOIN tbl_debtors_state tds ON t.idDebtorsState = tds.id AND tds. historic = 0 AND tds.idDebtorsState IS NULL';
        
        if($region != 0){
            $join .= ' JOIN view_location vl ON t.idCity = vl.idCity AND vl.idRegion = '.$region;
        }
        $join .= ' JOIN view_debtors_capital vdc ON t.id = vdc.idDebtor';
        
        $criteria = new CDbCriteria();
        $condition = '';
                
        if(!Yii::app()->user->isGuest){
            
            if(Yii::app()->user->getState('rol') == 7){
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= 't.idCustomers = '.Yii::app()->user->getId();
            }elseif(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))){
                $idCoordinator = (Yii::app()->user->getState('idCoordinator') != '' && in_array(Yii::app()->user->getState('rol'), Yii::app()->params['advisers']))? Yii::app()->user->getState('idCoordinator') : Yii::app()->user->getId();                
                $join .= ' JOIN tbl_campaigns_debtors cd ON t.id = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
                $condition .= ($condition != '') ? ' AND ' : '';
                $condition .= ' cc.idCoordinator = ';
                $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $idCoordinator;                                
            }
            
        }
        
        $condition .= ($condition != '') ? ' AND ' : '';
        $condition .= ' t.idDebtorsState = '.$state;
        
        $criteria->select = $select;
        $criteria->condition = $condition;
        $criteria->join = $join;
        //$criteria->group = 't.id';
                
        $quadrants = Debtors::model()->find($criteria);
        
        return $quadrants;
        
    }
    
    public function viewSupport($file){
         $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'type' => '',
            'file' => '',
            );
         $image = array('gif','jpg','jpeg','png','tiff');
         
         if($file != ''){
         
             $extension  = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION));
             
             if($extension != ''){
                 $return['msg'] = 'ok';
                 $return['status'] = 'success';
                 $return['type'] = (!in_array($extension, $image))? 1 : 2;                 
                 $return['file'] = $file;                 
                
             }else{
                $return['msg'] = Yii::t('front', 'No extesion');                 
             }
             
         }        
                 
         return $return;
        
    }
    
    public function usersTerms(){
         $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'show' => false,
            );
                  
         if(!Yii::app()->user->isGuest){
         
             $model  = Users::model()->findByPk(Yii::app()->user->getId());
             
             if($model != null){
                 
                 if($model->require_ckeck_terms  == 1 && $model->check_terms == 0 ){
                     $return['status'] = 'success';
                     $return['msg'] = Yii::t('front', 'ok');
                     $return['show'] = true;
                 }
                
             }else{
                 $return['status'] = 'warning';
                 $return['msg'] = Yii::t('front', 'Usuario no localizado');
             }
                          
         }        
                 
         return $return;
        
    }
    
    
    public function getLocationDebtor($model){
         $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            );
         $address = '';
         $key = Yii::app()->params['keyMaps'];
                  
         if($model != null){            
            $address .= ($model->idCity0 != null)? str_replace(' ', '+', $model->idCity0->name).'' : '';
            //$address .= ($model->address != null && $model->address != '')? str_replace(' ', '+', $model->address) : '';            
            
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;
    
            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
            curl_setopt( $ch, CURLOPT_HEADER, 0 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

            $data = curl_exec( $ch );
            $data = json_decode($data);
            
            if(isset($data->status,$data->results[0]->geometry->location->lat, $data->results[0]->geometry->location->lng) && $data->status == 'OK'){
                $model->address_lat = $data->results[0]->geometry->location->lat;
                $model->address_lng = $data->results[0]->geometry->location->lng;                

                if($model->save(false)){
                     $return['status'] = 'success';
                     $return['msg'] = 'save';
                }else{ 
                     $return['msg'] = '';
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            }else{
                print_r($data);
                echo '<br>';
                echo $url;
                exit;
                $return['msg'] = '-'.'-'.$url;
            }
            
            curl_close( $ch );
         }        
                 
         return $return;
        
    }
    
    public function getLocationBusiness($model){
         $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            );
         $address = '';
         $key = Yii::app()->params['keyMaps'];
                  
         if($model != null){            
            $address .= ($model->idCity0 != null)? str_replace(' ', '+', $model->idCity0->name).',' : '';
            $address .= ($model->address != null && $model->address != '')? str_replace(' ', '+', $model->address) : '';            
            
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;
    
            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
            curl_setopt( $ch, CURLOPT_HEADER, 0 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

            $data = curl_exec( $ch );
            $data = json_decode($data);
            
            if(isset($data->status,$data->results[0]->geometry->location->lat, $data->results[0]->geometry->location->lng) && $data->status == 'OK'){
                $model->lat = $data->results[0]->geometry->location->lat;
                $model->lng = $data->results[0]->geometry->location->lng;                

                if($model->save(false)){
                     $return['status'] = 'success';
                     $return['msg'] = 'save';
                }else{ 
                     $return['msg'] = '';
                    foreach ($model->getErrors() as $error) {
                        $return['msg'] .= $error[0] . "<br/>";
                    }
                }
            }else{
                print_r($data);
                echo '<br>';
                echo $url;
                exit;
                $return['msg'] = '-'.'-'.$url;
            }
            
            curl_close( $ch );
         }        
                 
         return $return;
        
    }
    
    public function getLocationDebtorCron($params){
         $address = '';
                  
         if($params != null){    
            $location = str_replace(' ','',$params['location']);
            $location = str_replace('-', ',', $location);
            $address = $this->clean($params['address']);         
            $findMaps = $location.",".$address;
            $data = $this->getMarkerMaps($findMaps);
            if($data['status'] == "error"){
                $findMaps = $location;
                $data = $this->getMarkerMaps($findMaps);
            }
            $command = Yii::app()->db->createCommand();
            $command->update('tbl_debtors', array(
                        'address_lat' => $data['lat'],
                        'address_lng' => $data['lng'],
                    ), 'id=:id', array(':id'=>$params['id']));
            //echo "{'idDebtor':'".$params['id']."','position':'".$data['lat'].",".$data['lng']."'}"."<br>";          
         }        
        
    }
    
    public function getMarkerMaps($address){
        $key = Yii::app()->params['keyMaps'];
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;  
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        $data = curl_exec( $ch );
        $data = json_decode($data);
        $return = array("status" => "error", "lat" => "", "lng" => "");
        
        if(isset($data->status, $data->results[0]->geometry->location->lat, $data->results[0]->geometry->location->lng) && $data->status == 'OK'){       
            $return['status'] = "ok";
            $return['lat'] = $data->results[0]->geometry->location->lat;
            $return['lng'] = $data->results[0]->geometry->location->lng;
        }
        
        curl_close( $ch );
        
        return $return;
    }
    
    public function clean($string) {
        $string = str_replace(' ', '+', $string);
        return preg_replace('/[^A-Za-z0-9\+]/', '', $string);
    }
    
    
    public function getIndicators(){
        
        $join = 'JOIN tbl_debtors_state tds ON t.idDebtorsState = tds.id';
        $condition = 'tds.historic = 0';
        $indicators = NULL;
        
        $user = ViewUsers::model()->find(array('condition' => 'id =' . Yii::app()->user->getId()));
        
        if($user != NULL){
            
            if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers']))) {
               $join .= ' JOIN tbl_campaigns_debtors cd ON t.id = cd.idDebtor JOIN tbl_campaigns c ON cd.idCampaigns = c.id JOIN tbl_campaigns_coordinators cc ON cd.idCampaigns = cc.idCampaign';
               $condition .= ($condition != '') ? ' AND ' : '';
               $condition .= ' cc.idCoordinator = ';
               $condition .= ( in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])) ? Yii::app()->user->getId() : $user->idCoordinator;
           } elseif (Yii::app()->user->getState('rol') == 7) {
               $condition .= ($condition != '') ? ' AND ' : '';
               $condition .= 't.idCustomers = ' . Yii::app()->user->getId();
           }

           //indicators
           $criteriaIndicators = new CDbCriteria();
           $criteriaIndicators->select = '(SUM(vdc.capital)) as capital, COUNT(t.id) as cant';
           $criteriaIndicators->join = $join.' JOIN view_debtors_capital vdc ON t.id = vdc.idDebtor';
           $criteriaIndicators->condition = $condition;
           'JOIN view_debtors_obligations vdo ON t.id = vdo.id';
           //assigned           
           $assigned = Debtors::model()->find($criteriaIndicators);
           
           //recovered
           $criteriaIndicators->select = '(SUM(vdp.value)) as capital, COUNT(t.id) as cant';
           $criteriaIndicators->join = $join.' JOIN view_debtors_payments vdp ON t.id = vdp.idDebtor';
           $recovered = Debtors::model()->find($criteriaIndicators);
           
//           print_r($recovered);
//           exit;

           //estimated - agreement
           $criteriaIndicators->select = '(SUM(vda.value)) as capital, COUNT(t.id) as cant';
           $criteriaIndicators->join = $join.' JOIN view_debtors_agreements vda ON t.id = vda.idDebtor';
           $agreement = Debtors::model()->find($criteriaIndicators);

           $indicators = new Indicators();
           $indicators->assigned = ($assigned != null) ? $assigned->capital : 0;
           $indicators->countAssigned = ($assigned != null) ? $assigned->cant : 0;
           $indicators->credit = ($agreement != null) ? $agreement->capital : 0;
           $indicators->countCredit = ($agreement != null) ? $agreement->cant : 0;
           $indicators->pending = ($assigned != null && $recovered != null) ? ($assigned->capital - $recovered->capital) : 0;
           $indicators->recovered = ($recovered != null) ? $recovered->capital : 0;
           $indicators->countRecovered = ($recovered != null) ? $recovered->cant : 0;
           $indicators->pRecovered = ($recovered != null && $indicators->assigned > 0)? round((($indicators->recovered*100)/ $indicators->assigned),2) : 0;
        }
                
        return $indicators;
        
    }
           
    public static function createNotification($model,$typeNotification){
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
        );
        if($model != null){
            $idUser = 0; 
            $idDebtor = $model->idDebtor0->idDebtor;
            $notifications = new UsersNotifications();
            $notifications->idMessage = 2;
            $notifications->idCreator = Yii::app()->user->getId();
            $notifications->idUser = $model->idDebtor0->idDebtor0->idCustomers;
            $notifications->parameters = '{"-*idD*-":"'.$idDebtor.'","tbl":"tbl_debtors","params":"id,name"}';
            if($notifications->save(false)){
                $return['status'] = 'success';
                $return['msg'] = 'save';
                $idUser = $model->idDebtor0->idDebtor0->idCustomers;
                $user = Users::model()->findByPk($idUser);
                if($user->notification){
                    $typeN = NotificationsType::model()->findByPk($typeNotification);
                    $url = Yii::app()->getBaseUrl(true)."/wallet/debtor/".$model->idDebtor0->idDebtor0->id;
                    $htmlEmail = Yii::app()->controller->renderPartial('/notifications/email/notification_email', array('name' => $model->idDebtor0->idDebtor0->name,'title' => $typeN->name, 'url' => $url), true);
                    $subject = Yii::t('front',$typeN->name);
                    //Yii::app()->controller->SendGridMail("desarrollo@collectpay.co", $subject, $htmlEmail);
                    Yii::app()->controller->SendGridMail($user->email,$user->name, $subject, $htmlEmail);
                }
            }else{
                foreach ($notifications->getErrors() as $error) {
                    $return['msg'] .= $error[0] . "<br/>";
                }
            }
        }
        return $return;
    }
    
    public static function formatParams($params = array()){
         $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
        );
        if(is_array($params)){
            foreach($params as $key => $param){
                if(Controller::validateDate($param)){
                    $params[$key] = " ".date("d/m/Y", strtotime($param))." ";  
                }
                if(Controller::isCurrency($param)){
                    $params[$key] = " $".Yii::app()->format->formatNumber($param)." ";  
                }
            }
            $return = $params;
        }else{
            $return['msg'] = "Null";
        }
        return $return;
    }
    
    public static function uploadFile($file, $folder, $identificator = 0, $uploadPath = "/uploads", $del = true){
        $return = false;
        if ($file != '') {
            Yii::import('application.google.google.*');
            require_once("protected/google/autoload.php");

            $configuration = array(
                'login' => 'cojunal@cojunal-148320.iam.gserviceaccount.com',
                'key' => file_get_contents('assets/cojunal-5498ea4f2a1c.p12'),
                'scope' => 'https://www.googleapis.com/auth/devstorage.full_control',
                'project' => 'cojunal-148320',
                'storage' => array(
                    'url' => 'https://storage.googleapis.com/',
                    'prefix' => ''),
            );
            $bucket = 'cojunal-148320.appspot.com';
            Yii::log("GOOGLE => " . sys_get_temp_dir(), "warning", "create");

            //Upload del archivo
            $fname = @Controller::slugUrl($identificator . '-' . Date('d_m_Y_h_i_s')) . "." . $file->getExtensionName();

            $location = Yii::getPathOfAlias('webroot') . $uploadPath . $fname;
            $file->saveAs($location);
            //Subir archivo a bucket
            $credentials = new Google_Auth_AssertionCredentials($configuration['login'], $configuration['scope'], $configuration['key']);
            $client = new Google_Client();
            $client->setAssertionCredentials($credentials);
            if ($client->getAuth()->isAccessTokenExpired()) {
                $client->getAuth()->refreshTokenWithAssertion();
            }

            # Starting Webmaster Tools Service
            $storage = new Google_Service_Storage($client);

            $uploadDir = substr($uploadPath,1);
            $folder = ($folder != "") ? $folder : $uploadDir;
            
            $file_name = $folder . "/" . $fname;
            
            $obj = new Google_Service_Storage_StorageObject();
            $obj->setName($file_name);
            try {
                $storage->objects->insert(
                        "cojunal-148320.appspot.com", $obj, ['name' => $file_name, 'data' => file_get_contents($uploadDir . $fname), 'uploadType' => 'media', 'predefinedAcl' => 'publicRead']
                );
                if($del){
                    Yii::app()->controller->deleteFile($location);
                }
                $return = array();
                $return['filename'] = $configuration['storage']['url'] . $bucket . '/' . $file_name;
                $return['location'] = $location;
            } catch (Exception $e) {
                $return = false;
            }
        }
        
        return $return;
    }
    
    public function getFileDelimiter($file, $checkLines = 2){
	$file = new SplFileObject($file);
	$delimiters = array(
	  ',',
	  '\t',
	  ';',
	  '|',
	  ':'
	);
	$results = array();
	$i = 0;
	 while($file->valid() && $i <= $checkLines){
		$line = $file->fgets();
		foreach ($delimiters as $delimiter){
			$regExp = '/['.$delimiter.']/';
			$fields = preg_split($regExp, $line);
			if(count($fields) > 1){
				if(!empty($results[$delimiter])){
					$results[$delimiter]++;
				} else {
					$results[$delimiter] = 1;
				}   
			}
		}
	   $i++;
	}
	$results = array_keys($results, max($results));
	return $results[0];
    }
    
    public function deleteFile($file){
        if(file_exists($file)){
            unlink($file);
        }
    }
    
    public static function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    
    public static function isCurrency($number){
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }
    
    public static function unformatMoney($money){
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);
        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;
        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);
        return (float) str_replace(',', '.', $removedThousendSeparator);
    }
    public function getColorManagement($days){
        $color = '';
        
        if($days <= 7){
            $color = 'green';
        }elseif($days > 7 && $days <= 20){
            $color = 'orange';            
        }elseif($days > 20){
            $color = 'red';
        }
        
        return $color;
    }
    
    public function getAllianceManagementDebtor($idDebtor){
        $return = array('alliance' => '', 'image' => '');
        
        $debtor = ViewDebtors::model()->find(array('condition' => 'id = '.$idDebtor));
        if($debtor != null){            
        
            $criteria = new CDbCriteria();  
            $select = 't.name, t.image';
            $condition = 't.active = 1';
            $join = NULL;
            
            if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
                $join = 'JOIN tbl_campaigns_coordinators tcc ON t.id = tcc.idCoordinator AND tcc.active = 1
                         JOIN tbl_campaigns_debtors tcd ON tcc.idCampaign = tcd.idCampaigns AND tcd.active = 1';
            }else{
                $join = 'JOIN view_customers vc ON t.id = vc.idCompany AND vc.id ='.$debtor->idCustomer;
            }

            //$criteria->select = $select;
            $criteria->join = $join;
            $criteria->condition = $condition;                
            $model = Users::model()->find($criteria);
//            echo 'asdf9999';
//            print_r($model);  exit;
            if($model != null){            
                $return = array('alliance' => $model->name, 'image' => $model->image);            
            }
        }  
//        echo 'asdf'; exit;
        return $return;
    }
    
     public function lastManagement($date,$idDebtor){
        $return = array('status' => 'error','date' => Yii::t('front','SIN GESTIÓN'), 'color' => 'gray', 'alliance' => array('alliance' => '', 'image' => ''));
        $color = '';
        $criteria = new CDbCriteria();
        $criteria->select = '';
        $alliance = $this->getAllianceManagementDebtor($idDebtor);                
        if($date != null && $date != ''){            
            $model = Yii::app()->db->createCommand('SELECT timestampdiff(DAY,"'.$date.'",curdate()) as days')->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);

            if($model != null){
                $color = $this->getColorManagement($model->days);
            }            
        }
        
        $return = array('status' => 'success','alliance' => $alliance, 'date' => ($date != '')? Yii::app()->dateFormatter->format('dd/MM/yyyy', $date): 'SIN GESTIÓN', 'color' => $color);
        
        return $return;
    }
    
    public function lastManagementBusiness($idBusiness){
        $return = array('status' => 'error','date' => Yii::t('front','SIN GESTIÓN'), 'color' => 'gray');
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.date as date, timestampdiff(DAY,t.date,curdate()) as days';
        $criteria->join = 'JOIN view_business vb ON  vb.id = t.idUsersBusiness';
        $criteria->condition = 't.idUsersBusiness = '.$idBusiness;
        $criteria->order = 't.date DESC';
        
        $model = ViewManagementBusinessLast::model()->find($criteria);
        
        if($model != null){
            
            $color = $this->getColorManagement($model->days);
            
            $return = array('status' => 'success', 'date' => ($model->date != '')? Yii::app()->dateFormatter->format('dd/MM/yyyy', $model->date): '', 'color' => $color);
            
        }
        
        return $return;
    }
    
    public function getModelCluster($idMlModel,$clusterML,$idDebtorObligation){
        $return = array('status' => 'error','model' => Yii::t('front',''),'cluster' => Yii::t('front',''),'impago' => 0,'percent' => 0);
        
        $condition = 't.id = '.$idDebtorObligation;
        if($idMlModel != ''){
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 'tm.id ='.$idMlModel;
        }
        if($clusterML != ''){
            $condition .= ($condition != '') ? ' AND ' : '';
            $condition .= 'tc.id ='.$clusterML;
        }
        $criteria = new CDbCriteria();
        $criteria->select = 'tm.name as name, tc.name as code, tc.id as id';
        $criteria->join = ' JOIN view_debtors_debts_clusters vddc ON t.id = vddc.idDebtorDebt 
                       JOIN tbl_clusters tc ON vddc.idCluster = tc.id
                       JOIN tbl_mlmodels tm ON tc.idMLModel = tm.id';
        $criteria->condition = $condition;
        
        $model = ViewDebtors::model()->find($criteria);
        
        if($model != null){                        
            $return['status'] =  'success';
            $return['model'] = ($model->name != '')? $model->name : '';
            $return['cluster'] = ($model->code != '')? $model->code : '';
            
            $criteria = new CDbCriteria();
            $criteria->select = 'SUM(t.capital) as capital';
            $criteria->join = 'join tbl_debtors_state tds on t.idDebtorsState = tds.id AND tds.historic = 1
                    join tbl_debtors_obligations_clusters tdoc on t.id = tdoc.idDebtorObligation AND tdoc.idCluster ='.$model->id;
                                
            $capital = DebtorsObligations::model()->find($criteria);
            
            if($capital != null && $capital->capital > 0){
                $criteria = new CDbCriteria();
                $criteria->select = 'SUM(t.value) as value';
                $criteria->join = 'join tbl_debtors_obligations tdo on t.idDebtorObligation = tdo.id
                        join tbl_debtors_state tds on tdo.idDebtorsState = tds.id AND tds.historic = 1
                        join tbl_debtors_obligations_clusters tdoc on tdo.id = tdoc.idDebtorObligation AND tdoc.idCluster ='.$model->id;
                $payments = DebtorsPayments::model()->find($criteria);
                
                if($capital != null){
                    $return['percent'] = round(($payments->value * 100) / $capital->capital,2);
                }
            }
        }
        
        $impago = DebtorsObligationsPredictionsAgreement::model()->find(array('condition' => ' t.idDebtorObligation = '.$idDebtorObligation));
        
        if($impago != null){
            $return['impago'] = round(($impago->probabilityTrue * 100), 2);
        }
        
        return $return;
    }
    
    public static function othersValues__($idDebtor){
        $return = array('status' => 'error','model' => '', 'ageDebt' => '');
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.id as id, SUM(vdo.payments) as payments, SUM(vdo.agreement) as agreement, SUM(vdo.fee) as fee, SUM(vdo.interest) as c_interest, SUM(t.capital) as capital,SUM(t.interest) as interest, SUM(t.interest_arrears) as interest_arrears, SUM(interest_arrears_migrate) as interest_arrears_migrate, SUM(t.charges) as charges, SUM(t.others) as others';
        $criteria->condition = 't.idDebtor = '.$idDebtor;
        $criteria->join = 'JOIN view_debtors_obligations vdo ON t.id = vdo.id AND vdo.active = 1';        
        $model = DebtorsObligations::model()->find($criteria);
        
        if($model != null){            
            
            $return = array('status' => 'success', 'model' => $model);
            
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'JOIN view_debtors vd ON t.id = vd.ageDebt';
        $criteria->condition = 'vd.id = '.$idDebtor;
        
        $ageDebts = AgeDebt::model()->find($criteria);
        
        if($ageDebts != null){
            $return['ageDebt'] = $ageDebts->name; 
        }
        
        return $return;
    }
    
    public static function othersValues($id, $detail = true){
        $return = array('status' => 'error','model' => '','ageDebt' => '');
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.id as id, t.fee, t.interest, t.capital ';
        $criteria->condition = 't.id = '.$id;
        
        $model = ViewDebtorsDebts::model()->find($criteria);
        
        if($model != null){   
            if($detail){
                $criteria = new CDbCriteria();
                $criteria->select = 'SUM(t.value) as value';
                $criteria->condition  = 't.idDebtorDebt = '.$id;

                $payments = ViewDebtorsDebtsPayments::model()->find($criteria);
                $model->payments = ($payments != null)? $payments->value : 0;

                $criteria = new CDbCriteria();
                $criteria->select = 'SUM(t.value) as value';
                $criteria->condition = 't.idDebtorDebt = '.$id;

                $agreements = ViewDebtorsDebtsAgreements::model()->find($criteria);
                $model->agreement = ($agreements != null)? $agreements->value : 0;
            }
            
            $return = array('status' => 'success', 'model' => $model,'ageDebt' =>'');            
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'JOIN view_debtors vd ON t.id = vd.ageDebt';
        $criteria->condition = 'vd.id = '.$id;
        
        $ageDebts = AgeDebt::model()->find($criteria);
        
        if($ageDebts != null){
            $return['ageDebt'] = $ageDebts->name; 
        }
        
        return $return;
    }
    
    public static function getDays($date,$date_2){
//        $days = Yii::app()->db->createCommand("SELECT timestampdiff(DAY,'".$date."','".$date_2."') as days ")->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
        $days = Yii::app()->db->createCommand("select timestampdiff(MONTH, '".$date."', '".$date_2."') * 30 + DAY('".$date_2."') - DAY('".$date."') as days ")->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
        
        return ($days != NULL)? $days->days : 0;
    }
    
    public static function getPeriodDiff($date_2,$date){
        $date = Yii::app()->dateFormatter->format('yyyyMM', $date);
        $date_2 = Yii::app()->dateFormatter->format('yyyyMM', $date_2);        
        $period = Yii::app()->db->createCommand("SELECT PERIOD_DIFF('".$date_2."', '".$date."') as period")->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
        
        return ($period != NULL)? $period->period : 0;
    }
    
    public static function demographicsPercent($id){
        $return = array('result' => 'error', 'count' => 0 ,'percent' => 0);
        
        $model = Yii::app()->db->createCommand('SELECT t.name, t.address, t.mobile, tdd.paymentCapacity, tdd.idGender, tdd.idTypeEducationLevel,
                    tdd.dependents, t.code, t.neighborhood, tdd.idOccupation, tdd.age, tdd.stratus, tdd.idTypeHousing, tdd.paymentCapacity, t.email, t.idCity, 
                    t.phone, tdd.idMaritalState, tdd.laborOld, tdd.idTypeContract, tdd.contractTerm
                    FROM tbl_debtors t LEFT JOIN tbl_debtors_demographics tdd ON t.id = tdd.idDebtor WHERE t.id ='.$id)->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
                
        if (is_object($model) && $model != null) {
            $return['result'] = 'success';
            $debtor = get_object_vars($model);
            
            foreach($debtor as $key => $value) {
             $return['count'] = ($value != '')? $return['count']+1 : $return['count'];
            }
        }        
        
        $return['percent'] = (($return['count'] * 100) / 21);
                
        return $return;
    }
    //
    public static function demographicsPercent_($id){
        $return = array('result' => 'error', 'count' => 0 ,'percent' => 0);
        
        $model = Yii::app()->db->createCommand('SELECT t.name, t.address, t.mobile, tdd.paymentCapacity, tdd.idGender, tdd.idTypeEducationLevel,
                    tdd.dependents, t.code, t.neighborhood, tdd.idOccupation, tdd.age, tdd.stratus, tdd.idTypeHousing, tdd.paymentCapacity, t.email, t.idCity, 
                    t.phone, tdd.idMaritalState, tdd.laborOld, tdd.idTypeContract, tdd.contractTerm
                    FROM tbl_debtors t
                    LEFT JOIN tbl_debtors_demographics tdd ON t.id = tdd.idDebtor WHERE t.id ='.$id)->setFetchMode(PDO::FETCH_OBJ)->queryRow(true);
              
        if (is_object($model) && $model != null) {
            $return['result'] = 'success';
            $debtor = get_object_vars($model);
            
            foreach($debtor as $key => $value) {
             $return['count'] = ($value != '')? $return['count']+1 : $return['count'];
            }
        }        
        
        $return['percent'] = (($return['count'] * 100) / 21);
                
        return $return;
    }
    
    public static function isJSON($string){
        //echo '1234';exit;
        $return  = false;
        
        //return $return;
        
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
        
    }
    
    
    public static function getCallphone($record){
        
        $url = '';
        
        if($record != ''){
            
            $url = str_replace('/var/www/html', 'http://'.Yii::app()->params['url_call'], $record);
        }
                
        return $url;
        
    }
    
     public static function CleanFilterDate($date = ''){
        $return = array('status' => 'error',
            'date' => '',
            'count' => 0,
        );
        
        $date_ = str_replace(' ', '',explode('/', $date));   
        $return['status'] = 'success';
        $return['date'] = $date_;
        $return['count'] = count($date_);
        
        return $return;
    }
    
    public static function sendSMS($number,$message) {
        $return = array('status' => 'error', 'msg' => '' );    
        //                  
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://107.20.199.106/restapi/sms/1/text/single",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n \"from\": \"COLLECT PAY\",\n \"to\":\"{$number}\",\n \"text\": \"{$message}\",\n \"language\": \"es\"\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Basic Q29sbGVjdHBheTpDMDNjN3A0MQ==",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $return['msg'] = $err;
        } else {
            $return['status'] = 'success';            
            $return['msg'] = 'ok';            
        }

        return $return;
    }
    
    
    public static function validAccess($access = ''){
        $return = false;
        
        if(!Yii::app()->user->isGuest && $access != ''){            
           $criteria = new CDbCriteria();
           $join = 'JOIN tbl_menu_users_profile tmup ON t.id = tmup.idMenu';
           $mCondition = 't.id ='.$access;                
           $condition = 'tmup.active = 1 AND _menu_ AND tmup.idUserProfile = '.Yii::app()->user->getState('rol');
            if(in_array(Yii::app()->user->getState('idPlan'), Yii::app()->params['plans'])){
                $condition .= ($condition != '')? ' AND' : '';
                $condition .= ' tmup.idPlan = '.Yii::app()->user->getState('idPlan');
            }else{                
            }            
            $criteria->join = $join;
            $criteria->condition = str_replace('_menu_', $mCondition, $condition);
            $criteria->order = 'tmup.order ASC';    
            $criteria->order = NULL;
            $module = Menu::model()->count($criteria);
            
            if($module > 0){
                $return = true;
            }
        }
        
        return $return;
    }
    
    public static function hideOptionsProfiles(){
        $return = '';
    
        if (Yii::app()->user->getState('ml') != null && Yii::app()->user->getState('ml') == 0) {
            $return .= 'hideMl();';
        }
        if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisers']))) {
            $return .= 'hideAdviser();';
        }
        if (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['customers']))) {
            $return .= 'hideCustomer();';
        }
        if (Yii::app()->user->getState('call') != null && Yii::app()->user->getState('call') == 0) {
            $return .= 'hideCall();';
        }
        if (Yii::app()->user->getState('sms') != null && Yii::app()->user->getState('sms') == 0) {
            $return .= 'hideSms();';
        }
        if (Yii::app()->user->getState('email') != null && Yii::app()->user->getState('email') == 0) {
            $return .= 'hideEmail();';
        }
        
        return $return;
    }
    
    
    public function getLastSessionUser($id){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'last_session' => Yii::t('front','SIN CONEXIÓN'));        
        $user = Users::model()->findByPk($id);
        
        if($user != null){           
            $model = UsersSession::model()->find(array('condition' => 't.idUser = '.$id, 'order' => 'dateCreated DESC'));
            if($model != null){
                $return['status'] = 'success';
                $return['last_session'] =  Yii::app()->dateFormatter->format('yyyy-MM-dd hh:mm:ss a',$model->dateCreated);
            }         
        }       
        return $return;
    }
    
    public function createSource($source, $name){
        $name = ($name != '')? $name : 'source_'.Date('d_m_Y_h_i_s');
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.','source' => '', 'dataset' => '');
        
        if($source != ''){
            $file = Yii::getPathOfAlias('webroot').$source;
            
            if (file_exists($file)){
                
                require_once 'protected/extensions/bigml/Machinebigml.php';   
         
                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);
                
                $source = $api->create_source($file, array('name'=> $name));                                 
                $return['source'] = $source->resource;
                
                if($source->code == 200 || $source->code == 201){                  
                    if($source->object->status->code == 5){                                        
                        $return['status'] = 'success';                    
                    }elseif($source->object->status->code == 1 || $source->object->status->code == 2 || $source->object->status->code == 3 || $source->object->status->code == 4){
                        $return['status'] = 'waiting';
                    }else{                    
                        $return['status'] = 'error';
                        $return['msg'] =  'Error generando Source';
                    }
                    $return['status'] = 'waiting';
                }else{
                    $return['status'] = 'error';
                    $return['msg'] = 'Error generando source';                    
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] =  'Source no encontrado';
            }
            
        }
        return $return;
    }
    public function getSource($source){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.','source' => '', 'dataset' => '');
        
        if($source != ''){
                
            require_once 'protected/extensions/bigml/Machinebigml.php';   

            $api = new BigML\BigML(["username" => "desarrollo",
                       "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                       "project" => "project/5cb08b756997fa1812000772"
                   ]);

            $source = $api->get_source($source);                                 
            $return['source'] = $source->resource;
            
            if($source->code == 200 || $source->code == 201){
                if($source->object->status->code == 5){                                        
                    $return['status'] = 'success';                    
                }elseif($source->object->status->code == 1 || $source->object->status->code == 2 || $source->object->status->code == 3 || $source->object->status->code == 4){
                    $return['status'] = 'waiting';
                }else{                    
                    $return['status'] = 'error';
                    $return['msg'] =  'Error status source';
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = 'Error get source';
            }
        }else{
            $return['status'] = 'error';
            $return['msg'] =  'Source no encontrado';
        }
            
        return $return;
    }
    
public function createDataset($source, $name){
    $name = ($name != '')? $name : 'dataset_'.Date('d_m_Y_h_i_s');
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.','source' => '', 'dataset' => '');
        
        if($source != ''){
            require_once 'protected/extensions/bigml/Machinebigml.php';   
         
                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);
                
                $dataset = $api->create_dataset($source, array("name"=> $name));                                 
                $return['source'] = $source;
                
                if($dataset->code == 200 || $dataset->code == 201){
                    $return['dataset'] = $dataset->resource;                    
                    if($dataset->object->status->code == 5){                                        
                        $return['status'] = 'success';                    
                    }elseif($dataset->object->status->code == 1 || $dataset->object->status->code == 2 || $dataset->object->status->code == 3 || $dataset->object->status->code == 4){
                        $return['status'] = 'waiting';
                    }else{                    
                        $return['status'] = 'error';
                        $return['msg'] =  'Error generando Source';
                    }                    
                }else{
                    $return['status'] = 'error';
                    $return['msg'] = 'Error generando source';                    
                }                
        }else{
            $return['status'] = 'error';
            $return['msg'] =  'Source no encontrado';
        }
        
        return $return;
    }
    
    public function getDataset($source,$dataset){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.','source' => '', 'dataset' => '');
        
        if($dataset != ''){
                
            require_once 'protected/extensions/bigml/Machinebigml.php';   

            $api = new BigML\BigML(["username" => "desarrollo",
                       "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                       "project" => "project/5cb08b756997fa1812000772"
                   ]);

            $dataset = $api->get_dataset($dataset);                                 
            $return['source'] = $source;
            $return['dataset'] = $dataset->resource;

            if($dataset->code == 200 || $dataset->code == 201){
                if($dataset->object->status->code == 5){                                        
                    $return['status'] = 'success';                    
                }elseif($dataset->object->status->code == 1 || $dataset->object->status->code == 2 || $dataset->object->status->code == 3 || $dataset->object->status->code == 4){
                    $return['status'] = 'waiting';
                }else{                    
                    $return['status'] = 'error';
                    $return['msg'] =  'Error status dataset';
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = 'Error get dataset';
            }
        }else{
            $return['status'] = 'error';
            $return['msg'] =  'dataset no encontrado';
        }
            
        return $return;
    }
    
    public function createCluster($source,$dataset,$fields,$name){
        $name = ($name != '')? $name : "cluster_".Date('d_m_Y_h_i_s');
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '','cluster' => '', 'prediction' => '', 'file' => '');        
        $input_fields = array();
        
        $fields = json_decode($fields); 
        foreach ($fields as $field){
            $fModel = MlmodelsFields::model()->findByPk($field);                    
            if($fModel != null){ 
                $input_fields[] = $fModel->name_export;
            }
        }
        
        if($source != '' && $dataset != ''){            
            $getDataset = Controller::getDataset($source,$dataset);            
            if($getDataset['status'] = 'success'){  
                $return['source'] = $source;
                $return['dataset'] = $dataset;
                
                require_once 'protected/extensions/bigml/Machinebigml.php';   

                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);
                
                $cluster = $api->create_cluster(
                        $dataset, 
                        array("name"=> $name, 
//                            "input_fields" => $input_fields,
                              "excluded_fields" => array('idDebtorObligation','portfolioName'),
                        ));
               
                if($cluster->code == 200 || $cluster->code == 201){     
                    $return['cluster'] = $cluster->resource;                    
                    if($cluster->object->status->code == 5){                                        
                        $return['status'] = 'success';                    
                    }elseif($cluster->object->status->code == 1 || $cluster->object->status->code == 2 || $cluster->object->status->code == 3 || $cluster->object->status->code == 4){
                        $return['status'] = 'waiting';
                    }else{                    
                        $return['status'] = 'error';
                        $return['msg'] =  'Error generando source';
                    }                       
                }else{                
                    $return['status'] =  'Error generando cluster';
                } 
            }else{
                $return['status'] =  'Error obteniendo dataset';
            }
        }        
        return $return;
    }
    
    public function getCluster($source,$dataset,$cluster){
         $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '','cluster' => '','clusters' => '','fields' => '', 'prediction' => '', 'file' => '');
        
        if($cluster != ''){
            
            require_once 'protected/extensions/bigml/Machinebigml.php';   

            $api = new BigML\BigML(["username" => "desarrollo",
                       "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                       "project" => "project/5cb08b756997fa1812000772"
                   ]);

            $cluster = $api->get_cluster($cluster);  
            $return['source'] = $source;
            $return['dataset'] = $dataset;
            
            if($cluster != null){
                $return['cluster'] = $cluster->resource;
                if($cluster->code == 200 || $cluster->code == 201){
                   if($cluster->object->status->code == 5){                                        
                       $return['status'] = 'success';   
                       if(property_exists($cluster, "object") && property_exists($cluster->object, "clusters") && property_exists($cluster->object->clusters, "clusters") ){
                           $return['clusters'] = $cluster->object->clusters->clusters;                        
                       }                    
                       if(property_exists($cluster, "object") && property_exists($cluster->object, "clusters") && property_exists($cluster->object->clusters, "fields") ){
                           $return['fields'] = $cluster->object->clusters->fields;                        
                       }                    
                   }elseif($cluster->object->status->code == 1 || $cluster->object->status->code == 2 || $cluster->object->status->code == 3 || $cluster->object->status->code == 4){
                       $return['status'] = 'waiting';
                   }else{                    
                       $return['status'] = 'error';
                       $return['msg'] =  'Error status cluster';
                   }
               }else{
                   $return['status'] = 'error';
                   $return['msg'] = 'Error get cluster';
               }   
            }else{
                $return['status'] = 'waiting';
            }            
        }else{
            $return['status'] = 'error';
            $return['msg'] =  'Clusters no encontrado';
        }
            
        return $return;
    }
    
    public function updateCluster($source,$dataset,$cluster){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '','cluster' => '', 'object' => '', 'prediction' => '', 'file' => '');        
        
        if($source != '' && $dataset != ''){            
            $getCluster = Controller::getCluster($source,$dataset,$cluster);            
            if($getCluster['status'] = 'success'){  
                $return['source'] = $source;
                $return['dataset'] = $dataset;
                
                require_once 'protected/extensions/bigml/Machinebigml.php';   

                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);
                
                $cluster = $api->update_cluster(
                        $cluster, 
                        array("shared" => true,));
                
                if($cluster->code == 200 || $cluster->code == 201 || $cluster->code == 202){     
                    $return['cluster'] = $cluster->resource;
                    $return['object'] = $cluster->object;
                    if($cluster->object->status->code == 5){                                        
                        $return['status'] = 'success';                    
                    }elseif($cluster->object->status->code == 1 || $cluster->object->status->code == 2 || $cluster->object->status->code == 3 || $cluster->object->status->code == 4){
                        $return['status'] = 'waiting';
                    }else{                    
                        $return['status'] = 'error';
                        $return['msg'] =  'Error generando source';
                    }                       
                }else{                
                    $return['status'] =  'Error generando cluster';
                } 
            }else{
                $return['status'] =  'Error obteniendo dataset';
            }
        }        
        return $return;
    }
    
    public function createPrediction($source,$dataset){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
        
        if($source != '' && $dataset != ''){            
            $getDataset = Controller::getDataset($source,$dataset);            
            if($getDataset['status'] = 'success'){  
                $return['source'] = $source;
                $return['dataset'] = $dataset;
                
                require_once 'protected/extensions/bigml/Machinebigml.php';   

                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);

                $model = $api->get_fusion('fusion/5d07d184eba31d5157004a8c');

                 $batch_prediction = $api->create_batch_prediction(
                            $model, 
                            $dataset, 
                            array("name" => "batch_prediction".Date('d_m_Y_h_i_s'),
                            //"all_fields" => true,
                            "output_fields" => array("idDebtorObligation"),
                            "header" => true,
                            "confidence" => true));

                if($batch_prediction->code == 200 || $batch_prediction->code == 201){     
                    $return['prediction'] = $batch_prediction->resource;                    
                    if($batch_prediction->object->status->code == 5){                                        
                        $return['status'] = 'success';                    
                    }elseif($batch_prediction->object->status->code == 1 || $batch_prediction->object->status->code == 2 || $batch_prediction->object->status->code == 3 || $batch_prediction->object->status->code == 4){
                        $return['status'] = 'waiting';
                    }else{                    
                        $return['status'] = 'error';
                        $return['msg'] =  'Error generando source';
                    }                       
                }else{                
                    $return['status'] =  'Error generando probabilidad';
                } 
            }else{
                $return['status'] =  'Error obteniendo dataset';
            }
        }        
        return $return;
    }
    
    public function getPrediction($source,$dataset,$prediction){
         $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
        
        if($prediction != ''){
                
            require_once 'protected/extensions/bigml/Machinebigml.php';   

            $api = new BigML\BigML(["username" => "desarrollo",
                       "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                       "project" => "project/5cb08b756997fa1812000772"
                   ]);

            $prediction = $api->get_batch_prediction($prediction);  
            $return['source'] = $source;
            $return['dataset'] = $dataset;
            $return['prediction'] = $prediction->resource;

            if($prediction->code == 200 || $prediction->code == 201){
                if($prediction->object->status->code == 5){                                        
                    $return['status'] = 'success';                    
                }elseif($prediction->object->status->code == 1 || $prediction->object->status->code == 2 || $prediction->object->status->code == 3 || $prediction->object->status->code == 4){
                    $return['status'] = 'waiting';
                }else{                    
                    $return['status'] = 'error';
                    $return['msg'] =  'Error status prediction';
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = 'Error get prediction';
            }
        }else{
            $return['status'] = 'error';
            $return['msg'] =  'prediction no encontrado';
        }
            
        return $return;
    }
    
    public function downloadPrediction($source,$dataset,$prediction){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
                
        if($source != '' && $dataset != '' && $prediction){            
            $getPrediction = Controller::getPrediction($source,$dataset,$prediction);
            if($getPrediction['status'] = 'success'){  
                $return['source'] = $source;
                $return['dataset'] = $dataset;
                $return['prediction'] = $prediction;
                
                require_once 'protected/extensions/bigml/Machinebigml.php';   

                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);

                $file = Yii::getPathOfAlias('webroot').'/uploads/bigMl/my_predictions'.Date('d_m_Y_h_i_s').'.csv';
                $return['file'] =  $file;
                $return['status'] =  'success';
                $api->download_batch_prediction($prediction,$file);
//                
//                if($batch_prediction->code == 200 || $batch_prediction->code == 201){     
//                    $return['prediction'] = $batch_prediction->resource;                    
//                    if($batch_prediction->object->status->code == 5){                                        
//                        $return['status'] = 'success';                    
//                    }elseif($batch_prediction->object->status->code == 1 || $batch_prediction->object->status->code == 2 || $batch_prediction->object->status->code == 3 || $batch_prediction->object->status->code == 4){
//                        $return['status'] = 'waiting';
//                    }else{                    
//                        $return['status'] = 'error';
//                        $return['msg'] =  'Error generando Source';
//                    }                       
//                }else{                
//                    $return['status'] =  'Error generando probabilidad';
//                } 
            }else{
                $return['status'] =  'Error status predicción';                
            }
        }
        return $return;
    }
    
    public function createBatchCentroid($source,$dataset,$cluster,$name){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '', 'batch' => '', 'file' => '');
        $name = ($name != '')? $name : "batch_centroide_".Date('d_m_Y_h_i_s');
        
        if($source != '' && $dataset != ''){            
            $getDataset = Controller::getDataset($source,$dataset);  
            $getCluster = Controller::getCluster($source,$dataset,$cluster);
            if($getDataset['status'] = 'success' && $getCluster['status'] == 'success'){  
                $return['source'] = $source;
                $return['dataset'] = $dataset;
                
                require_once 'protected/extensions/bigml/Machinebigml.php';   

                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);
                 
                $batch =  $api->create_batch_centroid($cluster,
                            $dataset,
                            array("name" => $name,
                                "output_fields" => array("idDebtorObligation"),
                                //"all_fields"=> true,
                                "header" => true));

                if($batch->code == 200 || $batch->code == 201){     
                    $return['batch'] = $batch->resource;                    
                    if($batch->object->status->code == 5){                                        
                        $return['status'] = 'success';                    
                    }elseif($batch->object->status->code == 1 || $batch->object->status->code == 2 || $batch->object->status->code == 3 || $batch->object->status->code == 4){
                        $return['status'] = 'waiting';
                    }else{                    
                        $return['status'] = 'error';
                        $return['msg'] =  'Error generando batch centroid';
                    }                       
                }else{                
                    $return['status'] =  'Error generando análisis';
                } 
            }else{
                $return['status'] =  'Error obteniendo dataset';
            }
        }        
        return $return;
    }
    
    public function getBatchCentroid($batch){
         $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '','batch' => '', 'cluster' => '', 'file' => '');
        
        if($batch != ''){
                
            require_once 'protected/extensions/bigml/Machinebigml.php';   

            $api = new BigML\BigML(["username" => "desarrollo",
                       "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                       "project" => "project/5cb08b756997fa1812000772"
                   ]);

            $batch = $api->get_batchcentroid($batch); 
            $return['batch'] = $batch->resource;

            if($batch->code == 200 || $batch->code == 201){
                if($batch->object->status->code == 5){                                        
                    $return['status'] = 'success';                    
                }elseif($batch->object->status->code == 1 || $batch->object->status->code == 2 || $batch->object->status->code == 3 || $batch->object->status->code == 4){
                    $return['status'] = 'waiting';
                }else{                    
                    $return['status'] = 'error';
                    $return['msg'] =  'Error status prediction';
                }
            }else{
                $return['status'] = 'error';
                $return['msg'] = 'Error get prediction';
            }
        }else{
            $return['status'] = 'error';
            $return['msg'] =  'prediction no encontrado';
        }
            
        return $return;
    }
    
    public function downloadBatchCentroid($source,$dataset,$batch){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'source' => '', 'dataset' => '', 'prediction' => '', 'file' => '');
                
        if($batch != ''){            
            $getPrediction = Controller::getBatchCentroid($batch);
            if($getPrediction['status'] = 'success'){  
                
                
                require_once 'protected/extensions/bigml/Machinebigml.php';   

                $api = new BigML\BigML(["username" => "desarrollo",
                           "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                           "project" => "project/5cb08b756997fa1812000772"
                       ]);

                $file = Yii::getPathOfAlias('webroot').'/uploads/bigMl/batch_centroide'.Date('d_m_Y_h_i_s').'.csv';
                $return['file'] =  $file;
                $return['status'] =  'success';
                $api->download_batch_centroid($batch,$file);
//                
//                if($batch_prediction->code == 200 || $batch_prediction->code == 201){     
//                    $return['prediction'] = $batch_prediction->resource;                    
//                    if($batch_prediction->object->status->code == 5){                                        
//                        $return['status'] = 'success';                    
//                    }elseif($batch_prediction->object->status->code == 1 || $batch_prediction->object->status->code == 2 || $batch_prediction->object->status->code == 3 || $batch_prediction->object->status->code == 4){
//                        $return['status'] = 'waiting';
//                    }else{                    
//                        $return['status'] = 'error';
//                        $return['msg'] =  'Error generando Source';
//                    }                       
//                }else{                
//                    $return['status'] =  'Error generando probabilidad';
//                } 
            }else{
                $return['status'] =  'Error status predicción';                
            }
        }
        return $return;
    }
    
    function  get_batch_prediction($batch_prediction){
        $return = array('status' => 'error', 'msg' => 'Solicitud Invalida.', 'batch_prediction' => '', 'file' => '');
        
        if($batch_prediction != ''){        
            
            require_once 'protected/extensions/bigml/Machinebigml.php';   

            $api = new BigML\BigML(["username" => "desarrollo",
                       "apiKey" => "f393c75474d684736c3aa754a450229fe8f6febc",
                       "project" => "project/5cb08b756997fa1812000772"
                   ]);
            
            $batch = $api->get_batch_prediction($batch_prediction);
            
            if($batch->code == 200 ||  $batch->code == 201){
                    $return['batch_prediction'] =  $batch_prediction;
                if($batch->object->status->code == 5){
                    $file = Yii::getPathOfAlias('webroot').'/uploads/bigMl/my_predictions'.Date('d_m_Y_h_i_s').'.csv';
                    $return['status'] =  'success';
                    $return['file'] =  $file;
                    $api->download_batch_prediction($prediction,$file);
                }elseif($batch->object->status->code == 2 || $batch->object->status->code == 3 || $batch->object->status->code == 4 ){
                    $return['status'] =  'waiting';
                }else{
                    $return['status'] =  'Error estado probabilidad';
                }
            }else{
                $return['status'] =  'Error obteniendo probabilidad';
            }        
        }
        return $return;
    }
    
    
    function getChartComparatios($idCustomer, $historic = 0){
        $return = null;
                
        if($idCustomer != ''){
            $join = ($historic)? '' : 'LEFT'; 
            $return = Yii::app()->db->createCommand("SELECT dayDebt, capital, total, ((capital * 100) / total) as ratio  FROM "
                    . "( select t.dayDebt, t.capital, (SELECT SUM(vdo.capital) as total FROM view_debtors_obligations vdo ".$join." JOIN tbl_debtors_state tds_ ON vdo.idDebtorsState = tds_.id AND tds_.historic = ".$historic." JOIN tbl_debtors td_ ON vdo.idDebtor = td_.id  WHERE td_.idCustomers = td.idCustomers ) as total from view_debtors_obligations t ".$join." JOIN tbl_debtors_state tds ON t.idDebtorsState = tds.id AND tds.historic = ".$historic." JOIN tbl_debtors td ON t.idDebtor = td.id WHERE td.idCustomers = ".$idCustomer." LIMIT 500) "
                    . "as t")->setFetchMode(PDO::FETCH_OBJ)->queryAll(true);  
            
        }
                
        return $return;
        
    }
    
    function getTasksDebtor($idDebtor){
        $return = false;
        
        if($idDebtor != null){
            $operator = ' = ';
            $condition = 't.idPrimary = '.$idDebtor. ' AND t.idTasksAction '.$operator.' 30';
            $model = ViewTasks::model()->find(array('condition' => $condition));
            
            if($model != null){
                $return = 2;
            }else{
                $condition  = str_replace($operator, '<>', $condition);
                $model = ViewTasks::model()->find(array('condition' => $condition));                
                if($model != null){
                   $return = true;
                }
            }
        }
        
        return $return;
        
    }
    
    public static function formatSizeMegaBytes($megabytes, $decimals = 2) {
        if ($megabytes > 1024) {
            $gb = $megabytes / 1024;
            if ($gb > 1024) {
                $tb = $gb / 1024;
                $result = round($tb, $decimals) . ' Tb';
            } else {
                $result = round($gb, $decimals) . ' Gb';
            }
        } else {
            $result = round($megabytes, $decimals) . ' Mb';
        }

        return $result;
    }
    
    
}
