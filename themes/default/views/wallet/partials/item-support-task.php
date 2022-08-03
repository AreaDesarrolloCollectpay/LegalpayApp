<tr id="itemSupportWallet-<?= $model->id; ?>">
    <td class="txt_center"><?= date("d/m/Y", strtotime($model->date)); ?></td>
    <td class="txt_center hide"><?= $model->coordinator; ?></td>
    <td class="txt_center "><?= $model->adviser; ?></td>
    <td class="txt_center"><?= $model->management; ?></td>
    <td class="txt_center"><?= $model->debtorState; ?></td>
    <td class="txt_center"><?= nl2br($model->comments); ?></td>
    <td class="txt_center icon_table">
        <?php if((in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers']))){ ?>
            <a href="#new_tasks_modal" 
               class="inline padding tooltipped editTaskDebtor modal_clic btn-disabled hide" 
               data-position="top" 
               data-delay="50" 
               data-tooltip="Editar" 
               data-id="<?= $model->id; ?>" 
               ><i class="fa fa-pencil-alt" aria-hidden="true"></i>
            </a>
        <?php } ?>
        
        <?php
            $model->getCallInfo();         
            $file = DebtorsTasksSupport::model()->find(array('condition' => 'idDebtorTask ='.$model->id));
            if($file != null && $model->call == null){ ?>            
                <a href="<?php echo $file->support; ?>" class="inline padding" download><i class="fas fa-download" aria-hidden="true"></i></a>                            
        <?php }
            if($model->images > 0){ ?>        
                <a href="#<?php echo ($model->call != null)? '' : 'view_management_images_modal'; ?>" class="inline padding tooltipped  <?php echo ($model->call != null)? 'listen-call' : 'viewSupportManagement modal_clic'; ?>" id="<?php echo $model->id; ?>" data-idTask="<?= $model->id; ?>" data-file="<?php echo ($model->call != null && array_key_exists('record', $model->call))? Controller::getCallphone($model->call['record']) : ''; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo ($model->call != null)? ((array_key_exists('number', $model->call))? $model->call['number'] : '') : Yii::t('front', 'Ver Soportes'); ?>"><i class="fas fa-<?php echo ($model->call != null)? 'play' : 'eye';  ?>" aria-hidden="true"></i></a>            
        <?php } ?>
                
        
        <?php if($model->images > 0 && $model->idTasksAction != 1){ ?>
            <!--<a href="#" class="inline padding tooltipped " data-idTask="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver Soportes') ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
        <?php } ?>
        <?php if($model->images > 0 && $model->idTasksAction == 1){
            $model->getCallInfo(); 
            if($model->call != null){ ?>
                <!--<a href="#" class="inline padding tooltipped listen-call" id="<?php echo $model->id; ?>" data-idTask="<?= $model->id; ?>" data-file="<?php echo (array_key_exists('record', $model->call))? Controller::getCallphone($model->call['record']) : ''; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo (array_key_exists('number', $model->call))? $model->call['number'] : ''; ?>"><i class="fas fa-play" aria-hidden="true"></i></a>-->
        <?php }else{  ?>
        <!--<a href="#view_management_images_modal" class="inline padding tooltipped viewSupportManagement modal_clic" data-idTask="<?= $model->id; ?>" data-position="top" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Ver Soportes') ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
        <?php }
            } ?>
    </td>
</tr>

