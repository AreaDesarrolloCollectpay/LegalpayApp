<?php

/**
 * This is the model base class for the table "tbl_debtors_obligations_clusters".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DebtorsObligationsClusters".
 *
 * Columns in table "tbl_debtors_obligations_clusters" available as properties of the model,
 * followed by relations of table "tbl_debtors_obligations_clusters" available as properties of the model.
 *
 * @property integer $idCluster
 * @property integer $idDebtorObligation
 * @property string $dateCreated
 *
 * @property Clusters $idCluster0
 * @property DebtorsObligations $idDebtorObligation0
 */
abstract class BaseDebtorsObligationsClusters extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_debtors_obligations_clusters';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'DebtorsObligationsClusters|DebtorsObligationsClusters', $n);
	}

	public static function representingColumn() {
		return 'dateCreated';
	}

	public function rules() {
		return array(
			array('idCluster, idDebtorObligation', 'required'),
			array('idCluster, idDebtorObligation', 'numerical', 'integerOnly'=>true),
			array('idCluster, idDebtorObligation, dateCreated', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idCluster0' => array(self::BELONGS_TO, 'Clusters', 'idCluster'),
			'idDebtorObligation0' => array(self::BELONGS_TO, 'DebtorsObligations', 'idDebtorObligation'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idCluster' => null,
			'idDebtorObligation' => null,
			'dateCreated' => Yii::t('app', 'Date Created'),
			'idCluster0' => null,
			'idDebtorObligation0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idCluster', $this->idCluster);
		$criteria->compare('idDebtorObligation', $this->idDebtorObligation);
		$criteria->compare('dateCreated', $this->dateCreated, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}