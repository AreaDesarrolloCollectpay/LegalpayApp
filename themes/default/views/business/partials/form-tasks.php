<form class="form-business-tasks formweb" data-id="business-tasks-" enctype="multipart/form-data"> 
    <fieldset class="large-6 medium-6 small-6 columns padding">
        <label><?php echo Yii::t('front', 'Acción'); ?>*</label>
        <select name="idTasksAction" id="business-tasks-idTasksAction" class="select-tasksAction select-tasksSupport">
            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
            <?php foreach ($actions as $action) { ?>
                <option value="<?php echo $action->id; ?>" ><?php echo $action->name; ?></option>
            <?php } ?>
        </select>
    </fieldset>
    <fieldset class="large-6 medium-6 small-6 columns padding">
        <label><?php echo Yii::t('front', 'Estado'); ?></label>                          
        <select  name="idUserState" id="business-tasks-idUserState" class="tasks-debtorState">
            <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
            <?php foreach ($states as $state) { ?>
                <option value="<?= $state->id; ?>"><?php echo Yii::t('front', $state->name); ?></option>
            <?php } ?>  
        </select>  
    </fieldset>  
    <fieldset class="large-6 medium-6 small-6 columns padding">           
        <label><?php echo Yii::t('front', 'Fecha'); ?>*</label>
        <div class="fecha">
            <input name="date" id="business-tasks-dateTask" type="date" class="calendar" value="" />
        </div>
    </fieldset>
    <fieldset class="large-6 medium-6 small-6 columns padding">
            <label><?php echo Yii::t('front', '¿Hizo Contacto?'); ?></label>                          
            <select  name="is_contact" id="business-tasks-is_contact" class="select-Tasks-is_contact" disabled>
                <option value="0"><?php echo Yii::t('front', 'No'); ?></option>
                <option value="1"><?php echo Yii::t('front', 'Si'); ?></option>
            </select>
    </fieldset>  
    <fieldset class="large-12 medium-12 small-12 columns padding">            
        <label><?php echo Yii::t('front', 'Comentario'); ?></label>
        <textarea name="comments" cols="30" rows="10" id="business-tasks-comment"></textarea>
    </fieldset>
    <fieldset class="large-12 medium-12 small-12 columns padding">            
        <div class="file-field input-field hide" id="file-task">
            <div class="btn">
                <span><?php echo Yii::t('front', 'Cargar sorporte'); ?></span>
                <input class="" name="support[]" id="business-tasks-support" type="file" multiple accept="image/*">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" disabled="disabled">
            </div>
        </div>
    </fieldset>  
    <input type="hidden" name="idUsersBusiness" id="business-tasks-idUsersBusiness" value="<?php echo $business->id; ?>" />
    <input type="hidden" name="id" id="business-tasks-id" value="" /> 
    <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
        <button type="submit" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'Guardar'); ?></button>
        <a href="<?php echo $this->createUrl('/business/detail/'.$business->id); ?>" class="btnb pop waves-effect btn-cancel-task waves-light right hide m_r_10"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </fieldset> 
</form>
<?php
if(isset($task) && $task != null){
    Yii::app()->clientScript->registerScript("edit_task",'
        
    $(document).ready(function(){
        $(".btn-cancel-task").removeClass("hide");
        $("#business-tasks-idTasksAction").val("'.$task->idTasksAction.'").trigger("change");
        $("#business-tasks-dateTask").val("'.$task->date.'");
        var picker = $("#tasks-dateTask").pickadate("picker");
//        picker.set("disable", true);
//        console.log("trest");
        $("#business-tasks-dateTask").attr("aria-readonly", true);        
        $("#business-tasks-idUserState").val("'.$task->idUserState.'").trigger("change");
        $("#business-tasks-comment").val("'.preg_replace("[\n|\r|\n\r]", " ", $task->comments).'");
        $("#business-tasks-id").val("'.$task->id.'");
    });
            
    ',
     CClientScript::POS_END
    );  
}
?>