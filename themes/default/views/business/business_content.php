<?php
foreach ($userStates as $userState) {
    $values = BusinessController::GetValuesBusiness($condition, $join ,$userState->id);
    ?>
    <li class="drag-column drag-column-on-hold">
        <div class="tittleList">
            <h3><?php echo mb_strtoupper(Yii::t('front', $userState->name)); ?><i class="feather feather-users m_l_10"></i>&nbsp;  <?php echo $values->cant; ?></h3>
            <!--<span class="deudor"><i class="feather feather-users"></i> <?php echo $values->cant; ?></span>-->                                     
            <span>$ <?php echo Yii::app()->format->formatNumber($values->value); ?></span>                 
            <!--<h6 class="numberBusiness"><?php echo $values->cant; ?></h6>-->
        </div>        
        <div class="scrolldash">  
            <ul class="connectedSortable" id="<?php echo $userState->id; ?>">
                <?php
                $models = BusinessController::GetBusiness($condition, $join ,$userState->id);
                foreach ($models['models'] as $model) {
                    $user = ViewUsers::model()->find(array("condition" => "id = ".$model->idBusinessAdvisor));
                    $model->comercial = ($user != null) ? $user->name : "";
                    $this->renderPartial('/business/partials/item-business', array('model' => $model));
                }
                ?>   
            </ul>
            <div class="item-loading <?php echo ($values->cant > 10)? '' : 'hide'; ?>">
                <a class="view-more see-more" data-page="<?php echo $currentPage; ?>" href=""><i class="fa fa-arrow-alt-circle-down lin2"></i> <?php echo Yii::t('front', 'Ver más'); ?></a>
                <b class="view-more hide"><?php echo Yii::t('front', 'Cargando'); ?>...</b>
            </div>
            <div class="draganNone"><?php echo Yii::t('front', 'Arrastrar proyecto aquí...'); ?></div>
        </div>
    </li>
<?php } ?>