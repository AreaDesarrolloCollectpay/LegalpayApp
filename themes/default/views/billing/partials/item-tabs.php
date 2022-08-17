<div class="block m_t_20">
    <ul class="tabs tab_cartera tab_blank">
        <li class="tab"><a href="<?php echo $this->createUrl('/billing/payments/'); ?>" class="<?php echo (isset($active) && $active == 0)? 'active' : ''; ?>"><i class="fa fa-money"></i> <?php echo Yii::t('front', 'Pagos '); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/billing/spending/'); ?>" class="<?php echo (isset($active) && $active == 2)? 'active' : ''; ?>"><i class="fa fa-line-chart"></i> <?php echo Yii::t('front', 'GASTOS PROCESALES'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/billing/business/'); ?>" class="<?php echo (isset($active) && $active == 3)? 'active' : ''; ?>"><i class="fa fa-area-chart"></i> <?php echo Yii::t('front', 'Gastos Comerciales'); ?></a></li>
    </ul>
</div> 
