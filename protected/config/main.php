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
    'language' => 'en',
    'charset' => 'utf-8',
    'sourceLanguage' => 'es',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.controllers.front.*',
        'ext.giix-components.*',
    ),
    'aliases' => array(
        'xupload' => 'ext.xupload',
    ),
    'behaviors' => array(
        'runEnd' => array(
            'class' => 'application.components.WebApplicationEndBehavior',
        ),
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'generatorPaths' => array(
                //'bootstrap.gii'
                'ext.giix-core',
            ),
            'password' => 'imaginamos',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1','45.79.7.35','190.85.157.66'),
        ),
    ),
    // application components
    'components' => array(
        'localtime' => array(
            'class' => 'LocalTime',
        ),
        'session' => array(
            'class' => 'CDbHttpSession',
            'sessionTableName' => 'yii_session',
            'timeout' => 3600 * 5,
            'connectionID' => 'db',
        ),
        'mobileDetect' => array(
            'class' => 'ext.MobileDetect.MobileDetect'
        ),
        'sendgrid' => array(  
            'class' => 'ext.yii-sendgrid.YiiSendGrid', //path to YiiSendGrid class  
            'username'=>'carteraCojunal', //replace with your actual username  
            'password'=>'cojunal2018*', //replace with your actual password  
            //alias to the layouts path. Optional  
            //'viewPath' => 'application.views.mail',  
            //wheter to log the emails sent. Optional  
            //'enableLog' => YII_DEBUG, 
            //if enabled, it won't actually send the emails, only log. Optional  
            //'dryRun' => false, 
            //ignore verification of SSL certificate  
            //'disableSslVerification'=>true,
            // develop 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
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
        'nameEmail' => 'LEGAL PAY',
        'adminEmail' => 'noreply@collectpay.co',
        'admin' => array(1),
        'coordinator' => array(11),
        'treeRol' => array(
                    'coodinators' => array( 
                        'parent' => 11,
                        'childs' => array(2,5,9) //quitamos 9
                    ),
                    'legal' => array( 
                        'parent' => 5,
                        'childs' => array(6)
                    ),
                    'preLegal' => array(
                        'parent' => 2,
                        'childs' => array(3)
                    )
        ),          
        'plans' => array(2,3,5,6,11),
        'coordinators' => array(2,5),
        'advisers' => array(3,6,13,14,15), //consultas a la base de datos por id - 13 -14- 15
        'legal' => array(5,6),  // quitamos 7
        'companies' => array(11),
        'customers' => array(7),
        'advisorBusiness' => array(9),
        'accounting' => array(10),
        'keyMaps' => 'AIzaSyDsjI18s16qkN9XavLeNZ4ROpVwbQAToLg',
        'company' => 'LEGAL PAY',
        'company_ID' => '901.106.562-2',
//        'url_call' => '45.79.86.134',
        'url_call' => 'pbx.collectpay.co',
    ),
);
