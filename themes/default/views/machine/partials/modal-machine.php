<!-- Modal chart machine -->
<section id="chart_modal" class="modal modal-lg">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'GRAFICA') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v">            
        <section class="padd_v">
            <div class="row"> 
                <article id="" class="block">                              
                    <div class="clear"></div>
                    <section class="padding m_t_20">
                        <div class="clearfix">                                        
                            <iframe id="iframe-chart-model" src="" style="width:100%; height:375px;" frameborder="0"></iframe>
                        </div>
                        <div class="clear"></div>
                    </section>
                </article>
            </div>
        </section>            
        <div class="clear"></div>
    </div>
</section>
<!-- Modal New model -->
<section id="mlModel_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'MODELO'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <!-- form mlmodels -->
</section>
<!-- Fin Modal New model -->
<!-- Cluster model -->
<section id="cluster_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'CLUSTERS'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <!-- form cluster -->
    <form class="formweb form-clusters" data-id="clusters-">
        <div class="row padd_v">                        
            <fieldset class="large-6 medium-6 small-12 columns padding">                                  
                <label><?php echo Yii::t('front', 'Codigo Cluster'); ?></label>                       
                <input id="clusters-clusterCode" name="clusterCode" type="text" value="" readonly />
                <label><?php echo Yii::t('front', 'Nombre'); ?></label>                       
                <input id="clusters-name" name="name" type="text" value="" />
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">                                  
                <label><?php echo Yii::t('front', 'Tags'); ?></label>                       
                <input id="clusters-tags" name="tags" type="text" value="">
                <label><?php echo Yii::t('front', 'Descripción'); ?></label>                       
                <textarea name="description" id="clusters-description" cols="30" rows="10"></textarea>                
            </fieldset>
            <input id="clusters-id" name="id" type="hidden" value="" />
            <div class="clear"></div>
        </div>
        <div class="modal-footer">    
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        </div>
    </form>
</section>
<!-- Fin Modal New cluster -->