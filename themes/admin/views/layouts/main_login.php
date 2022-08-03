<?php
    $this->Widget('ext.yii-toast.ToastrWidget');
    $base = Yii::app()->request->baseUrl;
    /* @var $this Controller */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
        <link rel="shortcut icon" type="image/ico" href="<?php echo $base; ?>/imaginamos.ico"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>/css/form.css" />
        <link href="<?php echo $base; ?>/css/cms.css" rel="stylesheet" type="text/css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script src="<?php echo $base; ?>/js/oLoader/js/jquery.oLoader.min.js"></script>
    </head>
    <body class="login">
        <div class="container-fluid">
        <?php echo $content; ?>
        </div>
        <footer class="text-center" >
            &copy; Copyright <?= date('Y'); ?> <cite title="imaginamos.com"><a href="http://www.imaginamos.com/" target="_blank">imaginamos.com</a> </cite>
        </footer>
        <script type="text/javascript">
            var pathurl = '<?php echo $base; ?>/';
            var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
            var messages = [];
            messages[0] = '<?php echo Yii::t('app', 'Seleccione...'); ?>';
            messages[5] = '<?php echo Yii::t('app', 'Caracteres máximos'); ?>';
            messages[6] = '<?php echo Yii::t('app', 'No se encontraron resultados'); ?>';
        </script>
        <script type="text/javascript" src="<?php echo $base; ?>/js/helper.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>/js/login.js"></script>
    </body>
</html>