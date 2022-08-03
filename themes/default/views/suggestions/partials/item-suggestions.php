<tr id="itemUsers-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->dateCreated; ?></td>
    <td class = "txt_center"><?= $model->title; ?></td>
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->comments; ?></td>
    <td class="txt_center icon_table hide">                                  
        <a href="#new_customers_modal" data-id="<?= $model->id; ?>" data-element="customers-" class="inline padding tooltipped editSuggestion modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
    </td>
</tr>

