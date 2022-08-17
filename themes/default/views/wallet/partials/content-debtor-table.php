<section class="panelBG  m_b_20 lista_all_deudor content-scroll-x">
    <table class="bordered highlight">
        <thead>
            <tr class="backgroung-table-4">
                <th class="txt_center" width="7%"><?php echo Yii::t('front', (in_array(Yii::app()->user->getState('rol'), Yii::app()->params['customers'])) ? 'ASESOR' : 'EMPRESA'); ?></th>
                <th class="txt_center " width="10%"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
                <th class="txt_center" width="11%"><?php echo Yii::t('front', 'DEUDOR'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'INTERESES'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'GASTOS'); ?></th>
                <th class="txt_center hide-ml" width="8%"><?php echo Yii::t('front', 'MODELO'); ?></th>
                <th class="txt_center hide-ml" width="8%"><?php echo Yii::t('front', 'SEGMENTO'); ?></th>
                <th class="txt_center hide-ml" width="8%"><?php echo Yii::t('front', 'PROBABILIDAD'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'TIPOLOGÍA'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'ESTADO'); ?></th>
                <th class="txt_center" width="8%"><?php echo Yii::t('front', 'ULTIMA GESTIÓN'); ?></th>
            </tr>
            <tr class="filters formweb" data-id="cluster" data-url="wallet/0/0/0">
                <th class="txt_centerr "><input class="filter-table" id="cluster-filter-" type="text" /></th>
                <th class="txt_center"><input class="filter-table" id="cluster-filter-customer" type="text" name="customer" /></th>
                <th class="txt_center"><input class="filter-table" id="cluster-filter-name" type="text" name="name" /></th>
                <th class="txt_center"><input class="filter-table" id="cluster-filter-code" type="text" name="code" /></th>
                <th class="txt_center"><input class="filter-table" id="cluster-filter-city" type="text" name="city" /></th>
                <th class="txt_center"><input class="filter-table" id="cluster-filter-capital" type="text" name="capital" /></th>
                <th class="txt_center"><input class="filter-table" id="cluster-filter-interest" type="text" name="interest" /></th>
                <th class="txt_center"><input class="filter-table" id="cluster-filter-spending" type="text" name="spendings" /></th>
                <th class="txt_center hide-ml" data-id="cluster-filter-">
                    <select id="cluster-filter-idMLModel" name="idMLModel" class="filter-mlModels filter-table" data-closest="th">
                        <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                        <?php foreach ($mlModels as $mModel) { ?>
                            <option value="<?php echo $mModel->id; ?>" <?php echo (isset($_REQUEST['idMLModel']) && $_REQUEST['idMLModel'] == $mModel->id) ? 'selected' : ''; ?>><?php echo $mModel->name; ?></option>
                        <?php } ?>
                    </select>
                </th>
                <th class="txt_center hide-ml">
                    <select id="cluster-filter-idCluster" name="idCluster" class="filter-table">
                        <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                        <?php foreach ($clustersSelect as $clusterSelect) { ?>
                            <option value="<?php echo $clusterSelect->id; ?>"><?php echo $clusterSelect->name; ?></option>
                        <?php } ?>
                    </select>
                </th>
                <th class="txt_center hide-ml"><input name="impago" type="text" class="filter-table" value="" readonly></th>
                <th class="txt_center">
                    <select id="cluster-filter-ageDebt" name="ageDebt" class="filter-table">
                        <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                        <?php foreach ($ageDebts as $ageDebt) { ?>
                            <option value="<?php echo $ageDebt->id; ?>"><?php echo $ageDebt->name; ?></option>
                        <?php } ?>
                    </select>
                </th>
                <th class="txt_center">
                    <select id="cluster-filter-idState" name="idState" class="filter-table">
                        <option value="" selected><?php echo Yii::t('front', ''); ?></option>
                        <?php foreach ($debtorState as $value) { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                    </select>
                </th>
                <th class="txt_center"><input name="date" type="text" class="filter-table calendar_range" value=""></th>
                <th class="hide"><input id="cluster-filter-page" name="page" type="hidden" class="filter-table" value="1"></th>
            </tr>
        </thead>
        <tbody id="tbody-cluster"> 
            <?php
                if(isset($model) && $model != null){
                    $this->renderPartial('/wallet/partials/item-debtor', array('model' => $model, 'modelML' => $modelML, 'clusterML' => $clusterML));                     
                }
            ?>
        </tbody>
    </table>
    <div class="clear"></div>  
    <div id="pagination-cluster" class="bg-pagination">                            
        <?php
            if(isset($pages) && $pages != null){
                $this->renderPartial('/wallet/partials/content-pagination', array('pages' => $pages, 'currentPage' => $currentPage, 'id' => 'cluster')); 
            }
        ?>
    </div>
</section>
