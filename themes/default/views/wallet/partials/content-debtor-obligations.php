<!-- -->
<table class="bordered">
    <thead>
        <tr class="backgroung-table-4">
            <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'N. OBLIGACIÓN'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'HONORARIOS'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'TOTAL'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
        </tr>
        <tr class="filters formweb" data-id="debtors-obligations" data-url="debtors-obligations">
            <th class="txt_center"><input class="filter-table calendar_range" id="debtors-obligations-filter-date" type="text" name="date" ></th>
            <th class="txt_center"><input class="filter-table" id="debtors-obligations-filter-credit_number" type="text" name="credit_number" /></th>
            <th class="txt_center"><input class="filter-table" id="debtors-obligations-filter-capital" type="text" name="capital" /></th>
            <th class="txt_center"><input class="filter-table" id="debtors-obligations-filter-interest" type="text" name="interest" /></th>            
            <th class="txt_center"><input class="filter-table" id="debtors-obligations-filter-fee" type="text" name="fee" /></th>            
            <th class="txt_center"><input class="filter-table" id="debtors-obligations-filter-total" type="text" name="total" /></th>            
            <th class="txt_center"><input class="filter-table" id="debtors-obligations-filter-actions" type="text" name="actions" readonly /></th>            
        </tr>
    </thead>
    <tbody id="walletObligations-<?php echo $debtor->id; ?>">
        <?php
		/*
		echo "<pre>";
		debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS); 
		echo "</pre>";
		*/
        foreach ($obligations as $obligation) {
            $this->renderPartial('/wallet/partials/item-debtor-obligation', array('model' => $obligation));
        }
        ?>                                  
    </tbody>
</table>
<div class="clear"></div>  
<div class="bg-pagination">
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pagesObligations,
        'currentPage' => (isset($currentObligationPage))? $currentObligationPage : 0,
        'header' => '',
        'id' => 'obligations',
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