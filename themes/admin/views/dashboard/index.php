<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Iniciar Sesión');
$base = Yii::app()->request->baseUrl;
?>
<div class="row">
    <div class="col-lg-3 col-md-3">
    </div>
    <div class="col-lg-6 col-md-6 col-xs-12">        
        <div class="panel panel-primary">
            <div class="panel-heading text-center"><img class="img-responsive img-logo-login" src="<?php echo $base; ?>/img/logo.png" alt="logo" /></div>
            <div class="panel-body">
                <p><?php echo Yii::t('app', 'Por favor, rellene el siguiente formulario con sus datos de acceso'); ?>:</p>
                <form id="login">
                    <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>" />
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo Yii::t('app', 'Usuario o Email'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                            <input type="text" class="form-control" name="username" placeholder="<?php echo Yii::t('app', 'Usuario o Email'); ?>" required="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><?php echo Yii::t('app', 'Contraseña'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></div>
                            <input type="password" class="form-control" name="password" placeholder="<?php echo Yii::t('app', 'Contraseña'); ?>" required="" />
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 text-left">
                            <button type="submit" class="btn btn-success btn-block"><?php echo Yii::t('app', 'Ingresar'); ?></button>
                        </div>
                        <div class="col-lg-4">                
                        </div>
                        <div class="col-lg-4 col-md-6 text-right">
                            <a class="btn btn-info btn-block" href="<?= $this->createUrl('recovery'); ?>"><?php echo Yii::t('app', 'Recuperar Contraseña'); ?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
    </div>
</div>