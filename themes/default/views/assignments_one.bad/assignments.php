<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2 class="inline"><?= Yii::t("database", "Asignación de Deudores") ?></h2>
                <div class="acions_head txt_right">
                    <!--<a href="<?php echo Yii::app()->baseUrl; ?>/assets/PlantillaDeudores.csv" class="btnb download" download><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t("database", "Descargar Plantilla") ?></a>      -->          
                    <a href="<?php echo Yii::app()->baseUrl.'/assignments'; ?>" class="btnb download">Asignaciones Masivas</a>
                </div>
            </div>
            <div class="clear"></div>  
            <section class="row p_t_60">
                <section class="padding animated fadeInUp">
                    <section class="panelBG padd_all m_t_20 m_b_20 adding_db">
                        <form enctype="multipart/form-data"  class="formweb form-assignments" >
                            <p class="hide"><?= Yii::t("database", "Elige el cliente a recuperar la cartera.") ?></p> 
                            <?php if (Yii::app()->user->getState('rol') == 7) { ?>
                                 <input type="hidden" id="assignments-idCustomer" name="idCustomer" value="<?php echo Yii::app()->user->getId(); ?>" /> 
                            <?php }else{ ?>    
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label class=""><?= Yii::t("database", "Elige el cliente a recuperar la cartera *") ?></label>                 
                                <select id="assignments-idCustomer" name="idCustomer">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar');?></option>      
                                    <?php foreach ($customers as $customer) { ?>                        
                                        <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>      
                                    <?php } ?>
                                </select>
                            <?php }  ?>
                            </fieldset> 
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Nombre - Razón social o contraparte*'); ?></label>  
                                <input id="assignments-name" name="name" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Tipo documento *'); ?></label>  
                                <select id="assignments-type_document" name="type_document"  class="">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <option value="cc">CC</option>
                                    <option value="ce">CE</option>
                                    <option value="nit">NIT</option>       
                                    <!--<?php //foreach ($typeDocument as $type) { ?>                        
                                        <option value="<?php //echo $type->id; ?>"><?php //echo $type->name; ?></option>      
                                    <?php //} ?>-->
                                </select>
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Número documento *'); ?></label>  
                                <input id="assignments-number" name="number" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>  
                                <input id="assignments-city" name="city" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Dirección'); ?></label>  
                                <input id="assignments-address" name="address" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>  
                                <input id="assignments-phone" name="phone" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Celular'); ?></label>  
                                <input id="assignments-mobile" name="mobile" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Email'); ?></label>  
                                <small id="wrong-email" style="color:red;">Formato de correo incorrecto</small>
                                <input id="assignments-email" name="email" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Soporte *'); ?></label>  
                                <select id="assignments-support_type" name="support_type">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <option value="factura">FACTURA</option>
                                    <option value="pagare">PAGARÉ</option>
                                    <option value="otro">OTRO</option>
                                </select>
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Referencia'); ?></label>  
                                <input id="assignments-credit_number" name="credit_number" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Capital en mora *'); ?></label>  
                                <input id="assignments-capital" name="capital" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Vencimiento *'); ?></label> 
                                <div class="fecha">
                                    <input class="calendar" id="assignments-expiration_date" name="expiration_date" type="date">
                                </div> 
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Jurídico'); ?></label>  
                                <select id="assignments-legal" name="legal">
                                    <!-- <option value=""><?php //echo Yii::t('front', 'Seleccionar'); ?></option> -->
                                    <option value="no">NO</option>
                                    <option value="si">SI</option>
                                </select>
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Juzgado'); ?></label>  
                                <input id="assignments-office_legal" name="office_legal" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Ubicación juzgado'); ?></label>  
                                <input id="assignments-office_legal_location" name="office_legal_location" type="text">
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Tipo de proceso'); ?></label>  
                                <select id="assignments-idTypeProcess" name="idTypeProcess">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <option value="declarativo">DECLARATIVO</option>
                                    <option value="ejecutivo">EJECUTIVO</option>
                                    <option value="liquidacion">LIQUIDACIÓN</option>
                                    <option value="voluntaria">VOLUNTARIA</option>
                                    <option value="arbitral">ARBITRAL</option>
                                    <option value="especiales">ESPECIALES</option>
                                    <option value="conciliacion">CONCILIACIÓN</option>
                                    <option value="acciones">ACCIONES</option>
                                </select>
                            </fieldset>
                            <fieldset class="large-4 medium-4 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Número radicado'); ?></label>  
                                <input id="assignments-settled_number" name="settled_number" type="text">
                            </fieldset>
                            <fieldset class="large-12 medium-12 small-12 columns padding">
                                <label><?php echo Yii::t('front', 'Comentarios'); ?></label>  
                                <input id="assignments-comments" name="comments" type="text">
                            </fieldset>
                            
                            <label class="hide"><?php echo Yii::t('front', 'CODIGO INTERNO'); ?></label>  
                            <input id="assignments-internal_code" name="internal_code" type="hidden">
                            
                            <fieldset class="large-12 medium-12 small-12 columns">
                                <div class="centerbtn">
                                    <p class="large-6 medium-6 small-12 columns padding">Campos obligatorios (*)</p>
                                    <div class="large-6 medium-6 small-12 columns padding">
                                        <button id="btn_agregar" type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'ASIGNAR DEUDOR'); ?></button>
                                        <button id="btn_fachada" type="button" class="btnb waves-effect waves-light right"  onclick="alertaBoton()"><?php echo Yii::t('front', 'ASIGNAR DEUDOR'); ?></button>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="clear"></div>
                        </form>
                    </section>
                    <!--
                    <section class="row">
                        <fieldset class="large-6 medium-6 small-6 columns ">
                            <a href="<?php echo Yii::app()->baseUrl.'/assignments/adviser'; ?>" class="btnb waves-effect waves-light left"><?= Yii::t("front", "Asignación Asesores") ?></a>
                        </fieldset>
                    </section>-->
                    <!--All assignments-->
                    <!--
                    <section class="panelBG m_t_10 content-scroll-x <?php echo ($count > 0)? '' : 'hide'; ?> ">
                        <table class="bordered highlight">
                            <thead>
                                <tr class="backgroung-table-2">
                                    <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'NÚMERO DE OBLIGACIONES'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                                    <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
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
                        <div id="pagination-assignments" class="bg-pagination">  
                            <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages,'currentPage' => $currentPage, 'id' => 'assignments')); ?>                                    
                        </div>
                    </section>-->
                    <!--Fin All assignments-->
                </section>
            </section>
        </section>
    </section>
