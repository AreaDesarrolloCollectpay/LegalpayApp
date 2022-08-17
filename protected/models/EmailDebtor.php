<?php

class EmailDebtor extends CFormModel {

    public $idDebtor;
    public $email;
    public $message;
    public $subject;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('idDebtor, email, subject, message', 'required'),
            array('email', 'email'),
            array('idDebtor', 'numerical', 'integerOnly' => true),
            array('idDebtor, email, subject, message', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idDebtor' => Yii::t('app', 'Deudor'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Asunto'),
            'message' => Yii::t('app', 'Mensaje'),                      
        );
    }

}
