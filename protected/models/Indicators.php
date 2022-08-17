<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Indicators extends CFormModel {

    public $assigned;
    public $countAssigned;
    public $recovered;
    public $countRecovered;
    public $credit;
    public $countCredit;
    public $pending;
    public $pRecovered;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'assigned' => Yii::t('t', 'assigned'),
            'countAssigned' => Yii::t('t', 'countAssigned'),
            'recovered' => Yii::t('t', 'recovered'),
            'countRecovered' => Yii::t('t', 'countRecovered'),
            'credit' => Yii::t('t', 'credit'),
            'countCredit' => Yii::t('t', 'countCredit'),
            'pending' => Yii::t('t', 'pending'),
            'pRecovered' => Yii::t('t', 'pRecovered'),
        );
    }

}
