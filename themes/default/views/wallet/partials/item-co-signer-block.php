<?php
$id = 'co-signer-'.$model->id.'-'; 
?>
<li class="content_acord">
    <div class="acordeon">                          
        <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
        <?php echo Yii::t('front', 'CODEUDOR'); ?>: <?php echo $model->name; ?>
    </div>
    <div class="clearfix respuesta">
        <!-- -->
        <form action="" class="formweb m_t_20 form-walletCoSigner" data-id="<?php echo $id; ?>">
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Nombre / Razón Social'); ?></label>
                <input type="text" id="<?php echo $id ?>name" name="" placeholder="<?= $model->name; ?>" value="<?= $model->name; ?>">                                        
                <label><?php echo Yii::t('front', 'País'); ?></label>
                <select id="<?php echo $id; ?>idCountry" name="idCountry" class="select-country">
                <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <?php
                    if (count($countries) > 0) {
                        foreach ($countries as $country) {
                            ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>                                         
                <label><?php echo Yii::t('front', 'Dirección'); ?></label>
                <input type="text" id="<?php echo $id ?>address" name="address" placeholder="<?= $model->address; ?>" value="<?= $model->address; ?>">
                <label><?php echo Yii::t('front', 'Nivel de Ingresos'); ?></label>
                <select id="<?php echo $id ?>idIngresos" name="idIngresos">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">≤ 1.3</option>
                    <option value="">1.3 - 2.06</option>
                    <option value="">2.06 - 3.09</option>
                    <option value="">3.09 - 4.12</option>
                    <option value=""> > 4.12</option>
                </select> 
                <label><?php echo Yii::t('front', 'Género'); ?></label>
                <select id="<?php echo $id ?>idGender" name="idGender">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <?php
                    if (count($genders) > 0) {
                        foreach ($genders as $gender) {
                            ?>
                            <option value="<?= $gender->id; ?>"><?= $gender->name; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <label><?php echo Yii::t('front', 'Nivel Educativo'); ?></label>
                <select id="<?php echo $id ?>Level" name="idLevel">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">Bachiller</option>
                    <option value="">Ninguno</option>
                    <option value="">Postgrado</option>
                    <option value="">Primaria</option>
                    <option value="">Técnico</option>                                            
                    <option value="">Tecnológico</option>                                            
                    <option value="">Universitario</option>                                            
                </select>
                <label><?php echo Yii::t('front', 'Personas a Cargo'); ?></label>
                <select id="<?php echo $id ?>idStateSocial" name="idStateSocial">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">0</option>
                    <option value="">1</option>
                    <option value="">2</option>
                    <option value="">3</option>
                    <option value="">≥ 4</option>                                            
                </select>
                <label><?php echo Yii::t('front', 'Capacidad de Pago'); ?></label>
                <select name="idStateSocial">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">≤ 2.8 o muy baja</option>
                    <option value="">2.8 - 3.82 o baja capacidad</option>
                    <option value="">3.82 - 5.28 o mediana capacidad</option>
                    <option value="">> 5.28 o alta capacidad</option>                             
                </select>
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Cédula / NIT'); ?></label>
                <input type="text" id="<?php echo $id; ?>code" name="" placeholder="" value="">
                <label><?php echo Yii::t('front', 'Departamento'); ?></label>
                <select id="<?php echo $id ?>idDepartment" class="select-department">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                </select> 
                <label><?php echo Yii::t('front', 'Barrio / Zona'); ?></label>
                <input type="text" name="" id="<?php echo $id ?>neighborhood" placeholder="" value="" >                                        
                <label><?php echo Yii::t('front', 'Ocupación'); ?></label>
                <select id="<?php echo $id; ?>idOccupation" name="idOccupation">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <?php
                    if (count($occupations) > 0) {
                        foreach ($occupations as $occupation) {
                            ?>
                            <option value="<?= $occupation->id; ?>"><?= $occupation->name; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select> 
                <label><?php echo Yii::t('front', 'Edad'); ?></label>
                <select name="idAge">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">18 - 25</option>
                    <option value="">26 - 35</option>
                    <option value="">36 - 45</option>
                    <option value="">46 - 55</option>
                    <option value="">≥ 56</option>                                            
                </select>
                <label><?php echo Yii::t('front', 'Estrato Social'); ?></label>
                <select name="idStateSocial">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">1</option>
                    <option value="">2</option>
                    <option value="">3</option>
                    <option value="">4</option>
                    <option value="">5</option>                                            
                    <option value="">6</option>                                            
                </select>
                <label><?php echo Yii::t('front', 'Tipo de Vivienda'); ?></label>
                <select name="idStateSocial">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">Arrendada</option>
                    <option value="">Familiar</option>
                    <option value="">Propia</option>
                    <option value="">Ninguna de las anteriores</option>                             
                </select>                
            </fieldset>
            <fieldset class="large-4 medium-4 small-12 columns padding">
                <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>
                <input type="text" name="" id="<?php echo $id; ?>email" placeholder="<?= $model->email; ?>" value="<?= $model->email; ?>" >
                <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                <select id="<?php echo $id; ?>idCity">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>                    
                </select>
                <label><?php echo Yii::t('front', 'Teléfono / Celular'); ?></label>
                <input type="text" name="" id="<?php echo $id; ?>phone" placeholder="<?= $model->phone; ?>" value="<?= $model->phone; ?>" readonly>
                <label><?php echo Yii::t('front', 'Estado Civil'); ?></label>
                <select name="idMaritalState">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <?php
                    if (count($maritalStates) > 0) {
                        foreach ($maritalStates as $maritalState) {
                            ?>
                            <option value="<?= $maritalState->id; ?>"><?= $maritalState->name; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select> 
                <input type="hidden" name="id" value="<?= $model->id ?>" />                                        
                <label><?php echo Yii::t('front', 'Antiguedad Laboral'); ?></label>
                <select name="idStateSocial">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">≤ 1 año</option>
                    <option value="">1 - 3 años</option>
                    <option value="">3 - 6 años</option>
                    <option value="">6 - 9 años</option>
                    <option value="">> 9 años</option>                                            
                </select>
                <label><?php echo Yii::t('front', 'Tipo Contrato'); ?></label>
                <select name="idStateSocial">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">Jubilado</option>
                    <option value="">Servicios</option>
                    <option value="">Término Definido</option>
                    <option value="">Término Indefinido</option>
                    <option value="">Ninguno de los anteriores</option>                                            
                </select>
                <label><?php echo Yii::t('front', 'Plazo Contrato'); ?></label>
                <select name="idStateSocial">
                    <option value=""><?php echo Yii::t('front', 'Seleccionar opción'); ?></option>
                    <option value="">≤ 12 meses</option>
                    <option value="">12 - 18 meses</option>
                    <option value="">18 - 24 meses</option>
                    <option value="">24 - 36 meses</option>
                    <option value="">> 36 meses</option>                                            
                </select>
            </fieldset>
            <fieldset class="large-12 medium-12 small-12 columns padd_v">                
            <?php if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
                <div class="txt_center block padding ">
                    <button class="btnb waves-effect waves-light btn-disabled"><?php echo Yii::t('front', 'GUARDAR'); ?></button>
                </div>
            <?php } ?>
            </fieldset>
        </form>
    </div>
</li>
<?php 
Yii::app()->clientScript->registerScript("edit_".$id,'
        
    $(document).ready(function(){
    
        $("#'.$id.'idCountry").val("'.$model->idCountry.'").trigger("change");
        setTimeout(function(){        
            $("#'.$id.'idDepartment").val("'.$model->idDepartment.'").trigger("change");
            setTimeout(function(){        
                $("#'.$id.'idCity").val("'.$model->idCity.'").trigger("change");
            },500);                
        },1000);
    });            
    ',
     CClientScript::POS_END
    );

