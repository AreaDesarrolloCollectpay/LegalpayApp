<div class="block m_t_20">
    <ul class="tabs tab_cartera tab_blank">
        <li class="tab"><a href="<?php echo $this->createUrl('/properties/movables'); ?>" class="<?php echo (isset($active) && $active == 1)? 'active' : ''; ?>"><i class="feather feather-airplay"></i> <?php echo Yii::t('front', 'Muebles'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/properties/inmovables'); ?>" class="<?php echo (isset($active) && $active == 2)? 'active' : ''; ?>"><i class="feather feather-home"></i> <?php echo Yii::t('front', 'Inmuebles'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/properties/others'); ?>" class="<?php echo (isset($active) && $active == 3)? 'active' : ''; ?>"><i class="feather feather-aperture"></i> <?php echo Yii::t('front', 'Otros'); ?></a></li>
    </ul>
</div> 