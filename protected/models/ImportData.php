<?php

class ImportData extends CFormModel {

    public $idCustomer;
    public $lot;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('idCustomer, lot', 'required'),
            array('idCustomer', 'numerical', 'integerOnly' => true),
            array('idCustomer, lot', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idCustomer' => Yii::t('app', 'Cliente'),
            'lot' => Yii::t('app', 'Lote'),
        );
    }

}
