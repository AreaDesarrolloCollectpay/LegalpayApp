<tr class="<?php echo ($cuota == '' || $cuota == 0)? 'hide' : ''; ?>">
    <td class = "txt_center"><?= $month; ?></td>
    <td class = "txt_center"><?= $m; ?></td>
    <td class = "txt_center"><?= $days; ?></td>
    <td class = "txt_center"><?= ($rate > '')? $rate.'%' : ''; ?></td>
    <td class = "txt_center"><?= ($cuota != '')? '$ '.number_format($cuota, 2, ',', '.') : 0; ?></td>
    <td class = "txt_center"><?= ($intereses != '')? '$ '.number_format($intereses, 2, ',', '.')  : 0; ?></td>
    <td class = "txt_center"><?= ($intereses != '')? '$ '.number_format($intereses, 2, ',', '.')  : 0; ?></td>
    <td class = "txt_center"><?= ($interestPending != '')? '$ '.number_format($interestPending, 2, ',', '.')  : 0; ?></td>
    <td class = "txt_center"><?= ($amortizacion != '')? '$ '.number_format($amortizacion, 2, ',', '.')  : 0; ?></td>
    <td class = "txt_center"><?= ($capitalpendiente != '')? '$ '.number_format($capitalpendiente, 2, ',', '.')  : 0; ?></td>
</tr>

