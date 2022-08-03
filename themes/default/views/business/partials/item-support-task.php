<tr id="itemSupportWallet-<?= $model->id; ?>">
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->date)); ?></td>
    <td class = "txt_center hide"><?= $model->adviser; ?></td>
    <td class = "txt_center"><?= $model->management; ?></td>
    <td class="txt_center"><?= nl2br($model->comments); ?></td>    
</tr>

