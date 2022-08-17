<?php
$invoices = ViewNotificationInvoiceCustomer::model()->findAll(array('condition' => 't.idUser = '.$model->idUser));
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
    <tbody>
        <tr>
            <td valign="top" align="center">
                <table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                        <tr>
                            <td valign="middle" bgcolor="#FFFFFF" align="center">
                                <table class="two-left-inner" width="350" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td valign="middle" align="center">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                                    <tbody>                                        
                                                          <tr>
                                                            <td style="font-family:'Open Sans', Verdana, Arial; font-size:20px; color:#1e2848; font-weight:bold;" data-color="theme-colour" mc:edit="nm1-05" valign="middle" align="center"><multiline><?php echo Yii::t('front', 'HOLA').' '.Yii::t('front', $model->name); ?></multiline></td>
                                                          </tr>
                                                          <tr>
                                                              <td style="line-height:20px; font-size:20px;" valign="middle" align="center" height="20">&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                              <td style="font-family:'Open Sans', Verdana, Arial; font-size:15px; color:#767a86; font-weight:normal; line-height:28px;" mc:edit="nm1-06" valign="middle" align="center"><multiline><?php echo Yii::t('front', 'Recuerda que tienes pendiente el pago de las siguientes facturas :'); ?> </multiline></td>
                                                          </tr>
                                                          <tr>
                                                              <td style="line-height:20px; font-size:20px;" valign="middle" align="center" height="20">&nbsp;</td>
                                                          </tr>
                                                          <tr>                                                              
                                                                <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
                                                                    <tbody><tr>
                                                                      <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                                                                        <tbody><tr>
                                                                          <td valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                                                                            <tbody><tr>
                                                                              <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                              <td valign="top" align="left">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                                                                                  <thead>
                                                                                      <tr style="background-color: #5341ff;">
                                                                                          <th style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#fff;  font-weight:bold; line-height:34px;"><?php echo Yii::t('front', 'No. FACTURA'); ?></th>
                                                                                          <th style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#fff;  font-weight:bold; line-height:34px;"><?php echo Yii::t('front', 'FECHA VENCIMIENTO'); ?></th>
                                                                                          <th style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#fff;  font-weight:bold; line-height:34px;"><?php echo Yii::t('front', 'VALOR'); ?></th>
                                                                                      </tr>
                                                                                  </thead>
                                                                                  <tbody>
                                                                            <?php foreach ($invoices as $invoice){ ?>
                                                                                   <tr style="">                                                                                    
                                                                                    <td width="200" style="border:#efefef solid 1px; font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: center;" mc:edit="nm11-10" valign="top" align="center"><multiline><?php echo $invoice->number; ?></multiline></td>
                                                                                    <td width="200" style="border:#efefef solid 1px;font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: center;" mc:edit="nm11-10" valign="top" align="center"><multiline><?php echo Yii::app()->dateFormatter->format('dd/MM/yyyy', $invoice->date_expiration); ?></multiline></td>
                                                                                    <td width="200" style="border:#efefef solid 1px; font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: center;" mc:edit="nm11-10" valign="top" align="center"><multiline>$ <?php echo Yii::app()->format->formatNumber(round($invoice->total, 2)); ?></multiline></td>
                                                                                  </tr>
                                                                            <?php } ?>
                                                                                  </tbody>
                                                                                </table>
                                                                              </td>
                                                                            </tr>
                                                                            <tr>
                                                                              <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                                                                            </tr>
                                                                          </tbody></table></td>
                                                                        </tr>
                                                                      </tbody></table></td>
                                                                    </tr>
                                                                  </tbody>
                                                                  </table>
                                                              
                                                              
                                                          </tr>
                                                          <tr>
                                                              <td style="font-family:'Open Sans', Verdana, Arial; font-size:22px; color:#767a86; font-weight:bold; line-height:28px;" mc:edit="nm1-06" valign="middle" align="center"><multiline></multiline></td>
                                                          </tr>
                                                          <tr>
                                                              <td style="line-height:25px; font-size:25px;" valign="middle" align="center" height="25">&nbsp;</td>
                                                          </tr>
                                                  </tbody>
                                              </table>

                                          </td>
                                      </tr>                                      
                                      <tr>
                                          <td style="line-height:90px; font-size:90px;" valign="middle" align="center" height="90">&nbsp;</td>
                                      </tr>
                                  </tbody>
                              </table>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </td>
      </tr>
  </tbody>
</table>

