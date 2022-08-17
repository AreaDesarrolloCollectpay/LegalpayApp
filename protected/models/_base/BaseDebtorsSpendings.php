<?php

/**
 * This is the model base class for the table "tbl_debtors_spendings".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DebtorsSpendings".
 *
 * Columns in table "tbl_debtors_spendings" available as properties of the model,
 * followed by relations of table "tbl_debtors_spendings" available as properties of the model.
 *
 * @property integer $id
 * @property integer $idDebtor
 * @property integer $idDebtorDebt
 * @property integer $idUserSpending
 * @property integer $idSpendingType
 * @property integer $idCity
 * @property string $dateSpending
 * @property double $value
 * @property string $comments
 * @property string $support
 * @property string $dateCreated
 *
 * @property Cities $idCity0
 * @property DebtorsObligations $idDebtor0
 * @property DebtorsDebts $idDebtorDebt0
 * @property SpendingTypes $idSpendingType0
 * @property Users $idUserSpending0
 */
abstract class BaseDebtorsSpendings extends GxActiveRecord {
    
    public $idCountry;
    public $idDepartment;
    public $fullDistrict;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_debtors_spendings';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'DebtorsSpendings|DebtorsSpendings', $n);
	}

	public static function representingColumn() {
		return 'dateSpending';
	}

	public function rules() {
		return array(
			//array('idDebtorDebt, idSpendingType, idUserSpending, idCountry, idDepartment, idCity, dateSpending, value', 'required'),
			array('idSpendingType, idUserSpending, idCountry, idDepartment, idCity, dateSpending, value', 'required'),
			array('idDebtor, idDebtorDebt, idUserSpending, idSpendingType, idCountry, idDepartment, idCity', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical', 'integerOnly'=>true, 'min'=>1),
            array('support', 'match', 'pattern'=>'/\.(gif|jpg|jpeg|png|pdf|tiff)$/i','message'=>Yii::t('err','El {attribute} es inválido, Solo los archivos con estas extensiones son permitidos: gif, jpg, jpeg, png, tiff, pdf'), 'allowEmpty'=>true),                        
			array('comments, support', 'safe'),
			array('idDebtor, idDebtorDebt, idUserSpending, idSpendingType, idCountry, idDepartment, idCity, comments, support', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, idDebtor, idDebtorDebt, idUserSpending, idSpendingType, idCity, dateSpending, value, comments, support, dateCreated', 'safe', 'on'=>'search'),
		);
	}
        
        public function afterFind(){
            parent::afterFind();                        
            
            if($this->idCity!= NULL){
                $treeDistrict = ViewLocation::model()->find(array('condition' =>'idCity ='.$this->idCity));
                if($treeDistrict != NULL){
                    $this->idCountry = $treeDistrict->idCountry;
                    $this->idDepartment = $treeDistrict->idDepartment;
                    $this->fullDistrict = $treeDistrict->location;                    
                }                
            } 
        }
        
        public function afterSave() {
            parent::afterSave();

            if ($this->idCity != NULL) {
                $treeDistrict = ViewLocation::model()->find(array('condition' => 'idCity =' . $this->idCity));
                if ($treeDistrict != NULL) {
                    $this->idCountry = $treeDistrict->idCountry;
                    $this->idDepartment = $treeDistrict->idDepartment;
                    $this->fullDistrict = $treeDistrict->location;
                }
            }
        }

        public function relations() {
		return array(
			'idCity0' => array(self::BELONGS_TO, 'Cities', 'idCity'),
			'idDebtor0' => array(self::BELONGS_TO, 'DebtorsObligations', 'idDebtor'),
                        'idDebtorDebt0' => array(self::BELONGS_TO, 'DebtorsDebts', 'idDebtorDebt'),
			'idSpendingType0' => array(self::BELONGS_TO, 'SpendingTypes', 'idSpendingType'),
			'idUserSpending0' => array(self::BELONGS_TO, 'Users', 'idUserSpending'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'idDebtor' => Yii::t('front', 'Deudor'),
                        'idDebtorDebt' => null,
			'idUserSpending' => Yii::t('front', 'Usuario'),
			'idSpendingType' => Yii::t('front', 'Tipo'),
			'idCountry' => Yii::t('front', 'País'),
			'idDepartment' => Yii::t('front', 'Departamento'),
			'idCity' => Yii::t('front', 'Ciudad'),
			'dateSpending' => Yii::t('front', 'Fecha'),
			'value' => Yii::t('front', 'Valor'),
			'comments' => Yii::t('front', 'Comentarios'),
			'support' => Yii::t('front', 'Soporte'),
			'dateCreated' => Yii::t('front', 'Fecha de Creación'),
			'idCity0' => null,
			'idDebtor0' => null,
                        'idDebtorDebt0' => null,
			'idSpendingType0' => null,
			'idUserSpending0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('idDebtor', $this->idDebtor);
                $criteria->compare('idDebtorDebt', $this->idDebtorDebt);
		$criteria->compare('idUserSpending', $this->idUserSpending);
		$criteria->compare('idSpendingType', $this->idSpendingType);
		$criteria->compare('idCity', $this->idCity);
		$criteria->compare('dateSpending', $this->dateSpending, true);
		$criteria->compare('value', $this->value);
		$criteria->compare('comments', $this->comments, true);
		$criteria->compare('support', $this->support, true);
		$criteria->compare('dateCreated', $this->dateCreated, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}