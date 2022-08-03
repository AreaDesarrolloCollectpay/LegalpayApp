<?php
foreach ($model as $value) {
    $this->renderPartial('/users/partials/item-invoices', array('model' => $value));
}
