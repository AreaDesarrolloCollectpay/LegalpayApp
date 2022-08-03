<?php 
    $id = $typeDebtorContact == 1 ? "walletCod-".$model->id:"walletRef-".$model->id;
?>
<li class="content_acord">
    <div class="acordeon" id="<?php echo $id; ?>">                          
        <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
        <?php echo $model->name; ?>
    </div>
    <div class="clearfix respuesta">
        <!-- -->
        <div class="row m_b_20">            
            <?php 
                $this->renderPartial('/wallet/partials/form-debtor-contacts', 
                    array('model' => $model,
                        'debt' => $debt,
                        'typeDebtorContact' => $typeDebtorContact,
                        'countries' => $countries,
                        'genders' => $genders,
                        'occupations' => $occupations,
                        'maritalStates' => $maritalStates,
                        'educationLevels' => $educationLevels,
                        'typeHousings' => $typeHousings,
                        'typeContracts' => $typeContracts,
                    )
                ); 
            ?>  
        </div>
    </div>
</li>
