<?php

return CMap::mergeArray(
        require(dirname(__FILE__) . '/main.php'), array(
            'theme' => 'admin',
            'name'=>'Administrador de contenido',
            'components' => array(
                'file'=>array(
                    'class'=>'application.extensions.CFile',
                ),
                'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        'loginUrl'=>array('dashboard/index'),
		),
                'booster' => array(
                    'class' => 'ext.booster.components.Booster',
                    'responsiveCss' => true,
                    'fontAwesomeCss' => true,
                    'enableNotifierJS' => false,
                ),
                'errorHandler'=>array(
                        // use 'site/error' action to display errors
                        'errorAction'=>'dashboard/error',
                ),
                'urlManager' => array(
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'rules' => array(
                        'cms' => 'dashboard/index',
                        'cms/<_c>/<_a>/<id:\d+>' => '<_c>/<_a>',
                        'cms/<_c>' => '<_c>',
                        'cms/<_c>/<_a>' => '<_c>/<_a>',
                    ),
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                                        array(
                           'class' => 'CFileLogRoute',
                           'levels' => 'trace, info, error, warning, vardump',
                       ),
                       // uncomment the following to show log messages on web pages
                       array(
                           'class' => 'CWebLogRoute',
                           'enabled' => YII_DEBUG,
                           'levels' => 'error, warning, trace, notice',
                           'categories' => 'application',
                           'showInFireBug' => false,
                       ),
                    ),
                ),
            )
        )
);
?>