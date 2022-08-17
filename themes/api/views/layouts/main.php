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
        <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>/css/form.css" />
        <link href="<?php echo $base; ?>/css/cms.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            var pathurl = '<?php echo $base; ?>/';
            var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
        </script>
    </head>
    <body>
        <?php
            echo $content;
        ?>
    </body>
</html>