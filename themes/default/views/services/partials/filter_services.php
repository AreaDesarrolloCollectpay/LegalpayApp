<div class="dates_all topBarJuridico p_t_20">
    <ul class="filter_views">        
        <li class="backSite">
            <a href="<?php echo (isset($url) && $url != '')? $url : '#'; ?>" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo Yii::t('front', 'Volver'); ?>" <?php if(!isset($url) || $url == ''){ ?>   onClick="history.go(-1); return false;" <?php } ?>>
                <i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo Yii::t('front', 'Volver'); ?>
            </a>
        </li>
    </ul>                  
</div>

