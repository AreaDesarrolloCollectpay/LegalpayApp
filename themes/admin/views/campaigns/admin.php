<?php
$this->pageTitle = Yii::t('app', 'Administrar') . ' ' . GxHtml::encode($model->label(2)) ;
$this->menu = array(
        array('label'=>'<i class="fa fa-plus"></i> ' . Yii::t('app', 'Crear') . ' ' . $model->label(), 'url'=>array('create')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('campaigns-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="col-lg-3 col-md-3">
        <?php echo GxHtml::link(Yii::t('app', '<i class="fa fa-plus"></i> Crear') . ' ' . $model->label(), $this->createUrl('create'), array('class' => 'btn btn-success btn-block')); ?>
    </div>
    <div class="col-lg-6 col-md-6">
        
    </div>
    <div class="col-lg-3 col-md-3">
        <?php echo GxHtml::link(Yii::t('app', '<i class="fa fa-search"></i> Búsqueda Avanzada'), '#', array('class' => 'search-button btn btn-info btn-block')); ?>
    </div>
</div>
<hr/>
<div class="search-form" style="display: none">
<p>
<?php echo Yii::t('app', 'Si lo desea, puede entrar en un operador de comparación'); ?> (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; o =) <?php echo Yii::t('app', 'al principio de cada uno de los valores de la búsqueda para especificar la forma en la comparación se debe hacer.'); ?>
</p>
<hr/>
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

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
		array(
			'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {Inactivar Campaña} {Actualizar Clave}',
            'buttons' => array(
		        'Actualizar Clave' => array(
		            'url' => 'Yii::app()->createUrl("campaigns/updatePassword", array("id"=>$data->idCampaign))',
		            'icon'=>'glyphicon glyphicon-refresh',

		        ),
		        'Inactivar Campaña' => array(
		            'url' => 'Yii::app()->createUrl("campaigns/delete", array("id"=>$data->idCampaign))',
		            'icon'=>'glyphicon glyphicon-minus-sign',

		        ),
		    ),
		),
	),
)); ?>