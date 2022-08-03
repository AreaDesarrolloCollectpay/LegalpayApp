<?php $hide = (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin'], Yii::app()->params['companies'])))? false : true; ?>
<div class="block m_t_20">
    <ul class="tabs tab_cartera tab_blank">
        <li class="tab <?php echo ($hide)? 'hide' : ''; ?>"><a href="<?php echo $this->createUrl('/callcenter/attend/'); ?>" class="<?php echo (isset($active) && $active == 0)? 'active' : ''; ?>"><?php echo Yii::t('front', 'Atendidas'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/callcenter/unattended/'); ?>" class="<?php echo (isset($active) && $active == 2)? 'active' : ''; ?>"><?php echo Yii::t('front', 'Sin Atender'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/callcenter/distribution/'); ?>" class="<?php echo (isset($active) && $active == 3)? 'active' : ''; ?>"><?php echo Yii::t('front', 'Distribución'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/callcenter/realtime/'); ?>" class="<?php echo (isset($active) && $active == 4)? 'active' : ''; ?>"><?php echo Yii::t('front', 'RealTime'); ?></a></li>
    </ul>
</div> 