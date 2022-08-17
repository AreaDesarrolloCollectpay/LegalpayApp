<tr id="cluster-<?php echo $model->id; ?>">
    <td class="txt_center"><?= $model->name; ?></td> 
    <td class="txt_center"><?= nl2br($model->description); ?></td> 
    <td class="txt_center icon_table">                                  
        <a href="#cluster_modal" data-id="<?= $model->id; ?>" data-element="clusters-" class="inline padding tooltipped editCluster modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>         
    </td>
</tr>