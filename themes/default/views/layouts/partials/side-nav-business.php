<?php if(in_array(Yii::app()->user->getState('rol'), array_merge(Yii::app()->params['advisorBusiness'],Yii::app()->params['admin']))){ ?>
<!--Side Nav-->
<section class="sidenavFixed animated fadeInRight">    
        <a href="#email_detail_business" data-idBusiness="<?php echo (isset($business)) ? $business->id : ''; ?>" class="tooltipped modal_clic email-detail-debtor hide-email" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'E-mail'); ?>"><i class="feather feather-mail"></i></a>
        <a href="#sms_detail_business" data-idBusiness="<?php echo (isset($business)) ? $business->id : ''; ?>" class="tooltipped modal_clic sms-detail-debtor hide-sms" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'SMS'); ?>"><i class="feather feather-message-circle"></i></a>
        <a href="#" class="tooltipped open_phone hide-call" data-position="left" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Llamar'); ?>"><i class="feather feather-phone"></i><span class="active__call"></span></a>
</section>
<!--/ Side Nav-->
<?php } ?>