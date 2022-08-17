<?php
foreach ($model as $value) {
    $this->renderPartial('/users/partials/item-licenses', array('model' => $value));
}
