<?php 
$session = Yii::app()->session;
$idioma = $session['idioma'];
?>
<section class="cont_home">      
    <section class="cont_login animated fadeInDown">
        <div class="logo_login">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.svg" alt="Collectpay">
        </div>
        <form class="form_login login_services" autocomplete="off">  
            <fieldset class="">
                <h2 style="text-transform: uppercase;
    margin: 0 auto 5px;
    font-family: 'nerislight';
    font-size: 26px;
    font-weight: bold;
    line-height: 29px;
    color: #1e2848;"><?php echo Yii::t('front', 'Pagos en línea') ?></h2>
            <!--<p><?php echo Yii::t('front', 'Realiza el pago de tus obligaciones'); ?></p>-->
            </fieldset>
            <fieldset class="m_t_20"> 
                <label for="icon_prefix"><?php echo Yii::t('front', 'Tipo de Documento'); ?></label>
                <div class="input-field">
                    <select name="passwd" class="">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                        <?php foreach ($typeDocuments as $typeDocument) { ?>
                            <option value="<?php echo $typeDocument->id; ?>"><?php echo $typeDocument->name_complete.'('.$typeDocument->name.')'; ?></option>
                        <?php } ?>
                    </select>
                  </div>
            </fieldset>        
            <fieldset class="m_t_10">                
                <label for="icon_prefix"><?php echo Yii::t('front', 'Número'); ?></label>
                <input type="text" name="user" class="validate">
            </fieldset>  
            <section class="p_b_10">  
                <div class="large-12 medium-12 small-12 columns">
                    <input type="checkbox" name="terms" class="filled-in" id="terms" value="1" />
                    <label for="terms"><a style="color: #767a86 !important; font-family: 'nerislight' !important;" target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/POLITICA_DE_TRATAMIENTO_Y_PROTECCION_DE_DATOS_PERSONALES.pdf"><?php echo Yii::t('front', 'He leído y acepto las políticas de privacidad'); ?></a></label>
                    <a class="link2 link_recup_pass left modal_clic" href="#form_register"><?php // echo Yii::t('front', '¿No tienes cuenta?'); ?></a>
                </div>  
                <div class="clear"></div>
            </section> 
            <div class="g-recaptcha" data-sitekey="<?php echo PUBLIC_KEY_GOOGLE ?>"></div>
            <div class="clear"></div>
            <button type="submit" class="btnb large waves-effect waves-light" name="btnLogin"><?php echo Yii::t('front', 'Ingresar'); ?></button>        
        </form>         
            <div class="clear"></div>
            <p class="m_t_20 padding" style="text-align: center;">Si tienes alguna duda o presentas algún inconveniente para ingresar, por favor escríbenos a atencionalcliente@collectpay.co o llámanos en BOGOTA DC al +57(1) 747 0677 de lunes a viernes de 7:30 a.m. a 5:30 p.m., jornada continua.</p>
    </section>

    <div class="clear"></div>
    
    <!-- Idioma -->
    <div class="lenguage m_t_20 txt_center">
        <div style="display: block; margin-left: auto; margin-right: auto; width: 90%; max-width: 358px;"  href="http://www.payulatam.com/logos/pol.php?l=133&c=5b8d41496adb8" target="_blank"><img style="width: 100%;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/payu-alliances_.png" alt="PayU Latam" border="0" /></a>        
    </div>
    <!--/ Idioma -->

    <div class="clear"></div>
</section>

<div class="clear"></div>

<section class="footer_login">
    <p><span>© <?php echo date('Y'); ?>  Collectpay</span> </p>        
</section>

<?php
Yii::app()->clientScript->registerScriptFile('https://www.google.com/recaptcha/api.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/js/services.min.js', CClientScript::POS_END);
