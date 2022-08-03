<?php 
$array = array('3','6');
?>

	<div class="dates_all topBarJuridico">
 <ul class="filter_views">      
		<li><a href="/dashboard" id="m-dashboard"><i class="feather feather-grid"></i> Gestión</a></li>
		<li><a href="/maps" id="m-maps"><i class="feather feather-map-pin"></i> Mapa</a></li>
		<li><a href="/properties/movables" id="m-properties"><i class="fa fa-home"></i> Garantías</a></li>
		</ul>
	</div>
<button class="btn waves-effect waves-black right btn-filter-task" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>">
    <i class="feather feather-filter"></i> <?php // echo Yii::t('front', 'Filtrar'); ?>
</button>
<div class="formweb bg_filter_task"> 
    <h2><?php echo Yii::t('front', 'FILTRO DE TAREAS'); ?></h2>                
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
        <form class="formweb" id="form-filter-task" data-id="form-filter-" data-url="<?php echo (isset($url) && $url != '') ? $url : ''; ?>" enctype="multipart/form-data"> 
            <fieldset class="large-12 medium-12 small-12 columns">
                <label><?php echo Yii::t('front', 'Perfil'); ?></label>
                <select name="idProfile" id="searchProfile" class="cd-select filterType filterTask">
                    <option value="" selected><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($profiles as $value) { ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php } ?>
                </select>
                <label><?php echo Yii::t('front', 'Usuario'); ?></label>
                <select name="idUserAsigned" id="userSearch" class="cd-select filterType filterTask">
                    <option value="" selected><?php echo Yii::t('front', 'Seleccione'); ?></option>
                </select>
                <label><?php echo Yii::t('front', 'Acción'); ?></label>
                <select name="idTasksAction" id="from-filter-idTasksAction" class="cd-select filterTask">
                    <option value="" selected><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($actions as $action) { ?>
                        <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns">
                <label><?php echo Yii::t('front', 'Nombre / Contraparte'); ?></label>
                <input name="name" id="form-filter-numberDocument" type="text" class="filter-task filterTask" value="">  
                <label><?php echo Yii::t('front', 'CC / NIT'); ?></label>
                <input name="numberDocument" id="form-filter-numberDocument" type="text" class="" value="">  
            </fieldset>                                               
            <input name="type" id="form-filter-type" type="hidden" class="filter-task" value="" />  
            <input name="page" id="form-filter-page" type="hidden" class="filter-page" value="<?php echo $page; ?>" />  
            <fieldset class="large-12 medium-12 small-12 columns txt_right m_t_10">            
                <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                   
            </fieldset> 
        </form>
    </fieldset>
</div> 
<div class="maskFilter"></div>
