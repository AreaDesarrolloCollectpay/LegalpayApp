<?php

class Amortization extends CFormModel {

    public $time;
    public $interest;
    public $capital;
    public $date_initial;
    public $type_solution;
    public $discount;
    public $agreement;
    public $quote_initial;
    public $idDebtor;
    
    
    public function typeSolution($attribute,$params){          
                
        if($this->date_initial != ''){
        
            $dateF = GeneralController::getDateAmortization($this->date_initial);

            if($this->time == 3 && $this->type_solution == 2 ){
               $cantDays = Controller::getDays($this->date_initial,$dateF);

               for($i = 1; $i < $this->time; $i++){  
                   $datePay = date('Y-m-d', strtotime("+1months", strtotime($dateF)));
                   $cant = Controller::getDays($dateF,$datePay);
                   $cantDays += (($cant == 31)? 30 : $cant);
                   $dateF = $datePay;
               }

               if($cantDays > 90){
                   $this->addError($attribute, Yii::t('front', 'Tipo de solucion excede los 90 Días permitidos'));
               }


            }elseif( $this->time == 4 && $this->type_solution == 3){

               for($i = 1; $i < $this->time; $i++){  
                   $datePay = date('Y-m-d', strtotime("+1months", strtotime($dateF)));
                   $dateF = $datePay;
               } 
               $months = Controller::getPeriodDiff($dateF,$this->date_initial);

               if($months > 4){
                   $this->addError($attribute, Yii::t('front', 'Tipo de solucion excede los 4 meses permitidos'));
               }
            }
         }  
    }
    
    public function valueAgreement($attribute,$params){          
        
        if($this->idDebtor != ''){            
            $model = Controller::othersValues($this->idDebtor);

            if($model['model'] != NULL){
                $capital = ($model['model']->capital * 25) / 100;
                $capital = $model['model']->capital - $capital;
                $total = ($model['model']->capital);
                if($this->agreement < $capital){                
                    $this->addError($attribute, Yii::t('front', 'Valor del Total Acuerdo esta por debajo de lo permitido'));            
                }elseif($this->agreement > $total){
                    $this->addError($attribute, Yii::t('front', 'Valor del Total Acuerdo excede lo permitido'));
                }                        
            }else{
                $this->addError($attribute, Yii::t('front', 'Deudor no encontrado'));            
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
            array('type_solution, discount, time, interest, capital, idDebtor, agreement', 'required'),
            array('date_initial', 'required','on' => 'dateInitial'),
            array('type_solution', 'typeSolution'),
            array('agreement', 'valueAgreement'),
            array('type_solution, discount, time, interest, capital, agreement, idDebtor', 'numerical', 'integerOnly' => true),
            array('type_solution, discount, date_initial, time, interest, capital, agreement, quote_initial, idDebtor', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'time' => Yii::t('app', 'Plazo'),
            'interest' => Yii::t('app', 'Intereses'),
            'capital' => Yii::t('app', 'Capital'),                      
            'date_initial' => Yii::t('app', 'Fecha Pago Cuota Inicial'),                      
            'type_solution' => Yii::t('app', 'Tipo Solución'),    
            'agreement' => Yii::t('app', 'Total Acuerdo'),    
            'quote_initial' => Yii::t('app', 'Cuotal Inicial'),    
            'idDebtor' => Yii::t('app', 'Deudor'),    
        );
    }

}
