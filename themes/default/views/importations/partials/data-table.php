<section class="panelBG m_t_10 <?php echo ($count > 0)? '' : 'hide'; ?> ">
    <table class="bordered highlight responsive-table">
        <thead>
            <tr class="backgroung-table-2">
                <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                <th class="txt_center"><?php echo Yii::t('front', 'TIPO DE IMPORTACIÓN'); ?></th>
                <th class="txt_center"><?php echo Yii::t('front', 'NÚMERO DE CUENTAS'); ?></th>
                <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                <th class="txt_center"><?php echo Yii::t('front', 'ARCHIVO'); ?></th>
            </tr>
        </thead>
        <tbody id="listDebtors"> 
            <?php 
            foreach ($model as $value) { 
                  $this->renderPartial('/importations/partials/item-import', array('model' => $value));
            } ?>
    </table>
    <div class="clear"></div>  
    <div class="bg-pagination">
        <?php
        $this->widget('CLinkPager', array(
            'pages' => $pages,
            'header' => '',
            'selectedPageCssClass' => 'active',
            'previousPageCssClass' => 'prev',
            'nextPageCssClass' => 'next',
            'hiddenPageCssClass' => 'disbled',
            'internalPageCssClass' => 'pages',
            'htmlOptions' => array(
                'class' => 'pagination txt_center',
                'id' => 'paginator-import')
                )
        );
        ?>
    </div>
</section>