<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row dashContent">
            <section class="padding">
                <!--Global Dashboard-->              
                <section class="list_dash">
                    <ul><!-- medium-offset-3 -->
                        <?php 
                        $i = 2;
                        foreach ($mlModels as $mlModel){ ?>
                            <li class="large-6 medium-6 small-12 columns">
<!--href="<?php echo Yii::app()->baseUrl.'/cluster/'.$mlModel->id; ?>"-->                                
                                <div>
                                    <div class="card_dash sin_margin waves-effect waves-light">
                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                        <div class="txt">
                                            <h1><?php echo Yii::t('front', ucwords(mb_strtolower($mlModel->name))); ?></h1>                                    
                                            <div class="lineap"></div>
                                            <?php $quadrants = Controller::GetClusterDebt($mlModel->id); 
                                                  $clusters = Clusters::model()->findAll(array('condition' => 'idMLModel = '.$mlModel->id));
                                            ?>
                                            <div class="row formweb" style="width: 78%">
                                                <fieldset class="large-4 medium-4 small-6 columns padding">                                                    
                                                <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null)? $quadrants->cant : '0'; ?></p>
                                                </fieldset>
                                                <fieldset class="large-4 medium-4 small-6 columns padding">                                                    
                                                <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null)? $quadrants->capital : '0'); ?></p>                                                
                                                </fieldset>
                                                <fieldset class="large-4 medium-4 small-6 columns padding">                                                    
                                                    <select class="select-cluster">
                                                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                                        <?php foreach ($clusters as $cluster){ ?>
                                                        <option value="<?php echo $mlModel->id.'?idCluster='.$cluster->id; ?>"><?php echo $cluster->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </li>
                        <?php 
                            $i++;
                        } ?> 
                        <li class="large-6 medium-6 small-12 columns">                                
                            <a href="<?php echo Yii::app()->baseUrl . '/wallet/legal/0/0'; ?>">
                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Cartera Judicializada'); ?></h1>                                    
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetAgeDebt(0, 7); ?>
                                        <div class="row">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null) ? $quadrants->cant : '0'; ?></p>
                                            <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null) ? $quadrants->capital : '0'); ?></p>                                            
                                        </div>
                                    </div>           
                                </div>
                            </a>
                        </li>
                    </ul>
                </section>
                <!--Fin Global Dashboard-->              
            </section>
            <div class="clear"></div>
        </section>
    </section>
    <div class="clear"></div>
</section>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/dashboard.min.js', CClientScript::POS_END); ?>
