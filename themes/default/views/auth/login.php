<?php 
$session = Yii::app()->session;
$idioma = $session['idioma'];
?>
<section class="cont_home">      
        
    <section  class="cont_login animated fadeInDown">
        <div class="logo_login">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.svg" alt="LegalPay">
        </div>
        <div id="form-login">
            <form  class="form_login form-login" autocomplete="off">           
                <!-- <h2><?php echo Yii::t('front', 'Inicio de Sesión') ?></h2>
                <p><?php echo Yii::t('front', 'a su cuenta en Cojunal'); ?></p> -->
                <fieldset class="inputLogin">                
                    <label for="icon_prefix"><?php echo Yii::t('front', 'Usuario'); ?></label>
                    <input type="text" name="user" class="validate">
                </fieldset>        
                <fieldset class="inputLogin">                
                    <label for="icon_prefix"><?php echo Yii::t('front', 'Contraseña'); ?></label>
                    <input type="password" name="passwd" class="validate">
                </fieldset>
                <section class="p_b_10">  
                    <div class="large-6 medium-6 small-5 columns">
    <!--                    <input type="checkbox" class="filled-in" id="recordarme" checked="checked" />
                        <label for="recordarme"><?php echo Yii::t('front', 'Recordarme'); ?></label>-->
                        <a class="link2 left register-show" href="#"><?php echo Yii::t('front', '¿No tienes una cuenta?'); ?></a>
                    </div>  
                    <div class="large-6 medium-6 small-7 columns">
                        <a class="link2 link_recup_pass modal_clic txt_right" href="#modal-recover"><?php echo Yii::t('front', '¿Olvidaste tu contraseña?'); ?></a>
                    </div>  
                    <div class="clear"></div>
                </section>        
                <div class="g-recaptcha" data-sitekey="<?php echo PUBLIC_KEY_GOOGLE ?>"></div>
                <div class="clear"></div>
                <button type="submit" class="btnb waves-effect waves-light" name="btnLogin"><?php echo Yii::t('front', 'Ingresar'); ?></button>        
            </form>  
        </div>
        <div id="form-register" class="row" style="display: none;">
            <form action="" class="form-register form_login " >
                <fieldset class="large-6 medium-6 small-12 columns padding inputLogin">
                    <label><?php echo Yii::t('front', 'Nombres y Apellidos'); ?></label>
                    <input type="text" id="register-name" name="name" placeholder="" value="">                                      
                    <label><?php echo Yii::t('front', 'Contraseña'); ?></label>  
                    <input type="password" id="register-passwd" name="psswd" value="">  
                </fieldset>
                <fieldset class="large-6 medium-6 small-12 columns padding inputLogin">
                    <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>  
                    <input id="register-email" name="email" type="text" value="">
                    <label><?php echo Yii::t('front', 'Confirmar Contraseña'); ?></label>  
                    <input type="password" id="register-mobile" name="psswd_confirm" value=""> 
                </fieldset>
                <fieldset class="large-6 medium-6 small-12 columns padding">
                    <p>
                        <input type="checkbox" class="filled-in" id="register-terms" name="terms" checked="checked" value="1" />
                        <label for="register-terms"><a class="" target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/TERMINOS_Y_CONDICIONES.pdf" style="color: #1e2848;"><?php echo Yii::t("front", "Términos y Condiciones"); ?> </a></label>
		    </p>
		     <div class="g-recaptcha" data-sitekey="<?php echo PUBLIC_KEY_GOOGLE ?>"></div>	 		
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding m_t_20">                    
<!--                    <fieldset class="large-6 medium-6 small-6 columns padd_v">                      
                        <div class="txt_center block padding "> 
                        </div>
                    </fieldset>-->
                    <button class="btnb waves-effect waves-light  right"><?php echo Yii::t('front', 'CREAR CUENTA'); ?></button>
                    <a href="#!" class="btnb-back waves-effect waves-light right padding back-login"><i class="fas fa-chevron-left"></i>&nbsp;</a>
