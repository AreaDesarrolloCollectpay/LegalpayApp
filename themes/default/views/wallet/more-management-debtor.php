<section class="padding">                                                
    <ul class="collapsible acordeon_history" data-collapsible="accordion">

        <table class="bordered responsive-table"> 
            <thead>
                <tr>
                    <th width="25%" class="txt_center"><?php echo Yii::t('front', 'ALIANZA'); ?></th>
                    <th width="30%" class="txt_center"><?php echo Yii::t('front', 'ASESOR'); ?></th>
                    <th width="15%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                    <th width="30%" class="txt_center"><?php echo Yii::t('front', 'GESTION'); ?></th>
                </tr>
            </thead>
        </table>
        <?php
        if (count($managements) > 0) {
            foreach ($managements as $management) {
                $this->renderPartial('/wallet/partials/item-management', array('model' => $management, 'viewMore' => false));
            }
        }
        ?>
    </ul>
</section>