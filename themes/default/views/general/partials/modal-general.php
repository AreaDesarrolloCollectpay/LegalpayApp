<!-- Modal Consultas -->
<section id="consultsOption" class="modal modal-s">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'BUSQUEDA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="padd_all">
        <div class="row padd_v">
            <form class="formweb form-seach-modal" >
                <fieldset class="large-12 medium-12 small-12 columns padding">
                    <label><?php echo Yii::t('front', 'CC / NIT'); ?></label>                       
                    <input type="text" name="code" id="search-code" value="">
                    <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Buscar'); ?></button>
                </fieldset>
                <div class="clear"></div>
            </form>
        </div>
        <div class="clear"></div>
        <div id="resultSearch-modal">
            <hr>
            <label><?php echo Yii::t('front', 'Resultados'); ?></label>
            <div class="row padd_v" id="content-search">

            </div>
        </div>
    </div>
</section>
<!--/ Modal Consultas -->
<!-- Modal Documentos -->
<section id="docsOption" class="modal modal-s">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'DOCUMENTOS'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="padd_all">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem accusantium molestias sed blanditiis nihil nesciunt assumenda facere enim, repellendus architecto necessitatibus, suscipit delectus beatae consequatur minima qui libero. Laborum, quos!</p>
    </div>
</section>
<!--/ Modal Documentos -->
<!-- Modal Terms -->
<section id="check-terms" class="modal modal-lg">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'POLÍTICAS DE PRIVACIDAD'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close hide">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="padd_all">
        <p><?= Yii::t("database", "Antes de continuar por favor acepta nuestras políticas de privacidad: ") ?></p>
        <div class="row padd_v">
            <form class="formweb form-check-terms" >
                <fieldset class="large-12 medium-12 small-12 columns padding">
                    <input type="checkbox" class="filled-in" id="terms" name="terms" value="1" />
                    <label for="terms" style="padding: 6px 0 0 34px;"><a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/POLITICA_DE_TRATAMIENTO_Y_PROTECCION_DE_DATOS_PERSONALES.pdf" ><?= Yii::t("database", "Política de Privacidad")  ?></a></label>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding">                      
                    <input type="checkbox" class="filled-in" id="agreement" name="agreement" value="1" />
                    <label for="agreement" style="padding: 6px 0 0 34px;"><a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/assets/ACUERDO_DE_CONFIDENCIALIDAD.pdf"><?= Yii::t("database", "Acuerdo de Confidencialidad")  ?></a></label>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding">                      
                    <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Enviar'); ?></button>
                </fieldset>
                <div class="clear"></div>
            </form>
        </div>
        <div class="clear"></div>        
    </div>
</section>
<!--/ Modal Documentos -->
<!-- Modal List Advisers -->
<section id="new_help_links_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'LINKS DE APOYO') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v">            
        <section class="padd_v">
            <div class="row"> 
                <article class="block">                              
                    <div class="clear"></div>
                    <section class="padding m_t_20">
                        <div class="clearfix">                                        
                            <table class="bordered responsive-table">
                                <thead>
                                    <tr class="backgroung-table-2">
                                        <th class="txt_center"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
                                        <th class="txt_center"><?php echo Yii::t('front', 'VER'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="helpLinks">

                                </tbody>
                            </table>                                           
                        </div>
                        <div class="clear"></div>
                    </section>
                </article>
            </div>
        </section>            
        <div class="clear"></div>
    </div>
    <div class="modal-footer">    
        <input id="users-id" name="id" type="hidden" value="" />
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">Cancelar</a>
    </div>
</section>
<!-- Modal List Advisers -->
<section id="view_support" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'SOPORTE') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v">            
        <section class="padd_v">
            <div class="row"> 
                <article id="" class="block">                              
                    <div class="clear"></div>
                    <section class="padding m_t_20">
                        <div class="clearfix" id="content-view_support">                                        
                                                                     
                        </div>
                        <div class="clear"></div>
                    </section>
                </article>
            </div>
        </section>            
        <div class="clear"></div>
    </div>
</section>
<!-- Modal support Management -->
<section id="view_management_images_modal" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'SOPORTE'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v" >        
        <section class="padd_v">
            <div class="row"> 
                <article id="" class="block">                              
                    <div class="clear"></div>
                    <section class="padding m_t_20">
                        <div class="clearfix" id="suport-management">                                        
                                                                     
                        </div>
                        <div class="clear"></div>
                    </section>
                </article>
            </div>
        </section>            
        <div class="clear"></div>
    </div>
</section>
<!--/ Modal support Management -->
<!-- Modal Debtor Amortization -->
<section id="debtors_amortization" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'AMORTIZACIÓN DEUDA') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="padd_all">
        <div class="row padd_v" id="content-form-amortization">
            
        </div>
        <div class="clear"></div>
        <div id="results-content-amortization">
            <hr>
            <label><?php echo Yii::t('front', 'RESULTADOS'); ?></label>
            <div class="row padd_v">
                <table class="bordered responsive-table">
                    <thead>
                        <tr class="backgroung-table-2">
                            <th class="txt_center"><?php echo Yii::t('front', 'AÑO'); ?></th>
                            <th class="txt_center"><?php echo Yii::t('front', 'MES'); ?></th>
                            <th class="txt_center"><?php echo Yii::t('front', 'CUOTA'); ?></th>
                            <th class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                            <th class="txt_center"><?php echo Yii::t('front', 'AMORTIZACIÓN'); ?></th>
                            <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="results-amortization">

                    </tbody>
                </table>     
            </div>
        </div>
    </div>
    <div class="modal-footer">    
        <input id="users-id" name="id" type="hidden" value="" />
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </div>
</section>
<!-- Modal listen call -->
<section id="listen_call" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'AUDIO') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="padd_all">
        <fieldset class="large-12 medium-12 small-12 columns padding">            
            <label><?php echo Yii::t('front', 'Audio'); ?></label>
            <audio controls id="callPhone" idCall="">
                <source id="file-call-phone" src="" type="audio/wav">
            </audio>
        </fieldset>
    </div>
    <div class="modal-footer">    
        <input id="users-id" name="id" type="hidden" value="" />
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </div>
</section>       
<!-- Modal modal manual call -->
<section id="modal_manual_call" class="modal modal-m">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'AUTENTICAR EQUIPO') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="padd_all m_b_30">
        <fieldset class="large-12 medium-12 small-12 columns padding">            
            <label><?php echo Yii::t('front', 'Sigue los siguientes para la autenticar tu equipo :'); ?></label><br>            
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
            <label><?php echo Yii::t('front', '1. Ingresa al siguiente link : '); ?> <a target="_blank" href="https://<?php echo Yii::app()->params['url_call']; ?>:8089/httpstatus"><?php echo Yii::t('front', 'Autenticar'); ?></a></label> 
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
            <label><?php echo Yii::t('front', '2. Da click en el enlace señalado'); ?></label>            
            <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
                <img style="width: 600px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/manual/1.png" />
            </fieldset>
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
            <label><?php echo Yii::t('front', '3. Despues da click en el enlace señalado'); ?></label>            
            <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
                <img style="width: 600px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/manual/2.png" />
            </fieldset>
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
            <label><?php echo Yii::t('front', '4. En el momento que salga la siguiente información, su equipo ya se encontrara autenticado'); ?></label>            
            <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
                <img style="width: 600px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/manual/3.png" />
            </fieldset>
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding m_t_10">            
            <label><?php echo Yii::t('front', '5. Por ultimo cierra la pestaña e ingresa de nuevo a LEGAL PAY y recarga la pagina.'); ?></label>
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">            
        </fieldset>
    </div>
</section>       