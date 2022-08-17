<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">

            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "PSM - Propensity Score Matching") ?></h2>
                <div class="acions_head txt_right hide">
                    <a href="<?php echo Yii::app()->baseUrl; ?>/assets/PlantillaDeudores.csv" class="btnb download" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>                
                </div>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_60">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
                        <div id="form-comparations"> 
                            <form enctype="multipart/form-data"  class="formweb form-comparations" >
                                <fieldset class="large-6 medium-6 small-6 columns padding">
                                    <label class=""><?= Yii::t("front", 'Modelo de predicción') ?></label> 
                                    <select id="predictions-idModel" name="idModel">
                                        <option value="1"><?php echo Yii::t('front', 'Modelo A'); ?></option>      
                                        <option value="2"><?php echo Yii::t('front', 'Modelo B'); ?></option>      
                                        <option value="3"><?php echo Yii::t('front', 'Modelo C'); ?></option>      
                                    </select>
                                    <label class=""><?= Yii::t("database", "Elige el portafolio para generar la comparación") ?></label> 
                                    <select id="comparations-p-0" data-count="0" name="idPorfolio" class="p-comparation">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                        <?php foreach ($customers as $customer) { ?>                        
                                            <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                                        <?php } ?>
                                    </select>
                                </fieldset>
                                <fieldset class="large-6 medium-6 small-6 columns padding">
                                    <label class=""><?= Yii::t("front", 'Portafolio 1') ?></label> 
                                    <select id="comparations-p-1" data-count="1" name="p-1" class="p-comparation portfolio-comparation">
                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>      
                                    </select>
                                    <div class="content-portfolios">
                                        
                                    </div>
                                    <div class="m_t_10 padding">
                                        <a class="more-portfolio view-more see-more left" href=""><i class="fa fa-plus lin2"></i> <?php echo Yii::t('front','Agregar portafolio'); ?></a>                                        
                                    </div>
                                </fieldset>
                                <div class="centerbtn">
                                    <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'COMPARAR'); ?></button>
                                </div>
                                <div class="clear"></div>
                            </form>
                        </div>
                        <div id="form-comparations-status" class="row" style="display: none;"><!--  -->                           
                            <div class="large-12 medium-12 small-12 columns m_t_20 m_b_20">                                                                              
                                <div id="container" class="padd_all white border_indicators " style="width: 100%; min-height: 60vh;"></div> 
                            </div>
                        </div>
                    </section>
                   
                    <!--All assignments-->
                    <section class="panelBG m_t_10 content-scroll-x hide">
                        <table class="bordered highlight">
                            <thead>
                                <tr class="backgroung-table-2">
                                    <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'NÚMERO DE OBLIGACIONES'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'ARCHIVO'); ?></th>
                                </tr>
                                <tr class="filters formweb" data-id="assignments" data-url="assignments">
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-customer" type="text" name="customer" /></th>
                                    <th class="txt_center"><input name="date" type="text" class="filter-table calendar_range" value=""></th>
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-accounts" type="text" name="accounts" /></th>
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-capital" type="text" name="capital" readonly /></th>                                    
                                    <th class="txt_center"><input class="filter-table" id="cluster-filter-" type="text" name="" readonly /></th>                                    
                                    <th class="hide"><input id="cluster-filter-page" name="page" type="hidden" class="filter-table" value="1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-assignments">
                                <?php $this->renderPartial('/assignments/partials/content-assignments-table', array('model' => $model)); ?>
                            </tbody>
                        </table>
                        <div class="clear"></div>  
                        <div id="pagination-assignments" class="bg-pagination hide">  
                            <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'assignments')); ?>                                    
                        </div>
                    </section>
                    <!--Fin All assignments-->
                </section>
            </section>
        </section>
    </section>
</section>
<script>
    $(function () {        
        
        $('body').on('change', '.p-comparation', function (e) { 
            e.preventDefault();
            var _this_p = $(this);
            var element = _this_p.attr('data-count');
            var comparation = '';
            $('.p-comparation').each(function(){
                var _this = $(this);
                comparation = (_this.val() != '')? comparation+_this.val()+',' : comparation;
                
            });
            
            $.ajax({
            url: SITEURL + "/predictions/getCustomers",
            dataType: 'json',
            type: 'POST',
            data: {comparation : comparation, element : element},
            beforeSend: function () {
                $(".preload").fadeIn(300);
            },
            success: function (result) {
                $(".preload").fadeOut(300);
                if (result.status == "success"){
                    console.log(result.element);
                    if($(result.element).length){
                        $(result.element).html('');
                        $(result.element).html(result.html);
                    }else{
                        console.log('elemento no encontrado');
                    }                    
                }else{
                    toastr[result.status](result.msg);
                    $('#content-info-sources').addClass('hide');                    
                }
            }
        });            
            console.log(comparation);                            
        });
        
        $('body').on('click', '.more-portfolio', function (e) { 
            e.preventDefault();
            console.log('click');
            
            var i = 1;
            $('.portfolio-comparation').each(function(){
                var _this = $(this);
                i++;                
            }); 
            
            if(i > 0){                
                var _html = '<label class=""><?= Yii::t("database", "Portafolio") ?> '+i+'</label>'+ 
                                            '<select id="comparations-p-'+i+'" data-count="'+i+'" name="p-'+i+'" class="p-comparation portfolio-comparation">'+
                                                '<option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>'+
                                            '</select>';

                $('.content-portfolios').append(_html);
            }
            
//            var formElement = document.querySelector(".form-predictions");
//            var form = new FormData(formElement);
//            
//            $.ajax({
//            url: SITEURL + "/predictions/validateResources",
//            dataType: 'json',
//            type: 'POST',
//            data: form,
//            processData: false,
//            contentType: false,
//            beforeSend: function () {
//                $(".preload").fadeIn(300);
//            },
//            success: function (result) {
//                $(".preload").fadeOut(300);
//                if (result.status == "success"){
//                    $('#predictions-total_debts').val(result.cant);
//                    $('#predictions-file').val(result.file);
//                    $('#predictions-total_capital_debts').val(numeral(result.model.capital).format('0,0'));
//                    $('#content-info-sources').removeClass('hide');
//                }else{
//                    toastr[result.status](result.msg);
//                    $('#content-info-sources').addClass('hide');                    
//                }
//            }
//        });
            
        });
    });
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/exporting.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/highcharts/export-data.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/comparations.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/predictions/partials/modal-data', array());