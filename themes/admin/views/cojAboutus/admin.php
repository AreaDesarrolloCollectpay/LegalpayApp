
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
	$.fn.yiiGridView.update('coj-aboutus-grid', {
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
        'id' => 'coj-aboutus-grid',
        'type'=>'striped bordered condensed hover',
        'responsiveTable'=>true,
        //descomentar para ordenar contenido, especifique el campo del orden data-field
        //'htmlOptions'=>array('class'=>'grid-view sort-table-update', 'data-field'=> 'orden', 'data-table'=> get_class($model)),
        //'rowCssClassExpression'=>'"items[]_{$data->id}"',
        //'afterAjaxUpdate' => 'function(id, data){sortTable();reloadGrid(id);}',
        'filter' => $model,
        'dataProvider' => $model->search(),
        'columns' => array(
			    array('name' => 'img_en', 'type'=>'raw', 'value'=> '$data->img_en !== null ? \'<img class="thumb-detalle thumbnail" src="\'.$data->img_en.\'">\' : ""'),
			'des_en',
			array('name' => 'img_es', 'type'=>'raw', 'value'=> '$data->img_es !== null ? \'<img class="thumb-detalle thumbnail" src="\'.$data->img_es.\'">\' : ""'),
			'des_es',
			//'title_en',
			/*
			'title_es',
			'dCreation',
			'dUpdate',
			*/
		array(
			'class' => 'booster.widgets.TbButtonColumn',
                        'template' => '{update} {delete}'
		),
	),
)); ?>