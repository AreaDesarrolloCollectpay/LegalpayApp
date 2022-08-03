<?php
$this->pageTitle = Yii::t('app', 'Administrar') . ' ' . GxHtml::encode($model->label(2)) ;

?>

<?php $this->widget('booster.widgets.TbGridView', array(
        'id' => 'coj-home-grid',
        'type'=>'striped bordered condensed hover',
        'responsiveTable'=>true,
        //descomentar para ordenar contenido, especifique el campo del orden data-field
        //'htmlOptions'=>array('class'=>'grid-view sort-table-update', 'data-field'=> 'orden', 'data-table'=> get_class($model)),
        //'rowCssClassExpression'=>'"items[]_{$data->id}"',
        //'afterAjaxUpdate' => 'function(id, data){sortTable();reloadGrid(id);}',
        'filter' => $model,
        'dataProvider' => $model->search(),
        'columns' => array(
        	array('name' => 'img_es', 'type'=>'raw', 'value'=> '$data->img_es !== null ? \'<img class="thumb-detalle thumbnail" src="\'.$data->img_es.\'">\' : ""'),
			'title_es',
			'des_es',
			array('name' => 'img_en', 'type'=>'raw', 'value'=> '$data->img_en !== null ? \'<img class="thumb-detalle thumbnail" src="\'.$data->img_en.\'">\' : ""'),
			'title_en',
			'des_en',
			/*'dCreation',
			'dUpdate',
			*/
		array(
			'class' => 'booster.widgets.TbButtonColumn',
                        'template' => '{update}'
		),
	),
)); ?>