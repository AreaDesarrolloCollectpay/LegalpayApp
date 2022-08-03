<?php
$this->Widget('ext.yii-toast.ToastrWidget');
$base = Yii::app()->request->baseUrl;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]>      <html class="lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="lt-ie7"> <![endif]-->
<!--[if IE 8]>         <html class="lt-ie8"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js ie10"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=1024, maximum-scale=2" />
        <meta charset="utf-8" />
        <meta name="language" content="es" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $base; ?>/favicon.ico" />
        <meta name="Keywords" lang="es" content="palabras clave" />
        <meta name="Description" lang="es" content="texto empresarial" />
        <meta name="date" content="2013" />
        <meta name="author" content="diseño web: imaginamos.com" />
        <meta name="robots" content="All" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script type="text/javascript">
            var pathurl = '<?php echo $base; ?>/';
            var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
            var messages = [];
            messages[0] = '<?php echo Yii::t('app', 'Seleccione...'); ?>';
            messages[5] = '<?php echo Yii::t('app', 'Caracteres máximos'); ?>';
            messages[6] = '<?php echo Yii::t('app', 'No se encontraron resultados'); ?>';
        </script>
    </head>
    <body class="modal">
        <?php
            echo $content;
        ?>
    </body>
</html>