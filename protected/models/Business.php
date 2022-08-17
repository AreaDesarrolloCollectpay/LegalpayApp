<?php

class Business extends CFormModel {

    public $idCountry;
    public $idDepartment;
    public $idCity;
    public $idUserProfile;
    public $numberDocument;
    public $name;
    public $email;
    public $mobile;
    public $phone;
    public $address;
    public $contact;
    public $value;
    public $date_close;
    public $idUserState;
    public $idBusinessAdvisor;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('idCountry, idDepartment, idCity, idUserProfile, name, email, phone, address, contact, date_close, idUserState, idBusinessAdvisor', 'required'),
            array('email', 'email'),
//            array('date_close','compare','compareValue'=>date('Y-m-d'),'operator'=>'>='),
            array('phone','match', 'pattern' => '/^[1-9]\d{6}$/','message' => '{attribute} inválido'),
            array('mobile','match', 'pattern' => '/^3[\d]{9}$/','message' => '{attribute} inválido'),
            array('date_close', 'type', 'type' => 'date', 'dateFormat' => 'yyyy-MM-dd'),
            array('idCountry, idDepartment, idCity, idUserProfile, numberDocument, value, idBusinessAdvisor', 'numerical', 'integerOnly' => true),
            array('idCountry, idDepartment, idCity, idUserProfile, numberDocument, name, email, mobile, phone, address, contact, value, date_close, idUserState, idBusinessAdvisor', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idCountry' => Yii::t('app', 'País'),
            'idDepartment' => Yii::t('app', 'Departamento'),
            'idCity' => Yii::t('app', 'Ciudad'),
            'idUserProfile' => Yii::t('app', 'id Perfil'),
            'numberDocument' => Yii::t('app', 'CC / NIT'),
            'name' => Yii::t('app', 'Nombre / Razón Social'),
            'email' => Yii::t('app', 'Correo Electrónico'),
            'mobile' => Yii::t('app', 'Celular'),
            'phone' => Yii::t('app', 'Teléfono'),
            'address' => Yii::t('app', 'Dirección'),
            'contact' => Yii::t('app', 'Contacto'),
            'value' => Yii::t('app', 'Valor Portafolio'),
            'date_close' => Yii::t('app', 'Fecha de Cierre Prevista'),            
            'idUserState' => Yii::t('app', 'Estado del Negocio'),            
            'idBusinessAdvisor' => Yii::t('app', 'Asesor Comercial'),            
        );
    }

}
