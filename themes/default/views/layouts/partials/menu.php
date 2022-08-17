<?php
$model = ViewUsers::model()->find(array('condition' => 'id ='.Yii::app()->user->getId()));
$notifications = UsersNotifications::model()->count(array('condition' => 'idUser ='.Yii::app()->user->getId().' AND seen = 0'));
?>
<header>
    <div class="row border_bottom_header">
        <a href="#" data-activates="nav-mobile" class="nav_movile top-nav hide-on-large-only">    
            <div class="burger"> <ul> <li></li> <li></li> <li></li> </ul></div>
        </a>
        <a href="<?php echo Yii::app()->createUrl("/dashboard");?>" class="logo animated fadeInLeft">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.svg" alt="Collectpay">
        </a>           
        <div class="user-header">
            <div class="user_log">
                <img src="<?php echo ($model != null && $model->image != '')? $model->image :  Yii::app()->theme->baseUrl.'/assets/img/user/user.png'; ?>" alt="<?php echo ($model != null && $model->name != '')? $model-> name : Yii::app()->user->getState('title'); ?>" class="img-user">
            </div>
            <ul>
                <li><a href="<?php echo Yii::app()->baseUrl; ?>/profile" class="waves-effect waves-light"><?php echo Yii::t('front', 'Ver perfil'); ?></a></li> 
                <li><a href="<?php echo Yii::app()->baseUrl; ?>/logout" class="waves-effect waves-light"><?php echo Yii::t('front', 'Cerrar sesión'); ?></a></li> 
            </ul>    
        </div>
        <ul class="list_actions">
            <li>
                <a href="#consultsOption" class="modal_clic search-modal"><i class="feather feather-search"></i></a>
            </li>
            <li>
                <a href="javascript:void(0)" class="notif getNotifications"><span class="swing"><?php echo $notifications; ?></span><i class="feather feather-bell"></i></a>
                <div class="all_not" id="content-notifications"></div>
            </li>
        </ul>
    </div>  
</header>
<nav id="nav-mobile" class="side-nav fixed">
    <div class="bg_profile">              
        <a href="<?php echo Yii::app()->baseUrl; ?>/profile">
            <div class="user_log">
                <img src="<?php echo ($model != null && $model->image != '')? $model->image :  Yii::app()->theme->baseUrl.'/assets/img/user/user.png'; ?>" alt="<?php echo ($model != null && $model->name != '')? $model-> name : Yii::app()->user->getState('title'); ?>" class="img-user">
            </div>
            <?php 
            if(Yii::app()->user->getId() != 185){ ?>
            <h1 class="txt_center user-name"><?php echo ($model != null && $model->name != '')? $model->name : Yii::app()->user->getState('title'); ?></h1>
            <?php } ?>
            <p><?php echo Yii::t('front' , ($model != null && $model->profile != '')? $model->profile : 'Invitado');  ?></p>
        </a>
    </div>
    <ul>
        <?php echo Controller::getMenu(); ?>          
    </ul> 
</nav>

<!--Calendar-->
<div id="root-picker-outlet"></div>
<!--Calendar-->