<li class="no-padding" <?php echo $model->id.'-'.$model->menuUsersProfiles[0]->order; ?>>
    <ul class="collapsible">
        <li class="bold">
            <a class="collapsible-header" id="m-<?php echo $model->slug; ?>"><i class="<?php echo $model->class; ?>"></i> <?php echo Yii::t('front', $model->name); ?></a>
            <div class="collapsible-body">
                <ul>
                    <?php 
					
                    $criteria->order = 'tmup.order ASC';
					//$criteria->condition="tmup.active=1";
                    $subItems = Menu::model()->findAll($criteria);
					
					$nomostrar= array('Negocios','Call Center','Probabilidad','PSM','Valoración','Tareas','Mapa','Garantías','Métricas','Trazabilidad','KPI\'s');
					
                    foreach ($subItems as $subItem){
						if(!in_array($subItem->name,$nomostrar)){
							$this->renderPartial("/layouts/partials/item-menu",array('model' => $subItem));      
						}
                    }             
                    ?>
                    <li class="hide"><a href="#">Sub menu 3</a></li>
                </ul>
            </div>
        </li>
        <li></li>
    </ul>
</li> 
 
