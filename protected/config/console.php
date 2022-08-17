<?php

return array(
    // This path may be different. You can probably get it from `config/main.php`.
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Collectpay',
 
    'preload'=>array('log'),
    'language'=>'es',
    'charset'=>'utf-8',
    'sourceLanguage'=> 'es_co',
 
    'import'=>array(
        'application.components.*',
        'application.models.*',
        'ext.giix-components.*',
    ),
    // We'll log cron messages to the separate files
    'components'=>array(
        'localtime'=>array(
                    'class'=>'LocalTime',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),
 
        // Your DB connection
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=collectpay_demo',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 0,
            'enableProfiling'=>true,
            // …
        ),
        'request' => array(
            'hostInfo' => 'localhost/cojunalv2',
            'baseUrl' => '',
            'scriptUrl' => '',
        ),
    ),
);