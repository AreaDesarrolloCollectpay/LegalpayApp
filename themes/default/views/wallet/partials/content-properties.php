<table class="bordered">
    <thead>
        <tr class="backgroung-table-4">
            <th class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'MATRÍCULA'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'UBICACIÓN'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'DIRECCIÓN'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
        </tr>
        <tr class="filters formweb" data-id="cluster" data-url="cluster">
            <th class="txt_center"><input class="filter-table" id="properties-filter-type" type="text" name="type" /></th>
            <th class="txt_center"><input class="filter-table" id="properties-filter-number" type="text" name="number" /></th>                        
            <th class="txt_center"><input class="filter-table" id="properties-filter-address" type="text" name="address" /></th>                        
            <th class="txt_center"><input class="filter-table" id="properties-filter-comments" type="text" name="comments" /></th>                        
            <th class="txt_center"><input class="filter-table" id="properties-filter-actions" type="text" name="actions" readonly /></th>            
        </tr>
    </thead>
    <tbody id="walletProperty-<?php echo $debtor->id; ?>">
        <?php
        if (count($properties) > 0) {
            foreach ($properties as $property) {
                $this->renderPartial('/wallet/partials/item-property', array('model' => $property));
            }
        }
        ?>                                  
    </tbody>
</table>
<div class="clear"></div>  
<div class="bg-pagination">
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pagesProperties,
        'currentPage' => (isset($currentPropertyPage)) ? $currentPropertyPage : 0,
        'header' => '',
        'id' => 'management',
        'firstPageCssClass' => 'paginationTab',
        'selectedPageCssClass' => 'active paginationTab',
        'previousPageCssClass' => 'prev paginationTab',
        'nextPageCssClass' => 'next paginationTab',
        'hiddenPageCssClass' => 'disbled',
        'internalPageCssClass' => 'pages paginationTab',
        'lastPageCssClass' => 'paginationTab',
        'htmlOptions' => array(
            'class' => 'pagination txt_center')
            )
    );
    ?>
</div>