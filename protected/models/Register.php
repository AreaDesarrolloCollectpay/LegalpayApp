<?php

class Register extends CFormModel {

    
    public $idUserProfile;    
    public $name;
    public $email;
    public $psswd;
    public $psswd_confirm;
    public $terms;
    public $is_internal;
    public $company;
    public $idSector;
    public $idTypeDocument;
    public $numberDocument;
    public $phone;
    public $address;
    public $id;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('idUserProfile, name, email, psswd, psswd_confirm, terms, is_internal', 'required', 'on' => 'register'),
            array('company, idSector, idTypeDocument, numberDocument, phone, address, id', 'required', 'on' => 'confirm'),
            array('psswd', 'length', 'min' => 8),
            array('terms, is_internal, idSector, idTypeDocument, numberDocument, phone, id', 'numerical', 'integerOnly' => true),
            array('phone','match', 'pattern' => '/^[1-9]\d{6}$/','message' => '{attribute} inválido'),
            array('psswd', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message' => Yii::t('front', '{attribute} debe contener al menos un carácter en mayúscula y minúscula y un dígito.')),
            array('psswd_confirm', 'compare', 'compareAttribute' => 'psswd'),            
            array('email', 'email'),
            array('idUserProfile, name, email, psswd, psswd_confirm, terms, is_internal, company, idSector, idTypeDocument, numberDocument, phone, address, id', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            
            'name' => Yii::t('app', 'Nombre y apellidos'),
            'email' => Yii::t('app', 'Email'),
            'psswd' => Yii::t('app', 'Contraseña'),
            'psswd_confirm' => Yii::t('app', 'Confirmar Contraseña'),            
            'terms' => Yii::t('app', 'Política de privacidad'),
            'is_internal' => Yii::t('app', 'Interno'),
            'company' => Yii::t('app', 'Nombre / Razón social'),
            'idSector' => Yii::t('app', 'Industria'),
            'idTypeDocument' => Yii::t('app', 'Tipo Documento'),
            'numberDocument' => Yii::t('app', 'Número Documento'),
            'phone' => Yii::t('app', 'Teléfono'),
            'address' => Yii::t('app', 'Dirección'),
            'id' => Yii::t('front', 'Cliente'),
        );
    }

}
