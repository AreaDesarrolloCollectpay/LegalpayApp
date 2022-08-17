<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$band = false;
?>
<div class="form">

<?php echo "<?php \$form = \$this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl(\$this->route),
	'method' => 'get',
)); ?>\n"; ?>

<?php foreach($this->tableSchema->columns as $column): ?>
<?php
$field = $this->generateInputField($this->modelClass, $column);
if (strpos($field, 'password') !== false || $column->autoIncrement){continue;}
?>
<?php if(!$band): ?>
        <div class="row">
<?php endif; ?>
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php echo "<?php echo \$form->label(\$model, '{$column->name}'); ?>\n"; ?>
                    <?php echo "<?php " . $this->generateSearchField($this->modelClass, $column)."; ?>\n"; ?>
            </div>
<?php 
    if($band):
        $band = false;
?>
        </div>
<?php
    else:
        $band =true;
    endif; 
?>
<?php endforeach; ?>
<?php if($band): ?>
        </div>
<?php endif; ?>
        <hr/>
        <div class="row buttons text-center">
                <?php echo "<?php echo GxHtml::submitButton(Yii::t('app', 'Buscar'), array('class'=>'btn btn-primary btn-lg')); ?>\n"; ?>
        </div>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
</div><!-- search-form -->