<?php
foreach ($model as $value) {
    $this->renderPartial('/users/partials/item-advisers', array('model' => $value));
}
