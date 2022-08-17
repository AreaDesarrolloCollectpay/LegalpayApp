<section class="row m_b_10 m_t_10 wow fadeInDown padding">
    <div class="dates_pend">
        <div class="large-12 medium-12 small-12 columns list_valores">
            <div class="large-3 medium-3 small-6 columns padding">
                <div class="panel new">
                    <!-- <i class="feather feather-pie-chart"></i>    -->                    
                    <div class="relative">                               
                        <span>$ <?php echo Yii::app()->format->formatNumber($indicators->assigned); ?></span>                 
                        <span class="deudor"><i class="feather feather-user"></i> <?php echo $indicators->countAssigned;  ?></span> 
                        <span><?php echo Yii::t('front', 'Saldo Asignado'); ?></span>
                    </div>
                    <div class="circle-porcent">
                        <span class="num">
                            <strong class="counter"><?php echo '100'; ?></strong><strong>%</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="large-3 medium-3 small-6 columns padding">
                <div class="panel new">
                    <!-- <i class="feather feather-activity"></i> -->                    
                    <div class="relative">                           
                        <span>$ <?php echo Yii::app()->format->formatNumber($indicators->recovered); ?></span>                     
                        <span class="deudor"><i class="feather feather-user"></i> <?php echo $indicators->countRecovered; ?></span>                        
                        <span><?php echo Yii::t('front', 'Saldo Recaudado'); ?></span>         
                    </div>
                    <div class="circle-porcent">
                        <span class="num">
                            <strong class="counter"><?php echo $indicators->pRecovered; ?></strong><strong>%</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="large-3 medium-3 small-6 columns padding">
                <div class="panel new">
                    <!-- <i class="feather feather-bar-chart"></i> -->                    
                    <div class="relative">                            
                        <span>$ <?php echo Yii::app()->format->formatNumber($indicators->credit); ?></span>                    
                        <span class="deudor"><i class="feather feather-user"></i> <?php echo $indicators->countCredit; ?></span>                        
                        <span><?php echo Yii::t('front', 'Acuerdo de Pago'); ?></span>         
                    </div>
                    <div class="circle-porcent">
                        <?php  $pCredit =  ($indicators->assigned > 0)?  round((($indicators->credit*100)/ $indicators->assigned),2) : 0;;?>
                        <span class="num">
                            <strong class="counter"><?php echo $pCredit; ?></strong><strong>%</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="large-3 medium-3 small-6 columns padding">
                <div class="panel new">
                    <!-- <i class="feather feather-check"></i> -->                    
                    <div class="relative">                        
                        <span>$ 0</span>                        
                        <span class="deudor"><i class="feather feather-user"></i> 0</span>                        
                        <span><?php echo Yii::t('front', 'Saldo Pendiente'); ?></span>         
                    </div>
                    <div class="circle-porcent">
                        <?php  $pPending = 0?>
                        <span class="num">
                            <strong class="counter"><?php echo $pPending; ?></strong><strong>%</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Fin Datos iniciales-->