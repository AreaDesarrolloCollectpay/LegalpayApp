<?php
foreach ($model as $value) {
    $this->renderPartial('/users/partials/item-coordinators', array('model' => $value));
}
