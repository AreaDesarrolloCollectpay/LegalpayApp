<style>
    .btn-submit-pay:disabled{
            background: #bdbdbd;
            color: #fff;
            -webkit-box-shadow: 5px 4px 15px 0 rgb(189, 189, 189);
            box-shadow : 5px 4px 15px 0 rgb(189, 189, 189);
    }
</style>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <?php
                Yii::app()->controller->renderPartial('/services/partials/title_head', array());
            ?>
        </section>
        <section class="row p_t_70">
<?php 
//            Yii::app()->controller->renderPartial('/services/partials/filter_services', array('url' => $this->createUrl('/services/detail/'.$id)));
?>         
            <section class="padding animated fadeInUp">                
                                        
                <section class="panelBG">
                               
                    <form id="frmFinantial" action="" class="formweb padd_v form_pay" data-id="pay-">                        
                        <fieldset class="large-12 medium-12 small-12 columns padding">  
                            <div class="large-6 medium-6 small-6 columns padding">                                
                                <h1><?php echo Yii::t('front', 'PRODUCTO A PAGAR'); ?></h1>
                            </div>
                            <div class="large-6 medium-6 small-6 columns padding">                                
                                <?php echo Yii::t('front', 'MONTO A PAGAR'); ?>
                            </div>
                        </fieldset>
                        <fieldset class="large-12 medium-12 small-12 columns padding m_t_20">                                                       
                            <div class="large-6 medium-6 small-6 columns padding">  
                                <div class="clear m_t_20 "></div>
                                <div class="large-6 medium-6 small-6 columns padding">                                    
                                    <p>                                    
                                        <input type="radio" name="type" class="filled-in" id="pay-type-1" value="1" <?php echo ((isset($valueCuote) && $valueCuote == 0) || !isset($valueCuote)  )? 'disabled' : ''; ?> />
                                        <label for="pay-type-1"><?php echo Yii::t('front', 'Pago Minímo'); ?></label>
                                    </p>
                                </div>
                                <div class="large-6 medium-6 small-6 columns padding">
                                    <input type="text" name="value_cuote" placeholder="" id="pay-value-coute" value="" readonly>
                                </div>
                                <div class="clear m_t_20"></div>
                                <div class="large-6 medium-6 small-6 columns padding">                                    
                                    <p>
                                        <input type="radio" name="type" class="filled-in" id="pay-type-3" value="3" <?php echo ((isset($valueBalance) && $valueBalance < 5000000)  )? '' : 'disabled'; ?> />
                                    <label for="pay-type-3"><?php echo Yii::t('front', 'Pago Total'); ?> : </label>
                                    </p>
                                </div>
                                <div class="large-6 medium-6 small-6 columns padding">                                    
                                    <input type="text" name="value_total" placeholder="" id="pay-value-total" value="" readonly>
                                </div>
                                <div class="clear m_t_20"></div>
                                <div class="large-6 medium-6 small-6 columns padding">                                    
                                    <p>
                                    <input type="radio" name="type" class="filled-in" id="pay-type-2" value="2" />
                                    <label for="pay-type-2"><?php echo Yii::t('front', 'Otro Valor'); ?> : </label>
                                    </p>
                                </div>
                                <div class="large-6 medium-6 small-6 columns padding">                                    
                                    <input type="text" name="value_other" placeholder="" id="pay-value-other" value="" disabled>                                     
                                    <label><?php echo Yii::t('front', 'Monto minímo $ 10.000 hasta $ 5.000.000'); ?></label>
                                </div>
                            </div> 
                            <div class="large-6 medium-6 small-6 columns padding"> 
                                <label><?php echo Yii::t('front', 'Día del siguiente Pago'); ?></label>
                                <input type="text" name="" placeholder="" value="<?php echo (isset($nextPay))? $nextPay : '00/00/0000'; ?>" disabled>                                                    
                                <label><?php echo Yii::t('front', 'Referencia de Transacción'); ?></label>
                                <input type="text" name="" value="<?php echo (isset($reference) && $reference != '')? $reference : ''; ?>" disabled>     
                            </div>
                        </fieldset>                        
                        <div class="clear m_t_20"></div>
                        <fieldset class="large-12 medium-12 small-12 columns padding content_btns">  
                            <a href="#" class="btnb waves-effect waves-light right btn_confirm_pay"><?php echo Yii::t('front', 'Continuar'); ?></a>
                            <a href="#" onClick="history.go(-1); return false;" class="btnb pop waves-effect waves-light right m_r_10"><?php echo Yii::t('front', 'Cancelar'); ?></a>
                        </fieldset>
                        <fieldset class="large-12 medium-12 small-12 columns padding content_confirm m_b_20">  
                            <div class="clear"></div>
                            <hr class="content_confirm">                        
                        </fieldset>
                        <fieldset class="large-12 medium-12 small-12 columns padding content_confirm m_t_20">  
                            <div class="large-6 medium-6 small-6 columns padding">                                
                                <h1><?php echo Yii::t('front', 'DATOS DE LA TRANSACCIÓN'); ?></h1>
                            </div>
                        </fieldset>
                        <fieldset class="large-12 medium-12 small-12 columns padding content_confirm m_t_5">  
                            <div class="large-6 medium-6 small-6 columns padding">                                 
                                <label><?php echo Yii::t('front', 'Nombres'); ?></label>
                                <input type="text" name="name" placeholder="" id="pay-name" value="">    
                                <label><?php echo Yii::t('front', 'Tipo de Documento'); ?></label>
                                <select id="pay-document_type" name="document_type">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <?php foreach ($typeDocuments as $key => $typeDocument){ ?>
                                    <option value="<?php echo $key; ?>"><?php echo Yii::t('front', $typeDocument); ?></option>
                                    <?php } ?>
                                </select>
                                <label><?php echo Yii::t('front', 'Pais'); ?></label>
                                <select id="pay-country" name="idCountry" class="select-country">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <?php foreach ($countries as $country) { ?>
                                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                    <?php } ?>
                                </select>   
                                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                                <select id="pay-idCity" name="idCity">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                    
                                </select>
                                <label><?php echo Yii::t('front', 'Teléfono'); ?></label>
                                <input type="text" name="phone" placeholder="" id="pay-phone" value=""> 
                                <label><?php echo Yii::t('front', 'Email de notificación'); ?></label>
                                <input type="text" name="email" placeholder="" id="pay-email" value=""> 
                            </div>
                            <div class="large-6 medium-6 small-6 columns padding"> 
                                <label><?php echo Yii::t('front', 'Tipo de cliente'); ?></label>
                                <select id="pay-type_person" name="type_person">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <?php foreach ($typePersons as $key => $typePerson){ ?>
                                    <option value="<?php echo $key; ?>"><?php echo Yii::t('front', $typePerson); ?></option>
                                    <?php } ?>
                                </select>  
                                <label><?php echo Yii::t('front', 'Documento de Identificación'); ?></label>
                                <input type="text" name="document" placeholder="" id="pay-document" value="">    
                                <label><?php echo Yii::t('front', 'Departamento'); ?></label>
                                <select id="pay-idDepartment" name="idDepartment" class="select-department">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                </select>      
                                <label><?php echo Yii::t('front', 'Dirección'); ?></label>
                                <input type="text" name="address" placeholder="" id="pay-address" value="">      
                                <label><?php echo Yii::t('front', 'Celular'); ?></label>
                                <input type="text" name="mobile" placeholder="" id="pay-mobile" value="">                                 
                                <label><?php echo Yii::t('front', 'Metodo de Pago'); ?></label>
                                <select id="pay-method_pay" name="method_pay">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <option value="PSE"><?php echo Yii::t('front', 'PSE'); ?></option>
                                    <option value="BALOTO"><?php echo Yii::t('front', 'BALOTO'); ?></option>
                                    <option value="EFECTY"><?php echo Yii::t('front', 'EFECTY'); ?></option>
                                    <option value="OTHERS_CASH"><?php echo Yii::t('front', 'SU RED'); ?></option>
                                </select> 
                            </div>
                        </fieldset>
                        <div class="clear"></div>
                        <div id="content-form"></div>
                        <input type="hidden" name="idDebtor" value="<?php echo ($debtor != null)? $debtor->idDebtor : ''; ?>" />
                        <input type="hidden" name="id" value="<?php echo ($debtor != null)? $debtor->id : ''; ?>" />
                        <input type="hidden" name="reference" value="<?php echo (isset($reference) && $reference != '')? $reference : ''; ?>" />
                        <input type="hidden" name="deviceSessionId" value="<?php echo $this->deviceSessionId; ?>" />
                        <fieldset class="large-12 medium-12 small-12 columns padding content_confirm m_b_20">  
                            <button type="submit" class="btnb waves-effect waves-light right btn-submit-pay" disabled><?php echo Yii::t('front', 'Pagar'); ?></button>
                            <a href="#" onClick="history.go(-1); return false;" class="btnb pop waves-effect waves-light right m_r_10"><?php echo Yii::t('front', 'Cancelar'); ?></a>
                        </fieldset>
                    </form>
                </section>
                <!--Fin Tabs--> 
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<a href="#" class="hide" target="_blank" id="btn-t"><?php echo Yii::t('front', 'Continuar'); ?></a>
<?php 
$this->renderPartial("/services/partials/modal-data", array());
$js = '';

  $js .= 'var other;
          var cuote = numeral('.((isset($valueCuote))? $valueCuote : '0').');
          $("#pay-value-coute").val(cuote.format("0,0"));';
  
  $js .= 'var total = numeral('.((isset($valueBalance))? $valueBalance : '0').');
          $("#pay-value-total").val(total.format("0,0"));';

    $js .= '$(".content_confirm, #content-form").fadeOut();
            $("#btn-submit-pay").prop("disabled",true);
            $("body").on("click","input:radio[name=\'type\']",function(e){ 
                var _this = $(this);
                var disa = (_this.val() == 2)? false : true;
                $("#pay-value-other").prop("disabled",disa);
            });
            $("body").on("click",".btn_confirm_pay",function(e){
                e.preventDefault();
                var formElement = document.querySelector(".form_pay");                
                var form = new FormData(formElement); 
                other = $("#pay-value-other").val();                
                var type = $("input[name=\'type\']:checked").val();                                 
                form.append("value", (type == 2)? other : ((type == 3)? total.value() : cuote.value()));
                $.ajax({
                    url: SITEURL + "/services/confirmPay",
                    async: false,
                    dataType: "json",
                    type: "POST",
                    data: form,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        if (result.status == "success") {     
                            $(".content_btns").fadeOut(400);
                            $(".content_confirm").fadeIn(400);
                        }else{
                            toastr[result.status](result.msg);
                        }
                    }
                });
            });
            $("body").on("submit",".form_pay",function(e){
                e.preventDefault();
                var formElement = document.querySelector(".form_pay");
                var form = new FormData(formElement); 
                var type = $("input[name=\'type\']:checked").val();                                 
                form.append("value", (type == 2)? other : ((type == 3)? total.value() : cuote.value()));
                $.ajax({
                    url: SITEURL + "/services/formPay",
                    async: false,
                    dataType: "json",
                    type: "POST",
                    data: form,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $(".preload").fadeIn(300);
                    },
                    success: function (result) {
                        if (result.status == "success") {  
                            setTimeout(function(){
                                  location.href = result.url;
                            },500);
                        }else{
                            $(".preload").fadeOut(300);
                            toastr[result.status](result.msg); 
//                            setTimeout(function () {
//                                location.reload();
//                            }, 200);
                        }
                    }
                });
            });  
            $("body").on("change","#pay-method_pay",function(e){
                e.preventDefault();
                var formElement = document.querySelector(".form_pay");
                var form = new FormData(formElement); 
                $.ajax({
                    url: SITEURL + "/services/getForm",
                    async: false,
                    dataType: "json",
                    type: "POST",
                    data: form,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $(".preload").fadeIn(300);
                    },
                    success: function (result) {
                        $(".preload").fadeOut(300);
                        if (result.status == "success") { 
                            $(".btn-submit-pay").prop("disabled",false);
                            $("#content-form").html(result.html).fadeIn(400);
                        }else{
                            $(".btn-submit-pay").prop("disabled",true);                        
                        }
                    }
                });
            });  
            
           ';
Yii::app()->clientScript->registerScript("pay_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
?>
