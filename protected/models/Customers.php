<?php

class Customers extends CFormModel {

    public $idCountry;
    public $idDepartment;
    public $idCity;
    public $idUserProfile;
    public $idTypeDocument;
    public $numberDocument;
    public $name;
    public $userName;
    public $email;
    public $mobile;
    public $phone;
    public $address;
    public $notification;
    public $contact;
    public $commission;
    public $interests;
    public $fee;
    public $web;
    public $legal_representative;
    public $id_representative;
    public $email_representative;
    public $regime;
    public $regime_special;
    public $regime_special_type;
    public $great_retainer;
    public $great_retainer_number;
    public $great_retainer_date;
    public $auto_retainer;
    public $auto_retainer_number;
    public $auto_retainer_date;
    public $code_ica;
    public $ica;
    public $code_rent;
    public $iva;
    public $concept_rent;
    public $rent;
    public $type_activity;
    public $other_activity;
    public $number_activity;
    public $name_bank;
    public $account_number;
    public $support_bank;    
    public $account_type;
    public $financial_contact;
    public $financial_phone;
    public $shopping_contact;
    public $shopping_phone;
    public $is_internal;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('idCountry, idDepartment, idCity, idTypeDocument, numberDocument, name, userName, email, mobile, phone, address, notification, contact, commission, interests, fee, is_internal', 'required'),
            array('support_bank', 'match', 'pattern'=>'/\.(pdf)$/i','message'=>Yii::t('err','El {attribute} es inválido, Solo los archivos con estas extensiones son permitidos: pdf'), 'allowEmpty'=>true),		
            array('web', 'url'),
            array('email, email_representative', 'email'),
            array('phone, financial_phone, shopping_phone','match', 'pattern' => '/^[1-9]\d{6}$/','message' => '{attribute} inválido'),
            array('mobile','match', 'pattern' => '/^3[\d]{9}$/','message' => '{attribute} inválido'),
            array('great_retainer_date, auto_retainer_date', 'type', 'type' => 'date', 'dateFormat' => 'yyyy-MM-dd'),
            array('interests', 'numerical', 'integerOnly' => false),
            array('commission, fee, idUserProfile, numberDocument, id_representative, great_retainer_number, auto_retainer_number, ica, code_rent, iva, number_activity, account_number, is_internal', 'numerical', 'integerOnly' => true),
            array('web, legal_representative, id_representative, email_representative, regime, regime_special, regime_special_type, great_retainer, great_retainer_number, great_retainer_date, auto_retainer, auto_retainer_number, auto_retainer_date, code_ica, ica, code_rent, iva, concept_rent, rent, type_activity, other_activity, number_activity, name_bank, account_number, support_bank, account_type, financial_contact, financial_phone, shopping_contact, shopping_phone, is_internal', 'safe')
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
            'idTypeDocument' => Yii::t('app', 'Tipo de Documento'),
            'numberDocument' => Yii::t('app', 'Número Documento'),
            'name' => Yii::t('app', 'Nombres'),
            'userName' => Yii::t('app', 'Nombre Corto'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Celular'),
            'phone' => Yii::t('app', 'Teléfono'),
            'address' => Yii::t('app', 'Dirección'),
            'notification' => Yii::t('app', 'Notificación'),
            'contact' => Yii::t('app', 'Contacto'),
            'commission' => Yii::t('app', 'Comisión'),
            'interests' => Yii::t('app', 'Intereses'),
            'fee' => Yii::t('app', 'Honorarios'),
            'web' => Yii::t('app', 'Pagina Web'),
            'legal_representative' => Yii::t('app', 'Repesentante Legal'),
            'id_representative' => Yii::t('app', 'Cédula Representante'),
            'email_representative' => Yii::t('app', 'Email del Representante'),
            'regime' => Yii::t('app', 'Regimen Tributario'),
            'regime_special' => Yii::t('app', 'Regimen Especial'),
            'regime_special_type' => Yii::t('app', 'Tipo Regimen Especial'),
            'great_retainer' => Yii::t('app', 'Gran Retenedor'),
            'great_retainer_number' => Yii::t('app', 'Número de Resolución'),
            'great_retainer_date' => Yii::t('app', 'Fecha'),
            'auto_retainer' => Yii::t('app', 'Auto Retenedor'),
            'auto_retainer_number' => Yii::t('app', 'Número de Resolución'),
            'auto_retainer_date' => Yii::t('app', 'Fecha'),
            'code_ica' => Yii::t('app', 'Cod. Actividad ICA'),
            'ica' => Yii::t('app', 'Tarifa ICA'),
            'code_rent' => Yii::t('app', 'Cod. Actividad Económica Renta'),
            'iva' => Yii::t('app', 'Tarifa IVA'),
            'concept_rent' => Yii::t('app', 'Concepto Retención Renta'),
            'rent' => Yii::t('app', 'Tarifa Renta'),
            'type_activity' => Yii::t('app', 'Tipo Actividad'),
            'other_activity' => Yii::t('app', 'Otra Actividad'),
            'number_activity' => Yii::t('app', 'Número de Actividad'),
            'name_bank' => Yii::t('app', 'Entidad Bancaria'),
            'account_number' => Yii::t('app', 'Número de Cuenta'),
            'support_bank' => Yii::t('app', 'Certificación Bancaria'),
            'account_type' => Yii::t('app', 'Tipo de Cuenta'),
            'financial_contact' => Yii::t('app', 'Contacto Financiero'),
            'financial_phone' => Yii::t('app', 'Teléfono'),
            'shopping_contact' => Yii::t('app', 'Contacto Compras'),
            'shopping_phone' => Yii::t('app', 'Teléfono'),
            'is_internal' => Yii::t('app', 'Interno')
        );
    }

}
