<?php

/**
 * This is the model base class for the table "tbl_users_import".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "UsersImport".
 *
 * Columns in table "tbl_users_import" available as properties of the model,
 * followed by relations of table "tbl_users_import" available as properties of the model.
 *
 * @property integer $id
 * @property integer $idCustomer
 * @property integer $idUserCreated
 * @property integer $idTypeImport
 * @property integer $idAdviser
 * @property string $file
 * @property integer $state
 * @property integer $accounts
 * @property double $capital
 * @property string $dateCreated
 *
 * @property AssignmentsDebtorsAdvisers[] $assignmentsDebtorsAdvisers
 * @property Users $idCustomer0
 * @property Users $idUserCreated0
 */
abstract class BaseUsersImport extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_users_import';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'UsersImport|UsersImports', $n);
	}

	public static function representingColumn() {
		return 'file';
	}

	public function rules() {
		return array(
			array('idCustomer, idTypeImport', 'required'),
                        array('file', 'match', 'pattern' => '/\.(csv)$/i', 'message' => Yii::t('err', 'El {attribute} es inválido, Solo los archivos con estas extensiones son permitidos: csv'), 'allowEmpty' => true),
			array('idCustomer, idUserCreated, idTypeImport, state, accounts', 'numerical', 'integerOnly'=>true),
			array('idAdviser', 'required', 'on' => 'AsAdviser'),                    
			array('capital', 'numerical'), 
			array('idUserCreated, idTypeImport, idAdviser, state, accounts, capital', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, idCustomer, idUserCreated, idTypeImport, idAdviser, file, state, accounts, capital, dateCreated', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
                        'assignmentsDebtorsAdvisers' => array(self::HAS_MANY, 'AssignmentsDebtorsAdvisers', 'idUserImport'),
			'idCustomer0' => array(self::BELONGS_TO, 'Users', 'idCustomer'),
			'idUserCreated0' => array(self::BELONGS_TO, 'Users', 'idUserCreated'),
			'idTypeImport0' => array(self::BELONGS_TO, 'TypeImport', 'idTypeImport'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'idCustomer' => Yii::t('app', 'Cliente'),
			'idUserCreated' => Yii::t('app', 'Creador'),
			'idTypeImport' => Yii::t('app', 'Tipo de Importación'),
                        'idAdviser' => Yii::t('app', 'Asesor'),
			'file' => Yii::t('app', 'Archivo'),
			'state' => Yii::t('app', 'Estado'),
			'accounts' => Yii::t('app', 'Cuentas'),
			'capital' => Yii::t('app', 'Capital'),
			'dateCreated' => Yii::t('app', 'Fecha de Creación'),
                        'assignmentsDebtorsAdvisers' => null,
			'idCustomer0' => null,
			'idUserCreated0' => null,
			'idTypeImport0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('idCustomer', $this->idCustomer);
		$criteria->compare('idUserCreated', $this->idUserCreated);
		$criteria->compare('idTypeImport', $this->idTypeImport);
                $criteria->compare('idAdviser', $this->idAdviser);
		$criteria->compare('file', $this->file, true);
		$criteria->compare('state', $this->state);
		$criteria->compare('accounts', $this->accounts);
		$criteria->compare('capital', $this->capital);
		$criteria->compare('dateCreated', $this->dateCreated, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}
