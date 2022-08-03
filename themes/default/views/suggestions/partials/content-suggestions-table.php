<?php
foreach ($model as $value) {
    $this->renderPartial('/suggestions/partials/item-suggestions', array('model' => $value));
}
