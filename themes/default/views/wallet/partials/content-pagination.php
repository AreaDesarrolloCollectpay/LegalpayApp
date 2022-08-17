<?php
$this->widget('CLinkPager', array(
                'pages' => $pages,
                'currentPage' => (isset($currentPage))? $currentPage : 0,
                'header' => '',
                'firstPageCssClass' => 'pagination_ajax',
                'selectedPageCssClass' => 'active pagination_ajax',
                'previousPageCssClass' => 'prev pagination_ajax',
                'nextPageCssClass' => 'next pagination_ajax',
                'hiddenPageCssClass' => 'disbled',
                'internalPageCssClass' => 'pages pagination_ajax',
                'lastPageCssClass' => 'pagination_ajax',
                'htmlOptions' => array(
                    'class' => 'pagination txt_center'),
                    'id' => $id,
                    )
            );