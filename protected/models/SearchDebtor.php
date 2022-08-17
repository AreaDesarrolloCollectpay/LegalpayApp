<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SearchDebtor extends CFormModel {

    public $code;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // code are required
            array('code', 'required'),
            // code needs to be a number
            array('code', 'numerical', 'integerOnly'=>true)
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'code' => Yii::t('front', 'Número de Documento'),
        );
    }

}
