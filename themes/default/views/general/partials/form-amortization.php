<form class="formweb form-debtor-amortization" >
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Tipo Solución'); ?></label>                       
        <select name="type_solution" id="form-debtor-amortization-type_solution" class="quote_initial">
            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>  
            <option value="1"><?php echo Yii::t('front', 'Pago Total'); ?></option>  
            <option value="2"><?php echo Yii::t('front', 'Pago Total < 90'); ?></option>  
            <option value="3"><?php echo Yii::t('front', 'Acuerdo de Pago'); ?></option>  
        </select>
    </fieldset>
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Valor adeudado'); ?></label>                       
        <input type="text" id="form-debtor-amortization-capital-txt" value="<?php echo ($model != null)? Yii::app()->format->formatNumber($model->capital) : 0 ?>" class="">
        <input type="hidden" id="form-debtor-amortization-capital" name="capital" value="<?php echo ($model != null)? $model->capital : 0 ?>" pattern="\d+" >
    </fieldset>
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <fieldset class="large-6 medium-6 small-12 columns" style="padding-right: 20px;">            
            <label><?php echo Yii::t('front', 'Descuento'); ?></label>                       
            <select id="form-debtor-amortization-discount" name="discount" class="quote_initial">
                <option value="0"><?php echo Yii::t('front', 'NO'); ?></option>  
                <option value="1"><?php echo Yii::t('front', 'SI'); ?></option>  
            </select>        
        </fieldset>
        <fieldset class="large-6 medium-6 small-12 columns"> 
            <label><?php echo Yii::t('front', 'Valor Descuento %'); ?></label>                       
            <input type="text" id="form-debtor-amortization-discount_value" name="discount_value" value="0" class="" readonly pattern="\d+">
        </fieldset>
    </fieldset>
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Total Acuerdo'); ?></label>                       
        <input type="text" id="form-debtor-amortization-agreement-txt" value="" class="agreement" >
        <input type="hidden" id="form-debtor-amortization-agreement" name="agreement" value="" pattern="\d+">
    </fieldset>
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Cuota Inicial'); ?></label>                       
        <input type="text" id="form-debtor-amortization-quote_initial-txt"  value="" >
        <input type="hidden" id="form-debtor-amortization-quote_initial" name="quote_initial" value="" pattern="\d+">
    </fieldset>
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Fecha Pago Cuota Inicial'); ?></label>                       
        <div class="fecha">
            <input type="date" id="form-debtor-amortization-date-initial" name="date_initial" class="calendar" value="" />
        </div>
    </fieldset>    
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Plazo'); ?></label>                       
        <select id="form-debtor-amortization-time" name="time"> 
            <option value="1">1</option>  
            <option value="2">2</option>  
            <option value="3">3</option>  
        </select>
    </fieldset>
    <fieldset class="large-4 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', 'Tasa Nominal MV'); ?>%</label>                       
        <input type="text" name="interest" id="form-debtor-amortization-interest" value="" pattern="[0-9]{2}" readonly="readonly">
        <input type="hidden" name="tnmv" id="form-debtor-amortization-tnmv" value="<?php echo 20; ?>" >
    </fieldset>
    <fieldset class="large-12 medium-12 small-12 columns padding">
        <input type="hidden" name="idDebtor" id="form-debtor-amortization-idDebtor" value="<?php echo $model->id; ?>" >
        <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Calcular'); ?></button>
        <button type="button" class="btnb pop waves-effect waves-light right m_r_10" id="btn_generate_amortization"><?php echo Yii::t('front', 'Generar'); ?></button>
    </fieldset>
    <div class="clear"></div>
</form>