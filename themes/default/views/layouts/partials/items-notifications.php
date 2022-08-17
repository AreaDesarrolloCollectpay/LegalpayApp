<h5><?php echo Yii::t('front', 'Tienes'); ?> <span><?php echo $count; ?></span> <?php echo ($count == 1) ? Yii::t('front', 'Notificacion') : Yii::t('front', 'Notificaciones'); ?></h5>
<ul class="list-not">
    <?php 
    foreach ($model as $value){ 
    ?>
    <li>
        <a data-id="<?php echo $value->id; ?>" href="<?php echo $value->url; ?>">
            <div class="media-body">
                <h6><?php echo $value->messages->typeNot->name; ?></h6>
                <p><?php echo $value->message; ?></p>
            </div>
            <div class="media-right text-nowrap">
                <time datetime="<?php echo $value->dateCreated;?>" class="fs-13 text-muted"><?php echo $value->getTime(); ?></time>
            </div>
        </a>
    </li>
    <?php } ?>    
</ul>
<?php if($count > $limit){ ?>
<div class="dropdown-footer">
    <a href="<?php echo Yii::app()->baseUrl; ?>/notifications"><?php echo Yii::t('front', 'Ver todas las notificaciones') ?></a>
</div>
<?php } ?>
<script>
    $(document).ready(function(){
        $("ul.list-not li").on("click", "a",function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var href = $(this).attr('href');
            $.ajax({
                url: SITEURL + "/notifications/updateNotification",
                dataType: 'json',
                type: 'POST',
                data: {id: id},
                success: function (result) {
                    if (result.status == "ok") {
                        window.location.href = href;
                    }
                }
            });
            return false;
        });
    });
</script>