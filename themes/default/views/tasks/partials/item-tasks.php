<?php $user = Users::model()->findByPk($model->idUserAsigned); ?>
<li>
    <div class="panel-card estado<?php echo $i; ?> <?php echo ($model->date < date('Y-m-d')) ? 'backward' : ''; ?>">
        <a href="<?php echo ($model->idUserAsigned == Yii::app()->user->getId()) ? $model->url : "#"; ?>" class="modal_clic">                                                
            <div class="text">
                <h3><?php echo $model->name; ?> <span class="tab"><?php echo $model->actionName; ?></span> <?php echo ($model->date < date('Y-m-d')) ? '<span class="tab alert">' . Yii::t('front', 'Atrasada') . '</span>' : ''; ?></h3>    
                <p><?php echo Yii::t('front', 'Asignado a'); ?>: <?php echo ($user != null)? $user->name : ''; ?></p>
            </div>
        </a> 
        <div class="date">
            <span><?php echo $model->date; ?></span>
            <a href="#edit_task" class="modal_clic hide">                                                
                <div class="btn_actualizar"><i class="fa fa-edit"></i> <?php echo Yii::t('front', 'Actualizar'); ?></div>
            </a> 
        </div>
    </div>
</li>