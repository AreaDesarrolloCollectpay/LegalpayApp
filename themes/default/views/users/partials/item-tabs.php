<?php $hide = (in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['admin'], Yii::app()->params['companies'])))? false : true; ?>
<div class="block m_t_20">
    <ul class="tabs tab_cartera tab_blank">
        <li class="tab <?php echo ($hide)? 'hide' : ''; ?>"><a href="<?php echo $this->createUrl('/users/coordinators/'.$id); ?>" class="<?php echo (isset($active) && $active == 0)? 'active' : ''; ?>"><i class="feather feather-users"></i> <?php echo Yii::t('front', 'Coodinadores'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/users/advisers/'.$id); ?>" class="<?php echo (isset($active) && $active == 2)? 'active' : ''; ?>"><i class="feather feather-users"></i> <?php echo Yii::t('front', 'Abogados'); ?></a></li>
        <li class="tab"><a href="<?php echo $this->createUrl('/users/dependent/'.$id); ?>" class="<?php echo (isset($active) && $active == 3)? 'active' : ''; ?>"><i class="feather feather-users"></i> <?php echo Yii::t('front', 'Dependientes'); ?></a></li>
        <li class="tab <?php echo 'hide'; ?>"><a href="<?php echo $this->createUrl('/users/business/'.$id); ?>" class="<?php echo (isset($active) && $active == 3)? 'active' : ''; ?>"><i class="feather feather-users"></i> <?php echo Yii::t('front', 'Comerciales'); ?></a></li>
    </ul>
</div> 
