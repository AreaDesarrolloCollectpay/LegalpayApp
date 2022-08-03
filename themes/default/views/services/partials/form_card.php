<fieldset class="large-12 medium-12 small-12 columns padding content_confirm m_t_5">  
    <div class="large-6 medium-6 small-6 columns padding">                                 
        <label><?php echo Yii::t('front', 'Número Tarjeta'); ?></label>
        <input type="text" name="number_card" placeholder="" id="pay-number_card" value="">     
        <label><?php echo Yii::t('front', 'CVV'); ?></label>
        <input type="text" name="cvv" placeholder="" id="pay-cvv" value="">     
    </div>
    <div class="large-6 medium-6 small-6 columns padding">   
        <div class="large-6 medium-6 small-6 columns">
            <label><?php echo Yii::t('front', 'Válido Hasta'); ?></label>
            <select name="month" id="pay-month">
                <option value=""><?php echo Yii::t('front', 'Mes'); ?></option>
                <?php for($i = 1; $i <= 12; $i++){ ?>
                    <option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="large-6 medium-6 small-6 columns" style="padding-left: 10px;">
            <label>&nbsp;</label>
            <select name="year" id="pay-year">
                <option><?php echo Yii::t('front', 'Año'); ?></option>
                <?php
                $year = date('Y');
                    for($i = 1; $i <= 12; $i++){ ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php 
                        $year++;
                    } ?>
            </select>
        </div>
    </div>
</fieldset>
    

