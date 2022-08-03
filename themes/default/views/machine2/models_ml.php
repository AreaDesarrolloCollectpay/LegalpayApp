<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Modelos ML") ?></h2>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_60">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
                        <div id="content-form-models"> 
                            <form enctype="multipart/form-data"  class="formweb wrapper_s form-mlmodels" >                            
                                <label class="hide"><?= Yii::t("database", "Tipo") ?></label> 
                                <select id="mlmodels-type" class="hide" name="type">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <option selected value="1"><?= Yii::t("front", "Clusters"); ?></option>      
                                    <option value="2"><?= Yii::t("front", "Anomalía"); ?></option>      
                                    <option value="3"><?= Yii::t("front", "Predicción"); ?></option>      
                                </select>
                                <label class=""><?= Yii::t("front", "Nombre") ?></label> 
                                <input type="text" id="mlmodels-name" name="name" value="" />                                
                                <label><?php echo Yii::t('front', 'Descripción'); ?></label>
                                <textarea id="mlmodels-description" name="description" cols="30" rows="10"></textarea>                            
                                <label class=""><?= Yii::t("front", "Variables") ?></label> 
                                <div class="selected-element">
                                    <ul class="changed-element hide"><li>Nothing yet</li></ul>
                                </div>
                                <select id="mlmodels-fields" class="select2" name="dual-listbox">
                                    <?php foreach ($fields as $field){ ?>
                                    <option value="<?php echo $field->id; ?>"><?php echo Yii::t('front',$field->name); ?></option>     
                                    <?php }?>
                                </select>
                                <div class="centerbtn">
                                    <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'SIGUIENTE'); ?></button>
                                </div>
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/dual-listbox/dual-listbox.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/mlmodels.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/assignments/partials/modal-data', array());

Yii::app()->clientScript->registerScript("dual-listbox","
   $(document).ready(function(){    
        var dlb2 = new DualListbox('.select2', {
            availableTitle:'Disponibles',
            selectedTitle: 'Seleccionadas',
            addButtonText: '>',
            removeButtonText: '<',
            addAllButtonText: '>>',
            removeAllButtonText: '<<',
            searchPlaceholder: 'Buscar'
        });
        dlb2.addEventListener('added', function(event){
            document.querySelector('.changed-element').innerHTML = event.addedElement.outerHTML;
        });
        dlb2.addEventListener('removed', function(event){
            document.querySelector('.changed-element').innerHTML = event.removedElement.outerHTML;
        });
   });
   
",
 CClientScript::POS_END
);
