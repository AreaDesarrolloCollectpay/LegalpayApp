<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Api');
$base = Yii::app()->request->baseUrl;
?>
<div class="row">
    <div class="col-lg-3 col-md-3">
    </div>
    <div class="col-lg-6 col-md-6 col-xs-12">        
        <div class="panel panel-primary">
            <div class="panel-heading text-center"><img class="img-responsive img-logo-login" src="<?php echo $base; ?>/img/logo.png" alt="logo" /></div>
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="jumbotron">
                        <h1><?php echo Yii::t('app', 'Acceso al Api 1.0'); ?></h1>
                        <p>Bienvenido</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
    </div>
</div>