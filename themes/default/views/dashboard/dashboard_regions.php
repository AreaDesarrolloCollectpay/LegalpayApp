<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row dashContent">
            <section class="padding">
                <!--Global Dashboard-->              
                <section class="list_dash animated fadeInUp">
                    <ul>
                        <?php foreach ($regions as $region){ ?>
                            <li class="large-6 medium-6 small-12 columns">                                
                                <a href="<?php echo Yii::app()->baseUrl.'/region/'.$region->id; ?>">
                                    <div class="card_dash sin_margin waves-effect waves-light">
                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                        <div class="txt">
                                            <h1><?php echo Yii::t('front', 'Región').' '.Yii::t('front', ucwords(mb_strtolower($region->name))); ?></h1>                                    
                                            <div class="lineap"></div>
                                            <?php $quadrants = Controller::GetRegionDebt($region->id); ?>
                                            <div class="row">
                                                <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null)? $quadrants->cant : '0'; ?></p>
                                                <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null)? $quadrants->capital : '0'); ?></p>                                                
                                            </div>
                                        </div> 
                                    </div>
                                </a>
                            </li>
                        <?php } ?>                        
                        <li class="large-6 medium-6 small-12 columns">
                            <a href="<?php echo Yii::app()->baseUrl.'/region/'; ?>">
                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Total'); ?></h1>                                    
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetRegionDebt(0); ?>
                                        <div class="row">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null)? $quadrants->cant : '0'; ?></p>
                                            <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null)? $quadrants->capital : '0'); ?></p>
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