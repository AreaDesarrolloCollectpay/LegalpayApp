<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false));  ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row dashContent">
            <section class="padding">
                <?php
//                    Yii::app()->controller->renderPartial('/layouts/partials/content-indicators', array('indicators' => $indicators));
                ?>
                <!--Global Dashboard-->              
                <section class="list_dash animated fadeInUp">
                    <ul>
                        <?php foreach ($ageDebts as $ageDebt){ ?>
                            <li class="large-6 medium-6 small-12 columns">                                
                                <a href="<?php echo ($ageDebt->id == 5)? Yii::app()->baseUrl.'/wallet/legal/'.$id.'/0' : Yii::app()->baseUrl.'/wallet/'.$id.'/'.$ageDebt->id.'/0'; ?>">
                                    <div class="card_dash sin_margin waves-effect waves-light">
                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                        <div class="txt">
                                            <h1><?php echo Yii::t('front', ucwords(mb_strtolower($ageDebt->name))); ?></h1>                                    
                                            <div class="lineap"></div>
                                            <?php $quadrants = Controller::GetAgeDebt($id, $ageDebt->id); ?>
                                            <div class="row">
                                                <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null)? $quadrants->cant : '0'; ?></p>
                                                <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null)? $quadrants->capital : '0'); ?></p>
                                                <?php if($ageDebt->id != 5){ ?>
                                                <p><i class="fa fa-clock" aria-hidden="true"></i> <?php echo ($ageDebt->id == 4)? '+'.$ageDebt->text.' ' : ''.$ageDebt->text.' '; echo Yii::t('front', 'días'); ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>           
<!--                                        <div class="hover">
                                            <p><?php echo $ageDebt->text; ?></p>
                                        </div>                         -->
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="large-6 medium-6 small-12 columns hide">
                            <a href="<?php echo Yii::app()->baseUrl.'/wallet/'.$id.'?investigation=0&filter=hide'; ?>">
                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Investigación'); ?></h1>                                    
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetInvestigation($id, 0); ?>
                                        <div class="row">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null)? $quadrants->cant : '0'; ?></p>
                                            <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null)? $quadrants->capital : '0'); ?></p>
                                        </div>
                                    </div>                                                                                                 
                                </div>
                            </a>
                        </li>
<!--                        <li class="large-6 medium-6 small-12 columns">
                            <a href="<?php echo Yii::app()->baseUrl.'/wallet/'.$id.'?idState=81&filter=hide'; ?>">
                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Visitas Domiciliarias'); ?></h1>                                    
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetAgeState($id, 81); ?>
                                        <div class="row">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null)? $quadrants->cant : '0'; ?></p>
                                            <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null)? $quadrants->capital : '0'); ?></p>
                                        </div>
                                    </div>                                                                                                 
                                </div>
                            </a>
                        </li>-->
                        <li class="medium-offset-3 medium-6 small-12 columns">
                            <a href="<?php echo Yii::app()->baseUrl.'/wallet/'.$id.'/0/0'; ?>">
                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Total'); ?></h1>                                    
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetAgeDebt($id, 0); ?>
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