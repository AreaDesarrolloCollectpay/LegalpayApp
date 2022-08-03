<?php // $this->renderPartial('/layouts/partials/side-nav', array('task' => false)); ?>
<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <!-- filter 123 -->            
            <?php $this->renderPartial('/wallet/partials/filter-debtors', array('active' => 1, 'url' => 'wallet/legal/0/0','urlExport' => $urlExport, 'debtorState' => $debtorState,'id' => $id, 'quadrant' => $quadrant,  'coordinators' => $coordinators, 'legal' => true, 'mlModels' => $mlModels, 'typeProcess' => $typeProcess, 'currentPage' => $currentPage)); ?>            
            <!-- END filter -->
        </section>
        <section class="row">
            <section class="padding animated fadeInUp">
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/wallet.legal.min.js', CClientScript::POS_END);
if(Yii::app()->user->getState('rol') != 17){
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/sortable.legal.min.js', CClientScript::POS_END);
}

$js = '';

if(isset($_GET['customer']) && $_GET['customer'] != ''){
    $js .= '$("#form-filter-customer").val("'.$_GET['customer'].'");';
}

if(isset($_GET['name']) && $_GET['name'] != ''){
    $js .= '$("#form-filter-name").val("'.$_GET['name'].'");';
}

if(isset($_GET['code']) && $_GET['code'] != ''){
    $js .= '$("#form-filter-code").val("'.$_GET['code'].'");';
}

if(isset($_GET['investigation']) && $_GET['investigation'] != ''){
    $js .= '$("#form-filter-investigation").val("'.$_GET['investigation'].'");';
}

if(isset($_GET['city']) && $_GET['city'] != ''){
    $js .= '$("#form-filter-city").val("'.$_GET['city'].'");';
}

if(isset($_GET['idState']) && $_GET['idState'] != ''){
    $js .= '$("#form-filter-idState").val("'.$_GET['idState'].'").trigger("change");';
}

if(isset($_GET['idCoordinator']) && $_GET['idCoordinator'] != ''){
    $js .= '$("#form-filter-idCoordinator").val("'.$_GET['idCoordinator'].'").trigger("change");';
}

if(isset($_GET['settledNumber']) && $_GET['settledNumber'] != ''){
    $js .= '$("#form-filter-settledNumber").val("'.$_GET['settledNumber'].'");';
}

if(isset($_GET['idTypeProcess']) && $_GET['idTypeProcess'] != ''){
    $js .= '$("#form-filter-idTypeProcess").val("'.$_GET['idTypeProcess'].'").trigger("change");';
}

if(isset($_GET['office_legal_location']) && $_GET['office_legal_location'] != ''){
    $js .= '$("#form-filter-office_legal_location").val("'.$_GET['office_legal_location'].'");';
}

if(isset($_GET['terms']) && $_GET['terms'] != ''){
    $js .= '$("#form-filter-terms").val("'.$_GET['terms'].'").trigger("change");';
}

$filter = (isset($_GET['filter']))? false : true;  
if($js != '' && $filter){
    $js .= "
        setTimeout(function(){
            $('.btn-filter-advance').trigger('click');
        },300);";
}

Yii::app()->clientScript->registerScript("debtor_list_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);
?>
