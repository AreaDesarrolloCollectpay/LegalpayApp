<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->number; ?></td>
    <td class = "txt_center">$ <?= Yii::app()->format->formatNumber($model->value); ?></td>
    <td class = "txt_center"><?= Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->date_expedition); ?></td>
    <td class = "txt_center"><?= Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->date_expiration); ?></td>
    <td class = "txt_center"><?= ($model->idInvocieState0 != null)? $model->idInvocieState0->name : ''; ?></td>
    <td class = "txt_center"><?= Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->date_pay); ?></td>
    <td class="txt_center icon_table">                             
        <?php if($model->file != ''){ ?>
        <a href="<?php echo ($model->file != '')? $model->file : '#'; ?>" class="inline padding" download><i class="fa fa-download" aria-hidden="true"></i></a> 
        <?php } ?>
    </td>
    <td class="txt_center icon_table">                             
        <?php if($model->support_pay != ''){ ?>
        <a href="<?php echo ($model->support_pay != '')? $model->support_pay : '#'; ?>" class="inline padding" download><i class="fa fa-download" aria-hidden="true"></i></a> 
        <?php } ?>
    </td>
    <td class="txt_center icon_table">                                  
        <a href="#new_invoice_modal" data-id="<?= $model->id; ?>" data-element="invoice-" class="inline padding tooltipped editInvoices modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>             
    </td>
</tr>

