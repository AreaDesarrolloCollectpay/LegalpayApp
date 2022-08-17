<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
#Configuración de la aplicación
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    // preloading 'log' component
    'preload' => array('log'),
    'name'=>'Api',
    'theme' => 'api',
    'language' => 'es',
    'charset' => 'utf-8',
    'sourceLanguage' => 'es_co',
    'defaultController' => 'default',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*',
        'application.extensions.yiirestmodel.*',
    ),
    'aliases' => array(
        'xupload' => 'ext.xupload',
    ),
    'behaviors' => array(
        'runEnd' => array(
            'class' => 'application.components.WebApplicationEndBehavior',
        ),
    ),
    // application components
    'components' => array(
        'localtime' => array(
            'class' => 'LocalTime',
        ),
        'session' => array(
            'timeout' => 3600 * 5,
        ),
        'mobileDetect' => array(
            'class' => 'ext.MobileDetect.MobileDetect'
        ),
        'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'default/error',
        ),
        'booster' => array(
            'class' => 'ext.booster.components.Booster',
            'responsiveCss' => true,
            'fontAwesomeCss' => true,
            'enableNotifierJS' => false,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'api' => 'default/index',
                array('<controller>/list', 'pattern'=>'api/<controller:\w+>', 'verb'=>'GET'),
                array('<controller>/view', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'GET'),
                array('<controller>/create', 'pattern'=>'api/<controller:\w+>', 'verb'=>'POST'),
                array('<controller>/update', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'PUT'),
                array('<controller>/update', 'pattern'=>'api/<controller:\w+>', 'verb'=>'PUT'),
                array('<controller>/delete', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'DELETE'),
                array('<controller>/delete', 'pattern'=>'api/<controller:\w+>', 'verb'=>'DELETE'),
            ),
        ),
        'db' => (YII_DEBUG ? require(dirname(__FILE__) . '/database-developer.php') : require(dirname(__FILE__) . '/database-production.php')),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages

            /* array(
              'class'=>'CWebLogRoute',
              ), */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'freddy.alarcon@imaginamos.com.co',
    ),
);