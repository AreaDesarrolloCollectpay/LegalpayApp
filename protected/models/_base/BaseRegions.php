<?php

/**
 * This is the model base class for the table "tbl_regions".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Regions".
 *
 * Columns in table "tbl_regions" available as properties of the model,
 * followed by relations of table "tbl_regions" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property string $dateCreated
 *
 * @property Departments[] $departments
 */
abstract class BaseRegions extends GxActiveRecord {
    
    public $capital;
    public $cant;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_regions';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Regions|Regions', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, dateCreated', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>500),
			array('active', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, active, dateCreated', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'departments' => array(self::HAS_MANY, 'Departments', 'idRegion'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'active' => Yii::t('app', 'Active'),
			'dateCreated' => Yii::t('app', 'Date Created'),
			'departments' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('dateCreated', $this->dateCreated, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}