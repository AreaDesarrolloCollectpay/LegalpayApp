<?php
$session = Yii::app()->session;
$idioma = $session['idioma'];
?>
<section class="cont_home">      
    <section class="cont_login animated fadeInDown">
        <div class="logo_login">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.svg" alt="Collectpay">
        </div>
        <div class="row">
            <form class="form_login form-confirm m_b_10" autocomplete="off">
                <fieldset class="large-12 medium-12 small-12 columns padding inputLogin">
                    <h2><?php // echo Yii::t('front', 'ACTIVAR CUENTA')  ?></h2>
                    <p class="m_t_10 txt_center" style="font-size: 18px;"><?php echo Yii::t('front', 'Estás a un paso de completar tu registro.'); ?></p> 
                </fieldset>        
                <div class="clear m_t_20"></div>
                <fieldset class="large-12 medium-12 small-12 columns">
                    <fieldset class="large-6 medium-6 small-6 columns padding inputLogin">                
                        <label for="icon_prefix"><?php echo Yii::t('front', 'Nombre / Razón social'); ?></label>
                        <input type="text" name="company" class="validate">
                    </fieldset>        
                    <fieldset class="large-6 medium-6 small-6 columns padding inputLogin">                
                        <label for="icon_prefix"><?php echo Yii::t('front', 'Industria'); ?></label>
                        <div class="input-field col s12">                    
                            <select name="idSector">
                                <option></option>
                                <?php foreach ($sectors as $sector) { ?>
                                    <option value="<?php echo $sector->id; ?>"><?php echo $sector->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </fieldset>        
                </fieldset>        
                <fieldset class="large-12 medium-12 small-12 columns">
                    <fieldset class="large-6 medium-6 small-6 columns padding inputLogin">                
                        <label for="icon_prefix"><?php echo Yii::t('front', 'Tipo de documento'); ?></label>
                        <div class="input-field col s12">                    
                            <select name="idTypeDocument">
                                <option></option>
                                <?php foreach ($typeDocuments as $typeDocument) { ?>
                                    <option value="<?php echo $typeDocument->id; ?>"><?php echo $typeDocument->name . ' - ' . $typeDocument->name_complete; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </fieldset>        
                    <fieldset class="large-6 medium-6 small-6 columns padding inputLogin">                
                        <label for="icon_prefix"><?php echo Yii::t('front', 'No. documento'); ?></label>
                        <input type="number" name="numberDocument" class="validate">
                    </fieldset>      
                </fieldset>        
                <fieldset class="large-12 medium-12 small-12 columns">
                    <fieldset class="large-6 medium-6 small-6 columns padding inputLogin">                
                        <label for="icon_prefix"><?php echo Yii::t('front', 'Teléfono'); ?></label>
                        <input type="number" name="phone" class="validate">
                    </fieldset>      
                    <fieldset class="large-6 medium-6 small-6 columns padding inputLogin">                
                        <label for="icon_prefix"><?php echo Yii::t('front', 'Dirección'); ?></label>
                        <input type="text" name="address" class="validate">
                    </fieldset>      
                </fieldset>    
                <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
                <div class="clear "></div>
                <fieldset class="large-12 medium-12 small-12 columns padding m_t_20">
                    <button type="submit" class="btnb waves-effect waves-light m_t_10" name="btnLogin"><?php echo Yii::t('front', 'Activar mi cuenta'); ?></button>                        
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
        <p><span>© <?php echo date('Y'); ?>  Collectpay</span>  -  <a style="color: #767a86;" target="_blank" class="hide" href="<?php echo Yii::app()->baseUrl; ?>/assets/TERMINOS_Y_CONDICIONES_COLLECT_PAY.pdf"><?php echo Yii::t('front', 'Términos de servicio'); ?></a>    <a style="color: #767a86;" target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/POLITICA_DE_TRATAMIENTO_Y_PROTECCION_DE_DATOS_PERSONALES.pdf"><?php echo Yii::t('front', 'Política de Privacidad'); ?></a></p>
    </div>
    <div class="lenguage m_t_20 hide">
        <p><?php echo Yii::t('front', 'Idioma'); ?>: <span class="leng<?php echo $idioma; ?>"></span></p>        
        <select class="changeLang" name="" id="">
            <option value="1" <?php echo ($idioma == 1) ? 'selected' : ''; ?> ><?php echo Yii::t('front', 'Español'); ?></option>
            <option value="2" <?php echo ($idioma == 2) ? 'selected' : ''; ?> ><?php echo Yii::t('front', 'Ingles'); ?></option>
        </select>
    </div>
    <!--/ Idioma -->

    <div class="clear"></div>
</section>

<div class="clear"></div>

<section class="footer_login hide">
    <p><span>© <?php echo date('Y'); ?>  Collectpay</span>  -  <a target="_blank" class="hide" href="<?php echo Yii::app()->baseUrl; ?>/assets/TERMINOS_Y_CONDICIONES_COLLECT_PAY.pdf"><?php echo Yii::t('front', 'Términos de servicio'); ?></a>    <a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/POLITICA_DE_TRATAMIENTO_Y_PROTECCION_DE_DATOS_PERSONALES.pdf"><?php echo Yii::t('front', 'Política de Privacidad'); ?></a></p>        
</section>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/auth.min.js', CClientScript::POS_END);
