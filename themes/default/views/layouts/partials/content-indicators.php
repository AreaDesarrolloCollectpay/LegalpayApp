<section class="row m_b_10 padding wow fadeInDown">
    <div class="dates_pend">
        <div class="large-12 medium-12 small-12 columns list_valores">
            <div class="large-3 medium-3 small-12 columns padding">
                <div class="panel new">
                    <!-- <i class="feather feather-pie-chart"></i>    -->                    
                    <div class="relative">                               
                        <span><?php echo Yii::t('front', 'Procesos con medidas cautelares'); ?></span>
                        <h6>Usuarios: <?php echo $indicators->countAssigned;  ?></h6>
                        <!-- <i class="feather feather-user"></i> -->
                        <div class="circle-porcent">
                            <span class="num">
                                <strong class="counter"><?php echo '100'; ?></strong><strong>%</strong>
                            </span>
                        </div>
                        <span class="prices"><i class="feather feather-arrow-up"></i> $ <?php echo Yii::app()->format->formatNumber($indicators->assigned); ?></span>
                        <div class="progress">
                          <div class="determinate" style="width: 100%"></div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="large-3 medium-3 small-12 columns padding">
                <div class="panel new negative">
                    <!-- <i class="feather feather-activity"></i> -->                    
                    <div class="relative">                           
                        <span><?php echo Yii::t('front', 'Procesos con sentencia'); ?></span>
                        <h6>Usuarios: <?php echo $indicators->countRecovered; ?></h6>
                        <!-- <i class="feather feather-user"></i> -->                                            
                        <div class="circle-porcent">
                            <span class="num">
                                <strong class="counter"><?php echo $indicators->pRecovered; ?></strong><strong>%</strong>
                            </span>
                        </div>
                        <span class="prices"><i class="feather feather-arrow-up"></i> $ <?php echo Yii::app()->format->formatNumber($indicators->recovered); ?></span>
                        <div class="progress">
                          <div class="determinate" style="width: <?php echo $indicators->pRecovered; ?>%"></div>
                        </div>         
                    </div>
                </div>
            </div>
            <div class="large-3 medium-3 small-12 columns padding">
                <div class="panel new">
                    <!-- <i class="feather feather-bar-chart"></i> -->                    
                    <div class="relative">                            
                        <span><?php echo Yii::t('front', 'Procesos en ejecución'); ?></span>
                        <h6>Usuarios: <?php echo $indicators->countCredit; ?></h6>
                         <!-- <i class="feather feather-user"></i> -->
                        <div class="circle-porcent">
                            <?php  $pCredit = ($indicators->assigned > 0)?  round((($indicators->credit*100)/ $indicators->assigned),2) : 0;?>
                            <span class="num">
                                <strong class="counter"><?php echo $pCredit; ?></strong><strong>%</strong>
                            </span>
                        </div>
                        <span class="prices"><i class="feather feather-arrow-up"></i> $ <?php echo Yii::app()->format->formatNumber($indicators->credit); ?></span>
                        <div class="progress">
                          <div class="determinate" style="width: <?php echo $pCredit; ?>%"></div>
                        </div>         
                    </div>
                </div>
            </div>
            <div class="large-3 medium-3 small-12 columns padding">
                <div class="panel new">
                    <!-- <i class="feather feather-check"></i> -->                    
                    <div class="relative">                        
                        <span><?php echo Yii::t('front', 'Procesos en apelación'); ?></span>
                        <h6>Usuarios: <?php echo $indicators->countAssigned;  ?></h6>
                        <!-- <i class="feather feather-user"></i> -->
                        <div class="circle-porcent">
                            <?php  $pPending = ($indicators->assigned > 0)? round((($indicators->pending*100)/ $indicators->assigned),2) : 0?>
                            <span class="num">
                                <strong class="counter"><?php echo $pPending; ?></strong><strong>%</strong>
                            </span>
                        </div>
                        <span class="prices"><i class="feather feather-arrow-up"></i> $ <?php echo Yii::app()->format->formatNumber($indicators->pending); ?></span>
                        <div class="progress">
                          <div class="determinate" style="width: <?php echo $pPending; ?>%"></div>
                        </div>         
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="large-3 medium-4 small-12 columns">
            <div class="large-12 medium-12 small-12 columns padding">
                <div class="panel porcent_dash">
                    <div class="relative">
                        <div class="circle-porcent">
                            <div class="chart" data-percent="<?php echo $indicators->pRecovered; ?>">
                                <span class="num">
                                    <strong class="counter"><?php echo $indicators->pRecovered; ?></strong><strong>%</strong>
                                </span>
                            </div>
                        </div>
                        <h2><?php echo Yii::t('front', 'Porcentaje de <br>Recuperación'); ?></h2>
                        <a href="<?php echo Yii::app()->baseUrl; ?>/wallet">
                            <b class="feather feather-chevron-right"></b> <?php echo Yii::t('front', 'Ver toda la lista'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</section>
<!--Fin Datos iniciales-->