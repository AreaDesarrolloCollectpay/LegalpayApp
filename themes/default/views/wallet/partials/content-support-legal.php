<table class="bordered responsive-table">
    <thead>
        <tr class="backgroung-table-4">
            <th class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'TIPO'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
        </tr>
        <tr class="filters formweb" data-id="supportLegal" data-url="wallet/supportLegalPage">
            <th class="txt_center"><input class="filter-table calendar_range" id="supportLegal-filter-date" type="text" name="date" ></th>
            <th class="txt_center">
                <select id="supportLegal-filter-idTypeSupport" name="idTypeSupport" class="filter-table" data-closest="th">
                    <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                    <?php foreach ($typeLegalSupports as $typeLegalSupport) { ?>
                        <option value="<?php echo $typeLegalSupport->id; ?>"><?php echo Yii::t('front', $typeLegalSupport->name); ?></option>
                    <?php } ?>
                </select>
            </th>  
            <th class="txt_center"><input class="filter-table" id="supportLegal-filter-comments" type="text" name="comments" /></th>            
            <th class="txt_center"><input class="filter-table" id="supportLegal-filter-actions" type="text" name="actions" readonly /></th> 
            <th class="hide"><input id="supportLegal-filter-page" name="page" type="hidden" class="filter-table" value="1"></th>
            <th class="hide"><input id="supportLegal-filter-idDebtor" name="idDebtor" type="hidden" class="filter-table" value="<?php echo $debtor->id; ?>"></th>
        </tr>
    </thead>
    <tbody id="tbody-supportLegal">
        <?php
        foreach ($supportsLegals as $supportsLegal) {
            $this->renderPartial('/wallet/partials/item-support', array('model' => $supportsLegal));
        }
        ?>                                  
    </tbody>
</table>
<div class="clear"></div>  
<div id="pagination-supportLegal" class="bg-pagination">  
    <?php
        if(isset($pages) && $pages != null){
            $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages, 'currentPage' => (isset($currentPage))? $currentPage : 0, 'id' => 'supportLegal')); 
        }
    ?>
</div>