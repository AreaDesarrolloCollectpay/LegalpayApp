<table class="bordered border-table" style=" border: 1px solid #a5a5a5 !important;">
    <thead>
        <tr class="backgroung-table-4">
            <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
            <th class="txt_center hide_customer hide"><?php echo Yii::t('front', 'ASESOR'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'ACCIÓN'); ?></th>
            <th width="50%" class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
        </tr>
        <tr class="filters formweb" data-id="cluster" data-url="cluster">
            <th class="txt_center"><input class="filter-table calendar_range" id="management-filter-date" type="text" name="date" ></th>
            <th class="txt_center hide"><input class="filter-table" id="management-filter-adviser" type="text" name="adviser" /></th>
            <th class="txt_center">
                <select id="management-filter-idMLModel" name="idTasksAction" class="filter-table" data-closest="th">
                    <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                    <?php foreach ($actionsManagements as $actionsManagement) { ?>
                        <option value="<?php echo $actionsManagement->idTasksAction; ?>"><?php echo Yii::t('front', $actionsManagement->management); ?></option>
                    <?php } ?>
                </select>
            </th>  
            <th class="txt_center"><input class="filter-table" id="management-filter-comments" type="text" name="comments" /></th>            
        </tr>
    </thead>
    <tbody id="walletSupportsView-<?php echo $business->id; ?>">
        <?php
        foreach ($managements as $management) {
            $this->renderPartial('/business/partials/item-support-task', array('model' => $management));
        }
        ?>                                  
    </tbody>
</table>
<div class="clear"></div>  
<div class="bg-pagination">
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pagesManagement,
        'currentPage' => (isset($currentManagementPage))? $currentManagementPage : 0,
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