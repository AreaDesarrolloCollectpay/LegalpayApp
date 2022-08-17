<?php

/**
 * GiixCrudCode class file.
 *
 * @author Rodrigo Coelho <rodrigo@giix.org>
 * @link http://giix.org/
 * @copyright Copyright &copy; 2010-2011 Rodrigo Coelho
 * @license http://giix.org/license/ New BSD License
 */
Yii::import('system.gii.generators.crud.CrudCode');
Yii::import('ext.giix-core.helpers.*');

/**
 * GiixCrudCode is the model for giix crud generator.
 *
 * @author Rodrigo Coelho <rodrigo@giix.org>
 */
class GiixCrudCode extends CrudCode {

    /**
     * @var string The type of authentication.
     */
    public $authtype = 'auth_none';

    /**
     * @var int Specifies if ajax validation is enabled. 0 represents false, 1 represents true.
     */
    public $enable_ajax_validation = 0;

    /**
     * @var string The controller base class name.
     */
    public $baseControllerClass = 'GxController';

    /**
     * Adds the new model attributes (class properties) to the rules.
     * #MethodTracker
     * This method overrides {@link CrudCode::rules}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Adds the rules for the new attributes in the code generation form: authtype; enable_ajax_validation.</li>
     * </ul>
     */
    public function rules() {
        return array_merge(parent::rules(), array(
            array('authtype, enable_ajax_validation', 'required'),
        ));
    }

