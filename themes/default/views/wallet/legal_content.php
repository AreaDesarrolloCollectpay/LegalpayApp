<?php
foreach ($legalStates as $legalState) {    
    $values = WalletController::getValuesLegal($condition, $join ,$legalState->id);
    ?>
    <li class="drag-column drag-column-on-hold">
        <div class="tittleList">
            <h3><?php echo Yii::t('front', $legalState->name); ?><i class="feather feather-users m_l_10"></i>&nbsp;  <?php echo $values->cant; ?></h3>
            <!--<span class="deudor"><i class="feather feather-users"></i> <?php echo $values->cant; ?></span>-->                                    
            <span>$ <?php echo Yii::app()->format->formatNumber(($values != null)? $values->capital : ''); ?></span>  
            <!--<h6><?php // echo Yii::t('front', 'Usuario'); ?>: <?php // echo $values->cant; ?></h6>-->
        </div>        
        <div class="scrolldash">  
            <ul class="connectedSortable" id="<?php echo $legalState->id; ?>">
                <?php
                $models = WalletController::getDebtorsLegal($condition, $join ,$legalState->id);
                foreach ($models['models'] as $model) {
                   $this->renderPartial('/wallet/partials/item-debtor-legal', array('model' => $model));
                }
                ?>   
            </ul>
            <div class="item-loading <?php echo ($values->cant > 10)? '' : 'hide'; ?>">
                <a class="view-more see-more" data-page="<?php echo $currentPage; ?>" href=""><i class="fa fa-arrow-alt-circle-down lin2"></i> <?php echo Yii::t('front', 'Ver más'); ?></a>
                <b class="view-more hide"><?php echo Yii::t('front', 'Cargando'); ?>...</b>
            </div>
            <?php if(Yii::app()->user->getState('rol') != 17){ ?>
            <div class="draganNone"><?php echo Yii::t('front', 'Arrastrar proyecto aquí...'); ?></div>
            <?php } ?>
        </div>
    </li>
<?php } ?>
