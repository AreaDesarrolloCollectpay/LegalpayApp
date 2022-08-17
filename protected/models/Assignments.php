<?php

class Assignments extends CFormModel {

    public $idCustomer;
    public $file;
    public $terms;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('idCustomer, file, terms', 'required'),
            array('file', 'match', 'pattern' => '/\.(csv)$/i', 'message' => Yii::t('err', 'El {attribute} es inválido, Solo los archivos con estas extensiones son permitidos: csv'), 'allowEmpty' => true, 'on' => 'updatePerfil'),
            array('idCustomer, file, terms', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idCustomer' => Yii::t('app', 'Cliente'),
            'file' => Yii::t('app', 'Archivo'),
            'terms' => Yii::t('app', 'Términos y Condiciones'),
        );
    }

}
