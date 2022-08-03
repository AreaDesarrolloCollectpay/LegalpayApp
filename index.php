<?php
ob_start();
ob_clean();
setlocale(LC_ALL,"es_ES");
date_default_timezone_set("America/Bogota");
ini_set ('display_errors', 1);
error_reporting (E_ALL | E_STRICT);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../../../yii-1.1.19/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/front.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->runEnd('front');