</section>
</body>
</html>


<script>

$( document ).ready(function() {

    $("#btn_agregar").hide();

    $("#wrong-email").hide();

    $('#assignments-number').bind('keypress', function(e) {
        if(e.keyCode>=48 && e.keyCode<=57){
            return true;
        }else{
            return false;
        }
    });

    $('#assignments-phone').bind('keypress', function(e) {
        if(e.keyCode>=48 && e.keyCode<=57){
            //console.log($('#assignments-phone').val().length);

            if($('#assignments-phone').val().length<7){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }

    });

    $('#assignments-mobile').bind('keypress', function(e) {
        if(e.keyCode>=48 && e.keyCode<=57){
            
            if($('#assignments-mobile').val().length<10){
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    });

    $('#assignments-capital').bind('keypress', function(e) {
        if(e.keyCode>=48 && e.keyCode<=57){
            return true;
        }else{
            return false;
        }
    });

    $('#assignments-settled_number').bind('keypress', function(e) {
        if(e.keyCode>=48 && e.keyCode<=57){
            return true;
        }else{
            return false;
        }
    });

    /* $('#assignments-internal_code').bind('keypress', function(e) {
        if(e.keyCode>=48 && e.keyCode<=57){
            return true;
        }else{
            return false;
        }
    }); */

    $('#assignments-email').change(function(){
        if($('#assignments-email').val()==''){

        }else{
            
            var arroba= 0;
            var punto= 0;
            var correo= false;


            for (let i = 0; i < $('#assignments-email').val().length; i++) {
                
                if($('#assignments-email').val()[i]=='@'){
                    arroba++;

                    console.log($('#assignments-email').val()[i]);
                }

                if($('#assignments-email').val()[i]=='.' && arroba==1){
                    punto++;

                    console.log($('#assignments-email').val()[i]);
                }

                if(arroba==1 && punto==1){
                    correo=true;
                    $("#wrong-email").hide();
                    $('#assignments-email').css("border-color", "rgb(165, 165, 165)");

                }else{
                    $("#wrong-email").show();
                    $('#assignments-email').css("border-color", "red");
                }
                
            }



        }
    })
  

    setInterval(revisarBoton, 500);



});


function revisarBoton(){

    var boton = true;

    if($("#assignments-idCustomer").val()==""){
        boton = false;
    }

    if($("#assignments-name").val()==""){
        boton = false;
    }

    if($("#assignments-type_document").val()==""){
        boton = false;
    }

    if($("#assignments-number").val()==""){
        boton = false;
    }

    if($("#assignments-support_type").val()==""){
        boton = false;
    }

    if($("#assignments-capital").val()==""){
        boton = false;
    }

    if($("#assignments-expiration_date").val()==""){
        boton = false;
    }

    if(boton==true){
        $("#btn_fachada").hide();
        $("#btn_agregar").show();
    }else{
        $("#btn_fachada").show();
        $("#btn_agregar").hide();
    }

    
} 

function alertaBoton(){
    toastr["error"]("Faltan campos obligatorios");
}


</script>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/assignments_one.min.js', CClientScript::POS_END);
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

