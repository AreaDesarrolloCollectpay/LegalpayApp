<tr>
    <td class="txt_center"><?= $model->name; ?></td> 
    <td class="txt_center"><?= nl2br($model->description); ?></td> 
    <td class="txt_center"><?= $model->dataset; ?></td> 
    <td class="txt_center icon_table">                                  
        <a href="#mlModel_modal" data-id="<?= $model->id; ?>" data-element="mlModels-" class="inline padding tooltipped editMlModel modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>         
        <a href="<?php echo $this->createUrl('/machine/clusters/'.$model->id); ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front','Clusters'); ?>"><i class="fas fa-project-diagram" aria-hidden="true"></i></a> 
        <a href="#chart_modal" class="inline padding tooltipped getChart modal_clic"  data-chart="<?= $model->urlBigML; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Grafica'); ?>"><i class="fas fa-chart-line" aria-hidden="true"></i></a> 
    </td>
</tr>