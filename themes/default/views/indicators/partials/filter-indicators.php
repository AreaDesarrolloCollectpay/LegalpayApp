<?php 
$idCoordinator = Yii::app()->user->getState('idCoordinator');
$large = 3;
$hide = false;
    if(in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators'])){
        $idCoordinator =Yii::app()->user->getId();
        $large = 4;
        $hide = true;
    } 
?>
<div class="dates_all topBarJuridico">
    <ul class="filter_chart"> 
        <li>
            <a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>">
                <i class="fas fa-bars lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?>
            </a>
        </li>                    
    </ul>                  
</div>
<div class=" formweb content_filter_advance">
    <form class="form-filter-indicators form-filter" data-id="indicators-">
        <div class="row padd_v">  
            <fieldset class="large-<?php echo $large; ?> medium-<?php echo $large; ?> small-6 columns padding">
                <div class="">                            
                    <label><?php echo Yii::t('front', 'Tipo de Estadística'); ?></label>
                    <select name="idType" id="indicators-idType" class="form-indicators">
                        <option value="1"><?php echo Yii::t('front', 'Distribución Regional'); ?></option>
                        <!--<option value="2"><?php echo Yii::t('front', 'Tipos de Producto'); ?></option>-->
                        <option value="3"><?php echo Yii::t('front', 'Tipos de Persona'); ?></option>
                        <option value="4"><?php echo Yii::t('front', 'Garantias'); ?></option>
                        <option value="5"><?php echo Yii::t('front', 'Edades Cartera'); ?></option>
                        <option value="6"><?php echo Yii::t('front', 'Acuerdo de Pago'); ?></option>
                        <option value="0" selected><?php echo Yii::t('front', 'Estados de Cartera'); ?></option>
                    </select>
                </div>
            </fieldset>
            <fieldset class="large-<?php echo $large; ?> medium-<?php echo $large; ?> small-6 columns padding">
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Estadísticas por Cliente'); ?></label>
                    <select name="idCustomer" id="indicators-idCustomer" class="form-indicators">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                        <?php foreach ($customers as $customer) { ?>
                            <option value="<?php echo $customer->id; ?>"><?php echo $customer->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </fieldset>
            <fieldset class="large-<?php echo $large; ?> medium-<?php echo $large; ?> small-6 columns padding">                        
                <label><?php echo Yii::t('front', 'Estadísticas por Etapa'); ?></label>
                <select name="ageDebt" id="indicators-ageDebt" class="form-indicators">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($ageDebts as $ageDebt) { ?>
                        <option value="<?php echo $ageDebt->id; ?>"><?php echo $ageDebt->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <fieldset class="large-<?php echo $large; ?> medium-<?php echo $large; ?> small-6 columns padding <?php echo ($hide)? 'hide' : ''; ?>">                        
                <label><?php echo Yii::t('front', 'Agencias'); ?></label>
                <select name="idCoordinator" id="indicators-idCoordinator" class="form-indicators">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    <?php foreach ($coordinators as $coordinator) { ?>
                        <option <?php echo ($coordinator->id == $idCoordinator)? 'selected' : ''; ?> value="<?php echo $coordinator->id; ?>"><?php echo $coordinator->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <input type="hidden" name="idAdviser" value="" />
        </div>
    </form>
</div>