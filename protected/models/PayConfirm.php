<?php

class PayConfirm extends CFormModel {

    public $id;
    public $type;
    public $idDebtor;
    public $value;
    public $reference;
    
    public $name;
    public $document_type;
    public $idCountry;
    public $idCity;
    public $phone;
    public $email;
    public $type_person;
    public $document;
    public $idDepartment;
    public $address;
    public $mobile;
    public $method_pay;
    public $deviceSessionId;
    public $ip_address;
    //PSE
    public $bank;
    
    //CARD
    public $number_card;
    public $month;
    public $year;
    public $cvv;
    
    
    
    public function month($attribute,$params){
            $month = date('m');
            $year = date('Y');
            
        if ($year == $this->year && $this->$attribute < $month) {
            $this->addError($attribute, Yii::t('front', 'Mes debe ser mayor '));
        }
    }

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('id, idDebtor, type, value, reference, deviceSessionId', 'required'),
            array('name, document_type, idCountry, idCity, phone, email, type_person, document, idDepartment, address, mobile, method_pay, bank', 'required', 'on' => 'PSE'),
            array('name, document_type, idCountry, idCity, phone, email, type_person, document, idDepartment, address, method_pay', 'required', 'on' => 'BALOTO,EFECTY,OTHERS_CASH'),
            array('name, document_type, idCountry, idCity, phone, email, type_person, document, idDepartment, address, method_pay, number_card, month, year, cvv', 'required', 'on' => 'CARD'),
            array('email', 'email'),            
            array('value', 'numerical', 'integerOnly'=>true, 'min'=>8600, 'max' => 14400000,'tooSmall' => '{attribute} debe ser mayor a $ 100.000','tooBig' => '{attribute} debe ser menor a $ 5.000.000', 'on' => 'PSE' ),
            array('value', 'numerical', 'integerOnly'=>true, 'min'=>8600, 'max' => 14400000,'tooSmall' => '{attribute} debe ser mayor a $ 10.000','tooBig' => '{attribute} debe ser menor a $ 1.000.000', 'on' => 'BALOTO' ),
            array('value', 'numerical', 'integerOnly'=>true, 'min'=>8600, 'max' => 14400000,'tooSmall' => '{attribute} debe ser mayor a $ 20.000','tooBig' => '{attribute} debe ser menor a $ 3.000.000', 'on' => 'EFECTY' ),
            array('value', 'numerical', 'integerOnly'=>true, 'min'=>8600, 'max' => 14400000,'tooSmall' => '{attribute} debe ser mayor a $ 20.000','tooBig' => '{attribute} debe ser menor a $ 4.000.000', 'on' => 'OTHERS_CASH' ),
            array('id, idDebtor, type, cvv', 'numerical', 'integerOnly' => true),            
            array('cvv', 'length', 'min'=>3, 'max'=>3),
            array('month', 'month'),
            //array('phone', 'length', 'min'=>7, 'max'=>7),
            //array('mobile', 'length', 'min'=>10, 'max'=>10),
            //array('mobile', 'length', 'min'=>10, 'max'=>10),
//            array('date_close','compare','compareValue'=>date('Y-m-d'),'operator'=>'>='),
            array('phone','match', 'pattern' => '/^[1-9]\d{6}$/','message' => '{attribute} inválido'),
            array('mobile','match', 'pattern' => '/^3[\d]{9}$/','message' => '{attribute} inválido'),
            array('number_card','match', 'pattern' => '/^4[0-9]{12}(?:[0-9]{3})?$/','message' => 'Número de Tarjeta inválido'),
            array('id, idDebtor, type, value, reference, deviceSessionId, name, document_type, idCountry, idCity, phone, email, type_person, document, idDepartment, address, mobile, method_pay, deviceSessionId, ip_address, bank, number_card, month, year, cvv', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'Obligación'),
            'idDebtor' => Yii::t('app', 'Deuda'),
            'type' => Yii::t('app', 'Monto a Pagar'),
            'reference' => Yii::t('app', 'Referencia'),
            'deviceSessionId' => Yii::t('app', 'Sesión Id'),
            'name' => Yii::t('app', 'Nombre'),
            'document_type' => Yii::t('app', 'Tipo de Documento'),
            'idCountry' => Yii::t('app', 'País'),
            'idDepartment' => Yii::t('app', 'Departamento'),
            'idCity' => Yii::t('app', 'Ciudad'),
            'phone' => Yii::t('app', 'Teléfono'),
            'email' => Yii::t('app', 'Correo Electrónico'),
            'type_person' => Yii::t('app', 'Tipo de Cliente'),
            'document' => Yii::t('app', 'Número de Documento'),
            'address' => Yii::t('app', 'Dirección'),
            'mobile' => Yii::t('app', 'Celular'),
            'method_pay' => Yii::t('app', 'Metodo de Pago'),
            'deviceSessionId' => Yii::t('app', 'Sessión Id'),
            'ip_address' => Yii::t('app', 'Dirección IP'),
            'bank' => Yii::t('app', 'Banco'),
            'number_card' => Yii::t('front', 'Número de Tarjeta'),
            'month' => Yii::t('front', 'Mes'),
            'year' => Yii::t('front', 'Año'),
            'cvv' => Yii::t('app', 'Código de Seguridad'),
            'mobile' => Yii::t('app', 'Celular'),
            'phone' => Yii::t('app', 'Teléfono'),
            'address' => Yii::t('app', 'Dirección'),
            'contact' => Yii::t('app', 'Contacto'),
            'value' => Yii::t('app', 'Valor a Pagar'),
            'date_close' => Yii::t('app', 'Fecha de Cierre Prevista'),            
            'idUserState' => Yii::t('app', 'Estado del Negocio'),            
            'idBusinessAdvisor' => Yii::t('app', 'Asesor Comercial'),            
        );
    }

}
