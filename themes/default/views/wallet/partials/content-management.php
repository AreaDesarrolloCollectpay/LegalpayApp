<table class="bordered">
    <thead>
        <tr class="backgroung-table-4">
            <th width="8%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
            <th width="10%" class="txt_center  hide"><?php echo Yii::t('front', 'COORDINADOR'); ?></th>
            <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ASESOR'); ?></th>
            <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ACCIÓN'); ?></th>
            <th width="10%" class="txt_center"><?php echo Yii::t('front', 'ESTADO DEUDOR'); ?></th>
            <th width="40%" class="txt_center"><?php echo Yii::t('front', 'COMENTARIOS'); ?></th>
            <th width="12%" class="txt_center"><?php echo Yii::t('front', 'ACCIONES'); ?></th>
        </tr>
        <tr class="filters formweb" data-id="management-<?php echo $debtor->id; ?>" data-url="wallet/managementPage">
            <th class="txt_center"><input class="filter-table calendar_range" id="management-<?php echo $debtor->id; ?>-filter-date" type="text" name="date" ></th>
            <th class="txt_center  hide"><input class="filter-table" id="management-<?php echo $debtor->id; ?>-filter-coordinator" type="text" name="coordinator" /></th>
            <th class="txt_center "><input class="filter-table" id="management-<?php echo $debtor->id; ?>-filter-adviser" type="text" name="adviser" /></th>
            <th class="txt_center">
                <select id="management-<?php echo $debtor->id; ?>-filter-idMLModel" name="idTasksAction" class="filter-table" data-closest="th">
                    <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                    <?php foreach ($actionsManagements as $actionsManagement) { ?>
                        <option value="<?php echo $actionsManagement->idTasksAction; ?>"><?php echo Yii::t('front', $actionsManagement->management); ?></option>
                    <?php } ?>
                </select>
            </th>            
            <th class="txt_center ">
                <select id="management-<?php echo $debtor->id; ?>-filter-idState" name="idState" class="filter-table">
                    <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                    <?php foreach ($status as $stat) { ?>
                        <option value="<?php echo $stat->id; ?>"><?php echo $stat->name; ?></option>
                    <?php } ?>
                </select>
            </th>
            <th class="txt_center"><input class="filter-table" id="management-<?php echo $debtor->id; ?>-filter-comments" type="text" name="comments" /></th>            
            <th class="txt_center"><input class="filter-table" id="management-<?php echo $debtor->id; ?>-filter-actions" type="text" name="actions" readonly /></th>            
            <th class="hide"><input id="management-<?php echo $debtor->id; ?>-filter-page" name="page" type="hidden" class="filter-table" value="1"></th>
            <th class="hide"><input id="management-<?php echo $debtor->id; ?>-filter-idDebtor" name="idDebtor" type="hidden" class="filter-table" value="<?php echo $debtor->id; ?>"></th>
        </tr>
    </thead>
    <tbody id="tbody-management-<?php echo $debtor->id; ?>">
        <?php
        foreach ($managements as $management) {
            $this->renderPartial('/wallet/partials/item-support-task', array('model' => $management));
        }
        ?>                                  
    </tbody>
</table>
<div class="clear"></div>  
<div id="pagination-management-<?php echo $debtor->id; ?>" class="bg-pagination">
    <?php $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pagesManagement,'currentPage' => (isset($currentManagementPage))? $currentManagementPage : 0, 'id' => 'management-'.$debtor->id)); ?>    
</div>
