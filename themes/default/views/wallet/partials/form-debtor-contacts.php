<?php
$id = ($model != null) ? 'debtor-contact-'.$model->id.'-' : 'debtor-contact-';
?> 
<form action="" class="formweb form-walletContact" data-id="<?php echo $id;?>">
    <div class="row padd_v">
        <fieldset class="large-4 medium-4 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Nombre / Razón Social'); ?></label>
            <input type="text" id="<?= $id; ?>name" name="name" value="<?= $model != null ? $model->name : "";?>">                                        
            <label><?php echo Yii::t('front', 'País'); ?></label>
            <select id="<?= $id; ?>idCountry" name="idCountry" class="select-country">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php foreach ($countries as $country) { ?>
                <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                <?php } ?>
            </select>                                         
            <label><?php echo Yii::t('front', 'Dirección'); ?></label>
            <input type="text" id="<?= $id; ?>address" name="address" value="<?= $model != null ? $model->address : "";?>">
            <label><?php echo Yii::t('front', 'Celular'); ?></label>
            <input type="text" id="<?= $id; ?>mobile" name="mobile" value="<?= $model != null ? $model->mobile : "";?>">
            <label><?php echo Yii::t('front', 'Nivel de Ingresos (Cantidad salarios mínimos)'); ?></label>
            <input type="number" id="<?= $id; ?>incomeLegal" name="incomeLegal" value="<?= $model != null ? $model->debtorsContactsDemographics[0]->incomeLegal : ""; ?>" class="input-disabled">                                     
            <label><?php echo Yii::t('front', 'Género'); ?></label>
            <select id="<?= $id; ?>idGender" name="idGender">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php foreach ($genders as $gender) { ?>
                <option value="<?= $gender->id; ?>" <?php echo ($model != null && $model->debtorsContactsDemographics[0]->idGender == $gender->id) ? "selected":""?>><?= $gender->name; ?></option>
                <?php } ?>
            </select>
            <label><?php echo Yii::t('front', 'Nivel Educativo'); ?></label>
            <select id="<?= $id; ?>idTypeEducationLevel" name="idTypeEducationLevel">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php foreach ($educationLevels as $educationLevel){ ?>
                <option value="<?php echo $educationLevel->id; ?>" <?php echo ($model != null && $model->debtorsContactsDemographics[0]->idTypeEducationLevel == $educationLevel->id) ? "selected":""?>><?php echo $educationLevel->name ?></option>
                <?php } ?>                                            
            </select>
            <label><?php echo Yii::t('front', 'Personas a Cargo'); ?></label>
            <input type="number" id="<?= $id; ?>idDependents" name="dependents" value="<?= $model != null ? $model->debtorsContactsDemographics[0]->dependents:""; ?>" class="input-disabled">                                                         
        </fieldset>
        <fieldset class="large-4 medium-4 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Cédula / NIT'); ?></label>
            <input type="text" id="<?= $id; ?>code" name="code" value="<?= $model != null ? $model->code : "";?>">
            <label><?php echo Yii::t('front', 'Departamento'); ?></label>
            <select id="<?= $id; ?>idDepartment" name="idDepartment" class="select-department">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
            </select> 
            <label><?php echo Yii::t('front', 'Barrio / Zona'); ?></label>
            <input type="text" name="neighborhood" id="<?= $id; ?>neighborhood" placeholder="" value="<?= $model != null ? $model->neighborhood : "";?>" >                                        
            <label><?php echo Yii::t('front', 'Ocupación'); ?></label>
            <select id="<?= $id; ?>idOccupation" name="idOccupation">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php foreach ($occupations as $occupation) { ?>
                <option value="<?= $occupation->id; ?>" <?php echo ($model != null && $model->debtorsContactsDemographics[0]->idOccupation == $occupation->id) ? "selected":""?>><?= $occupation->name; ?></option>
                <?php } ?>
            </select> 
            <label><?php echo Yii::t('front', 'Edad'); ?></label>
            <input type="number" id="<?= $id; ?>age" name="age" value="<?= $model != null ? $model->debtorsContactsDemographics[0]->age:""; ?>" class="input-disabled">                                                  
            <label><?php echo Yii::t('front', 'Estrato Social'); ?></label>
            <input type="number" id="<?= $id; ?>stratus" name="stratus" value="<?= $model != null ? $model->debtorsContactsDemographics[0]->stratus:""; ?>" class="input-disabled">                                                  
            <label><?php echo Yii::t('front', 'Tipo de Vivienda'); ?></label>
            <select id="<?= $id; ?>idTypeHousing" name="idTypeHousing">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php foreach ($typeHousings as $typeHousing) { ?>
                <option value="<?php echo $typeHousing->id; ?>" <?php echo ($model != null && $model->debtorsContactsDemographics[0]->idTypeHousing == $typeHousing->id) ? "selected":""?>><?php echo $typeHousing->name; ?></option>
                <?php } ?>  
            </select> 
            <label><?php echo Yii::t('front', 'Capacidad de Pago (Cantidad salarios)'); ?></label>
            <input type="number" id="<?= $id; ?>paymentCapacity" name="paymentCapacity" value="<?= $model != null ? $model->debtorsContactsDemographics[0]->paymentCapacity:""; ?>" class="input-disabled">                                                        
        </fieldset>
        <fieldset class="large-4 medium-4 small-12 columns padding">
            <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>
            <input type="text" name="email" id="<?= $id; ?>email" value="<?= $model != null ? $model->email : "";?>" >
            <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
            <select id="<?= $id; ?>idCity" name="idCity">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>                    
            </select>
            <label><?php echo Yii::t('front', 'Teléfono'); ?></label>
            <input type="text" name="phone" id="<?= $id; ?>phone" value="<?= $model != null ? $model->phone : "";?>">
            <label><?php echo Yii::t('front', 'Estado Civil'); ?></label>
            <select id="<?= $id; ?>idMaritalState" name="idMaritalState">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php  foreach ($maritalStates as $maritalState) { ?>
                <option value="<?= $maritalState->id; ?>" <?php echo ($model != null && $model->debtorsContactsDemographics[0]->idMaritalState == $maritalState->id) ? "selected":""?>><?= $maritalState->name; ?></option>
                <?php } ?>
            </select>                                                         
            <label><?php echo Yii::t('front', 'Antiguedad Laboral (Cantidad en años)'); ?></label>
             <input type="number" id="<?= $id; ?>laborOld" name="laborOld" value="<?= $model != null ? $model->debtorsContactsDemographics[0]->laborOld:""; ?>" class="input-disabled">                                                                 
            <label><?php echo Yii::t('front', 'Tipo Contrato'); ?></label>
            <select id="<?= $id; ?>idTypeContract" name="idTypeContract">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php  foreach ($typeContracts as $typeContract) { ?>                                            
                <option value="<?php echo $typeContract->id; ?>" <?php echo ($model != null && $model->debtorsContactsDemographics[0]->idTypeContract == $typeContract->id) ? "selected":""?>><?php echo $typeContract->name; ?></option>
                <?php } ?>                                            
            </select> 
            <label><?php echo Yii::t('front', 'Plazo Contrato (Cantidad en meses)'); ?></label>
            <input type="number" id="<?= $id; ?>contractTerm" name="contractTerm" value="<?= $model != null ? $model->debtorsContactsDemographics[0]->contractTerm:""; ?>" class="input-disabled">                                                                    
        </fieldset> 
        <input id="<?= $id; ?>idDebtor" name="idDebtor" type="hidden" value="<?= ($debt != null ? $debt->id :"");?>" />
        <input id="<?= $id; ?>typeDebtorContact" name="idTypeDebtorContact" type="hidden" value="<?= ($typeDebtorContact != null ? $typeDebtorContact:"") ;?>" />
        <input id="<?= $id; ?>DebtorContact" name="id" type="hidden" value="<?= ($model != null ? $model->id:"") ;?>" />
        <div class="clear"></div>
    </div>
    <div class="modal-footer">
         <?php if($model == null){?>
            <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>      
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
        <?php }else{?>
            <div class="txt_center block padding ">
                <button class="btnb waves-effect waves-light btn-disabled"><?php echo Yii::t('front', 'GUARDAR'); ?></button>
            </div>
        <?php } ?>
    </div>
</form>
<?php 
if($model != null){
    $array = array(
        'idCountry'=>$model->idCountry,
        'idDepartment'=>$model->idDepartment,
        'idCity'=>$model->idCity);
    Yii::app()->clientScript->registerScript("edit_".$id,'

        $(document).ready(function(){
            var model = '.json_encode($array).';
            var id = "'.$id.'";
            getLocation(id,model);
        });            
        ',
         CClientScript::POS_END
        );
}