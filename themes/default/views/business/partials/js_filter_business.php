<?php 
$js = '';

if(isset($_GET['name']) && $_GET['name'] != ''){
    $js .= '$("#form-filter-name").val('.$_GET['name'].');';
}
if(isset($_GET['numberDocument']) && $_GET['numberDocument'] != ''){
    $js .= '$("#form-filter-code").val('.$_GET['numberDocument'].');';
}
if(isset($_GET['idCountry']) && $_GET['idCountry'] != ''){
    $js .= '$("#form-filter-idCountry").val('.$_GET['idCountry'].').trigger("change");';
}

if(isset($_GET['idDepartment']) && $_GET['idDepartment'] != ''){
    $js .= ' setTimeout(function(){
                $("#form-filter-idDepartment").val('.$_GET['idDepartment'].').trigger("change");
            },500);';
}
if(isset($_GET['idCity']) && $_GET['idCity'] != ''){
    $js .= ' setTimeout(function(){
                $("#form-filter-idCity").val('.$_GET['idCity'].').trigger("change");
            },800);';
}

if(isset($_GET['idBusinessAdvisor']) && $_GET['idBusinessAdvisor'] != ''){
    $js .= '$("#form-filter-idBusinessAdvisor").val('.$_GET['idBusinessAdvisor'].').trigger("change");';
}

if($js != ''){
    $js .= "$('.btn-filter-advance').trigger('click'); console.log('filter');";
}

Yii::app()->clientScript->registerScript("filter_js",'
   $(document).ready(function(){    
    '.$js.'
   });
   
',
 CClientScript::POS_END
);

