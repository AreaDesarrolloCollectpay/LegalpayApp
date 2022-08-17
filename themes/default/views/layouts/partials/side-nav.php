<?php if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['accounting'],Yii::app()->params['customers'],Yii::app()->params['companies']))){ ?>
<!--Side Nav-->
<section class="sidenavFixed animated fadeInRight">
    <!--<a href="#tareaOption" class="tooltipped modal_clic tasks-modal <?php echo (!isset($task) || !$task)? 'hide' : ''; ?>" data-type="m" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Tarea'); ?>"><i class="feather feather-list"></i></a>-->
    <!--<a href="#consultsOption" class="tooltipped modal_clic search-modal" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Buscar'); ?>"><i class="feather feather-search"></i></a>-->
    <?php if (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) { ?>
    <a href="#new_help_links_modal" data-id="2" class="tooltipped modal_clic btnHelpLinks" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Formatos de Documento'); ?>"><i class="feather feather-file-text"></i></a>
    <a href="#new_help_links_modal" data-id="1" class="tooltipped modal_clic btnHelpLinks" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Links de Apoyo'); ?>"><i class="feather feather-link"></i></a>
    <?php if(isset($historic) &&  !$historic){ ?>
        <a href="#email_detail_debtor" data-iddebtor="<?php echo (isset($debtor))? $debtor->id : ''; ?>" class="tooltipped modal_clic email-detail-debtor hide-email" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'E-mail'); ?>"><i class="feather feather-mail"></i></a>
        <a href="#sms_detail_debtor" data-iddebtor="<?php echo (isset($debtor))? $debtor->id : ''; ?>" class="tooltipped modal_clic sms-detail-debtor hide-sms" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'SMS'); ?>"><i class="feather feather-message-circle"></i></a>
        <?php if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['coordinators'],Yii::app()->params['advisers'],Yii::app()->params['customers']))){ ?>
            <a href="#" class="tooltipped open_phone hide-call" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Llamar'); ?>">
                <i class="feather feather-phone"></i>
                <span class="active__call"></span>
            </a>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</section>
<!--/ Side Nav-->
<?php } ?>
