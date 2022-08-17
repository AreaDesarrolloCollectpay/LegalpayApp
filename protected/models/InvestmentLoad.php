<?php

class InvestmentLoad extends CFormModel {

    public $value;
    public $rate;
    public $file;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('value, rate, file', 'required'),
            array('value', 'numerical', 'integerOnly' => true),
            array('file', 'match', 'pattern' => '/\.(csv)$/i', 'message' => Yii::t('err', 'El {attribute} es inválido, Solo los archivos con estas extensiones son permitidos: csv'), 'allowEmpty' => true, 'on' => 'updatePerfil'),
            array('value, rate, file', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'value' => Yii::t('app', 'Valor Inversión'),
            'rate' => Yii::t('app', 'Tasa'),
            'file' => Yii::t('app', 'Flujo de Caja'),
        );
    }

}
