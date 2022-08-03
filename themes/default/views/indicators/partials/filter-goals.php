<div class="dates_all topBarJuridico hide">
    <ul class="filter_views"> 
        <li>
            <a href="#" class="tooltipped btn-filter-advance" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Filtrar'); ?>">
                <i class="fa fa-filter lin2"></i> <?php // echo Yii::t('front', 'Filtrar'); ?>
            </a>
        </li>                    
    </ul>                  
</div>
<div class=" formweb content_filter_advance">
    <form class="form-filter-indicators form-filter" data-id="goals-">
        <div class="row padd_v">              
            <fieldset class="large-6 medium-6 small-6 columns padding">
                <div class="item-customer">                            
                    <label><?php echo Yii::t('front', 'Estadísticas por Cliente'); ?></label>
                    <select name="idCustomer" id="goals-idCustomer" class="form-indicators">
                        <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                        
                    </select>
                </div>
            </fieldset>
            <fieldset class="large-6 medium-6 small-6 columns padding <?php echo (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['coordinators']))? 'hide' : ''; ?>">                        
                <label><?php echo Yii::t('front', 'Agencia'); ?></label>
                <select name="idCoordinator" id="goals-idCoordinator" class="form-indicators">
                    <option value=""><?php echo Yii::t('front', 'Seleccione'); ?></option>
                    
                </select>
            </fieldset>
            <input type="hidden" name="idAdviser" value="" />
        </div>
    </form>
</div>