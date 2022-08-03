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
	$.fn.yiiGridView.update('cms-usuario-grid', {
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
        'id' => 'cms-usuario-grid',
        'type'=>'striped bordered condensed hover',
        'responsiveTable'=>true,
        //descomentar para ordenar contenido, especifique el campo del orden data-field
        //'htmlOptions'=>array('class'=>'grid-view sort-table-update', 'data-field'=> 'orden', 'data-table'=> get_class($model)),
        //'rowCssClassExpression'=>'"items[]_{$data->idcmsusuario}"',
        'afterAjaxUpdate' => 'function(id, data){reloadGrid(id);}',
        'filter' => $model,
        'dataProvider' => $model->search(),
        'columns' => array(
			'usuario',
			'nombres',
			'apellidos',
			'email',
                        array(
				'name'=>'cms_rol_id',
				'value'=>'GxHtml::valueEx($data->cmsRol)',
                                'filter'=>GxHtml::listDataEx(CmsRol::model()->findAllAttributes(null, true)),
				),
			array(
					'name' => 'activo',
					'value' => '($data->activo == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Si\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')),
					),
			/*
			'empresa',
			'telefono',
			array(
                        'name' => 'descripcion', 
                        'type'=>'raw', 
                        'value'=> '$data->descripcion !== null ? $data->descripcion : null'
                    ),
			'ciudad',
			array(
				'name'=>'cms_rol_id',
				'value'=>'GxHtml::valueEx($data->cmsRol)',
                                'filter'=>GxHtml::listDataEx(CmsRol::model()->findAllAttributes(null, true)),
				),
			'token_chage',
			array(
					'name' => 'activo',
					'value' => '($data->activo == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Si\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')),
					),
			*/
		array(
			'class' => 'booster.widgets.TbButtonColumn',
                        'template' => '{update} {delete}'
		),
	),
)); ?>