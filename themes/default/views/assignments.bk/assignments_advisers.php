<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">

            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Asignación Asesores") ?></h2>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_60">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
                        <form enctype="multipart/form-data"  class="formweb wrapper_s form-assignments-advisers">  
                        <label><?php echo Yii::t('front', 'Cliente'); ?></label> 
                        <select id="customer-na" class="select-data-import" name="idCustomer">
                           <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                           <?php foreach ($customers as $customer) { ?>                        
                               <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                           <?php } ?>
                       </select>
                        <p><?= Yii::t("database", 'Descarga los titulares') ?>: <a href="#" class="hide" id="download-pl" download><i class="fa fa-download" aria-hidden="true"></i></a></p> 
                        <a href="#" class="hide" id="download-file" download></a> 
                        <label><?php echo Yii::t('front', 'Asesor'); ?></label> 
                        <select id="customer-na" class="select-data-import" name="idAdviser">
                           <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                           <?php foreach ($advisers as $adviser) { ?>                        
                               <option value="<?php echo $adviser->id; ?>"><?php echo $adviser->name; ?></option>      
                           <?php } ?>
                       </select>
                        <input class="dropify" name="file" id="assignments-file" type="file" accept=".csv">
                        <div class="clear"></div>
                        <input type="hidden" value="6" name="idTypeImport" /> 
                        <div class="centerbtn">
                            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'SIGUIENTE'); ?></button>
                        </div>
                        <div class="clear"></div>
                    </form>
                    </section>
                    <!--All assignments-->
                    <section class="panelBG m_t_10 content-scroll-x <?php echo ($count > 0)? '' : 'hide'; ?> ">
                        <table class="bordered highlight">
                            <thead>
                                <tr class="backgroung-table-2">
                                    <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'TITULARES'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'ARCHIVO'); ?></th>
                                </tr>
                                <tr class="filters formweb" data-id="assignments" data-url="assignments">
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-customer" type="text" name="customer" /></th>
                                    <th class="txt_center"><input name="date" type="text" class="filter-table calendar_range" value=""></th>
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-accounts" type="text" name="accounts" /></th>
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-" type="text" name="" readonly /></th>                                    
                                    <th class="hide"><input id="cluster-filter-page" name="page" type="hidden" class="filter-table" value="1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-assignments">
                                <?php $this->renderPartial('/assignments/partials/content-assignments-adviser-table', array('model' => $model)); ?>
                            </tbody>
                        </table>
                        <div class="clear"></div>  
                        <div id="pagination-assignments" class="bg-pagination">  
                            <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'assignments')); ?>                                    
                        </div>
                    </section>
                    <!--Fin All assignments-->
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/assignments_advisers.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/assignments/partials/modal-data', array());


Yii::app()->clientScript->registerScript("dropify","
   $(document).ready(function(){    
        $('.dropify').dropify({
            messages: {
                'default': 'Arrastre y suelte un archivo aquí o haga click',
                'replace': 'Arrastre y suelte o haga click para reemplazar',
                'remove':  'Remover',
                'error':   'Sucedio un error'
            }
        });  
   });
   
",
 CClientScript::POS_END
);

