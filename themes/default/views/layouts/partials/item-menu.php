<li <?php echo $model->id.'-'; ?>><a href="<?php echo Yii::app()->baseUrl.'/'.$model->url; ?>" <?php echo ($model->idMenu != null)? '' : 'class="waves-effect waves-light"'; ?> id="m-<?php echo $model->slug; ?>"><i class="<?php echo $model->class; ?>"></i> <?php echo Yii::t('front',$model->name); ?></a></li>
