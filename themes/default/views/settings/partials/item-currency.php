<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->currency; ?></td>
    <td class = "txt_center">$ <?= Yii::app()->numberFormatter->format("#,##0.00", $model->value); ?></td>
    <td class="txt_center icon_table">                                  
        <a href="#new_currency_modal" data-id="<?= $model->id; ?>" data-element="currency-" class="inline padding tooltipped editCurrency modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>         
    </td>
</tr>