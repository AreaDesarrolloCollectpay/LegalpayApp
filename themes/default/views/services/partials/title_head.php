<div class="tittle_head">
    <h2 class="inline"><?= Yii::t("front", "Hola"); ?> <?= (Yii::app()->user->getState('title') != '')? Yii::app()->user->getState('title') : ''; ?></h2>                
</div>
<div class="clear"></div>  