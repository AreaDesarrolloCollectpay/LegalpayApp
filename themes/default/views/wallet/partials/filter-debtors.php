<?php //, Yii::app()->params['customers'])
$hide = true;
if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['admin'])) {
    $hide = false;
}
?>
<div class="dates_all topBarJuridico">
    <ul class="filter_views">
        <!--        <li class="backSite hide">
                    <a href="#" data-url="" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>"  onClick="history.go(-1); return false;">
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
                    </a>
                </li>-->
        <!--        <li class="<?php echo (isset($legal) && $legal) ? '' : 'hide'; ?>"><a href="#" data-url="wallet/legal/<?php echo $id . '/' . $quadrant; ?>" class="tooltipped <?php echo (isset($active) && $active == 1) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Columnas'); ?>"><i class="feather feather-align-left rotate"></i> <?php echo Yii::t('front', 'Columnas'); ?></a></li>
                <li><a href="#" data-url="wallet/<?php echo $id . '/' . $quadrant; ?><?php echo (isset($legal) && $legal) ? '/1' : ''; ?>" class="tooltipped <?php echo (isset($active) && $active == 2) ? 'active' : 'btn-filter-type-view'; ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Lista'); ?>"><i class="feather feather-align-left"></i> <?php echo Yii::t('front', 'Lista'); ?></a></li>                    -->
        <li><a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>"><i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar');  ?></a></li>                    
        <!--<li><a href="#" class="tooltipped btn-filter-export" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Exportar'); ?>"><i class="fa fa-download lin2"></i> <?php echo Yii::t('front', 'Exportar'); ?></a></li>-->                           
    </ul>                  
</div>
<div class="formweb content_filter_advance"> 
    <div class="clear"></div>                            
    <fieldset class="large-12 medium-12 small-12 columns padding m_b_20">              
        <form class="formweb form-filter-debtors" id="form-filter-debtors" data-id="form-filter-" data-url="<?php echo (isset($url) && $url != '') ? $url : ''; ?>" data-export="<?php echo $urlExport; ?>" enctype="multipart/form-data"> 
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Cliente') ?></label>                          
                <input name="customer" id="form-filter-customer" type="text" class="" value="">
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Contraparte'); ?></label>
                <input name="name" id="form-filter-name" type="text" class="" value="">                    
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'CC / NIT'); ?></label>
                <input name="code" id="form-filter-code" type="text" class="" value="">                                        
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Estado') ?></label>
                <select id="form-filter-idState" name="idState" class="">
                    <option value="" selected><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                    <?php foreach ($debtorState as $value) { ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>                
            <fieldset class="large-2 medium-2 small-6 columns padding hide">
                <label><?php echo Yii::t('front', 'Datos demográficos'); ?></label>
                <select id="form-filter-investigation" name="investigation" class="">
                    <option value="" selected><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                    <option value="1"><?php echo Yii::t('front', 'SI'); ?></option>
                    <option value="0"><?php echo Yii::t('front', 'NO'); ?></option>
                </select>
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding <?php echo ($hide) ? 'hide' : ''; ?>">
                <label><?php echo Yii::t('front', 'Coordinadores'); ?></label>
                <select name="idCoordinator" id="form-filter-idCoordinator">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($coordinators as $coordinator) { ?>
                        <option  value="<?php echo $coordinator->id; ?>"><?php echo $coordinator->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Tipo Proceso'); ?></label>
                <select name="idTypeProcess" id="form-filter-idTypeProcess">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($typeProcess as $typePro) { ?>
                        <option  value="<?php echo $typePro->id; ?>"><?php echo $typePro->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Número Radicado') ?></label>                          
                <input name="settledNumber" id="form-filter-settledNumber" type="text" class="" value="">     
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding hide">
                <label><?php echo Yii::t('front', 'Ordenar por :'); ?></label>
                <select name="order" id="form-filter-order">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <option value="t.capital_DESC"><?php echo Yii::t('front', 'Capital más alto'); ?></option>
                    <option value="t.capital_ASC"><?php echo Yii::t('front', 'Capital más bajo'); ?></option>
                    <option value="vml.date_DESC"><?php echo Yii::t('front', 'Gestión más reciente'); ?></option>
                    <option value="vml.date_ASC"><?php echo Yii::t('front', 'Gestión más antigua'); ?></option>
                </select>
            </fieldset>               
            <fieldset class="large-2 medium-2 small-6 columns padding hide <?php echo ($hide) ? 'hide' : ''; ?>">
                <label><?php echo Yii::t('front', 'Tipo cluster'); ?></label>
                <select name="idMlModels" id="form-filter-idMlModels" class="filter-mlModels">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($mlModels as $mlModel) { ?>
                        <option  value="<?php echo $mlModel->id; ?>"><?php echo $mlModel->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding  hide">
                <label><?php echo Yii::t('front', 'Cluster'); ?></label>
                <select name="idCluster" id="form-filter-idCluster">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>                            
                </select>
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Venc. de Términos'); ?></label>
                <select id="form-filter-terms" name="terms" class="">
                    <option value="" selected><?php echo Yii::t('front', 'Seleccionar'); ?></option>                        
                    <option value="1"><?php echo Yii::t('front', 'SI'); ?></option>
                    <option value="0"><?php echo Yii::t('front', 'NO'); ?></option>
                </select>
            </fieldset>
            <fieldset class="large-2 medium-2 small-6 columns padding">
                <label><?php echo Yii::t('front', 'Ubicación Juzgado'); ?></label>
                <input name="office_legal_location" id="form-filter-office_legal_location" type="text" class="" value="">                         
            </fieldset>
            <input name="page" id="form-filter-page" type="hidden" class="filter-page" value="<?php echo $currentPage; ?>" />
            <fieldset class="large-12 medium-12 small-12 columns padding txt_center m_t_10">            
                <button type="submit" class="btnb waves-effect waves-light" ><?php echo Yii::t('front', 'Filtrar'); ?></button>                                            
            </fieldset> 
        </form>
    </fieldset>
</div> 
