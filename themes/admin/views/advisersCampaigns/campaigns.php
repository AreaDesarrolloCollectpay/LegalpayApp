<?php $this->widget('booster.widgets.TbGridView', array(
        'id' => 'campaigns-grid',
        'type'=>'striped bordered condensed hover',
        'responsiveTable'=>true,
        //descomentar para ordenar contenido, especifique el campo del orden data-field
        //'htmlOptions'=>array('class'=>'grid-view sort-table-update', 'data-field'=> 'orden', 'data-table'=> get_class($model)),
        //'rowCssClassExpression'=>'"items[]_{$data->idCampaign}"',
        //'afterAjaxUpdate' => 'function(id, data){sortTable();reloadGrid(id);}',
        'filter' => $model,
        'dataProvider' => $model->search(),
        'columns' => array(
            'name',
            'companyName',
            'idNumber',
            'address',
            'contactName',
            /*
            'contactEmail',
            'comments',
            'fCreacion',
            'dUpdate',
            'passwd',
            array(
                'name'=>'idAdviser',
                'value'=>'GxHtml::valueEx($data->idAdviser0)',
                                'filter'=>GxHtml::listDataEx(Advisers::model()->findAllAttributes(null, true)),
                ),
            array(
                'name'=>'idDistrict',
                'value'=>'GxHtml::valueEx($data->idDistrict0)',
                                'filter'=>GxHtml::listDataEx(Districts::model()->findAllAttributes(null, true)),
                ),
            */
        // array(
        //     'class' => 'booster.widgets.TbButtonColumn',
        //     'template' => '{update} {Inactivar Campaña} {Actualizar Clave}',
        //     'buttons' => array(
        //         'Actualizar Clave' => array(
        //             'url' => 'Yii::app()->createUrl("campaigns/updatePassword", array("id"=>$data->idCampaign))',
        //             'icon'=>'glyphicon glyphicon-refresh',

        //         ),
        //         'Inactivar Campaña' => array(
        //             'url' => 'Yii::app()->createUrl("campaigns/delete", array("id"=>$data->idCampaign))',
        //             'icon'=>'glyphicon glyphicon-minus-sign',

        //         ),
        //     ),
        // ),
    ),
)); ?>