<section class="cont_home">       
    <section class="conten_inicial">
	<div class="dates_all topBarJuridico">
 <ul class="filter_views">
		
		<li><a href="/tasks" id="m-tasks"><i class="feather feather-list "></i> Calendario</a></li>
		<li><a href="/maps" id="m-maps"><i class="feather feather-map-pin"></i> Mapa</a></li>
		<li><a href="/properties/movables" id="m-properties"><i class="fa fa-home"></i> Garantías</a></li>
		</ul>
	</div>
        <section class="row dashContent">
            <section class="padding">
                <!--Global Dashboard-->              
                <section class="list_dash">
                    <ul><!-- medium-offset-3 -->
                        <li class="large-6 medium-offset-3 small-12 columns">                                
			    <a href="<?php echo Yii::app()->baseUrl . '/dashboard/quadrants'; ?>"> <!-- <?php echo Yii::app()->baseUrl . '/wallet/0/0/0'; ?> -->

                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Conciliaciones Extrajudiciales'); ?></h1>
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetAgeDebt(0, 0); ?>
                                        <div class="row">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null) ? $quadrants->cant : '0'; ?></p>
                                            <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null) ? $quadrants->capital : '0'); ?></p>                                            
                                        </div>
                                    </div>           
				</div>

                            </a>
                        </li>
                        <li class="large-6 medium-offset-3 small-12 columns">                                
                            <a href="<?php echo Yii::app()->baseUrl . '/wallet/legal/0/0'; ?>">
                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Mis procesos'); ?></h1>
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetAgeDebt(0, 5); ?>
                                        <div class="row">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null) ? $quadrants->cant : '0'; ?></p>
                                            <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null) ? $quadrants->capital : '0'); ?></p>                                            
                                        </div>
                                    </div>           
                                </div>
                            </a>
                        </li>
                        <!---
                        <li class="large-6 medium-offset-3 small-12 columns <?php echo (Yii::app()->user->getState('rol') == 1)? '' : 'hide'; ?> ">
                            <a href="<?php echo Yii::app()->baseUrl.'/wallet/0/0/?investigation=0&filter=hide'; ?>">
                                <div class="card_dash sin_margin waves-effect waves-light">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/bg-panel-dashboard.svg" class="svg-img">
                                    <div class="txt">
                                        <h1><?php echo Yii::t('front', 'Procesos Finalizados'); ?></h1>
                                        <div class="lineap"></div>
                                        <?php $quadrants = Controller::GetInvestigation(0, 0); ?>
                                        <div class="row">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> <?php echo ($quadrants != null)? $quadrants->cant : '0'; ?></p>
                                            <p><i class="fa fa-dollar-sign" aria-hidden="true"></i> <?php echo Yii::app()->format->formatNumber(($quadrants != null)? $quadrants->capital : '0'); ?></p>
                                        </div>
                                    </div>                                                                                                 
                                </div>
                            </a>
                        </li>
                        -->
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
