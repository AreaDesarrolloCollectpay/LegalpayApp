<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">

            <div class="tittle_head">
                <h2><?php echo Yii::t('front', 'PARAMETRIZACIÓN'); ?></h2>
            </div>

            <section class="padding">
                <section class="bg_perfil m_t_20 m_b_20">
                    <!--Datos iniciales-->
                    <section class="row">
                        <div class="dates_user m_t_20">
                            <form action="" class="formweb form-settings hide" enctype="multipart/form-data">
                                <fieldset class="large-12 medium-12 small-12 columns">                                    
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'TRM'); ?></label>
                                        <input type="text" id="user-name" name="name" value="">
                                    </div>                                                                                                                                           
                                </fieldset>                                
                                <div class="clear"></div>
                                <div class="txt_right block padding m_t_10 m_b_20">
                                    <button class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'Guardar'); ?></button>
                                </div>
                                <div class="clear"></div>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </section>
                </section>    
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/settings.min.js', CClientScript::POS_END);
?>