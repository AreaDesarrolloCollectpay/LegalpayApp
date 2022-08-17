<?php

class ChartComparations extends CFormModel {

    public $idModel;
    public $idPorfolio;
    public $comparations;
        
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    
    public function rules() {
        return array(
            array('idModel, idPorfolio, comparations', 'required'),
            array('idModel, idPorfolio', 'numerical', 'integerOnly' => true),
            array('idModel, idPorfolio, comparations', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'idModel' => Yii::t('app', 'Modelo'),
            'idPorfolio' => Yii::t('app', 'Portafolio'),
            'comparations' => Yii::t('app', 'Comparación'),                      
        );
    }

}
