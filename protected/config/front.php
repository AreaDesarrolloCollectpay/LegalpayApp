<?php
define("SECRET_KEY_GOOGLE", "6LeT9yMeAAAAALqm56FsUaouwGyL9LjSgP1rpu_S");
define("PUBLIC_KEY_GOOGLE", "6LeT9yMeAAAAAO4E5c_SHHGtYPPCtQQWvK_S9FAP");
return CMap::mergeArray(
            require(dirname(__FILE__) . '/main.php'), array(
            'theme' => 'default',
            'name' => 'Legal Platform',
            'components' => array(
                'ePdf' => array(
                    'class'         => 'ext.yii-pdf.EYiiPdf',
                    'params'        => array( 
                        'mpdf'     => array(
                        'librarySourcePath' => 'application.vendors.mpdf.*',
                        'constants'         => array(
                            '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                        ),
                        'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                        /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                            'mode'              => '', //  This parameter specifies the mode of the new document.
                            'format'            => 'A4', // format A4, A5, ...
                            'default_font_size' => 0, // Sets the default document font size in points (pt)
                            'default_font'      => '', // Sets the default font-family for the new document.
                            'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                            'mgr'               => 15, // margin_right
                            'mgt'               => 16, // margin_top
                            'mgb'               => 16, // margin_bottom
                            'mgh'               => 9, // margin_header
                            'mgf'               => 9, // margin_footer
                            'orientation'       => 'P', // landscape or portrait orientation
                        )*/
                    ),
                        'HTML2PDF' => array(
                            'librarySourcePath' => 'application.vendors.html2pdf.*',
                            'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                            /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                                'orientation' => 'P', // landscape or portrait orientation
                                'format'      => 'A4', // format A4, A5, ...
                                'language'    => 'en', // language: fr, en, it ...
                                'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                                'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                                'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                            )*/
                        )
                    ),
                ),
                'booster' => array(
                    'class' => 'ext.booster.components.Booster',
                    'responsiveCss' => true,
                    'fontAwesomeCss' => true,
                    'enableNotifierJS' => false,
                ),
                'user' => array(
                    // enable cookie-based authentication
                    'allowAutoLogin' => true,
                    'loginUrl' => array('site/index'),
                ),
//                'session' => array (
//                    'class' => 'application.extensions.MyDbHttpSession',
//                    'connectionID' => 'db',
//                    'sessionTableName' => 'tbl_users_sessions',
//                    'timeout' => 2700,
//                    /*'cookieParams' => array(
//                        'secure' => true,
//                        'httpOnly' => true,
//                    ),*/
//                ),
                'errorHandler' => array(
                    // use 'site/error' action to display errors
                    'errorAction' => 'site/error',
                ),
                'urlManager' => array(
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'rules' => array(
                        '/' => 'site/auth',
                        'confirm/<id>' => 'site/confirm',
                        'logout' => 'site/logout',
                        'goals' => 'indicators/goals',
                        'tendencies' => 'indicators/tendencies',
                        'performance' => 'indicators/performance',
                        'investments' => 'indicators/investments',
                        'business/detail/<id:\d+>/<task:\d+>' => 'business/detail',
                        //'dashboard' => 'dashboard/quadrants/id/0',
                        'region/<id:\d+>' => 'dashboard/region',
                        'region' => 'dashboard/region/id/0',
                        'cluster' => 'wallet/cluster',
                        'cluster/<idMLModel:\d+>' => 'wallet/cluster',
                        //'dashboard/<id:\d+>' => 'dashboard/quadrants',
                        'profile' => 'dashboard/profile',
                        'wallet/legal' => 'wallet/legal',
                        'wallet/legal/<idRegion:\d+>' => 'wallet/legal',
                        'wallet/legal/<idRegion:\d+>/<ageDebt:\d+>' => 'wallet/legal',
                        'wallet/<idRegion:\d+>' => 'wallet/index',
                        'wallet/<idRegion:\d+>/<ageDebt:\d+>' => 'wallet/index',
                        'wallet/<idRegion:\d+>/<ageDebt:\d+>/<is_legal:\d+>' => 'wallet/index',
                        'wallet/exportDebtors/<id:\d+>' => 'wallet/exportDebtors',
                        'wallet/exportDebtors/<id:\d+>/<ageDebt:\d+>' => 'wallet/exportDebtors',
                        'wallet/debtor/<id:\d+>' => 'wallet/debtor',
                        'wallet/debtor/<id:\d+>/<task:\d+>' => 'wallet/debtor',
                        'historic' => 'wallet/historic',
                        'historic/debtor/<id:\d+>' => 'wallet/debtor',
                        'historic/debtor/<id:\d+>/<task:\d+>' => 'wallet/debtor',
                        'allies' => 'users/allies/id/1',
                        'allies/<id:\d+>' => 'users/allies',
                        'services/pay/<id>' => 'services/pay',
                        'services/detail/<id>' => 'services/detail',
                        'investors' => 'users/investor',
                        'users/coordinators/supports/<id:\d+>' => 'users/supports',
                        'customers/supports/<id:\d+>' => 'users/supports',
                        'users/coordinators/contacts/<id:\d+>' => 'customers/contacts',
                        'importations' => 'usersImport/index',
                        '<controller:\w+>/<id:\d+>' => '<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
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
//                       array(
//                           'class' => 'CWebLogRoute',
//                           'enabled' => YII_DEBUG,
//                           'levels' => 'error, warning, trace, notice',
//                           'categories' => 'application',
//                           'showInFireBug' => false,
//                    ),
                ),
                ),
            )
    )
);
?>
