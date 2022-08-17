<?php

class SmsDebtor extends CFormModel {

    public $idDebtor;
    public $number;
    public $message;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('idDebtor, number, message', 'required'),
            array('idDebtor, number', 'numerical', 'integerOnly' => true),
            array('idDebtor, number, message', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idDebtor' => Yii::t('app', 'Deudor'),
            'number' => Yii::t('app', 'Número'),
            'message' => Yii::t('app', 'Mensaje'),                      
        );
    }

}
