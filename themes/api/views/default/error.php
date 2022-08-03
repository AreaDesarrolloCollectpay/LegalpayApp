<?php
/* @var $this SiteController */
/* @var $error array */
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Error');
?>
<div class="alert alert-danger" role="alert">
    
    <span class="sr-only">Error:</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <?php echo Yii::t('app', 'Error'); ?> <strong><?php echo $code; ?></strong></h2>
    <p>
        <?php echo CHtml::encode($message); ?>
    </p>
</div>