<?php

class Predictions extends CFormModel {

    public $idCustomer;
    public $cant;
    public $capital;
    public $file;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('idCustomer, cant, capital, file', 'required'),
            array('cant', 'numerical', 'integerOnly' => false),
            array('idCustomer, cant', 'numerical', 'integerOnly' => true),
            array('idCustomer, cant, capital, file', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idCustomer' => Yii::t('app', 'Cliente'),
            'cant' => Yii::t('app', 'Obligaciones'),
            'capital' => Yii::t('app', 'Total Capital'),
            'file' => Yii::t('app', 'Source'),            
        );
    }

}
