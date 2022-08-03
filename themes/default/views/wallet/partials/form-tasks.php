<form class="form-management formweb" data-id="tasks-<?php echo $type; ?>-" enctype="multipart/form-data"> 
    <fieldset class="large-6 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', ($debtor->is_legal)? 'Actuación' : 'Acción'); ?>*</label>
        <select name="idTasksAction" id="tasks-<?php echo $type; ?>-idTasksAction" class="select-tasksAction select-tasksSupport">
            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
            <?php foreach ($actions as $action) { ?>
                <option value="<?php echo $action->id; ?>" ><?php echo $action->name; ?></option>
            <?php } ?>
        </select>
        <label><?php echo Yii::t('front', 'Fecha'); ?>*</label>
        <div class="fecha">
            <input name="date" id="tasks-<?php echo $type; ?>-dateTask" type="date" class="calendar" value="" />
        </div>
    </fieldset>
    <fieldset class="large-6 medium-12 small-12 columns padding">
        <label><?php echo Yii::t('front', ($debtor->is_legal)? 'Etapa' : 'Estado'); ?></label>                          
        <select  name="idDebtorState" id="tasks-<?php echo $type; ?>-idDebtorState" data-substate="#tasks-<?php echo $type; ?>-" class="tasks-debtorState <?php echo ($debtor->is_legal)? 'select-debtorStateLegal' : ''; ?>">
            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
            <?php foreach ($status as $stat) { ?>
                <option value="<?= $stat->id; ?>"><?php echo Yii::t('front', $stat->name); ?></option>
            <?php } ?>  
        </select>
<!--        <label><?php echo Yii::t('front', 'Efectos'); ?></label>                          
        <select  name="idTasksEffect" id="tasks-<?php echo $type; ?>-idTasksEffect">
            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
        </select>                                             -->
        
        <?php if($debtor->is_legal == 0){ ?>
            <label><?php echo Yii::t('front', 'Valor'); ?></label>                          
            <input type="text" value="" name="value" <?php //echo ($debtor->idState == 1)? '' : 'readonly'; ?> class="task-value" />
        <?php }else{ ?>
            <label><?php echo Yii::t('front', 'Sub-etapa'); ?></label>
            <div class="DebtorSubState" id="tasks-<?php echo $type; ?>-SubState">
                <select id="tasks-<?php echo $type; ?>-idDebtorSubState" class="debtorObligations-idDebtorSubState" name="idDebtorSubstate">
                <option value="" enabled='true'><?php echo Yii::t('front', 'NINGUNO'); ?></option>
                <?php echo Controller::printTree($tree, 1, null, $debtor->idDebtorSubstate); ?>
            </select>
            </div>
        <?php } ?>
        
<!--        <select  name="state" id="tasks-<?php echo $type; ?>-idState" class="select-tasksSupport">
            <option value=""><?php echo Yii::t('front', 'Seleccionarn'); ?></option>
            <option value="1"><?php echo Yii::t('front', 'Realizada'); ?></option>
        </select>-->          
        <input type="hidden" name="is_contact" value="0" />
    </fieldset>  
    <fieldset class="large-12 medium-12 small-12 columns padding">            
        <label><?php echo Yii::t('front', 'Comentarios'); ?></label>
        <textarea name="comments" cols="30" rows="10" id="tasks-<?php echo $type; ?>-comment"></textarea>
    </fieldset>
    <fieldset class="large-12 medium-12 small-12 columns padding">            
        <div class="file-field input-field"><!-- hide id="file-task" -->
            <div class="btn">
                <span><?php echo Yii::t('front', 'Soporte'); ?></span>
                <input class="" name="support" id="tasks-<?php echo $type; ?>-support" type="file">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" disabled="disabled">
            </div>
        </div>
    </fieldset>  
    <input type="hidden" name="idDebtorDebt" id="tasks-<?php echo $type; ?>-idDebtorDebt" value="<?php echo $debtor->id; ?>" />
    <input type="hidden" name="id" id="tasks-<?php echo $type; ?>-id" value="" /> 
    <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_5">            
        <button type="submit" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'Guardar'); ?></button>
        <a href="<?php echo $this->createUrl('/wallet/debtor/'.$debtor->id); ?>" class="btnb pop waves-effect btn-cancel-task waves-light right hide m_r_10"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </fieldset> 
</form>
<?php
    
if(isset($task) && $task != null){ ?>
<script>
        
    $(document).ready(function(){
        $(".btn-cancel-task").removeClass("hide");
        $("#tasks-<?php echo $type ?>-idTasksAction").val("<?php echo $task->idTasksAction; ?>").trigger("change");
        $("#tasks-<?php echo $type ?>-dateTask").val("<?php echo $task->date; ?>");
        $("#tasks-<?php echo $type ?>-dateTask").attr("aria-readonly", true);        
        $("#tasks-<?php echo $type ?>-idState").val("<?php echo $task->state; ?>").trigger("change");
        $("#tasks-<?php echo $type ?>-comment").val("<?php echo  preg_replace("[\n|\r|\n\r]", " ", $task->comments); ?>");
        $("#tasks-<?php echo $type ?>-id").val("<?php echo $task->id; ?>");
        setTimeout(function(){        
            $("#tasks-<?php echo $type ?>-idTasksEffect").val("<?php echo $task->idTasksEffect; ?>").trigger("change");                
        },1000);
        console.log("task");
    });
</script>

 <?php }
 //    if(Yii::app()->user->getId() == 533){
//                     print_r($task);
//                     echo '$(document).ready(function(){
//        $(".btn-cancel-task").removeClass("hide");
//        $("#tasks-'.$type.'-idTasksAction").val("'.$task->idTasksAction.'").trigger("change");
//        $("#tasks-'.$type.'-dateTask").val("'.$task->date.'");
//        var picker = $("#tasks-'.$type.'-dateTask").pickadate("picker");
////        picker.set("disable", true);
////        console.log("trest");
//        $("#tasks-'.$type.'-dateTask").attr("aria-readonly", true);        
//        $("#tasks-'.$type.'-idState").val("'.$task->state.'").trigger("change");
//        $("#tasks-'.$type.'-comment").val("'.preg_replace("[\n|\r|\n\r]", " ", $task->comments).'");
//        $("#tasks-'.$type.'-id").val("'.$task->id.'");
//        setTimeout(function(){        
//            $("#tasks-'.$type.'-idTasksEffect").val("'.$task->idTasksEffect.'").trigger("change");                
//        },1000);
//    });';
//                exit;
//            }
    
?>