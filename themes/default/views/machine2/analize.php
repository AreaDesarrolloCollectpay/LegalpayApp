<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Modelo -". $model->name) ?></h2>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_60">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
                        <div id="content-form-models"> 
                            <form enctype="multipart/form-data"  class="formweb wrapper_m form-mlanalize" >   
                                <fieldset class="large-6 medium-6 small-6 columns padding">
                                    <h1 class="m_b_10"><?= Yii::t("front", "INFORMACIÓN MODELO") ?></h1>                                     
                                    <label class=""><?= Yii::t("front", "Nombre") ?></label> 
                                    <input type="text" id="mlmodels-name" name="name" value="<?php echo $model->name; ?>" />                                
                                    <label><?php echo Yii::t('front', 'Descripción'); ?></label>
                                    <textarea id="mlmodels-description" name="description" cols="30" rows="10"><?php echo $model->description; ?></textarea>                            
                                    <div class="dates_pend">
                                        <div class="large-12 medium-12 small-12 columns list_valores">
                                            <div class="large-3 medium-3 small-6 columns padding">
                                                <div class="panel new">
                                                    <!-- <i class="feather feather-bar-chart"></i> -->                    
                                                    <div class="relative">                            
                                                        <span class="ml-analize-item"><?php echo Yii::t('front', 'Instancias'); ?></span>
                                                        <!-- <i class="feather feather-user"></i> -->                        
                                                        <span class="prices ml-analize-item" ><?php echo $model->instances; ?></span>       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="large-3 medium-3 small-6 columns padding">
                                                <div class="panel new">
                                                    <!-- <i class="feather feather-bar-chart"></i> -->                    
                                                    <div class="relative">                            
                                                        <span class="ml-analize-item"><?php echo Yii::t('front', 'Tamaño'); ?></span>
                                                        <!-- <i class="feather feather-user"></i> -->                        
                                                        <span class="prices ml-analize-item"><?php echo @Controller::formatSizeMegaBytes($model->size); ?></span>       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="large-3 medium-3 small-6 columns padding">
                                                <div class="panel new">
                                                    <!-- <i class="feather feather-bar-chart"></i> -->                    
                                                    <div class="relative">                            
                                                        <span class="ml-analize-item"><?php echo Yii::t('front', 'Variables'); ?></span>
                                                        <!-- <i class="feather feather-user"></i> -->                        
                                                        <span class="prices ml-analize-item" ><?php echo $model->columns; ?></span>       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="large-3 medium-3 small-6 columns padding">
                                                <div class="panel new">
                                                    <!-- <i class="feather feather-bar-chart"></i> -->                    
                                                    <div class="relative">                            
                                                        <span class="ml-analize-item"><?php echo Yii::t('front', 'Clusters'); ?></span>
                                                        <!-- <i class="feather feather-user"></i> -->                        
                                                        <span class="prices ml-analize-item"><?php echo $clusters; ?></span>       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                
                                </fieldset>
                                <fieldset class="large-6 medium-6 small-6 columns padding">
                                    <h1 class="m_b_10"><?= Yii::t("front", "INFORMACIÓN CARTERA ACTUAL") ?></h1> 
                                    <label class=""><?= Yii::t("front", "Clientes") ?></label> 
                                    <select id="mlmodels-customers" class="" name="idCustomer">
                                        <option value="0"><?php echo Yii::t('front','Todos'); ?></option>     
                                        <?php foreach ($customers as $customer){ ?>
                                        <option value="<?php echo $customer->id; ?>"><?php echo Yii::t('front',$customer->name); ?></option>     
                                        <?php }?>   
                                    </select>                                    
                                </fieldset>
                                <fieldset class="large-12 medium-12 small-12 columns padding">
                                    <input type="hidden" name="idMLModel" value="<?php echo $model->id; ?>" />
                                    <div class="centerbtn">
                                        <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'ANALIZAR'); ?></button>
                                    </div>
                                </fieldset>
                                <div class="clear"></div>
                            </form>
                        </div>
                        <div id="content-form-status" class="row" style="display: none;">
                            <form enctype="multipart/form-data"  class="formweb wrapper_s" >                                
                                <h2 id="text-status" class="form-predictions-status" style="text-align: center; font-size: 20px; "><?php echo Yii::t('front', 'GENERANDO FUENTE DE DATOS ...') ?></h2>
                                <div class="centerbtn form-predictions-status">
                                    <div class="progress">
                                        <div class="indeterminate"></div>
                                    </div>
                                </div>
                                <div class="centerbtn">
                                    <div class="row txt-prediction" style="display: none;">     
                                        <span class="num" style="font-weight: bold; font-size: 60px; color: #48ea88;">
                                            <strong class="counter" >100</strong><strong>%</strong>
                                        </span>
                                        <p class="txt_center"><?php echo Yii::t('front', 'Probabilidad de recaudo de este portafolio'); ?></p>
                                    </div>                                    
                                </div>
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/analize.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/assignments/partials/modal-data', array());

