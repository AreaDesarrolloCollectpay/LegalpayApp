<?php

class Recover extends CFormModel {

    public $email;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email' => Yii::t('app', 'Correo Electrónico'),
        );
    }

}
