<?php

/**
 * This is the model base class for the table "view_location".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ViewLocation".
 *
 * Columns in table "view_location" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $idCountry
 * @property integer $idDepartment
 * @property integer $idCity
 * @property string $location
 *
 */
abstract class BaseViewLocation extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'view_location';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ViewLocation|ViewLocations', $n);
	}

	public static function representingColumn() {
		return 'location';
	}

	public function rules() {
		return array(
			array('idCountry, idDepartment, idCity', 'numerical', 'integerOnly'=>true),
			array('location', 'safe'),
			array('idCountry, idDepartment, idCity, location', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idCountry, idDepartment, idCity, location', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idCountry' => Yii::t('app', 'Id Country'),
			'idDepartment' => Yii::t('app', 'Id Department'),
			'idCity' => Yii::t('app', 'Id City'),
			'location' => Yii::t('app', 'Location'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idCountry', $this->idCountry);
		$criteria->compare('idDepartment', $this->idDepartment);
		$criteria->compare('idCity', $this->idCity);
		$criteria->compare('location', $this->location, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}