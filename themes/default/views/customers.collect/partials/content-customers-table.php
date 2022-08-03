<?php
foreach ($model as $value) {
    $this->renderPartial('/customers/partials/item-customers', array('model' => $value));
}
