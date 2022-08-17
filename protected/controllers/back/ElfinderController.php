<?php
Yii::import('ext.tinymce.*');
class ElfinderController extends GxController
{
        public function filters() {
            return array(
                'accessControl', 
            );
        }

        public function accessRules() {
                return array(
                    array('allow',
                        'expression'=>'Controller::validateAccess(array(),"",true)',
                    ),
                    array('deny', 
                            'users'=>array('*'),
                        ),
                    );
        }
        
        public function actions()
        {
             return array(
                 'compressor' => array(
                    'class' => 'TinyMceCompressorAction',
                    'settings' => array(
                       'compress' => true,
                            'disk_cache' => true,
                        )
                  ),
                  'connector' => array(
                        'class' => 'ext.elFinder.ElFinderConnectorAction',
                        // elFinder connector configuration
                        // https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
                        'settings' => array(
                            'roots' => array(
                                array(
                                    'driver' => 'LocalFileSystem',
                                    'path' => Yii::getPathOfAlias('webroot') . '/uploads/',
                                    'URL' => Yii::app()->baseUrl . '/uploads/',
                                    'alias' => 'Inicio',
                                    'mimeDetect' => 'internal',
                                    'acceptedName' => '/^[^\.].*$/', // disable creating dotfiles
                                    'attributes' => array(
                                        array(
                                            'pattern' => '/\/[.].*$/', // hide dotfiles
                                            'read' => false,
                                            'write' => false,
                                            'hidden' => true,
                                        ),
                                    ),
                                )
                            ),
                        )
                    ),
                    // action for TinyMCE popup with elFinder widget
                    'elfinderTinyMce' => array(
                        'class' => 'ext.elFinder.TinyMceElFinderPopupAction',
                        'connectorRoute' => 'connector', // main connector action id
                    ),
                    // action for file input popup with elFinder widget
                    'elfinderFileInput' => array(
                        'class' => 'ext.elFinder.ServerFileInputElFinderPopupAction',
                        'connectorRoute' => 'connector', // main connector action id
                    ),
             );
        }
        
}
