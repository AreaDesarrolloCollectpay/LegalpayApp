<tr style="cursor:pointer" onClick="document.location.href = '<?php echo $model->url; ?>';">
    <td><b><?php echo $model->messages->typeNot->name; ?></b><br>
            <?php echo $model->message; ?>
    </td>
    <td class="txt_right padding"><b><?php echo $model->getTime(); ?></b></td>
    <td></td>
</tr>

