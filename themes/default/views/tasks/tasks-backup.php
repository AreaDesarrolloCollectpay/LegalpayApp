<!--Contenidos Sitio-->
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2><?php echo Yii::t('front', 'TAREAS'); ?></h2>
            </div>
        </section>
        <section class="row p_t_70">
            <section class="row">
                <!-- filter -->            
                <?php $this->renderPartial('/tasks/partials/filter-tasks', array('active' => 2, 'url'=>$url, 'profiles' => $profiles, 'profile' => $profile)); ?>            
                <!-- END filter -->
            </section>
            <section class="padding animated fadeInUp">
                <section class="all_tareas m_b_20">
                    <section class="panelBG m_b_20 animated" id="panelsk">                        
                        <div class="row block padd_v">
                            <div class="large-4 medium-4 small-12 columns padding hide">
                                <div class="bg_panel padding animated fadeInUp">
                                    <div class="table_scroll">  
                                        <table class="striped">
                                            <thead>
                                                <tr>
                                                    <th data-field="id"><b><?php echo Yii::t('front', 'PENDIENTES'); ?></b></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th data-field="name" class="txt_right padding"><span class="animated flip red"><?php  echo $countTasksPending; ?></span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($tasksPending as $tasks) {
                                                    $this->renderPartial('/tasks/partials/item-tasks', array('model' => $tasks));
                                                }
                                                ?>                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="large-6 medium-6 small-12 columns padding">
                                <div class="bg_panel padding animated fadeInUp">
                                    <div class="table_scroll" id="tasksToday"> 
                                        <table class="striped tAppendTasks">
                                            <thead>
                                                <tr>
                                                    <th data-field="id"><b><?php echo Yii::t('front', 'HOY'); ?></b></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th data-field="name" class="txt_right padding"><span class="animated flip"><?php  echo $countTasksToday; ?></span></th>
                                                </tr>
                                                <tr class="background-table-5">
                                                    <th class="txt_center"><?php echo Yii::t('front','Realizar en'); ?></th>
                                                    <th class="txt_center"><?php echo Yii::t('front','Fecha Tarea'); ?></th>
                                                    <th class="txt_center"><?php echo Yii::t('front','Acción'); ?></th>
                                                    <th class="txt_center"><?php echo Yii::t('front','Asignado'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>                                        
                                                <?php
                                                foreach ($tasksToday as $tasks) {
                                                    $this->renderPartial('/tasks/partials/item-tasks', array('model' => $tasks));
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="item-loading">
                                            <?php if($countTasksToday > 10): ?>
                                            <a class="view-more see-more" data-page="1" data-type="1" href=""><i class="fa fa-arrow-alt-circle-down lin2"></i> <?php echo Yii::t('front','Ver más'); ?></a>
                                            <b class="view-more hide">Cargando...</b>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="large-6 medium-6 small-12 columns padding">
                                <div class="bg_panel padding animated fadeInUp table_scroll">
                                    <div class="">
                                        <table class="striped tpAppendTasks">
                                            <thead>
                                                <tr>
                                                    <th data-field="id"><b><?php echo Yii::t('front', 'PROXIMAS'); ?></b></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th data-field="name" class="txt_right padding" colspan="2"><span class="animated flip verde"><?php echo $countTasksComming; ?></span></th>
                                                </tr>
                                                <tr class="background-table-5">
                                                    <th class="txt_center"><?php echo Yii::t('front','Realizar en'); ?></th>
                                                    <th class="txt_center"><?php echo Yii::t('front','Fecha Tarea'); ?></th>
                                                    <th class="txt_center"><?php echo Yii::t('front','Acción'); ?></th>
                                                    <th class="txt_center"><?php echo Yii::t('front','Asignado'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($tasksComming as $tasks){
                                                    $this->renderPartial('/tasks/partials/item-tasks', array('model' => $tasks));
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="item-loading">
                                            <?php if($countTasksComming > 10): ?>
                                            <a class="view-more see-more" data-page="1" data-type="2" href=""><i class="fa fa-arrow-alt-circle-down lin2"></i> <?php echo Yii::t('front','Ver más'); ?></a>
                                            <b class="view-more hide">Cargando...</b>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>    
        </section>
        <div class="clear"></div>
    </section>
</section>
<div class="clear"></div>
<?php
$js = "";
if(isset($_GET['profile'],$_GET['idUserAsigned'])){
   $js .= '
        setTimeout(function(){
            $("#userSearch").val("'.$_GET['idUserAsigned'].'");
        },1500);   
        '; 
}
Yii::app()->clientScript->registerScriptFile('//unpkg.com/jscroll/dist/jquery.jscroll.min.js', CClientScript::POS_END);  
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/tasks.min.js', CClientScript::POS_END); 
Yii::app()->clientScript->registerScript("myquery",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
CClientScript::POS_END
);
