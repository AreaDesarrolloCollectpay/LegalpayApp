<fieldset class="large-12 medium-12 small-12 columns padding content_confirm m_t_5">  
    <div class="large-6 medium-6 small-6 columns padding">                                 
        <label><?php echo Yii::t('front', 'Banco'); ?></label>
        <select id="pay-bank" name="bank">
            <?php foreach ($banks as $bank) { ?>
                <option value="<?php echo ($bank->pseCode == 0)? '' : $bank->pseCode; ?>"><?php echo $bank->description; ?></option>
            <?php } ?>
        </select>         
    </div>
    <div class="large-6 medium-6 small-6 columns padding">   
    </div>
</fieldset>
    

