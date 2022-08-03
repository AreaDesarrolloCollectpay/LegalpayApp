<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Comprobante Collectpay</title>
</head>
<body>

<!--Inicio Mailling -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3">
  <tbody>
    <tr>
      <td valign="middle" align="center">    
     
      <!--Top Space Start-->
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody><tr>
          <td valign="top" align="center">
            <table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody>
                <tr>
                  <td style="line-height:40px; font-size:40px;" valign="middle" align="center" height="40">&nbsp;</td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr></tbody>
      </table>
      <!--Top Space End-->

      <!--Logo Part Start-->
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody><tr>
          <td valign="top" align="center">
            <table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                <td valign="middle" align="center">
                  <table width="165" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                      <td valign="middle" align="center">
                      </td>
                    </tr>
                    <tr>
                     <td style="line-height:30px; font-size:30px;" valign="middle" align="center" height="30">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr></tbody>
          </table>
        </td>
        </tr></tbody>
      </table>
      <!--Logo Part End-->
  
      <!--Title Part Start-->
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="-moz-border-radius: 8px 8px 0px 0px; -webkit-border-radius: 8px 8px 0px 0px; border-radius: 8px 8px 0px 0px;">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="-moz-border-radius: 8px 8px 0px 0px; -webkit-border-radius: 8px 8px 0px 0px; border-radius: 8px 8px 0px 0px; background-color: #1f1a2e;" align="middle" bgcolor="#1f1a2e" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody><tr>
                 <td style="line-height:25px; font-size:25px;" valign="middle" align="center" height="25">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family:'Open Sans', Verdana, Arial; font-size:30px; color:#FFF; font-weight:normal;" mc:edit="nm1-02" valign="middle" align="center">
                      <img src="<?php echo Yii::app()->controller->createAbsoluteUrl('/mailling/img/logo.png'); ?>" height="60px" alt="Collectpay" style="height: 60px;">
                  </td>
                  </tr>
                <tr>
                 <td style="line-height:25px; font-size:25px;" valign="middle" align="center" height="25">&nbsp;</td>
                  </tr>
              </tbody></table></td>
            </tr>
          </tbody></table></td>
        </tr>
      </tbody></table>
      <!--Title Part End-->

      <!--Content Part Start-->
      <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px; border-top:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="25">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; line-height:28px; font-weight:bold;" mc:edit="nm11-07" valign="top" align="center"><multiline><?php echo Yii::t('front', 'COMPROBANTE DE LA TRANSACCIÓN'); ?></multiline></td>
                </tr>
                <tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="25">&nbsp;</td>
                </tr>
              </tbody></table></td>
            </tr>
          </tbody></table></td>
        </tr>
      </tbody></table>
      <!--Item produt-->
      <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                      <tbody><tr>
                        <td width="220" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848;  font-weight:bold; line-height:34px;" mc:edit="nm11-08" valign="top" align="left"><multiline><?php echo Yii::t('front', 'EMPRESA'); ?>:</multiline></td>
                        <td width="200" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: right;" mc:edit="nm11-10" valign="top" align="right"><multiline><?php echo Yii::app()->params['company']; ?></multiline></td>
                      </tr>
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
      <!--Fin Item produt-->
      <!--Item produt-->
      <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                      <tbody><tr>
                        <td width="220" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848;  font-weight:bold; line-height:34px;" mc:edit="nm11-08" valign="top" align="left"><multiline><?php echo Yii::t('front', 'NIT'); ?>:</multiline></td>
                        <td width="200" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: right;" mc:edit="nm11-10" valign="top" align="right"><multiline><?php echo Yii::app()->params['company_ID']; ?></multiline></td>
                      </tr>
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
      <!--Fin Item produt-->
      <!--Item produt-->
      <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                      <tbody><tr>
                        <td width="220" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848;  font-weight:bold; line-height:34px;" mc:edit="nm11-08" valign="top" align="left"><multiline><?php echo Yii::t('front', 'FECHA'); ?>:</multiline></td>
                        <td width="200" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: right;" mc:edit="nm11-10" valign="top" align="right"><multiline><?php echo ($model != null)? Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->dateCreated) : ''; ?></multiline></td>
                      </tr>
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
      <!--Fin Item produt-->
      <!--Item produt-->
      <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                      <tbody><tr>
                        <td width="220" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848;  font-weight:bold; line-height:34px;" mc:edit="nm11-08" valign="top" align="left"><multiline><?php echo Yii::t('front', 'ESTADO'); ?>:</multiline></td>
                        <td width="200" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: right;" mc:edit="nm11-10" valign="top" align="right"><multiline><?php echo ($model != null)? $model->idPaymentsState0->name : ''; ?></multiline></td>
                      </tr>
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
      <!--Fin Item produt-->
      <!--Item produt-->
      <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                      <tbody><tr>
                        <td width="220" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848;  font-weight:bold; line-height:34px;" mc:edit="nm11-08" valign="top" align="left"><multiline><?php echo Yii::t('front', 'REFERENCIA DE PEDIDO'); ?>:</multiline></td>
                        <td width="200" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: right;" mc:edit="nm11-10" valign="top" align="right"><multiline><?php echo ($model != null)? $model->order_id : ''; ?></multiline></td>
                      </tr>
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
      <!--Fin Item produt-->
      <!--Item produt-->
      <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                      <tbody><tr>
                        <td width="220" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848;  font-weight:bold; line-height:34px;" mc:edit="nm11-08" valign="top" align="left"><multiline><?php echo Yii::t('front', 'IP ORIGEN'); ?>:</multiline></td>
                        <td width="200" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: right;" mc:edit="nm11-10" valign="top" align="right"><multiline><?php echo ($model != null)? $model->debtorsPaymentsPayers[0]->ip_address : ''; ?></multiline></td>
                      </tr>
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
      <!--Fin Item produt-->
      <table  width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f3f3" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td style="border-bottom:#efefef solid 1px;" valign="middle" bgcolor="#FFFFFF" align="center"><table width="485" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="font-size:20px; line-height:5px;" valign="top" align="left" height="5">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="padding: 0 30px;">
                      <tbody><tr>
                        <td width="220" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848;  font-weight:bold; line-height:34px;" mc:edit="nm11-08" valign="top" align="left"><multiline><?php echo Yii::t('front', 'VALOR'); ?>:</multiline></td>
                        <td width="200" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#1e2848; font-weight:normal; line-height:28px; text-align: right;" mc:edit="nm11-10" valign="top" align="right"><multiline>$<?php echo Yii::app()->format->formatNumber($model->value); ?></multiline></td>
                      </tr>
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
      <!--Content Part End-->

      <!--Copyright Part Start-->
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody><tr>
          <td valign="top" align="center"><table class="main" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody><tr>
              <td valign="middle" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody><tr>
                  <td style="line-height:40px; font-size:40px;" valign="middle" align="center" height="40">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="center"><table class="full" width="355" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody><tr>
                      <td style="font-family:'Open Sans', Verdana, Arial; font-size:13px; color:#a5a5a5; font-weight:normal; line-height:24px;" mc:edit="nm1-14" valign="top" align="center"><multiline>Copyright © 2018 - <a href="https://www.collectpay.co" target="_blank" style="color:#a5a5a5;font-family:'Open Sans', Verdana, Arial; font-size:13px; text-decoration: none;">Collectpay.co</a></multiline></td>
                    </tr>
                  </tbody></table></td>
                </tr>
                <tr>
                  <td style="line-height:40px; font-size:40px;" valign="middle" align="center" height="40">&nbsp;</td>
                </tr>
              </tbody></table></td>
            </tr>
          </tbody></table></td>
        </tr>
        </tbody>
      </table>
      <!--Copyright Part End-->

    </td>
  </tr></tbody>
</table>      
<!--Inicio Mailling -->
  
</body>
</html>