<!--                    <fieldset class="large-6 medium-6 small-6 columns padd_v">                      
                        <div class="txt_center block padding">
                        </div>
                    </fieldset>-->
                </fieldset>    
            </form>
        </div>
    </section>

    <div class="clear"></div>
    
    <!-- <a href="#" class="loginGoolgle">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/icons/icon-google.png">
        <?php echo Yii::t('front', 'Iniciar sesión con Google'); ?>
    </a>-->

    <!-- Idioma -->
    <div class="txt_center m_t_20">
        <p><span>© <?php echo date('Y'); ?>  Legal Pay</span>  -  <a style="color: #767a86;" target="_blank" class="" href="<?php echo Yii::app()->baseUrl; ?>/assets/TERMINOS_Y_CONDICIONES.pdf"><?php echo Yii::t('front', 'Términos y Condiciones'); ?></a>  -  <a style="color: #767a86;" target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/POLITICA_DE_TRATAMIENTO_Y_PROTECCION_DE_DATOS_PERSONALES.pdf"><?php echo Yii::t('front', 'Política de Privacidad'); ?></a></p>
    </div>
    <div class="lenguage m_t_20 hide">
        <p><?php echo Yii::t('front', 'Idioma'); ?>: <span class="leng<?php echo $idioma; ?>"></span></p>        
        <select class="changeLang" name="" id="">
            <option value="1" <?php echo ($idioma == 1)? 'selected' : ''; ?> ><?php echo Yii::t('front', 'Español'); ?></option>
            <option value="2" <?php echo ($idioma == 2)? 'selected' : ''; ?> ><?php echo Yii::t('front', 'Ingles'); ?></option>
        </select>
    </div>
    <!--/ Idioma -->

    <div class="clear"></div>
</section>

<div class="clear"></div>

<section class="footer_login hide">
    <p><span>© <?php echo date('Y'); ?>  Collectpay</span>  -  <a target="_blank" class="hide" href="<?php echo Yii::app()->baseUrl; ?>/assets/TERMINOS_Y_CONDICIONES_COLLECT_PAY.pdf"><?php echo Yii::t('front', 'Términos de servicio'); ?></a>    <a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/POLITICA_DE_TRATAMIENTO_Y_PROTECCION_DE_DATOS_PERSONALES.pdf"><?php echo Yii::t('front', 'Política de Privacidad'); ?></a></p>        
</section>


<!-- Modal Contraseña -->
<section id="modal-recover" class="modal modal-s">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'RECUPERAR MI CONTRASEÑA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="modal-content">
        <div class="form_recuperar">   
            <p class="txt_center"><?php echo Yii::t('front', 'Introduce tu dirección de correo electrónico y te enviaremos una nueva contraseña.'); ?></p>
            <form class="form-recover-pass formweb">
                <fieldset class="large-12 medium-12 small-12 columns padding">
                    <label for="icon_prefix"><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>
                    <input type="email" name="email" id="recover-email" class="">
                </fieldset>         
                <section class="txt_center">
                    <button type="submit" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'Recuperar.'); ?></button>
                </section>
            </form>
        </div>
    </div>
</section>
<!-- Fin Modal Contraseña -->


