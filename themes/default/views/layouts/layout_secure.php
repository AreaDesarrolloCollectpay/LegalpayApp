<?php
$this->Widget('ext.yii-toast.ToastrWidget');
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
$idioma = $session['idioma'];
$terms = Controller::usersTerms();
$script = '';

$script .= "ShowTooltipped(" . $this->isMobile . ");";

if(isset($terms['show']) && $terms['show']){
    
    $script .= "setTimeout(function(){
            $('#check-terms').openModal({dismissible: false});
            console.log('terms');
        },300);";
}

$script .= Controller::hideOptionsProfiles();
  
Yii::app()->clientScript->registerScript("terms_js","
   $(document).ready(function(){    
        ".$script."
   });
   
",
 CClientScript::POS_END
); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<![endif]-->
<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>  <![endif]-->
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="content-language" content="es" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="copyright" content="cojunal.com" />
        <meta name="date" content="<?php echo date('Y'); ?>" />
        <meta name="author" content="diseño web: collectpay.co" />
        <meta name="robots" content="All" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/favicon.ico" />
        <link rel="author" type="text/plain" href="humans.txt" />
        <meta name="theme-color" content="#1f1a2e"/>
        <!--Style's-->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/app.css" rel="stylesheet" type="text/css" />        
<!--        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/jquery.steps.css" rel="stylesheet" type="text/css" />        -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/datatables.css" rel="stylesheet" type="text/css" />
        <!--<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />-->                
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/dual-listbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/dropify/css/dropify.min.css" />
        <!--<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/steps/jquery-1.9.1.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>        
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
         
        <script type="text/javascript">
            var idioma = "<?php echo $idioma ?>";
            var SITEURL = "<?php echo Yii::app()->getBaseUrl(true); ?>";
            var CALLSURL = "<?php echo Yii::app()->theme->baseUrl.'/assets/js/calls'; ?>";
            var configCalendar = {monthsFull:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],monthsShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],weekdaysFull:['Domingo','Lunes','Martes','Mi\xE9rcoles','Jueves','Viernes','S\xE1bado'],weekdaysShort: ['Dom','Lun','Mar','Mi\xE9','Jue','Vie','S\xE1b'],weekdaysLetter: [ 'D', 'L', 'M', 'X', 'J', 'V', 'S' ],today:'hoy',clear:'borrar',close:'cerrar',firstDay:1,format:'yyyy-mm-dd',formatSubmit:'yyyy-mm-dd',selectMonths:!0,selectYears:!0,container:'#root-picker-outlet'};                        
        </script>
        <?php if($this->isPay){ ?>
            <script type="text/javascript" src="https://maf.pagosonline.net/ws/fp/tags.js?id=<?php echo $this->deviceSessionId; ?>80200"></script>
            <noscript>
                    <iframe style="width: 100px; height: 100px; border: 0; position: absolute; top: -5000px;" src="https://maf.pagosonline.net/ws/fp/tags.js?id=<?php echo $this->deviceSessionId; ?>80200"></iframe>
            </noscript>
        <?php } ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143174481-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-143174481-1');
        </script>
    </head>

    <body class="<?php echo ($this->isLogin) ? 'bg_login' : ''; ?>" >       

        <section class="preload">
            <div class="progress"> <div class="indeterminate"></div></div>
            <div class="loading waves-button waves-effect waves-light">
                <div class="logo_load"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.svg"></div>
            </div>
        </section>
        <section class="content_all">

            <?php
            if (!Yii::app()->user->isGuest) {
                if(Yii::app()->user->getState('rol') != 0 && Yii::app()->user->getState('rol') != '' && !$this->isLogin){
                    $this->renderPartial("/layouts/partials/menu");                    
                }elseif(Yii::app()->user->getState('rol') == 0){
                    $this->renderPartial("/layouts/partials/menu_services");
                }
            }
            ?>

            <!--Contenidos Sitio-->
            <?php if (!$this->isLogin) { ?>
                <main>
                <?php } ?>
                <?php
                echo $content;
                ?>
                <footer>
                    <div class="large-5 medium-12 small-12 columns">
                        <p>© <?php echo date('Y'); ?> Collect Pay - <?php echo Yii::t('front', 'Todos los derechos reservados'); ?>.</p>
                    </div>
                    <div class="large-7 medium-12 small-12 columns txt_right">
                        <p class="page-link"><a target="_blank" class="" href="<?php echo Yii::app()->baseUrl; ?>/assets/TERMINOS_Y_CONDICIONES.pdf"><?php echo Yii::t('front', 'Términos y Condiciones'); ?></a>  -  <a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/POLITICA_DE_TRATAMIENTO_Y_PROTECCION_DE_DATOS_PERSONALES.pdf"><?php echo Yii::t('front', 'Política de Privacidad'); ?></a></p>
                        <div class="lenguage">
                            <p><?php Yii::t('front', 'Idioma'); ?>: <span class="leng<?php echo $idioma; ?>"></span></p>        
                            <select class="changeLang" name="" id="">
                                <option value="1" <?php echo ($idioma == 1)? 'selected' : ''; ?> ><?php echo Yii::t('front', 'Español'); ?></option>
                                <option value="2" <?php echo ($idioma == 2)? 'selected' : ''; ?> ><?php echo Yii::t('front', 'Ingles'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>  
                </footer>
                <?php if (!$this->isLogin) { ?>
                </main>
            <?php } ?>

        </section>  
        <?php
        if (!$this->isLogin) {
            $this->renderPartial("/general/partials/modal-general");
        }
        ?>                  
        
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/push.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/app.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/general.min.js"></script>  
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/dropify/js/dropify.min.js"></script>  
        <script src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
        <!--<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/steps/jquery.steps.js"></script>-->        
    </body>
</html>