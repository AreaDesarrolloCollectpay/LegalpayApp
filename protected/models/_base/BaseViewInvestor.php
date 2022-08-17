<?php

/**
 * This is the model base class for the table "view_investor".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ViewInvestor".
 *
 * Columns in table "view_investor" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $name
 * @property string $numberDocument
 * @property string $contact
 * @property integer $capital
 * @property integer $interest
 * @property integer $fee
 * @property integer $payments
 * @property integer $balance
 * @property integer $estimated
 * @property integer $pending
 * @property integer $active
 *
 */
abstract class BaseViewInvestor extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'view_investor';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ViewInvestor|ViewInvestors', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('id, capital, interest, fee, payments, balance, estimated, pending, active', 'numerical', 'integerOnly'=>true),
			array('name, numberDocument, contact', 'safe'),
			array('id, name, numberDocument, contact, capital, interest, fee, payments, balance, estimated, pending, active', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, numberDocument, contact, capital, interest, fee, payments, balance, estimated, pending, active', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'numberDocument' => Yii::t('app', 'Number Document'),
			'contact' => Yii::t('app', 'Contact'),
			'capital' => Yii::t('app', 'Capital'),
			'interest' => Yii::t('app', 'Interest'),
			'fee' => Yii::t('app', 'Fee'),
			'payments' => Yii::t('app', 'Payments'),
			'balance' => Yii::t('app', 'Balance'),
			'estimated' => Yii::t('app', 'Estimated'),
			'pending' => Yii::t('app', 'Pending'),
			'active' => Yii::t('app', 'Active'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('numberDocument', $this->numberDocument, true);
		$criteria->compare('contact', $this->contact, true);
		$criteria->compare('capital', $this->capital);
		$criteria->compare('interest', $this->interest);
		$criteria->compare('fee', $this->fee);
		$criteria->compare('payments', $this->payments);
		$criteria->compare('balance', $this->balance);
		$criteria->compare('estimated', $this->estimated);
		$criteria->compare('pending', $this->pending);
		$criteria->compare('active', $this->active);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}