<!-- Modal Register -->
<section id="form_register" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'CREAR MI CUENTA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <section class="padd_all m_t_10">
        <ul class="tabs tab_cartera hide">
            <li class="tab" style="width: 30% !important;"><a href="#legal_person"><i class="fa fa-building"></i><?php echo Yii::t('front', 'PERSONA JURIDICA'); ?></a></li>
            <li class="tab" style="width: 30% !important;"><a href="#natural_person"><i class="fa fa-user"></i><?php echo Yii::t('front', 'PERSONA NATURAL'); ?></a></li>
        </ul>
        <section class="padd_v">
            <!--Tab 1-->
            <article id="legal_person" class="block">
                <form action="" class="formweb form-reddgister" >
                    <fieldset class="large-6 medium-6 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Nombres y Apellidos'); ?></label>
                        <input type="text" id="legal-register-name" name="name" placeholder="" value="">                                      
                        <label><?php echo Yii::t('front', 'Contraseña'); ?></label>  
                        <input type="password" id="legal-register-passwd" name="psswd" value="">  
                        <p class="">
                            <input type="checkbox" class="filled-in" id="register-termds" name="termds" checked="checked" value="1" />
                            <label for="termds" style="padding: 6px 0 0 34px;"><a class="modal_clic" href="" style="color: #1e2848;"><?php echo Yii::t("front", "Política de Privacidad"); ?> </a></label>
                        </p>
                    </fieldset>
                    <fieldset class="large-6 medium-6 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Email'); ?></label>  
                        <input id="legal-register-email" name="email" type="text" value="">
                        <label><?php echo Yii::t('front', 'Confirmar Contraseña'); ?></label>  
                        <input type="password" id="legal-register-mobile" name="psswd_confirm" value=""> 
                    </fieldset>
                    <fieldset class="large-12 medium-12 small-12 columns padd_v">  
                        <div class="txt_center block padding ">
                            <button class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'CREAR CUENTA'); ?></button>
                        </div>
                    </fieldset>
                </form>
                <div class="clear"></div> 
            </article>
            <!--Tab 2-->
            <article id="natural_person" class="block">
                <form action="" class="formweb " data-id="natural-register-">
                    <fieldset class="large-6 medium-6 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'Nombre'); ?></label>
                        <input type="text" id="natural-register-name" name="name" placeholder="" value="">                                        
                        <label><?php echo Yii::t('front', 'País'); ?></label>
                        <select id="natural-register-idCountry" name="idCountry"  class="select-country">
                        </select>                                                                 
                        <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                        <select id="natural-register-idCity" name="idCity" class="debtor-idCity" >
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                        </select>
                        <label><?php echo Yii::t('front', 'Teléfono'); ?></label>
                        <input type="text" id="natural-register-phone" name="phone" value="">   
                        <label><?php echo Yii::t('front', 'Email'); ?></label>  
                        <input id="natural-register-email" name="email" type="text" value="">
                        <p class="">
                            <input type="checkbox" class="filled-in" id="natural-register-tertms" name="termus" checked="checked" />
                            <label for="termus" style="padding: 6px 0 0 34px;"><?= str_replace("::url", "</a>", str_replace("url::", "<a href='#terms-modal' class=\"modal_clic\">", Yii::t("front", "Términos y Condiciones"))) ?></label>
                        </p>
                    </fieldset>
                    <fieldset class="large-6 medium-6 small-12 columns padding">
                        <label><?php echo Yii::t('front', 'CC'); ?></label>
                        <input type="text" id="natural-register-code" name="code" value="">
                        <label><?php echo Yii::t('front', 'Departamento'); ?></label>
                        <select id="natural-register-idDepartment" name="idDepartment" class="select-department">
                            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                        </select>
                        <label><?php echo Yii::t('front', 'Dirección'); ?></label>
                        <input type="text" id="natural-register-address" name="address" value="" class="">                        
                        <label><?php echo Yii::t('front', 'Celular'); ?></label>
                        <input type="text" id="natural-register-mobile" name="mobile" value="" class="">
                    </fieldset>
                    <fieldset class="large-12 medium-12 small-12 columns padd_v">  
                        <div class="txt_center block padding ">
                            <button class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'GUARDAR'); ?></button>
                        </div>
                    </fieldset>
                </form>
                <div class="clear"></div> 
            </article>
        </section>
    </section>
      
</section>
<!-- Fin Modal Register -->
<script>
    $(function () {
        
        $('body').on('click', '.register-show', function (e) {
            e.preventDefault();
            var _this = $(this);
            if(_this.hasClass('display-register')){
                $('#form-register').hide();
                $('#form-login').show();
                _this.removeClass('display-register');
            }else{
                $('#form-login').hide();
                $("#form-register").show();
               _this.addClass('display-register');
            }
        });
        
       
    });
</script>
<?php
Yii::app()->clientScript->registerScriptFile('https://www.google.com/recaptcha/api.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/js/auth.min.js', CClientScript::POS_END);
