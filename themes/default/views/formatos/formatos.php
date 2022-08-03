<?php
$session = Yii::app()->session;
?>
    <!--Contenidos Sitio-->
      <section class="cont_home">       
        <section class="conten_inicial">
          <section class="wrapper_l dashContent p_t_25">
            
            <section class="padding">

              <!--Datos iniciales-->
              <section class="panelBG wow fadeInUp m_b_20">
                <div class="tittle_head">
                  <h2>Notificaciones</h2>
                </div>
                <div class="row block padd_v">
                  <div id="frmManagement" class="form_register formweb wow fadeIn" action="" method="">

                       <div class="padding">
                         <div class="lineap"></div>
                       </div> 
                      <div class="clear"></div>

                     <fieldset class="large-12 medium-8 small-12 columns padding">
                      <div class="border_form padd_v m_b_10">
                        <fieldset class="large-6 medium-12 small-12 columns padding">
                          <label>Tipo de Formato*</label>
                          <select id="selectTipo">
                            <option value="">Seleccionar</option>
                            <option value="1">Formato 1: Notificación</option>
                            <option value="2">Formato 2: Notificación Con Inmueble</option>
                            <option value="3">Formato 3: Notificación Sin Inmueble</option>
                           
                          </select> 
                        </fieldset>

                        <fieldset class="large-6 medium-12 small-12 columns padding">
                          <label>Deudor*</label>
                          <select id="idWallet">
                            <option value="">Seleccionar</option>
                           	<?php  
                            foreach ($deudores as $deudor) {
                            ?>
                              <option value="<?= $deudor->idWallet ?>" ><?= $deudor->legalName.' '.$deudor->idNumber ?></option>
                            <?php
                                }
                            ?>
                          </select> 
                        </fieldset>

                      </div>
                      <button id="btnExportFormat" class="btnb block waves-effect waves-light">EXPORTAR</button>
                     </fieldset>
                      <div class="clear"></div>
                  </div> <!-- eRA fORM -->
                </div>
              </section>
              <!--Fin Datos iniciales-->
                
              </section>         

            </section>

            <div class="clear"></div>
          </section>
        </section>
          <div class="clear"></div>
      
<script type="text/javascript">
  $( document ).ready(function() {
    $("#formats").addClass("activo");
  });

$(function(){
  $("#btnExportFormat").bind('click', function(){

    var idWallet = $("#idWallet").val();
    var tipoFormato = $("#selectTipo").val();
    
    if(idWallet!='' && tipoFormato!=''){
    	
    if(tipoFormato == 1){
    	//alert(idWallet+' '+ tipoFormato);
    	window.open('<?php echo Yii::app()->getBaseUrl(true); ?>'+'/formatos/getFormatPdf/'+idWallet)
    }
    else{
    	if(tipoFormato == 2){
    		//alert(idWallet+' '+ tipoFormato);
    		window.open('<?php echo Yii::app()->getBaseUrl(true); ?>'+'/formatos/getFormatCPdf/'+idWallet);
    	}else{
    		//alert(idWallet+' '+ tipoFormato);
    		window.open('<?php echo Yii::app()->getBaseUrl(true); ?>'+'/formatos/getFormatSPdf/'+idWallet);
    	}
    }

    }  

    });
});
</script>