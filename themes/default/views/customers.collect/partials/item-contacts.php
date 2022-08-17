<tr id="itemContact-<?= $model->id; ?>">
    <td class = "txt_center"><?= $model->name; ?></td>
    <td class = "txt_center"><?= $model->mobile; ?></td>
    <td class = "txt_center"><?= $model->phone; ?></td>
    <td class = "txt_center"><?= $model->email; ?></td>
    <td class = "txt_center"><?= $model->position; ?></td>
    <td class = "txt_center"><?= $model->idCity0->name; ?></td>
    <td class="txt_center icon_table">                                  
        <a href="#new_contacts_modal" data-id="<?= $model->id; ?>" data-element="form-contacts-" class="inline padding tooltipped editContacts modal_clic" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>                
    </td>
</tr>