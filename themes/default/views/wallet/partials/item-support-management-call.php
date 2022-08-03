<?php $model->getCallInfo(); ?>
<form class="form-management-call formweb" enctype="multipart/form-data"> 
    <fieldset class="large-6 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Número'); ?></label>
            <input name="number" id="tasks-call-number" type="text" class="" value="" readonly="readonly" />
    </fieldset>
    <fieldset class="large-6 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Duración'); ?>*</label>
            <input name="duration" id="tasks-calll-duration" type="text" class="" value="" readonly="readonly"/>
    </fieldset>
    <fieldset class="large-12 medium-12 small-12 columns padding">            
        <label><?php echo Yii::t('front', 'Audio'); ?></label>
        <audio controls>
            <source src="horse.ogg" type="audio/ogg">
            <source src="horse.mp3" type="audio/mpeg">
        </audio>
    </fieldset>
</form>