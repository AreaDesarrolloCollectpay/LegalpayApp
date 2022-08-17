<?php
$this->Widget('ext.yii-toast.ToastrWidget');
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
  //Para probar idioma
Yii::app()->sourceLanguage = 'xx';
if($session['idioma']==2){
    Yii::app()->language = "en";
}else {
    Yii::app()->language = "es";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]>      <html class="lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="lt-ie7"> <![endif]-->
<!--[if IE 8]>         <html class="lt-ie8"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js ie10"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="viewport" content="width=device-width; initial-scale=1.0" />
        <meta charset="utf-8" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->baseUrl; ?>/assets/img/favicon.ico" />
        <meta name="Keywords" lang="es" content="palabras clave" />
        <meta name="Description" lang="es" content="" />
        <meta name="date" content="2014" />
        <meta name="author" content="diseño web: sits.com.co" />
        <meta name="robots" content="All" />
        <meta charset="utf-8">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->        
        <link rel="icon" href="<?php echo Yii::app()->baseUrl; ?>/assets/img/favicon.ico">

        
        <link href="<?php echo $base; ?>/assets/site/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo $base; ?>/assets/site/css/owl.carousel.css" rel="stylesheet" />
        <link href="<?php echo $base; ?>/assets/site/css/main.css" rel="stylesheet" />

        
        

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script type="text/javascript">
            var pathurl = '<?php echo $base; ?>/';
            var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
        </script>
    </head>
    <body>
    <div class="parallax_fixer"></div>
    <div class="loader"></div>
    
    <header>
        <?php 
            if($session['idioma']==2){
            ?>
                <a href="<?php echo $base; ?>/changeIdioma"><img src="<?php echo $base; ?>/assets/site/img/spain.png"></a>
            <?php 
            }else { 
            ?>
                <a href="<?php echo $base; ?>/changeIdioma"><img src="<?php echo $base; ?>/assets/site/img/usa.png"></a>
            <?php } ?>
        <a href="./">
            <img src="<?php echo $base; ?>/assets/site/img/logo.png" class="logo">
        </a>
        <div class="content_nav clearfix">
            <img src="<?php echo $base; ?>/assets/site/img/logo_nav.png" class="logo_nav">
            <nav class="clearfix">
                <a href="<?php echo Yii::app()->homeUrl; ?>"><?=Yii::t("site","inicio")?></a>
                <a href="<?php echo $this->createUrl('/aboutus'); ?>"><?=Yii::t("site","nosotros")?></a>
                <a href="<?php echo $this->createUrl('/services'); ?>"><?=Yii::t("site","servicios")?></a>
                <a href="<?php echo $this->createUrl('/contactus'); ?>"><?=Yii::t("site","contacto")?></a>
                <a href="<?php echo $this->createUrl('/iniciar-sesion'); ?>"><?=Yii::t("site","iniciarSesion")?></a>
            </nav>
        </div>
    </header>
            <?php   echo $content;  ?>
    <footer>
        <div class="main_container text-center">
            <nav>
               <a href="<?php echo Yii::app()->homeUrl; ?>"><?=Yii::t("site","inicio")?></a>
                <a href="<?php echo $this->createUrl('/aboutus'); ?>"><?=Yii::t("site","nosotros")?></a>
                <a href="<?php echo $this->createUrl('/services'); ?>"><?=Yii::t("site","servicios")?></a>
                <a href="<?php echo $this->createUrl('/contactus'); ?>"><?=Yii::t("site","contacto")?></a>
                <a href="<?php echo $this->createUrl('/iniciar-sesion'); ?>"><?=Yii::t("site","iniciarSesion")?></a>
            </nav>
        </div>
    </footer>

    <script src="<?php echo $base; ?>/assets/site/js/jquery.js"></script>
    <script src="<?php echo $base; ?>/assets/site/js/owl.carousel.js"></script>
    <script src="<?php echo $base; ?>/assets/site/js/bootstrap.min.js"></script>
    <script src="<?php echo $base; ?>/assets/site/js/tweenmax.js"></script>
    <script src="<?php echo $base; ?>/assets/site/js/functions.js"></script>

    
  
    </body>
</html>
