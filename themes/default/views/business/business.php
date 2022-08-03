<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter -->            
            <?php $this->renderPartial('/business/partials/filter-business', array('countries' => $countries, 'businessAdvisors' => $businessAdvisors, 'active' => 1,'url' => 'business', 'currentPage' => $currentPage)); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp m_t_10">
                <section class="drag-container">
                    <ul class="drag-list listEtapas" data-simplebar data-simplebar-autohide="false">
                        <?php echo $html; ?>
                    </ul>
                </section>
            </section>
        </section>
    </section>
</section>
<style>
    .connectedSortable {
        overflow-y: scroll;
        max-height: 300px;
    }
</style>
<?php
$this->renderPartial("/business/partials/modal_business", array('countries' => $countries, 'businessStates' => $businessStates, 'businessAdvisors' => $businessAdvisors));
//if(){
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/business.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/sortable.business.min.js', CClientScript::POS_END);
//}
$this->renderPartial("/business/partials/js_filter_business", array('_GET' => $_GET));
