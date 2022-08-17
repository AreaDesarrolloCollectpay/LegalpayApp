<?php
foreach ($model as $value) { 
    $this->renderPartial('/assignments/partials/item-assignments', array('model' => $value));
} 