    /**
     * Sets the labels for the new model attributes (class properties).
     * #MethodTracker
     * This method overrides {@link CrudCode::attributeLabels}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Adds the labels for the new attributes in the code generation form: authtype; enable_ajax_validation.</li>
     * </ul>
     */
    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'authtype' => 'Authentication type',
            'enable_ajax_validation' => 'Enable ajax validation',
        ));
    }

    public function getControllerFile() {
        $id = $this->getControllerID();
        if (($pos = strrpos($id, '/')) !== false) {
            $id[$pos + 1] = strtoupper($id[$pos + 1]);
        } else {
            $id[0] = strtoupper($id[0]);
        }
        if($this->template == 'restful'){
            return YiiBase::getPathOfAlias("webroot") . '/protected/controllers/api/' . $id . 'Controller.php';
        }else{
            return YiiBase::getPathOfAlias("webroot") . '/protected/controllers/back/' . $id . 'Controller.php';
        }
    }

    public function getViewPath() {
        return YiiBase::getPathOfAlias("webroot") . '/themes/admin/views/' . $this->getControllerID();
    }

    public function parseComment($comment) {
        return array_map(function($value) {
            $key = explode(":", $value);
            if (isset($key[0], $key[1])) {
                return array($key[0] => $key[1]);
            } else {
                return null;
            }
        }, explode("|", $comment));
    }

    /**
     * Generates and returns the view source code line
     * to create the appropriate active input field based on
     * the model attribute field type on the database.
     * #MethodTracker
     * This method is based on {@link CrudCode::generateActiveField}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>All styling is removed.</li>
     * </ul>
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The source code line for the active field.
     */
    public function generateActiveField($modelClass, $column, $fieldSearch = false) {
        if ($column->isForeignKey) {
            $relation = $this->findRelation($modelClass, $column);
            $relatedModelClass = $relation[3];
            return "echo \$form->dropDownList(\$model, '{$column->name}', GxHtml::listDataEx({$relatedModelClass}::model()->findAllAttributes(null, true)))";
        }

        $dataParse = $this->parseComment($column->comment);
        $data = array_column($dataParse, 'type');
        if ((isset($data[0]) && $fieldSearch == false) || (isset($data[0]) && $fieldSearch == true && in_array($data[0], array('email', 'date', 'datetime', 'time', 'color')))) {
            switch ($data[0]) {
                case 'image':
                    return "\$this->widget('ext.elFinder.ServerFileInput', array(
                                        'model' => \$model,
                                        'attribute' => '{$column->name}',
                                        'popupConnectorRoute' => 'elfinder/elfinderFileInput',
                                        'popupTitle' => \$model->getAttributeLabel('{$column->name}'),
                                        'htmlOptions' => array(
                                            'class' => 'row',
                                            ),
                                        )
                                    )";
                case 'file':
                    return "\$this->widget('ext.elFinder.ServerFileInput', array(
                                        'model' => \$model,
                                        'attribute' => '{$column->name}',
                                        'popupConnectorRoute' => 'elfinder/elfinderFileInput',
                                        'popupTitle' => \$model->getAttributeLabel('{$column->name}'),
                                        'file'=>true,
                                        'htmlOptions' => array(
                                            'class' => 'row',
                                            ),
                                        )
                                    )";
                case 'wysiwyg':
                    return "\$this->widget('ext.tinymce.TinyMce', array(
                                'model' => \$model,
                                'attribute' => '{$column->name}',
                                // Optional config
                                'compressorRoute' => 'elfinder/compressor',
                                'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
                                'fileManager' => array(
                                    'class' => 'ext.elFinder.TinyMceElFinder',
                                    'popupConnectorRoute'=>'elfinder/elfinderTinyMce',
                                    'popupTitle' => \$model->getAttributeLabel('{$column->name}'),
                                ),
                                'htmlOptions' => array(
                                    'rows' => 6,
                                    'cols' => 50,
                                    'style'=> 'width:100%; height:350px;',
                                ),
                            ))";
                case 'email':
                    if ($column->type !== 'string' || $column->size === null) {
                        return "echo \$form->emailField(\$model, '{$column->name}', array('class'=>'form-control input-block-level'))";
                    } else {
                        return "echo \$form->emailField(\$model, '{$column->name}', array('maxlength' => {$column->size}, 'class'=>'form-control input-block-level'))";
                    }
                case 'textlarge':
                case 'url':
                    if ($column->type !== 'string' || $column->size === null) {
                        return "echo \$form->textArea(\$model, '{$column->name}', array('class'=>'form-control input-block-level'))";
                    } else {
                        return "echo \$form->textArea(\$model, '{$column->name}', array('maxlength' => {$column->size}, 'class'=>'form-control input-block-level'))";
                    }
                case 'switch':
                    return "\$this->widget('booster.widgets.TbSwitch', array(
                                'model' => \$model,
                                'attribute' => '{$column->name}',
                                'options' => array(
                                    'onText'=>Yii::t('app', 'Si'),
                                    'offText'=>Yii::t('app', 'No'),
                                    'size' => 'normal', //null, 'mini', 'small', 'normal', 'large
                                    'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                    'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
                                ),
                            ))";
                case 'date':
                    return "\$form->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => \$model,
                                'attribute' => '{$column->name}',
                                'value' => \$model->{$column->name},
                                'language'=> Yii::app()->language,
                                'htmlOptions' => array('class'=>'form-control input-block-level'),
                                'options' => array(
                                        'showButtonPanel' => true,
                                        'changeYear' => true,
                                        'dateFormat' => 'yy-mm-dd',
                                        ),
                                ))";
                    break;
                case 'datetime':
                    return "\$this->widget('ext.timepicker.EJuiDateTimePicker', array(
                            'model' => \$model,
                            'attribute' => '{$column->name}',
                            'mode'=>'datetime',
                            'language'=> Yii::app()->language,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'timeFormat' => 'HH:mm:ss',
                                'showButtonPanel' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array('class'=>'form-control input-block-level'),
                            ))";
                case 'time':
                    return "\$this->widget('ext.timepicker.EJuiDateTimePicker', array(
                            'model' => \$model,
                            'attribute' => '{$column->name}',
                            'mode'=>'time',
                            'language'=> Yii::app()->language,
                            'options' => array(
                                'timeFormat' => 'HH:mm:ss',
                                'showButtonPanel' => true,
                            ),
                            'htmlOptions' => array('class'=>'form-control input-block-level'),
                            ))";
                case 'color':
                    return "\$this->widget('booster.widgets.TbColorPicker', array( 
                              'model' => \$model,
                              'attribute' => '{$column->name}',  
                            ));";
                case 'password':
                    if ($column->type !== 'string' || $column->size === null) {
                        return "echo \$form->passwordField(\$model, '{$column->name}', array('class'=>'form-control input-block-level'))";
                    } else {
                        return "echo \$form->passwordField(\$model, '{$column->name}', array('maxlength' => {$column->size}, 'class'=>'form-control input-block-level'))";
                    }
                default :
                    if ($column->type !== 'string' || $column->size === null) {
                        return "echo \$form->textField(\$model, '{$column->name}', array('class'=>'form-control input-block-level'))";
                    } else {
                        return "echo \$form->textField(\$model, '{$column->name}', array('maxlength' => {$column->size}, 'class'=>'form-control input-block-level'))";
                    }
            }
        } elseif (isset($data[0])) {
            if (in_array($data[0], array('url', 'wysiwyg'))) {
                return "echo \$form->textField(\$model, '{$column->name}', array('class'=>'form-control input-block-level'))";
            } else {
                return "echo \$form->textArea(\$model, '{$column->name}', array('class'=>'form-control input-block-level'))";
            }
        } else {
            return "echo \$form->textField(\$model, '{$column->name}', array('class'=>'form-control input-block-level'))";
        }
    }

    /**
     * Generates and returns the view source code line
     * to create the appropriate active input field based on
     * the model relation.
     * @param string $modelClass The model class name.
     * @param array $relation The relation details in the same format
     * used by {@link getRelations}.
     * @return string The source code line for the relation field.
     * @throws InvalidArgumentException If the relation type is not HAS_ONE, HAS_MANY or MANY_MANY.
     */
    public function generateActiveRelationField($modelClass, $relation) {
        $relationName = $relation[0];
        $relationType = $relation[1];
        $relationField = $relation[2]; // The FK.
        $relationModel = $relation[3];
        // The relation type must be HAS_ONE, HAS_MANY or MANY_MANY.
        // Other types (BELONGS_TO) should be generated by generateActiveField.
        if ($relationType != GxActiveRecord::HAS_ONE && $relationType != GxActiveRecord::HAS_MANY && $relationType != GxActiveRecord::MANY_MANY)
            throw new InvalidArgumentException(Yii::t('giix', 'The argument "relationName" must have a relation type of HAS_ONE, HAS_MANY or MANY_MANY.'));

        // Generate the field according to the relation type.
        switch ($relationType) {
            case GxActiveRecord::HAS_ONE:
                return "echo \$form->dropDownList(\$model, '{$relationName}', GxHtml::listDataEx({$relationModel}::model()->findAllAttributes(null, true)))";
                break;
            case GxActiveRecord::HAS_MANY:
            case GxActiveRecord::MANY_MANY:
                return "echo \$form->checkBoxList(\$model, '{$relationName}', GxHtml::encodeEx(GxHtml::listDataEx({$relationModel}::model()->findAllAttributes(null, true)), false, true))";
                break;
        }
    }

    public function generateInputField($modelClass, $column) {
        return 'echo ' . parent::generateInputField($modelClass, $column);
    }

    /**
     * Generates and returns the view source code line
     * to create the appropriate attribute configuration for a CDetailView.
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The source code line for the attribute.
     */
    public function generateDetailViewAttribute($modelClass, $column) {
        if (!$column->isForeignKey) {
            /* if (strtoupper($column->dbType) == 'TINYINT(1)'
              || strtoupper($column->dbType) == 'BIT'
              || strtoupper($column->dbType) == 'BOOL'
              || strtoupper($column->dbType) == 'BOOLEAN') {
              return "'{$column->name}:boolean'";
              } else */
            return $this->getViewAttribute($column);
        } else {
            // Find the relation name for this column.
            $relation = $this->findRelation($modelClass, $column);
            $relationName = $relation[0];
            $relatedModelClass = $relation[3];
            $relatedControllerName = strtolower($relatedModelClass[0]) . substr($relatedModelClass, 1);

            return "array(
			'name' => '{$relationName}',
			'type' => 'raw',
			'value' => \$model->{$relationName} !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx(\$model->{$relationName})), array('{$relatedControllerName}/view', 'id' => GxActiveRecord::extractPkValue(\$model->{$relationName}, true))) : null,
			)";
        }
    }

    /**
     * 
     * @param type $column
     * @return type
     */
    protected function getViewAttribute($column) {
        if (strtoupper($column->dbType) == 'TINYINT(1)' || strtoupper($column->dbType) == 'BIT' || strtoupper($column->dbType) == 'BOOL' || strtoupper($column->dbType) == 'BOOLEAN') {
            return "array(
                    'name' => '{$column->name}',
                    'value' => (\$model->{$column->name} == 0) ? Yii::t('app', 'No') : Yii::t('app', 'Si'),
                )";
        } elseif (strpos(strtoupper($column->name), 'LINK') !== false) {
            return "array(
                    'name' => '{$column->name}', 
                    'type'=>'raw', 
                    'value'=> \$model->{$column->name} !== null ? GxHtml::link(\$model->{$column->name}, \$model->{$column->name}) : null
                )";
        } elseif (strpos(strtoupper($column->name), 'IMAGE') !== false) {
            return "array(
                    'name' => '{$column->name}', 
                    'type'=>'raw', 
                    'value'=> \$model->{$column->name} !== null ? GxHtml::image(\$model->{$column->name}, \"cms\", array('class'=>'thumb-detalle thumbnail')) : null
                )";
        } elseif (strtoupper($column->dbType) == 'TEXT') {
            return "array(
                    'name' => '{$column->name}', 
                    'type'=>'raw', 
                    'value'=> \$model->{$column->name} !== null ? \$model->{$column->name} : null
                )";
        } else {
            return "'{$column->name}'";
        }
    }

    /**
     * Generates and returns the view source code line
     * to create the CGridView column definition.
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The source code line for the column definition.
     */
    public function generateGridViewColumn($modelClass, $column) {
        if (!$column->isForeignKey) {
            // Boolean or bit.
            if (strtoupper($column->dbType) == 'TINYINT(1)' || strtoupper($column->dbType) == 'BIT' || strtoupper($column->dbType) == 'BOOL' || strtoupper($column->dbType) == 'BOOLEAN') {
                return "array(
					'name' => '{$column->name}',
					'value' => '(\$data->{$column->name} == 0) ? Yii::t(\\'app\\', \\'No\\') : Yii::t(\\'app\\', \\'Si\\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')),
					)";
            } else // Common column.
                return $this->getGridViewColumn($column);
        } else { // FK.
            // Find the related model for this column.
            $relation = $this->findRelation($modelClass, $column);
            $relationName = $relation[0];
            $relatedModelClass = $relation[3];
            return "array(
				'name'=>'{$column->name}',
				'value'=>'GxHtml::valueEx(\$data->{$relationName})',
                                'filter'=>GxHtml::listDataEx({$relatedModelClass}::model()->findAllAttributes(null, true)),
				)";
        }
    }

    /**
     * 
     * @param type $column
     * @return type
     */
    protected function getGridViewColumn($column) {
        $dataParse = $this->parseComment($column->comment);
        $data = array_column($dataParse, 'type');
        if (isset($data[0])) {
            switch ($data[0]) {
                case 'image':
                    return "array(
                        'name' => '{$column->name}', 
                        'type'=>'raw', 
                        'value'=> '\$data->{$column->name} !== null ? GxHtml::image(\$data->{$column->name}, \"cms\", array(\\'class\\'=>\\'img-responsive img-thumbnail col-xs-12\\')) : null'
                    )";
                case 'textlarge':
                case 'wysiwyg':
                    return "array(
                        'name' => '{$column->name}', 
                        'type'=>'raw', 
                        'value'=> '\$data->{$column->name} !== null ? \$data->{$column->name} : null'
                    )";
                case 'file':   
                case 'url':
                    return "array(
                        'name' => '{$column->name}', 
                        'type'=>'raw', 
                        'value'=> '\$data->{$column->name} !== null ? GxHtml::link(\$data->{$column->name}, \$data->{$column->name}) : null'
                    )";
                case 'switch':
                    return "array(
                        'name' => '{$column->name}',
                        'value' => '(\$data->{$column->name} == 0) ? Yii::t(\\'app\\', \\'No\\') : Yii::t(\\'app\\', \\'Si\\')',
                    )";
                case 'email':
                case 'date':
                case 'datetime':
                case 'time':
                case 'color':
                case 'password':
                default :
                    return "'{$column->name}'";
            }
        }else{
            return "'{$column->name}'";
        }
    }

    /**
     * Generates and returns the view source code line
     * to create the advanced search.
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The source code line for the column definition.
     */
    public function generateSearchField($modelClass, $column) {
        if (!$column->isForeignKey) {
            // Boolean or bit.
            if (strtoupper($column->dbType) == 'TINYINT(1)' || strtoupper($column->dbType) == 'BIT' || strtoupper($column->dbType) == 'BOOL' || strtoupper($column->dbType) == 'BOOLEAN')
                return "echo \$form->dropDownList(\$model, '{$column->name}', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Si')), array('prompt' => Yii::t('app', 'Todos')))";
            else // Common column. generateActiveField method will add 'echo' when necessary.
                return $this->generateActiveField($this->modelClass, $column, true);
        } else { // FK.
            // Find the related model for this column.
            $relation = $this->findRelation($modelClass, $column);
            $relatedModelClass = $relation[3];
            return "echo \$form->dropDownList(\$model, '{$column->name}', GxHtml::listDataEx({$relatedModelClass}::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'Todos')))";
        }
    }

    /**
     * Generates and returns the array (as a PHP source code string)
     * to collect the MANY_MANY related data from the POST.
     * @param string $modelClass The model class name.
     * @return string The source code to collect the MANY_MANY related
     * data from the POST.
     */
    public function generateGetPostRelatedData($modelClass, $indent = 1) {
        $result = array();
        $relations = $this->getRelations($modelClass);
        foreach ($relations as $relationData) {
            $relationName = $relationData[0];
            $relationType = $relationData[1];
            if ($relationType == GxActiveRecord::MANY_MANY)
                $result[$relationData[0]] = "php:\$_POST['{$modelClass}']['{$relationName}'] === '' ? null : \$_POST['{$modelClass}']['{$relationName}']";
        }
        return GxCoreHelper::ArrayToPhpSource($result, $indent);
    }

    /**
     * Checks whether this AR has a MANY_MANY relation.
     * @param string $modelClass The model class name.
     * @return boolean Whether this AR has a MANY_MANY relation.
     */
    public function hasManyManyRelation($modelClass) {
        $relations = $this->getRelations($modelClass);
        foreach ($relations as $relationData) {
            if ($relationData[1] == GxActiveRecord::MANY_MANY) {
                return true;
            }
        }
        return false;
    }

    /**
     * Finds the relation of the specified column.
     * Note: There's a similar method in the class GxActiveRecord.
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return array The relation. The array will have 3 values:
     * 0: the relation name,
     * 1: the relation type (will always be GxActiveRecord::BELONGS_TO),
     * 2: the foreign key (will always be the specified column),
     * 3: the related active record class name.
     * Or null if no matching relation was found.
     */
    public function findRelation($modelClass, $column) {
        if (!$column->isForeignKey)
            return null;
        $relations = GxActiveRecord::model($modelClass)->relations();
        // Find the relation for this attribute.
        foreach ($relations as $relationName => $relation) {
            // For attributes on this model, relation must be BELONGS_TO.
            if ($relation[0] == GxActiveRecord::BELONGS_TO && $relation[2] == $column->name) {
                return array(
                    $relationName, // the relation name
                    $relation[0], // the relation type
                    $relation[2], // the foreign key
                    $relation[1] // the related active record class name
                );
            }
        }
        // None found.
        return null;
    }

    /**
     * Returns all the relations of the specified model.
     * @param string $modelClass The model class name.
     * @return array The relations. Each array item is
     * a relation as an array, having 3 items:
     * 0: the relation name,
     * 1: the relation type,
     * 2: the foreign key,
     * 3: the related active record class name.
     * Or an empty array if no relations were found.
     */
    public function getRelations($modelClass) {
        $relations = GxActiveRecord::model($modelClass)->relations();
        $result = array();
        foreach ($relations as $relationName => $relation) {
            $result[] = array(
                $relationName, // the relation name
                $relation[0], // the relation type
                $relation[2], // the foreign key
                $relation[1] // the related active record class name
            );
        }
        return $result;
    }

    /**
     * Returns the message to be displayed when the newly generated code is saved successfully.
     * #MethodTracker
     * This method overrides {@link CrudCode::successMessage}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Custom giix success message.</li>
     * </ul>
     * @return string The message to be displayed when the newly generated code is saved successfully.
     */
    public function successMessage() {
        return <<<EOM
<p><strong>Generado con éxito!</strong></p>
EOM;
    }

}
