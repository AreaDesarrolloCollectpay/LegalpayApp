<article class="checkSite" id="itemCommentWallet-<?= $model->id; ?>">
    <label for="check<?= $model->id ?>" class="block">
        <div class="large-9 medium-8 small-12 columns">
            <div class="img_perfil">
              <!--<img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/img/user/<?= $model->idUserComment ?>.png" alt="">
                -->
                <!--
                -->
                <img src="<?php echo ($model->idUserComment != null)? $model->idUserComment0->image : Yii::app()->theme->baseUrl.'/assets/img/user/user.png'; ?>" alt="">    
            </div>     
            <span class="inline txt">
                <h3><?php echo ($model->idUserComment != null)? $model->idUserComment0->name : Yii::t('front', 'Anónimo');?></h3>
                <p><?= $model->comment; ?></p>
            </span>
        </div>
        <div class="large-3 medium-4 small-12 columns txt_right">
            <div class="inline date">            
                <p><span><?php echo Controller::calculaFecha($model->minutes->minutes); ?></span></p>
            </div>
        </div>
        <div class="clear"></div>
    </label>
</article>