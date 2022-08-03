<?php
$model = null;
?>
<header>
    <div class="row border_bottom_header">
        <a href="#" data-activates="nav-mobile" class="nav_movile top-nav hide-on-large-only">    
            <div class="burger"> <ul> <li></li> <li></li> <li></li> </ul></div>
        </a>
        <a href="dashboard" class="logo animated fadeInLeft">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.svg" alt="Collectpay">
        </a>           
	<div class="user-header">
                
        </div>
        <ul class="list_actions">            
        </ul>
    </div>  
</header>
<nav id="nav-mobile" class="side-nav fixed">
    <div class="bg_profile">              
        <a href="<?php echo Yii::app()->baseUrl; ?>/profile">
            <div class="user_log">
                <img src="<?php echo ($model != null && $model->image != '')? $model->image :  Yii::app()->theme->baseUrl.'/assets/img/user/user.png'; ?>" alt="<?php echo ($model != null && $model->name != '')? $model-> name : Yii::app()->user->getState('title'); ?>" class="img-user">
            </div>
            <h1 class="txt_center user-name"><?php echo ($model != null && $model->name != '')? $model->name : Yii::app()->user->getState('title'); ?></h1>
            <p><?php echo Yii::t('front' , ($model != null && $model->profile != '')? $model->profile : 'Invitado');  ?></p>
        </a>
    </div>
    <ul>
        <?php echo Controller::getMenuServices(); ?>   
        
    </ul> 
</nav>

<!--Calendar-->
<div id="root-picker-outlet"></div>
<!--Calendar-->
