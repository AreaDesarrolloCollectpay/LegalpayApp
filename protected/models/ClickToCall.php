<?php

class ClickToCall extends CFormModel {

    public $idDebtor;
    public $idCity;
    public $number;
            
    public function validateNumber($attribute,$params){          
                
        // validate number phone
        if(!preg_match('/^[1-9]\d{6}$/', $this->number)){
            // validate number mobile
            if(!preg_match('/^3[\d]{9}$/', $this->number)){
                $this->addError($attribute, Yii::t('front', 'Numero a marcar es invalido'));
            }
        }  
    }
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('idDebtor, idCity, number', 'required'),
            array('number', 'validateNumber'),		            
            array('idDebtor, idCity, number', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idDebtor' => Yii::t('app', 'Deudor'),
            'idCity' => Yii::t('app', 'Ciudad'),
            'number' => Yii::t('app', 'Número'),
        );
    }

}
