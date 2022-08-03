<?php
foreach ($model as $value) { 
    $this->renderPartial('/assignments/partials/item-assignments-adviser', array('model' => $value));
} 
