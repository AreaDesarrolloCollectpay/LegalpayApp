<?php

/**
 * This is the model base class for the table "tbl_debtors_agreements".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DebtorsAgreements".
 *
 * Columns in table "tbl_debtors_agreements" available as properties of the model,
 * followed by relations of table "tbl_debtors_agreements" available as properties of the model.
 *
 * @property integer $id
 * @property integer $idUserAgreement
 * @property integer $idDebtorObligation
 * @property integer $idDebtorDebt
 * @property double $capital
 * @property double $valueAgreement
 * @property integer $quotas
 * @property double $discountRate
 * @property double $initialQuota
 * @property string $dateInitialQuota
 * @property string $dateCreated
 *
 * @property DebtorsDebts $idDebtorDebt0
 * @property DebtorsObligations $idDebtorObligation0
 * @property Users $idUserAgreement0
 */
abstract class BaseDebtorsAgreements extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_debtors_agreements';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'DebtorsAgreements|DebtorsAgreements', $n);
	}

	public static function representingColumn() {
		return 'dateInitialQuota';
	}

	public function rules() {
		return array(
			array('valueAgreement, quotas, initialQuota, dateInitialQuota, dateCreated', 'required'),
			array('idUserAgreement, idDebtorObligation, idDebtorDebt, quotas', 'numerical', 'integerOnly'=>true),
			array('capital, valueAgreement, discountRate, initialQuota', 'numerical'),
			array('idUserAgreement, idDebtorObligation, idDebtorDebt, capital, discountRate', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, idUserAgreement, idDebtorObligation, idDebtorDebt, capital, valueAgreement, quotas, discountRate, initialQuota, dateInitialQuota, dateCreated', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idDebtorDebt0' => array(self::BELONGS_TO, 'DebtorsDebts', 'idDebtorDebt'),
			'idDebtorObligation0' => array(self::BELONGS_TO, 'DebtorsObligations', 'idDebtorObligation'),
			'idUserAgreement0' => array(self::BELONGS_TO, 'Users', 'idUserAgreement'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'idUserAgreement' => null,
			'idDebtorObligation' => null,
			'idDebtorDebt' => null,
			'capital' => Yii::t('app', 'Capital'),
			'valueAgreement' => Yii::t('app', 'Value Agreement'),
			'quotas' => Yii::t('app', 'Quotas'),
			'discountRate' => Yii::t('app', 'Discount Rate'),
			'initialQuota' => Yii::t('app', 'Initial Quota'),
			'dateInitialQuota' => Yii::t('app', 'Date Initial Quota'),
			'dateCreated' => Yii::t('app', 'Date Created'),
			'idDebtorDebt0' => null,
			'idDebtorObligation0' => null,
			'idUserAgreement0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('idUserAgreement', $this->idUserAgreement);
		$criteria->compare('idDebtorObligation', $this->idDebtorObligation);
		$criteria->compare('idDebtorDebt', $this->idDebtorDebt);
		$criteria->compare('capital', $this->capital);
		$criteria->compare('valueAgreement', $this->valueAgreement);
		$criteria->compare('quotas', $this->quotas);
		$criteria->compare('discountRate', $this->discountRate);
		$criteria->compare('initialQuota', $this->initialQuota);
		$criteria->compare('dateInitialQuota', $this->dateInitialQuota, true);
		$criteria->compare('dateCreated', $this->dateCreated, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}