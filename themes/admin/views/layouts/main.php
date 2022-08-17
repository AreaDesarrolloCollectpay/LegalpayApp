<?php
$this->Widget('ext.yii-toast.ToastrWidget');
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$base = Yii::app()->request->baseUrl;
/* @var $this Controller */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="language" content="es" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script src="<?php echo $base; ?>/js/oLoader/js/jquery.oLoader.min.js"></script>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $base; ?>/imaginamos.ico"/>
        <link href="<?php echo $base; ?>/imaginamos.ico" rel="icon" type="image/x-icon" />
        <link href="<?php echo $base; ?>/css/chosen.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>/css/form.css" />
        <link href="<?php echo $base; ?>/css/cms.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            var pathurl = '<?php echo $base; ?>/';
            var messages = [];
            messages[0] = '<?php echo Yii::t('app', 'Seleccione...'); ?>';
            messages[1] = '<?php echo Yii::t('app', 'Anterior contraseña no puede ser vacia.'); ?>';
            messages[2] = '<?php echo Yii::t('app', 'Contraseña nueva y repita la contraseña no coinciden.'); ?>';
            messages[3] = '<?php echo Yii::t('app', 'Contraseña nueva y repita la contraseña no pueden ser vacias.'); ?>';
            messages[4] = '<?php echo Yii::t('app', 'Contraseña cambiada correctamente.'); ?>';
            messages[5] = '<?php echo Yii::t('app', 'Caracteres máximos'); ?>';
            messages[6] = '<?php echo Yii::t('app', 'No se encontraron resultados'); ?>';
            var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
        </script>
    </head>
    <body>
        <?php
        if ($this->validateAccess()):
            $modelmenu = CmsMenu::model()->findAll(array('condition' => 'visible=1' . $this->getFilterMenu(), 'order' => 'titulo'));
            ?>
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header fixed-brand">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only"><?php echo Yii::t('app', 'Toggle navigation'); ?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo $this->createUrl('/dashboard'); ?>">
                            <?php echo CHtml::encode(Yii::app()->name); ?>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-left">
                            <?php
                            if ($this->menu != null):
                                ?>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown dropdown-operations">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <b class="label label-info"><?php echo Yii::t('app', 'Operaciones'); ?></b> <span class="caret"></span>
                                    </a>
                                    <?php
                                    $this->widget('zii.widgets.CMenu', array(
                                        'items' => $this->menu,
                                        'encodeLabel' => false,
                                        'htmlOptions' => array('class' => 'dropdown-menu'),
                                    ));
                                    ?>
                                </li>
                                <?php
                            endif;
                            ?>
                            <li class="divider-vertical"></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a class="btn-login pointer" data-toggle="modal" data-target=".bs-modal-change">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <b title="Perfil"><?php echo Yii::app()->user->getState('title'); ?></b>
                                </a>
                            </li>
                            <li class="divider-vertical"></li>
                            <li>
                                <a href="<?php echo $this->createUrlFront('site/index'); ?>" target="_blank">
                                    <i class="glyphicon glyphicon-globe"></i>
                                    <b><?php echo Yii::t('app', 'Ver Sitio'); ?></b>
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <?php if ($this->validateAccess(array('admin'), 'admin')) { ?>
                                <li class="divider-vertical"></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="glyphicon glyphicon-wrench"></i>
                                        <b><?php echo Yii::t('app', 'Administración'); ?></b> <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu menu-barra">
                                        <li><a menu="cmsMenu" href="<?php echo $this->createUrl('cmsMenu/admin'); ?>"><i class="glyphicon glyphicon-tasks"></i> <b title="(Developer)"><?php echo Yii::t('app', 'Menús'); ?></b></a></li>
                                        <li class="divider"></li>
                                        <li><a menu="cmsConfiguracion" href="<?php echo $this->createUrl('cmsConfiguracion/index'); ?>"><i class="glyphicon glyphicon-wrench"></i> <b title="(Developer)"><?php echo Yii::t('app', 'Configurar sitio'); ?></b></a></li>
                                        <li class="divider"></li>
                                        <li><a menu="cmsUsuario" href="<?php echo $this->createUrl('cmsUsuario/admin'); ?>"><i class="glyphicon glyphicon-user"></i> <b><?php echo Yii::t('app', 'Usuarios'); ?></b></a></li>
                                        <li class="divider"></li>
                                        <li><a menu="cmsRol" href="<?php echo $this->createUrl('cmsRol/admin'); ?>"><i class="glyphicon glyphicon-cog"></i> <b title="(Developer)"><?php echo Yii::t('app', 'Roles'); ?></b></a></li>
                                        <li class="divider"></li>
                                        <li><a menu="cmsPermissionRol" href="<?php echo $this->createUrl('cmsPermissionRol/admin'); ?>"><i class="glyphicon glyphicon-warning-sign"></i> <b title="(Developer)"><?php echo Yii::t('app', 'Permisos para Roles'); ?></b></a></li>
                                        <li class="divider"></li>
                                        <li><a menu="cmsHelp" href="<?php echo $this->createUrl('cmsHelp/admin'); ?>"><i class="glyphicon glyphicon-question-sign"></i> <b><?php echo Yii::t('app', 'Ayuda'); ?></b></a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <li class="divider-vertical"></li>
                            <li>
                                <a href="<?php echo $this->createUrl('dashboard/logout'); ?>">
                                    <i class="glyphicon glyphicon-remove"></i>
                                    <b><?php echo Yii::t('app', 'Salir'); ?></b>
                                </a>
                            </li>
                            <li class="divider-vertical"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-sm-4">
                        <div>
                            <?php echo CHtml::dropDownList('busquedad_menu', '', CHtml::listData($modelmenu, 'url', 'titulo'), array('empty' => Yii::t('app', 'Buscar Menú...'), 'style' => 'width:100%')) ?>
                        </div>
                        <div class="well well-sm">
                            <ul class="nav nav-list menu-left">
                                <?php
                                unset($modelmenu);
                                $modelmenu = CmsMenu::model()->findAll(array('order' => 'orden', 'condition' => 'visible=1 AND cms_menu_id is null' . $this->getFilterMenu()));
                                foreach ($modelmenu as $value):
                                    $submenu = CmsMenu::model()->findAll(array('order' => 'orden', 'condition' => 'visible=1 AND cms_menu_id=' . $value->idcmsmenu . $this->getFilterMenu()));
                                    if ($submenu == null):
                                        ?>
                                        <li><a menu="<?php echo substr($value->url, 0, strlen($value->url) - strlen(strstr($value->url, "/"))); ?>" href="<?php echo $this->createUrl($value->url); ?>"> <i class="glyphicon <?php echo $value->icono; ?>"></i> <?php echo $value->titulo; ?></a></li>
                                        <li class="nav-divider"></li>
                                        <?php
                                    else:
                                        ?>
                                        <li class="dropdown">
                                            <a menu="<?php echo substr($value->url, 0, strlen($value->url) - strlen(strstr($value->url, "/"))); ?>" href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="glyphicon <?php echo $value->icono; ?>"></i> <?php echo $value->titulo; ?><b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <?php if ($value->visible_header == 1): ?>
                                                    <li class="well well-sm"><a menu="<?php echo substr($value->url, 0, strlen($value->url) - strlen(strstr($value->url, "/"))); ?>" href="<?php echo $this->createUrl($value->url); ?>"> <i class="glyphicon <?php echo $value->icono; ?>"></i> <?php echo $value->titulo; ?></a></li>
                                                <?php endif; ?>
                                                <li class="nav-divider"></li>
                                                <?php
                                                foreach ($submenu as $value2):
                                                    $submenu2 = CmsMenu::model()->find('visible=1 AND cms_menu_id=' . $value2->idcmsmenu . $this->getFilterMenu());
                                                    if ($submenu2 == null):
                                                        ?>
                                                        <li><a menu="<?php echo substr($value2->url, 0, strlen($value2->url) - strlen(strstr($value2->url, "/"))); ?>" href="<?php echo $this->createUrl($value2->url); ?>"> <i class="glyphicon <?php echo $value2->icono; ?>"></i> <?php echo $value2->titulo; ?></a></li>
                                                        <li class="nav-divider"></li>
                                                        <?php
                                                    else:
                                                        ?>
                                                        <li class="dropdown-submenu">
                                                            <a menu="<?php echo substr($value2->url, 0, strlen($value2->url) - strlen(strstr($value2->url, "/"))); ?>" href="<?php echo $this->createUrl($value2->url); ?>"> <i class="glyphicon <?php echo $value2->icono; ?>"></i> <?php echo $value2->titulo; ?></a>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                echo $this->submenus($value2->idcmsmenu);
                                                                ?>
                                                            </ul>  
                                                        </li>
                                                        <li class="nav-divider"></li>
                                                    <?php
                                                    endif;
                                                endforeach;
                                                ?>  
                                            </ul>
                                        </li>
                                        <li class="nav-divider"></li>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-10 col-sm-8">
                        <?php
                        $this->widget('booster.widgets.TbPanel', array(
                            'title' => $this->pageTitle,
                            'headerIcon' => 'home',
                            'context' => 'primary',
                            'content' => $content // $this->renderPartial('_view')
                        ));
                        ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <footer class="text-center" >
                &copy; Copyright <?= date('Y'); ?> <cite title="imaginamos.com"><a href="http://www.imaginamos.com/" target="_blank">imaginamos.com</a> </cite>
            </footer>
            <div id="login-form" class="modal fade bs-modal-change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 class="modal-title" id="myModalLabel"><?php echo Yii::t('app', 'Cambiar Contraseña'); ?></h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <?php echo CHtml::label(Yii::t('app', 'Anterior contraseña'), 'anteriorcontrasena', array('class' => 'label label-info')); ?>
                                    <?php echo CHtml::passwordField('anteriorcontrasena', '', array('maxlength' => 50, 'class' => 'input-block-level form-control')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <?php echo CHtml::label(Yii::t('app', 'Nueva contraseña'), 'nuevacontrasena', array('class' => 'label label-success')); ?>
                                    <?php echo CHtml::passwordField('nuevacontrasena', '', array('maxlength' => 50, 'class' => 'input-block-level form-control')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <?php echo CHtml::label(Yii::t('app', 'Repita contraseña'), 'repitacontrasena', array('class' => 'label label-success')); ?>
                                    <?php echo CHtml::passwordField('repitacontrasena', '', array('maxlength' => 50, 'class' => 'input-block-level form-control')); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 resp-change-pass">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo Yii::t('app', 'Cerrar'); ?></button>
                            <button class="btn btn-primary btn-change-pass"><?php echo Yii::t('app', 'Cambiar'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        else:
            echo $content;
        endif;
        ?>
        <script type="text/javascript" src="<?php echo $base; ?>/js/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>/js/helper.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>/js/admin.js"></script>
    </body>
</html>