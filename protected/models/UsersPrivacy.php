<?php

class UsersPrivacy extends CFormModel {

    public $id;
    public $terms;
    public $agreement;
    public $date;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('id, terms, agreement, date', 'required'),
            array('id, terms, agreement', 'numerical', 'integerOnly' => true),
            array('id, terms, agreement, date', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'Usuario'),
            'terms' => Yii::t('app', 'Políticas de Privacidad'),
            'agreement' => Yii::t('app', 'Acuerdo de Confidencialidad'),                      
            'date' => Yii::t('app', 'date'),                      
        );
    }

}
