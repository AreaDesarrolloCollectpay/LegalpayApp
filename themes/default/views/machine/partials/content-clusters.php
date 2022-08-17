<table class="bordered">
    <thead>
        <tr class="backgroung-table-4">
            <th class="txt_center"><?php echo Yii::t('front', 'NOMBRE'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'DESCRIPCIÓN'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
        </tr>
    </thead>
    <tbody id="items-clusters-<?php echo $model->id; ?>">
        <?php
        foreach ($clusters as $cluster) {
            $this->renderPartial('/machine/partials/item-clusters', array('model' => $cluster));
        }
        ?>                                  
    </tbody>
</table>
<div class="clear"></div>  
<div class="bg-pagination">
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pagesClusters,
        'currentPage' => (isset($currentClusterPage))? $currentClusterPage : 0,
        'header' => '',
        'id' => 'cluster-'.$model->id,
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