<?php

/**
 * This is the model base class for the table "tbl_tempo_demographic".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "TempoDemographic".
 *
 * Columns in table "tbl_tempo_demographic" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $number
 * @property string $email
 * @property string $country
 * @property string $department
 * @property string $city
 * @property string $address
 * @property string $neighborhood
 * @property string $phone
 * @property string $mobile
 * @property string $occupation
 * @property string $marital_state
 * @property double $income_legal
 * @property integer $age
 * @property integer $labor_old
 * @property string $gender
 * @property integer $social_stratus
 * @property string $type_contract
 * @property string $education_level
 * @property string $type_housing
 * @property double $contract_term
 * @property integer $dependents
 * @property double $payment_capacity
 * @property integer $migrate
 * @property string $lot
 * @property integer $idCustomer
 * @property string $dateCreated
 *
 */
abstract class BaseTempoDemographic extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_tempo_demographic';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'TempoDemographic|TempoDemographics', $n);
	}

	public static function representingColumn() {
		return 'number';
	}

	public function rules() {
		return array(
			array('number, email, country, department, city, occupation, age, gender, social_stratus, lot, idCustomer, dateCreated', 'required'),
			array('age, labor_old, social_stratus, dependents, migrate, idCustomer', 'numerical', 'integerOnly'=>true),
			array('income_legal, contract_term, payment_capacity', 'numerical'),
			array('number, phone, mobile, occupation, gender', 'length', 'max'=>50),
			array('email, country, department, city, neighborhood, marital_state, type_contract, education_level, type_housing, lot', 'length', 'max'=>255),
			array('neighborhood, phone, mobile, marital_state, income_legal, labor_old, type_contract, education_level, type_housing, contract_term, dependents, payment_capacity, migrate', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, number, email, country, department, city, address,neighborhood, phone, mobile, occupation, marital_state, income_legal, age, labor_old, gender, social_stratus, type_contract, education_level, type_housing, contract_term, dependents, payment_capacity, migrate, lot, idCustomer, dateCreated', 'safe', 'on'=>'search'),
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
			'number' => Yii::t('app', 'Number'),
			'email' => Yii::t('app', 'Email'),
			'country' => Yii::t('app', 'Country'),
			'department' => Yii::t('app', 'Department'),
			'city' => Yii::t('app', 'City'),
                        'address' => Yii::t('app', 'Address'),
			'neighborhood' => Yii::t('app', 'Neighborhood'),
			'phone' => Yii::t('app', 'Phone'),
			'mobile' => Yii::t('app', 'Mobile'),
			'occupation' => Yii::t('app', 'Occupation'),
			'marital_state' => Yii::t('app', 'Marital State'),
			'income_legal' => Yii::t('app', 'Income Legal'),
			'age' => Yii::t('app', 'Age'),
			'labor_old' => Yii::t('app', 'Labor Old'),
			'gender' => Yii::t('app', 'Gender'),
			'social_stratus' => Yii::t('app', 'Social Stratus'),
			'type_contract' => Yii::t('app', 'Type Contract'),
			'education_level' => Yii::t('app', 'Education Level'),
			'type_housing' => Yii::t('app', 'Type Housing'),
			'contract_term' => Yii::t('app', 'Contract Term'),
			'dependents' => Yii::t('app', 'Dependents'),
			'payment_capacity' => Yii::t('app', 'Payment Capacity'),
			'migrate' => Yii::t('app', 'Migrate'),
			'lot' => Yii::t('app', 'Lot'),
			'idCustomer' => Yii::t('app', 'Id Customer'),
			'dateCreated' => Yii::t('app', 'Date Created'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('number', $this->number, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('country', $this->country, true);
		$criteria->compare('department', $this->department, true);
		$criteria->compare('city', $this->city, true);
                $criteria->compare('address', $this->address, true);
		$criteria->compare('neighborhood', $this->neighborhood, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('mobile', $this->mobile, true);
		$criteria->compare('occupation', $this->occupation, true);
		$criteria->compare('marital_state', $this->marital_state, true);
		$criteria->compare('income_legal', $this->income_legal);
		$criteria->compare('age', $this->age);
		$criteria->compare('labor_old', $this->labor_old);
		$criteria->compare('gender', $this->gender, true);
		$criteria->compare('social_stratus', $this->social_stratus);
		$criteria->compare('type_contract', $this->type_contract, true);
		$criteria->compare('education_level', $this->education_level, true);
		$criteria->compare('type_housing', $this->type_housing, true);
		$criteria->compare('contract_term', $this->contract_term);
		$criteria->compare('dependents', $this->dependents);
		$criteria->compare('payment_capacity', $this->payment_capacity);
		$criteria->compare('migrate', $this->migrate);
		$criteria->compare('lot', $this->lot, true);
		$criteria->compare('idCustomer', $this->idCustomer);
		$criteria->compare('dateCreated', $this->dateCreated, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}