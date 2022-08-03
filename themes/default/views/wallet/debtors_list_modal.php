<table class="bordered highlight responsive-table">
    <thead>
        <tr class="backgroung-table-2">
            <th class="txt_center"><?php echo Yii::t('front', 'CLIENTE'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'DEUDOR'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'CC / NIT'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'CIUDAD'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'CAPITAL'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'INTERESES'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'RECAUDADO'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'ESTIMADO'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'SALDO'); ?></th>
            <th class="txt_center"><?php echo Yii::t('front', 'ESTADO'); ?></th>
        </tr>
<!--        <tr class="filters formweb">
    <input type="hidden" class="searchWallet" name="id" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : '0'; ?>" >
    <input type="hidden" class="searchWallet" name="quadrant" value="<?php echo (isset($_GET['quadrant'])) ? $_GET['quadrant'] : '0'; ?>" >
    <td>
        <input type="text" class="searchWallet"  name="customer" id="Campaigns" maxlength="100" value="<?php echo (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : ''; ?>">
    </td>
    <td>
        <input type="text" class="searchWallet"  name="name" id="nameDebtor" maxlength="100" value="<?php echo (isset($_GET['name']) && $_GET['name'] != '') ? $_GET['name'] : ''; ?>">
    </td>
    <td>
        <input type="text" class="searchWallet" name="code" id="identification" maxlength="100" value="<?php echo (isset($_GET['code']) && $_GET['code'] != '') ? $_GET['code'] : ''; ?>">
    </td>
    <td>
        <input type="text" class="searchWallet" name="city" id="ciudad" maxlength="100" value="<?php echo (isset($_GET['city']) && $_GET['city'] != '') ? $_GET['city'] : ''; ?>">
    </td>
    <td>
        <input type="number" class="searchWallet" name="capital" id="capitalValue" maxlength="100" value="<?php echo (isset($_GET['capital']) && $_GET['capital'] != '') ? $_GET['capital'] : ''; ?>">
    </td>
    <td>
        <input type="number" class="searchWallet" name="interest" id="interest" maxlength="100" value="<?php echo (isset($_GET['interest']) && $_GET['interest'] != '') ? $_GET['interest'] : ''; ?>">
    </td>
    <td>
        <input type="number" class="searchWallet" name="payments" id="valuePayments" maxlength="100" value="<?php echo (isset($_GET['payments']) && $_GET['payments'] != '') ? $_GET['payments'] : ''; ?>">
    </td>
    <td>
        <input type="number" class="searchWallet" name="agreement" id="feeValue" maxlength="100" value="<?php echo (isset($_GET['agreement']) && $_GET['agreement'] != '') ? $_GET['agreement'] : ''; ?>">
    </td>
    <td>
        <input type="number" class="searchWallet" name="balance" id="valueAssignment" maxlength="100" value="<?php echo (isset($_GET['balance']) && $_GET['balance'] != '') ? $_GET['balance'] : ''; ?>">
    </td>
    <td>
        <select id="" name="idState" class="cd-select filterType searchWallet">
            <option value="" selected><?php echo Yii::t('front', 'Seleccionar'); ?></option>
            <?php foreach ($debtorState as $value) { ?>
                <option <?php echo (isset($_GET['idState']) && $_GET['idState'] == $value->id ) ? 'selected' : ''; ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
            <?php } ?>
        </select>
    </td>
</tr>-->
</thead>
<tbody id="listDebtors"> 
    <?php foreach ($model as $value) { ?>
        <tr>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->customer; ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->name; ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->code; ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->city; ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format($value->capital, 0, ',', '.'); ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format($value->interest, 0, ',', '.'); ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format($value->payments, 0, ',', '.'); ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format($value->agreement, 0, ',', '.'); ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center">$<?php echo number_format($value->balance, 0, ',', '.'); ?></td>
            <td onClick="document.location.href = '<?php echo Yii::app()->baseUrl; ?>/wallet/debtor/<?php echo $value->idDebtor; ?>';" class="txt_center"><?php echo $value->state; ?></td>                          
        </tr>
    <?php } ?>
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
            'class' => 'pagination txt_center')
            )
    );
    ?>
</div>