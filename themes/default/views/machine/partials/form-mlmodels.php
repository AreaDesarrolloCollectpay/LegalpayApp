<form class="formweb form-mlModels hide" id="mlModels-<?php echo $model->id; ?>" data-id="mlModels-<?php echo $model->id; ?>-">
    <div class="row padd_v">                        
        <fieldset class="large-6 medium-6 small-12 columns padding">                                  
            <label><?php echo Yii::t('front', 'Nombre del Modelo'); ?></label>                       
            <input id="mlModels-<?php echo $model->id; ?>-name" name="name" type="text" value="<?php echo $model->name; ?>" />
        </fieldset>
        <fieldset class="large-6 medium-6 small-12 columns padding">                                  
            <label><?php echo Yii::t('front', 'Fuente de Datos'); ?></label>                       
            <input id="mlModels-<?php echo $model->id; ?>-dataset" name="dataset" type="text" value="<?php echo $model->dataset; ?>" />
            <input id="mlModels-<?php echo $model->id; ?>-id" name="id" type="hidden" value="<?php echo $model->id; ?>" />
        </fieldset>
        <fieldset class="large-6 medium-6 small-12 columns padding hide">                                  
            <label><?php echo Yii::t('front', 'Url BigMl'); ?></label>                       
            <input id="mlModels-<?php echo $model->id; ?>-urlBigML" name="urlBigML" type="text" value="https://bigml.com/embedded/<?php echo $model->urlBigML; ?>">
            <label><?php echo Yii::t('front', 'Url BigMl Embedded'); ?></label>                       
            <input id="mlModels-<?php echo $model->id; ?>-urlEmbedded" name="urlEmbedded" type="text" value="https://bigml.com/embedded/<?php echo $model->urlEmbedded; ?>">
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding">                                  
            <label><?php echo Yii::t('front', 'Descripción'); ?></label>                       
            <textarea name="description" id="mlModels-<?php echo $model->id; ?>-description" cols="30" rows="10"><?php echo $model->description; ?></textarea>                
        </fieldset>
        <div class="clear"></div>
    </div>
</form>
<div class="block m_t_10">
    <ul class="tabs tab_cartera">
        <li class="tab" style="width: 11px !important; float: right;"><a href="#chart_2">&nbsp;<i class="feather feather-more-horizontal"></i>&nbsp;</a></li>
        <li class="tab" style="width: 11px !important; float: right;"><a href="#chart_1">&nbsp;<i class="feather  feather-pie-chart"></i>&nbsp;</a></li>
    </ul>
</div>
<article id="chart_1" class="block"> 
    <fieldset class="large-12 medium-12 small-12 columns" id="mlModels-<?php echo $model->id; ?>-iframeExplain" ></fieldset>        
</article>
<article id="chart_2" class="block"> 
    <fieldset class="large-12 medium-12 small-12 columns" id="mlModels-<?php echo $model->id; ?>-iframeEmbedded" ></fieldset>
</article>