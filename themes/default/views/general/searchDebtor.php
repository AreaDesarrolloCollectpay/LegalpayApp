<table class="bordered responsive-table">
    <thead>
        <tr class="backgroung-table-2">
            <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'VER'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $value){
            $this->renderPartial('/general/partials/item-search-debtor', array('model' => $value));  
        } ?>
    </tbody>
</table>     